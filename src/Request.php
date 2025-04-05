<?php 
declare(strict_types=1);

namespace App;

class Request {
	private array $get = [];
	private array $post = [];
	private array $server = [];
	private array $session = [];

	public function __construct($get, $post, $server, $session) {
		$this->get = $get;
		$this->post = $post;
		$this->server = $server;
		$this->session = $session;
	}

	public function getSession(string $param, $default = null) {
		return $this->session[$param] ?? $default;
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
}