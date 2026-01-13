<?php

namespace tests\Middleware;

use PHPUnit\Framework\TestCase;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Middleware\CsrfMiddleware;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;

class CsrfMiddlewareTest extends TestCase {
  private $easyCSRF;
  private $request;
  private $middleware;

  public function setUp(): void
  {
    $this->easyCSRF = $this->createMock(EasyCSRF::class);
    $this->request = $this->createMock(Request::class);
    $this->middleware = new CsrfMiddleware($this->easyCSRF, $this->request);
  }

  public function testShouldIgnoreGetRequests(): void {
    // EXPECT 
    $this->easyCSRF->expects($this->never())
      ->method('check');
    // GIVEN 
    $this->request->method('isPost')
      ->willReturn(false);

    // WHEN
    $this->middleware->verify();    
  } 

  public function testShouldVerifyPostRequestSuccess(): void {
    // EXPECT 
    $this->easyCSRF->expects($this->once())
      ->method('check')
      ->with('csrf_token', 'token'); 

    // GIVEN 
    $this->request->method('isPost')
      ->willReturn(true);

    $this->request->method('getFormParam')
      ->willReturn('token');

    // WHEN
    $this->middleware->verify();
  }

  public function testShouldThrowExceptionWhenTokenIsInvalid(): void {
    // EXPECT   
    $this->expectException(InvalidCsrfTokenException::class);

    // GIVEN 
    $this->request->method('isPost')
      ->willReturn(true);

    $this->easyCSRF->method('check')
        ->willThrowException(new InvalidCsrfTokenException());
    
    // WHEN
    $this->middleware->verify();
  }

  public function testShouldGenerateToken(): void {
    // GIVEN 
    $this->easyCSRF->method('generate')
      ->willReturn('token');
    
    // WHEN 
    $actual = $this->middleware->generateToken();

    // THEN
    $this->assertSame('token', $actual);
  }
}