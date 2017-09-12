<?php
use Dwarf\Model\Version;

final class VersionTest extends PHPUnit\Framework\TestCase {
  private $version;

  public function setUp() {
    $this->version = new Version('v1','v1','2016-12-20');
  }

  public function testMethod() {
    $this->assertEquals('v1', $this->version->getCode());
  }

  public function testRequestParameters() {
    $this->assertEquals(new \DateTime('2016-12-20'), $this->version->getReleaseDate());
  }
}
