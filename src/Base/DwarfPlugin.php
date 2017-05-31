<?php

namespace Dwarf\Base;

abstract class DwarfPlugin {
  private $dwarf = null;

  public function __construct(\Dwarf\Dwarf $dwarf) {
    $this->dwarf = $dwarf;
  }

  public function getDwarf() {
    return $this->dwarf;
  }
}
