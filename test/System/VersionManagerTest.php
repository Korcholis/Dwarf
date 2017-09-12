<?php
use Dwarf\Dwarf;
use Dwarf\System\VersionManager;

class VersionManagerTest extends  PHPUnit\Framework\TestCase {
  private $dwarf = null;
  private $versionManager = null;

  private $config = [
    'rootPath' => __DIR__ . "/..",
    'versions' => [
      [ 'code' => 'v1', 'strong_code' => 'v1', 'release_date' => '2010-06-10', 'grace_period' => '2Y' ],
      [ 'code' => 'v2', 'strong_code' => 'v2', 'release_date' => '2011-07-20', 'grace_period' => '1Y' ],
      [ 'code' => 'v3', 'strong_code' => 'v3', 'release_date' => '2013-02-05', 'grace_period' => '2Y' ],
      [ 'code' => 'v4', 'strong_code' => 'v4', 'release_date' => '2014-08-15', 'grace_period' => '6M' ]
    ]
  ];

  public function setUp() {
    $this->dwarf = new Dwarf($this->config);
    $this->versionManager = $this->dwarf->getVersionManager();
  }

  public function testIfClassInheritsDwarfPlugin() {
    $this->assertTrue(is_subclass_of($this->versionManager, 'Dwarf\\Base\\DwarfPlugin'));
  }
}