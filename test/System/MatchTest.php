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

  public function testIfClassInheritsDwarfPlugin() {
    $this->assertTrue(is_subclass_of($this->match, 'Dwarf\\Bases\\DwarfPlugin'));
  }

  public function testPathsWithoutParameters() {
    $this->match->get('/', function() { return 1; });
    $this->match->post('/blog', function() { return 2; });
    $this->match->get('/blog/archive', function() { return 3; });

    $this->assertEquals(1, $this->match->fire('get', '/'));
    $this->assertEquals(3, $this->match->fire('get', '/blog/archive'));
    $this->assertEquals(2, $this->match->fire('post', '/blog'));
    $this->assertEquals('Error', $this->match->fire('get', '/made-up-query'));
    $this->assertEquals('Error', $this->match->fire('get', '/blog'));
  }

  public function testPathsWithParameters() {
    $this->match->get('/test1/{var1}', function($var1) { return $var1; });
    $this->match->get('/test2/{var2:1,5}', function($var2) { return "test2.1:$var2"; });
    $this->match->get('/test2/{var2:6,}', function($var2) { return "test2.2:$var2"; });
    $this->match->get('/test3/{reqvar}/{optvar?}', function($reqvar, $optvar = 'empty') { return "$reqvar$optvar"; });

    $this->assertEquals('test', $this->match->fire('get', '/test1/test'));
    $this->assertEquals('test2.1:short', $this->match->fire('get', '/test2/short'));
    $this->assertEquals('test2.2:much-much-longer', $this->match->fire('get', '/test2/much-much-longer'));
    $this->assertEquals('prefilledprefilled', $this->match->fire('get', '/test3/prefilled/prefilled'));
    $this->assertEquals('prefilledempty', $this->match->fire('get', '/test3/prefilled'));
  }
}
