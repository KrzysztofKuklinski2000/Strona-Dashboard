<?php 
declare(strict_types= 1);
namespace App\Core;
use App\Exception\NotFoundException;

class ErrorHandler {
    private string $isDev;
    private string $errorPath;
    public function __construct(string $isDev, string $errorPath) {
        $this->isDev = $isDev;  
        $this->errorPath = rtrim($errorPath, '/');
    }

    public function handle(\Throwable $e): void {
        error_log($e->getMessage());

        if($e instanceof NotFoundException) {
            $this->renderErrorPage('404.php', $e);
        }else {
            $this->renderErrorPage('500.php', $e);
        }
        exit;
    }

    public function renderErrorPage(string $file, \Throwable $e): void {
        if($this->isDev === "dev") {
            echo "<pre>" . get_class($e) .": ". $e->getMessage() ."\n";
            echo $e->getTraceAsString(). "</pre>";
        }else {
            $path = $this->errorPath."/".$file;
            if(file_exists($path)) {
                include $path;
            }else {
                echo "Wystąpił błąd. Spróbuj później";
            }
        }
    }
}