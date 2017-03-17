<?php
use Dwarf\Dwarf;
use Dwarf\Base\DwarfPlugin;

final class DwarfPluginTest extends PHPUnit\Framework\TestCase {

  private $config = [
    'rootPath' => __DIR__
  ];

  private $dwarf = null;
  private $class;

  public function setUp() {
    $this->dwarf = new Dwarf($this->config);

    $this->class = $this->getMockForAbstractClass('Dwarf\Bases\DwarfPlugin', ['dwarf' => $this->dwarf]);
  }

  public function testDwarfAssign() {
    $this->assertEquals($this->class->getDwarf(), $this->dwarf);
  }

}
