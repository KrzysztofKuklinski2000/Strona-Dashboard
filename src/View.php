<?php declare(strict_types=1);
namespace App;

class View {
	public function __construct(private string $templatePath = 'templates/'){}

	public function renderPageView(array $params) {
		$path = rtrim($this->templatePath, '/').'/layout.php';

		if(file_exists($path)) require $path;
	}
	
	public function renderDashboardView(array $params) {
		$path = rtrim($this->templatePath, '/') . '/dashboard/layout.php';
		
		if (file_exists($path)) require $path;
	}
}