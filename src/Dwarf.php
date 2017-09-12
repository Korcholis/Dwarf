<?php
namespace Dwarf;

class Dwarf {
  private $paths = [];
  private $versionManager = null;

  public function getRootPath() {
    return $this->paths['root'];
  }

  public function getAppPath() {
    return $this->paths['app'];
  }

  public function getTemplatePath() {
    return $this->paths['templates'];
  }

  public function __construct($config = []) {
    if (isset($config['rootPath'])) {
      $this->paths['root'] = $config['rootPath'];
    } else {
      $this->paths['root'] = $this->guessRootPath();
    }
    $this->paths['app'] = $this->guessAppPath();
    $this->paths['templates'] = $this->guessTemplatePath();

    $this->versionManager = new \Dwarf\System\VersionManager($this);
    if (isset($config['versions'])) {
      foreach ($config['versions'] as $version_metadata) {
        $this->versionManager->addVersion($version_metadata['code'], $version_metadata['strong_code'], new \DateTime($version_metadata['release_date']), $version_metadata['grace_period']);
      }
    }
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

  public function getVersionManager() {
    return $this->versionManager;
  }
}

set_exception_handler(function($ex) {
  $classname = explode("\\", get_class($ex));
  $classname = array_pop($classname);
  echo "<h1>" . $classname . "</h1><p>" . $ex->getMessage() . "</p>";
});
