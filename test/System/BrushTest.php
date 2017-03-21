<?php
use Dwarf\Dwarf;
use Dwarf\System\Brush;
use Dwarf\Exception\TemplateNotFoundException;

class BrushTest extends  PHPUnit\Framework\TestCase {

  private $dwarf = null;
  private $brush = null;
  private $config = [
    'rootPath' => __DIR__ . "/.."
  ];

  public function setUp() {
    $this->dwarf = new Dwarf($this->config);
    $this->brush = new Brush($this->dwarf);
  }

  public function testIfClassInheritsDwarfPlugin() {
    $this->assertTrue(is_subclass_of($this->brush, 'Dwarf\\Base\\DwarfPlugin'));
  }

  public function testRenderTemplate() {
    $this->brush->render('found_template');
    $this->assertEquals(true, true);
  }

  public function testRenderNotFoundTemplate() {
    $this->expectException(TemplateNotFoundException::class);
    $this->brush->render('not_found_template');
  }
}
