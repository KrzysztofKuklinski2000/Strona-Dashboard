<?php

namespace Tests\Core;

use App\Core\ErrorHandler;
use App\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Exception;

class ErrorHandlerTest extends TestCase
{
  private string $tempDir;

  protected function setUp(): void
  {
    $this->tempDir = sys_get_temp_dir() . '/error_templates_' . uniqid();
    mkdir($this->tempDir);

    file_put_contents($this->tempDir . '/404.php', '<h1>Widok 404</h1>');

    file_put_contents($this->tempDir . '/500.php', '<h1>Widok 500</h1>');
  }

  protected function tearDown(): void
  {
    array_map('unlink', glob("$this->tempDir/*.*"));
    rmdir($this->tempDir);
  }

  public function testShouldRenderDetailedTraceInDevMode(): void
  {
    // GIVEN
    $handler = new ErrorHandler(true, $this->tempDir); 
    $exception = new Exception("Testowy błąd krytyczny");

    // EXPECTS
    $this->expectOutputRegex('/<pre>.*Exception: Testowy błąd krytyczny/s');

    // WHEN
    $handler->renderErrorPage('500.php', $exception);
  }

  public function testShouldInclude404FileInProdModeWhenFileExists(): void
  {
    // GIVEN
    $handler = new ErrorHandler(false, $this->tempDir . '/');
    $exception = new NotFoundException("Nie znaleziono");

    // EXPECTS
    $this->expectOutputString('<h1>Widok 404</h1>');

    // WHEN
    $handler->renderErrorPage('404.php', $exception);
  }

  public function testShouldInclude500FileInProdModeWhenFileExists(): void
  {
    // GIVEN
    $handler = new ErrorHandler(false, $this->tempDir);
    $exception = new Exception("Błąd serwera");

    // EXPECTS
    $this->expectOutputString('<h1>Widok 500</h1>');

    // WHEN
    $handler->renderErrorPage('500.php', $exception);
  }

  public function testShouldRenderFallbackMessageInProdModeWhenFileIsMissing(): void
  {
    // GIVEN
    $handler = new ErrorHandler(false, $this->tempDir);
    $exception = new Exception("Błąd");

    // EXPECTS
    $this->expectOutputString('Wystąpił błąd. Spróbuj później');

    // WHEN
    $handler->renderErrorPage('missing_file.php', $exception);
  }

  public function testHandleShouldRender404PageForNotFoundExceptionAndTerminate(): void
  {
    // GIVEN
    $exception = new NotFoundException("Nie ma takiej strony");

    $handler = $this->getMockBuilder(ErrorHandler::class)
      ->setConstructorArgs([false, $this->tempDir]) 
      ->onlyMethods(['renderErrorPage', 'terminate'])
      ->getMock();

    // EXPECTS
    $handler->expects($this->once())
      ->method('renderErrorPage')
      ->with('404.php', $exception);

    $handler->expects($this->once())
      ->method('terminate');

    // WHEN
    $handler->handle($exception);
  }

  public function testHandleShouldRender500PageForGenericExceptionAndTerminate(): void
  {
    // GIVEN
    $exception = new \Exception("Krytyczny błąd");

    $handler = $this->getMockBuilder(ErrorHandler::class)
      ->setConstructorArgs([false, $this->tempDir])
      ->onlyMethods(['renderErrorPage', 'terminate'])
      ->getMock();

    // EXPECTS
    $handler->expects($this->once())
      ->method('renderErrorPage')
      ->with('500.php', $exception);

    $handler->expects($this->once())
      ->method('terminate');

    // WHEN
    $handler->handle($exception);
  }
}
