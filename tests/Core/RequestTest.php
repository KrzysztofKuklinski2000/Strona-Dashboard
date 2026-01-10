<?php 

namespace Tests\Core;

use App\Core\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
  public function testShouldGetSessionValue()
  {
    // GIVEN
    $session = ['test' => 123];
    $request = new Request([], [], [], $session);

    // WHEN 
    $actual = $request->getSession('test');

    //THEN 
    $this->assertSame(123, $actual);
  }


  public function testShouldSetSessionValue() {
    // GIVEN
    $request = new Request([], [], [], []);

    // WHEN 
    $request->setSession('test', 123);

    //THEN 
    $this->assertSame(123, $request->getSession('test'));
  }

  public function testShouldRemoveSessionValue()
  {
    // GIVEN
    $session = ['test' => 123];
    $request = new Request([], [], [], $session);

    // WHEN 
    $request->removeSession('test');

    //THEN 
    $this->assertNull($request->getSession('test'));
  }

  public function testShouldReturnQueryParamWhenParamExists() 
  {
    // GIVEN 
    $getParams = ['action' => 'start'];

    $request = new Request($getParams, [], [], []);

    // WHEN 
    $actual = $request->getQueryParam('action');

    // THEN 
    $this->assertSame('start', $actual);
  }

  public function testShouldReturnDefaultValueWhenQueryParamDoesNotExist() {
    // GIVEN
    $getParams = [];

    $request = new Request($getParams, [], [], []);

    // WHEN
    $actual = $request->getQueryParam('page', 10);

    // THEN
    $this->assertSame(10, $actual);
  }

  public function testShouldReturnFormParamWhenParamExists()
  {
    // GIVEN 
    $postParams = ['title' => 'start'];

    $request = new Request([], $postParams, [], []);

    // WHEN 
    $actual = $request->getFormParam('title');

    // THEN 
    $this->assertSame('start', $actual);
  }

  public function testShouldReturnDefaultValueWhenFormParamDoesNotExist()
  {
    // GIVEN
    $postParams = [];

    $request = new Request([], $postParams, [], []);

    // WHEN
    $actual = $request->getFormParam('title', 'tekst');

    // THEN
    $this->assertSame('tekst', $actual);
  }

  public function testShouldReturnGetMethodByDefault()
  {
    // GIVEN
    $request = new Request([], [], [], []);

    // WHEN 
    $actual = $request->getMethod();

    // THEN 
    $this->assertSame('GET', $actual);
  }

  public function testShouldReturnCorrectMethodFromHeaders()
  {
    // GIVEN
    $serverParams = ['REQUEST_METHOD' => 'DELETE'];
    $request = new Request([], [], $serverParams, []);

    // WHEN
    $actual = $request->getMethod();

    // THEN
    $this->assertSame('DELETE', $actual);
  }

  public function testShouldDetectPostMethod() {
    // GIVEN
    $serverParams = ['REQUEST_METHOD' => 'POST'];
    $request = new Request([], [], $serverParams, []);

    // WHEN 
    $actual = $request->isPost();

    // THEN 
    $this->assertTrue($actual);
  }

  public function testShouldReturnTrueWhenHasPost() {
    // GIVEN
    $post = ['title' => 'start'];
    $request = new Request([], $post, [], []);

    // WHEN 
    $actual = $request->hasPost();

    // THEN 
    $this->assertTrue($actual);
  }

  public function testShouldReturnFalseWhenHasNotPost()
  {
    // GIVEN
    $post = [];
    $request = new Request([], $post, [], []);

    // WHEN 
    $actual = $request->hasPost();

    // THEN 
    $this->assertFalse($actual);
  }

  public function testShouldReturnEmptyErrorsArray()
  {
    // GIVEN
    $request = new Request([], [], [], []);

    // WHEN
    $errors = $request->getErrors();

    // THEN
    $this->assertEmpty($errors);
  }

  public function testShouldResolveControllerKeyWhenQueryParamMatches() {
    // GIVEN
    $get = ['auth' => ''];
    $request = new Request($get, [], [], []);

    $factories = [
      'auth' => '',
      'site' => 'SiteController',
      'dashboard' => 'DashboardController'
    ];

    // WHEN 
    $key = $request->resolverControllerKey($factories);

    // THEN 
    $this->assertSame('auth', $key);
  }

  public function testShouldReturnDefaultSiteKeyWhenNotMatchFound(){
    // GIVEN
    $get = ['start' => ''];
    $request = new Request($get, [], [], []);

    $factories = [
      'auth' => '',
      'site' => 'SiteController',
      'dashboard' => 'DashboardController'
    ];

    // WHEN 
    $key = $request->resolverControllerKey($factories);

    // THEN 
    $this->assertSame('site', $key);
  }

  public function testShouldReturnDefaultSiteKeyWhenFactoriesListIsEmpty(){
    // GIVEN
    $get = ['auth' => ''];
    $request = new Request($get, [], [], []);

    $factories = [];

    // WHEN 
    $key = $request->resolverControllerKey($factories);

    // THEN 
    $this->assertSame('site', $key);
    
  }

  public function testShouldReturnDefaultSiteKeyWhenGetParamsAreEmpty()
  {
    // GIVEN
    $get = [];
    $request = new Request($get, [], [], []);

    $factories = [
      'auth' => '',
      'site' => 'SiteController',
      'dashboard' => 'DashboardController'
    ];

    // WHEN 
    $key = $request->resolverControllerKey($factories);

    // THEN 
    $this->assertSame('site', $key);
  }

  public function testShouldReturnErrorWhenRequiredFieldIsMissingInValidation(){
    // GIVEN 
    $request = new Request([], [], [], []);

    // WHEN 
    $actual = $request->validate('title', true);
    $errors = $request->getErrors();

    // THEN 
    $this->assertNull($actual);
    $this->assertArrayHasKey('title', $errors);
    $this->assertSame('To pole jest wymagane.', $errors['title']);
  }

  public function testShouldReturnIntegerWhenValidationTypeIsInt() {
    // GIVEN
    $post = ['number' => '10'];
    $request = new Request([], $post, [], []);

    // WHEN 
    $actual = $request->validate('number', true, 'int');
    $errors = $request->getErrors();

    // THEN 
    $this->assertSame(10, $actual);
    $this->assertEmpty($errors); 
  }

  public function testShouldReturnErrorAndNullWhenStringIsGivenAndExpectedValidationValueIsInteger()
  {
    // GIVEN
    $post = ['number' => 'test'];
    $request = new Request([], $post, [], []);

    // WHEN 
    $actual = $request->validate('number', true, 'int');
    $errors = $request->getErrors();

    // THEN 
    $this->assertNull($actual);
    $this->assertArrayHasKey('number', $errors);
    $this->assertSame('Pole musi zawierać tylko liczby całkowite.', $errors['number']);
  }

  public function testShouldReturnErrorWhenStringIsTooLong() {
    // GIVEN 
    $post = ['title' => 'Test title'];
    $request = new Request([], $post, [], []);

    // WHEN 
    $actual = $request->validate('title', true, 'string', 5);
    $errors = $request->getErrors();

    // THEN 
    $this->assertArrayHasKey('title', $errors);
    $this->assertSame('Długość pola musi być mniejsza niz 5. znaków', $errors['title']);
  }

  public function testShouldReturnErrorWhenStringIsTooShort()
  {
    // GIVEN 
    $post = ['title' => 'Test title'];
    $request = new Request([], $post, [], []);

    // WHEN 
    $actual = $request->validate('title', true, 'string', null, 15);
    $errors = $request->getErrors();

    // THEN 
    $this->assertArrayHasKey('title', $errors);
    $this->assertSame('Długość pola musi być większa niz 15. znaków', $errors['title']);
  }
}