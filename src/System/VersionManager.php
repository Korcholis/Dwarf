<?php

namespace Dwarf\System;

class VersionManager extends \Dwarf\Base\DwarfPlugin {
  private $versions = [];

  public function __construct(\Dwarf\Dwarf $dwarf) {
    parent::__construct($dwarf);
    \Dwarf\Model\Version::bind($dwarf);
  }

  public function addVersion($code, $strongCode, $releaseDate, $gracePeriod) {
    if (!empty($this->versions)) {
      $this->versions[0]->setLatest(false);
      $this->versions[0]->setDeprecationDate($releaseDate);
      $this->versions[0]->buildObsolescenceDate($releaseDate, $this->versions[0]->getGracePeriod());
    }

    $version = new \Dwarf\Model\Version($code, $strongCode, $releaseDate, $gracePeriod);
    $version->setLatest(true);

    array_unshift($this->versions, $version);
  }

  public function getVersions() {
    return $this->versions;
  }

  public function getLatestVersion() {
    for ($i=0; $i < count($this->versions); $i++) { 
      if ($this->versions[$i]->isLatest()) {
        return $this->versions[$i];
      }
    }

    return false;
  }

  public function getVersionByCode($code) {
    for ($i=0; $i < count($this->versions); $i++) { 
      if ($this->versions[$i]->getCode() == $code) {
        return $this->versions[$i];
      }
    }

    return false;
  }

  public function isVersionAvailable($code) {
    if ($this->getVersionByCode($code) === false) {
      return false;
    }
    return true;
  }
}