<?php

namespace Tests;

use App\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase {
    private string $tempDir;

    protected function setUp(): void {
        $this->tempDir = sys_get_temp_dir().'/test_view_'.uniqid();

        if(!is_dir($this->tempDir)) {
            mkdir($this->tempDir);
        }

        if(!is_dir($this->tempDir . '/dashboard')) {
            mkdir($this->tempDir . '/dashboard');
        }

        file_put_contents($this->tempDir . '/layout.php', 'Layout: <?= $params["content"] ?>');
        file_put_contents($this->tempDir . '/dashboard/layout.php', 'Dashboard: <?= $params["user"] ?>');

    }

    protected function tearDown(): void {
        if(file_exists($this->tempDir.'/dashboard/layout.php')) {
            unlink($this->tempDir . '/dashboard/layout.php');
        }

        if (file_exists($this->tempDir . '/layout.php')) {
            unlink($this->tempDir . '/layout.php');
        }

        if(is_dir($this->tempDir . '/dashboard')) {
            rmdir($this->tempDir . '/dashboard');
        }

        if(is_dir($this->tempDir)) {
            rmdir($this->tempDir);
        }
    }

    public function testShouldRenderPageViewAndPassParams(): void
    {
        $view = new View($this->tempDir);
        $params = ['content' => 'Testowa treść'];

        // EXPECT
        $this->expectOutputString('Layout: Testowa treść');

        // WHEN
        $view->renderPageView($params);
    }

    public function testShouldRenderDashboardViewAndPassParams(): void
    {
        // GIVEN
        $view = new View($this->tempDir);
        $params = ['user' => 'Admin'];

        // EXPECT
        $this->expectOutputString('Dashboard: Admin');

        // WHEN
        $view->renderDashboardView($params);
    }

}