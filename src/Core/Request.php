<?php 
declare(strict_types=1);

namespace App\Core;

class Request {
	private array $errors = [];
	private array $routeParams = [];

	public function __construct(
		private array $get, 
		private array $post, 
		private array $server, 
		private array $session) {}

	public function getSession(string $param, $default = null) {
		return $this->session[$param] ?? $default;
	}

	public function setSession(string $key, mixed $value): void {
		$_SESSION[$key] = $value;
		$this->session[$key] = $value;
	}

	public function removeSession(string $key): void{
		unset($_SESSION[$key]);
		unset($this->session[$key]);
	}

	public function getQueryParam(string $name, $default = null): mixed {
		return $this->get[$name] ?? $default;
	}

	public function getFormParam(string $name, $default = null): mixed {
		return $this->post[$name] ?? $default;
	}

	public function getServerParam(string $key, $default = null): mixed
	{
		return $this->server[$key] ?? $default;
	}

	public function getMethod(): string {
		return $this->server['REQUEST_METHOD'] ?? 'GET';
	}

	public function isPost(): bool {
		return $this->getMethod()=== 'POST';
	}

	public function hasPost(): bool {
		return !empty($this->post);
	}

	public function getErrors():array {
		return $this->errors;
	}

	public function validate(
		string $param,
		bool $required,
		string $type = 'string',
		?int $maxLength = null,
		?int $minLength = null
	): mixed {
		$value = $this->getFormParam($param);

		if ($required && empty($value)) {
			$this->errors[$param] = "To pole jest wymagane.";
			return null;
		}

		if ($type === 'int') {
			if (!ctype_digit((string)$value)) {
				$this->errors[$param] = "Pole musi zawierać tylko liczby całkowite.";
				return null;
			}
		} else {
			$value = (string) $value;
		}

		if ($maxLength !== null && strlen((string)$value) > $maxLength) {
			$this->errors[$param] = "Długość pola nie może być większa niż $maxLength znaków.";
		}

		if ($minLength !== null && strlen((string)$value) < $minLength) {
			$this->errors[$param] = "Długość pola musi być większa niż $minLength znaków.";
		}

		if ($type === 'int') {
			return (int) $value;
		}

		return (string) $value;
	}

	public function validateFile(string $field, array $allowedTypes = ['image/jpeg', 'image/png'], int $maxSize = 2_000_000): ?array {
		if (!isset($_FILES[$field])) {
			$this->errors[$field] = "Plik nie został przesłany";
			return null;
		}

		$file = $_FILES[$field];

		if ($file['error'] !== UPLOAD_ERR_OK) {
			$this->errors[$field] = "Błąd przesyłania pliku";
			return null;
		}

		if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
			$this->errors[$field] = "Nieprawidłowy typ pliku";
			return null;
		}

		if ($file['size'] > $maxSize) {
			$this->errors[$field] = "Plik jest zbyt duży (max ".($maxSize/1_000_000)." MB)";
			return null;
		}

		return $file;
	}

	public function setRouteParams(array $params): void {
		$this->routeParams = $params;
	}

	public function getRouteParam(string $key, $default = null): mixed {
		return $this->routeParams[$key] ?? $default;
	}

	
}