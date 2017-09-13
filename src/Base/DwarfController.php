<?php

namespace Dwarf\Base;

class DwarfController {
  protected static $dwarf = null;
  protected static $request = null;

  public static function bind(\Dwarf\Dwarf $dwarf, \Dwarf\Connection\Request $request) {
    self::$dwarf = $dwarf;
    self::$request = $request;
  }

  public static function getDwarf() {
    if (!isset(self::$dwarf)) {
      // FIXME
    }
    return self::$dwarf;
  }

  public static function getRequest() {
    if (!isset(self::$request)) {
      // FIXME
    }
    return self::$request;
  }
}