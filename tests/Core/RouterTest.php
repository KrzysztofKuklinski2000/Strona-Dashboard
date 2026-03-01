<?php

namespace Tests\Core;

use App\Core\Router;
use App\Core\Request;
use App\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
  private Router $router;

  protected function setUp(): void
  {
    $this->router = new Router();
  }

  public function testShouldReturnHandlerWhenRouteExists(): void
  {
    // GIVEN
    $request = new Request([], [], [
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI' => '/'
    ], []);

    // WHEN
    $result = $this->router->dispatch($request);

    // THEN
    $this->assertIsArray($result);
  }

  public function testShouldParseUriAndSetRouteParams(): void
  {
    // GIVEN
    $request = new Request([], [], [
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI' => '/aktualnosci/1'
    ], []);

    // WHEN
    $this->router->dispatch($request);

    // THEN
    $this->assertEquals('1', $request->getRouteParam('page'));
  }

  public function testShouldThrowNotFoundExceptionForInvalidUrl(): void
  {
    // GIVEN
    $request = new Request([], [], [
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI' => '/no-existing-route'
    ], []);

    // EXPECT
    $this->expectException(NotFoundException::class);

    // WHEN
    $this->router->dispatch($request);
  }

  public function testShouldStripQueryParamsFromUriBeforeDispatching(): void
  {
    // GIVEN
    $request = new Request([], [], [
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI' => '/grafik?test=123&abc=xyz'
    ], []);

    // WHEN
    $result = $this->router->dispatch($request);

    // THEN 
    $this->assertIsArray($result);
    $this->assertEquals(\App\Controller\SiteController::class, $result[0]);
  }

  public function testShouldThrowExceptionWhenMethodIsNotAllowed(): void
  {
    // GIVEN
    $request = new Request([], [], [
      'REQUEST_METHOD' => 'POST',
      'REQUEST_URI' => '/grafik'
    ], []);

    // EXPECT
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Metoda HTTP niedozwolona");

    // WHEN
    $this->router->dispatch($request);
  }

  public function testShouldThrowGeneralRoutingExceptionForUnexpectedStatus(): void
  {

    // GIVEN
    $mockDispatcher = $this->createMock(\FastRoute\Dispatcher::class);
    $mockDispatcher->method('dispatch')
      ->willReturn([99, null, null]);

    $router = new Router($mockDispatcher);
    $request = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/'], []);

    // EXPECTS
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("Błąd routingu");

    // WHEN
    $router->dispatch($request);
  }
}
