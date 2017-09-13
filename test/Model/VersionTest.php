<?php
use Dwarf\Model\Version;

final class VersionTest extends PHPUnit\Framework\TestCase {
  private $version;

  public function setUp() {
    $this->version = new Version('v3','version v3','2016-12-20', '1Y', null, null, false);
    $this->deprecatedVersion = new Version('v2','version v2','2015-10-04', '25Y', '2016-12-20', '2031-12-20', false);
    $this->obsoleteVersion = new Version('v1','version v1','2015-10-04', '1Y', '2015-10-04', '2016-10-04', false);
  }

  public function testCodes() {
    $this->assertEquals('v3', $this->version->getCode());
    $this->assertEquals('version v3', $this->version->getStrongCode());
  }

  public function testDates() {
    $this->assertEquals(new \DateTime('2016-12-20'), $this->version->getReleaseDate());
    $this->assertTrue($this->version->isCurrent());
    $this->assertTrue(!$this->version->isDeprecated());
    $this->assertTrue(!$this->version->isObsolete());

    $this->assertFalse($this->deprecatedVersion->isCurrent());
    $this->assertTrue($this->deprecatedVersion->isDeprecated());
    $this->assertFalse($this->deprecatedVersion->isObsolete());

    $this->assertFalse($this->obsoleteVersion->isCurrent());
    $this->assertTrue($this->obsoleteVersion->isDeprecated());
    $this->assertTrue($this->obsoleteVersion->isObsolete());
  }
}
