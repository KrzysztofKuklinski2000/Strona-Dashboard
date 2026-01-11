<?php 

namespace Tests\Core;

use App\Core\FileHandler;
use App\Exception\FileException;
use PHPUnit\Framework\TestCase;

class FileHandlerTest extends TestCase
{
  protected function setUp(): void
  {
    global $mockMoveUploadedFileResult, $mockIsDirResult;
    $mockMoveUploadedFileResult = true; 
    $mockIsDirResult = true;         
  }

  public function testShouldThrowFileExceptionWhenUploadImageFails() {
    // EXPECT 
    $this->expectException(FileException::class);
    $this->expectExceptionMessage('Błąd podczas przesyłania pliku');
    
    // GIVEN 
    $fileHandler = new FileHandler();

    $file = [
      'name' => 'test.jpg',
      'type' => 'image/jpeg',
      'tmp_name' => '/tmp/phpfaketmp',
      'error' => UPLOAD_ERR_CANT_WRITE,
      'size' => 12345,
    ];
    // WHEN

    $fileHandler->uploadImage($file);
  }

  public function testShouldUploadImageFileSuccessfullyAndReturnGeneratedName() {
    // GIVEN 
    $fileHandler = new FileHandler();

    $file = [
      'name' => 'test.jpg',
      'tmp_name' => '/tmp/phpfaketmp',
      'error' => 0,
    ];

    // WHEN 
    $actual = $fileHandler->uploadImage($file);

    // THEN 
    $this->assertNotEmpty($actual);
    $this->assertStringStartsWith('karate_', $actual);
    $this->assertStringEndsWith('.jpg', $actual);
  }

  public function testShouldThrowFileExceptionWhenMoveUploadedFileFails() {
    // EXPECT 
    $this->expectException(FileException::class);
    $this->expectExceptionMessage('Nie udało się przesłać obrazka');

    // GIVEN 
    $fileHandler = new FileHandler();

    $file = [
      'name' => 'test.jpg',
      'tmp_name' => '/tmp/phpfaketmp',
      'error' => 0,
    ];

    global $mockMoveUploadedFileResult;
    $mockMoveUploadedFileResult = false;

    // WHEN 
    $fileHandler->uploadImage($file);

  }

  public function testShouldCreateDirectoryIfItDoesNotExistAndUploadImageSuccessfully() {
    // GIVEN 
    $fileHandler = new FileHandler();

    $file = [
      'name' => 'test.jpg',
      'tmp_name' => '/tmp/phpfaketmp',
      'error' => 0,
    ];

    global $mockIsDirResult;
    $mockIsDirResult = false;

    // WHEN 
    $actual = $fileHandler->uploadImage($file);

    // THEN
    $this->assertNotEmpty($actual);
    $this->assertStringStartsWith('karate_', $actual);
    $this->assertStringEndsWith('.jpg', $actual);
  }

  public function testShouldThrowFileExceptionWhenFileArrayIsEmpty() {
    // EXPECT 
    $this->expectException(FileException::class);
    $this->expectExceptionMessage('Nieprawidłowe dane pliku.');

    // GIVEN 
    $fileHandler = new FileHandler();

    $file = [];

    // WHEN 
    $fileHandler->uploadImage($file);
  }

  public function testShouldPreserveFileExtensionCase() {
    // GIVEN
    $fileHandler = new FileHandler();

    $file = [
      'name' => 'Test.JPG',
      'tmp_name' => '/tmp/phpfaketmp',
      'error' => 0
    ];

    // WHEN
    $actual = $fileHandler->uploadImage($file);
    
    // THEN
    $this->assertStringEndsWith('.JPG', $actual);
  }
}

namespace App\Core;

$mockMoveUploadedFileResult = true;
$mockIsDirResult = true;

function move_uploaded_file(string $from, string $to): bool
{
  global $mockMoveUploadedFileResult;
  return $mockMoveUploadedFileResult;
}

function is_dir(string $filename): bool
{
  global $mockIsDirResult;
  return $mockIsDirResult;
}

function mkdir(string $directory, int $permissions = 0777, bool $recursive = false, $context = null): bool
{
  return true; 
}