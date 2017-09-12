<?php

namespace Dwarf\Base;

abstract class DwarfClass {
  protected static $dwarf = null;

  public static function bind(\Dwarf\Dwarf $dwarf) {
    static::$dwarf = $dwarf;
  }

  public static function getDwarf() {
    if (!isset(static::$dwarf)) {
      // FIXME
    }
    return static::$dwarf;
  }
}
