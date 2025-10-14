<?php 
declare(strict_types=1);

namespace App\Core;

class Request {
	private array $get = [];
	private array $post = [];
	private array $server = [];
	private array $session = [];
	private array $errors = [];

	public function __construct($get, $post, $server, $session) {
		$this->get = $get;
		$this->post = $post;
		$this->server = $server;
		$this->session = $session;
	}

	public function getSession(string $param, $default = null) {
		return $this->session[$param] ?? $default;
	}

	public function setSession(string $key, mixed $value): void {
		$_SESSION[$key] = $value;
		$this->session[$key] = $value;
	}

	public function removeSession(string $key) :void{
		unset($_SESSION[$key]);
		unset($this->session[$key]);
	}

	public function getParam(string $name = null, $default = null): ?string {
		return $this->get[$name] ?? $default;
	}

	public function postParam(string $name = null, $default = null): mixed {
		return $this->post[$name] ?? $default;
	}

	public function isPost(): bool {
		return $this->server['REQUEST_METHOD'] === 'POST';
	}

	public function hasPost(): bool {
		return !empty($this->post);
	}

	public function getErrors():array {
		return $this->errors;
	}

	public function resolverControllerKey(array $factories): string {
		foreach($factories as $key => $_) {
			if($this->getParam($key) !== null) {
				return $key;
			}
		}
		return 'site';
	}

	public function validate(string $param,  bool $required, string $type = 'string', int $maxLength = null, int $minLength = null): mixed {
		$value = $this->postParam($param);

		if ($required && empty($value)) {
			$this->errors[$param] = "Pole jest wymagany";
			return null;
		}
	
		if ($type === 'int') {
			if(!ctype_digit((string)$value)) {
				$this->errors[$param] = "Pole musi zawierać tylko liczby całkowite.";
				return null;
			}
 			
			return (int) $value;
		}

		$value = (string) $value;
	
		if ($maxLength !== null && strlen((string)$value) > $maxLength) {
			$this->errors[$param] = "Długość pola musi być mniejsza niz $maxLength. znaków";
		}

		if ($minLength !== null && strlen((string)$value) < $minLength) {
			$this->errors[$param] = "Długość pola musi być większa niz $minLength. znaków";
		}
	
		return $value;
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

}