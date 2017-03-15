<?php
use Dwarf\Dwarf;

final class DwarfTest extends PHPUnit\Framework\TestCase {

  private $config = [
    'rootPath' => __DIR__
  ];

  private $dwarf = null;

  public function setUp() {
    $this->dwarf = new Dwarf($this->config);
  }

  public function testCanBeInstanced() {
    $this->assertInstanceOf(
      Dwarf::class,
      $this->dwarf
    );
  }

  public function testPaths() {
    $this->assertEquals(
      realpath(__DIR__),
      $this->dwarf->getRootPath()
    );

    $this->assertEquals(
      realpath(__DIR__ . DIRECTORY_SEPARATOR . 'app'),
      $this->dwarf->getAppPath()
    );
    $this->assertEquals(
      realpath(__DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'templates'),
      $this->dwarf->getTemplatePath()
    );
  }
}
