<?php

namespace Tests\Core;

use App\Core\ActionResolver;
use App\Core\Request;
use PHPUnit\Framework\TestCase;


class ActionResolverTest extends TestCase 
{
  public function testShouldReturnDefaultActionWhenParamIsMissing() 
  {
    // GIVEN
    $request = $this->createMock(Request::class);
    $request->method('getQueryParam')
            ->with('action')
            ->willReturn(null);
    
            
    $resolver = new ActionResolver();

    // WHEN 
    $actual = $resolver->resolve($request);

    // THEN 
    $this->assertSame('indexAction', $actual);
  }

  public function testShouldReturnSanitizedActionName()
  {
    // GIVEN
    $request = $this->createMock(Request::class);
    $request->method('getQueryParam')->willReturn('list-123!');


    $resolver = new ActionResolver();

    // WHEN 
    $actual = $resolver->resolve($request);
    
    // THEN 
    $this->assertSame('listAction', $actual);
  
  }

  public function testShouldUseSlugMapWhenKeyExist() {
    // GIVEN
    $request = $this->createMock(Request::class);
    $request->method('getQueryParam')->willReturn('kontakt');

    $resolver = new ActionResolver([
      'kontakt' => 'contact'
    ]);

    // WHEN 
    $actual = $resolver->resolve($request);

    // THEN 
    $this->assertSame('contactAction', $actual);

  }

  public function testShouldFallbackToDefaultActionWhenKeyIsMissingInSlugMap()
  {
    // GIVEN
    $request = $this->createMock(Request::class);
    $request->method('getQueryParam')->willReturn('start');

    $resolver = new ActionResolver([
      'kontakt' => 'contact'
    ]);

    // WHEN 
    $actual = $resolver->resolve($request);

    // THEN 
    $this->assertSame('indexAction', $actual);
  }

  public function testShouldReturnDefaultActionWhenSanitizationResultsInEmptyString()
  {
    // GIVEN
    $request = $this->createMock(Request::class);
    $request->method('getQueryParam')->willReturn('12345');

    $resolver = new ActionResolver();

    // WHEN 
    $actual = $resolver->resolve($request);

    // THEN 
    $this->assertSame('indexAction', $actual);
  }

  public function testShouldReturnActionNameBasedOnParamWhenNoMapIsProvided()
  {
    // GIVEN
    $request = $this->createMock(Request::class);
    $request->method('getQueryParam')->willReturn('start');

    $resolver = new ActionResolver();

    // WHEN 
    $actual = $resolver->resolve($request);

    // THEN 
    $this->assertSame('startAction', $actual);
  }
}