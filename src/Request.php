<?php 
declare(strict_types=1);

namespace App;

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

	public function postParam(string $name = null, $default = null): ?string {
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

	public function validate(string $param,  bool $required, string $type = 'string', int $maxLength = null, int $minLength = null): string {
		$value = $this->postParam($param);

		if ($required && empty($value)) {
			$this->errors[$param] = "Pole jest wymagany";
		}
	
		if ($type === 'int' && !ctype_digit((string)$value)) {
			$this->errors[$param] = "Pole musi zawierać tylko liczby całkowite.";
		}
	
		if ($maxLength !== null && strlen((string)$value) > $maxLength) {
			$this->errors[$param] = "Długość pola musi być mniejsza niz $maxLength. znaków";
		}

		if ($minLength !== null && strlen((string)$value) < $minLength) {
			$this->errors[$param] = "Długość pola musi być większa niz $minLength. znaków";
		}
	
		return $value;
	}
}