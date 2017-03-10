<?php

namespace dwarf\bases;

class DwarfPlugin {
  private $dwarf = null;

  public function __construct() {
    $this->dwarf = \dwarf\Dwarf::instance();
  }

  public function getDwarf() {
    return $this->dwarf;
  }
}
