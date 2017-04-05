<?php
use Dwarf\Connection\Request;

final class RequestTest extends PHPUnit\Framework\TestCase {
  private $request;

  public function setUp() {
    $this->request = new Request(['REQUEST_METHOD' => 'POST'], [], []);
  }

  public function testMethod() {
    $this->assertEquals('POST', $this->request->getMethod());
  }

  public function testRequestParameters() {
    $this->assertEquals([], $this->request->getParameters());
  }
}
