<?php
namespace Dwarf;

class Dwarf {
  private $paths = [];

  private static $__instance = null;

  public static function instance() {
    if (!isset(self::$__instance)) {
      self::$__instance = new Dwarf;
    }
    return self::$__instance;
  }

  public static function get() {
    return self::instance();
  }

  private function __construct() {
    $this->paths['root'] = $this->guessRootPath();
    $this->paths['app'] = $this->guessAppPath();
    $this->paths['templates'] = $this->guessTemplatePath();
  }

  private function guessRootPath() {
    $trace = debug_backtrace();
    $traceItem = array_pop($trace);
    unset($trace);
    if (isset($traceItem) && isset($traceItem['file'])) {
      return dirname($traceItem['file']);
    }
  }

  private function guessAppPath() {
    if (is_dir($this->paths['root'] . DIRECTORY_SEPARATOR . 'app')) {
      return $this->paths['root'] . DIRECTORY_SEPARATOR . 'app';
    } else {
      // FIXME
    }
  }

  private function guessTemplatePath() {
    if (is_dir($this->paths['app'] . DIRECTORY_SEPARATOR . 'templates')) {
      return $this->paths['app'] . DIRECTORY_SEPARATOR . 'templates';
    } else {
      // FIXME
    }
  }

  public function getRootPath() {
    return $this->paths['root'];
  }

  public function getAppPath() {
    return $this->paths['app'];
  }

  public function getTemplatePath() {
    return $this->paths['templates'];
  }
}
