<?php 
declare(strict_types=1);

namespace App;

class Request {
	private array $get = [];
	private array $post = [];
	private array $server = [];

	public function __construct($get, $post, $server) {
		$this->get = $get;
		$this->post = $post;
		$this->server = $server;
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