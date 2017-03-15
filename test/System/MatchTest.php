<?php
use Dwarf\Dwarf;
use Dwarf\System\Match;

class MatchTest extends  PHPUnit\Framework\TestCase {

  private $dwarf = null;
  private $match = null;
  private $config = [
    'rootPath' => __DIR__
  ];

  public function setUp() {
    $this->dwarf = new Dwarf($this->config);
    $this->match = new Match($this->dwarf);
  }

  public function testPathsWithoutParameters() {
    $this->match->get('/', function() { return 1; });
    $this->match->get('/blog', function() { return 2; });
    $this->match->get('/blog/archive', function() { return 3; });

    $this->assertEquals(1, $this->match->fire('get', '/'));
    $this->assertEquals(3, $this->match->fire('get', '/blog/archive'));
    $this->assertEquals(2, $this->match->fire('get', '/blog'));
  }
}
