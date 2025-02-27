<?php declare(strict_types=1);
namespace App;

use RuntimeException;

class View {
	public function renderPageView(array $params) {
		require_once('templates/layout.php');
	}
	
	public function renderDashboardView(array $params) {
		require_once('templates/dashboard/layout.php');
	}
}