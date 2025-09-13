<?php 
declare(strict_types= 1);
namespace App\Core;

use App\Exception\NotFoundException;
use App\Exception\ValidationException;
use App\Exception\AuthException;
use App\Exception\AppException;

class ErrorHandler {
    private string $isDev;
    private string $errorPath;
    private string $logPath;
    
    public function __construct(string $isDev, string $errorPath, string $logPath = '') {
        $this->isDev = $isDev;  
        $this->errorPath = rtrim($errorPath, '/');
        $this->logPath = $logPath ?: __DIR__ . '/../../logs/';
    }

    public function handle(\Throwable $e): void {
        // Szczegółowe logowanie
        $this->logError($e);
        
        // Określenie typu odpowiedzi na podstawie typu wyjątku
        if ($e instanceof NotFoundException) {
            http_response_code(404);
            $this->renderErrorPage('404.php', $e);
        } elseif ($e instanceof ValidationException) {
            http_response_code(400);
            $this->handleValidationError($e);
        } elseif ($e instanceof AuthException) {
            http_response_code($e->getCode() === AuthException::ACCESS_DENIED ? 403 : 401);
            $this->handleAuthError($e);
        } else {
            http_response_code(500);
            $this->renderErrorPage('500.php', $e);
        }
        exit;
    }

    private function logError(\Throwable $e): void {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'type' => get_class($e),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'url' => $_SERVER['REQUEST_URI'] ?? 'N/A',
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'N/A',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'N/A',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'N/A'
        ];

        // Dodatkowe informacje dla AppException
        if ($e instanceof AppException) {
            $logData['context'] = $e->getContext();
            $logData['user_message'] = $e->getUserMessage();
        }

        // Zapis do pliku logów
        $logMessage = json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->writeToLog($logMessage);
        
        // Również podstawowy log
        error_log($e->getMessage());
    }

    private function writeToLog(string $message): void {
        if (!is_dir($this->logPath)) {
            @mkdir($this->logPath, 0755, true);
        }
        
        $filename = $this->logPath . 'errors_' . date('Y-m-d') . '.log';
        file_put_contents($filename, $message . "\n---\n", FILE_APPEND | LOCK_EX);
    }

    private function handleValidationError(ValidationException $e): void {
        if ($this->isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $e->getUserMessage(),
                'errors' => $e->getValidationErrors()
            ]);
        } else {
            // Przekierowanie z błędami walidacji
            $errorQuery = http_build_query([
                'error' => 'validation',
                'message' => $e->getUserMessage()
            ]);
            $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/?dashboard=start';
            header("Location: $redirectUrl?" . $errorQuery);
        }
    }

    private function handleAuthError(AuthException $e): void {
        if ($e->getCode() === AuthException::SESSION_EXPIRED) {
            // Wyczyść sesję
            session_destroy();
        }

        if ($this->isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $e->getUserMessage(),
                'redirect' => '/?dashboard=login'
            ]);
        } else {
            header('Location: /?dashboard=login&error=' . urlencode($e->getUserMessage()));
        }
    }

    private function isAjaxRequest(): bool {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function renderErrorPage(string $file, \Throwable $e): void {
        if($this->isDev === "dev") {
            $this->renderDevErrorPage($e);
        } else {
            $this->renderProdErrorPage($file, $e);
        }
    }

    private function renderDevErrorPage(\Throwable $e): void {
        echo "<!DOCTYPE html>";
        echo "<html><head><title>Error</title><style>
            body { font-family: monospace; margin: 20px; background: #f5f5f5; }
            .error { background: #fff; padding: 20px; border-left: 5px solid #d32f2f; }
            .context { background: #e3f2fd; padding: 10px; margin: 10px 0; }
            pre { overflow-x: auto; }
        </style></head><body>";
        
        echo "<div class='error'>";
        echo "<h2>" . get_class($e) . "</h2>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Code:</strong> " . $e->getCode() . "</p>";
        echo "<p><strong>File:</strong> " . $e->getFile() . " (line " . $e->getLine() . ")</p>";
        
        if ($e instanceof AppException) {
            echo "<div class='context'>";
            echo "<h3>Context:</h3>";
            echo "<pre>" . htmlspecialchars(json_encode($e->getContext(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "</pre>";
            echo "<p><strong>User Message:</strong> " . htmlspecialchars($e->getUserMessage()) . "</p>";
            echo "</div>";
        }
        
        echo "<h3>Stack Trace:</h3>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "</div></body></html>";
    }

    private function renderProdErrorPage(string $file, \Throwable $e): void {
        $path = $this->errorPath . "/" . $file;
        if (file_exists($path)) {
            // Przekaż przyjazną wiadomość do template
            $errorMessage = $e instanceof AppException 
                ? $e->getUserMessage() 
                : 'Wystąpił nieoczekiwany błąd. Spróbuj ponownie.';
            include $path;
        } else {
            echo "<!DOCTYPE html>";
            echo "<html><head><title>Błąd</title></head><body>";
            echo "<h1>Wystąpił błąd</h1>";
            echo "<p>" . ($e instanceof AppException ? $e->getUserMessage() : 'Spróbuj później.') . "</p>";
            echo "</body></html>";
        }
    }
}