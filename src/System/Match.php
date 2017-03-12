<?php

namespace Dwarf\System;

class Match {

  private $routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
  ];

  private static $__instance = null;

  public static function instance() {
    if (!isset(self::$__instance)) {
      self::$__instance = new Match;
    }
    return self::$__instance;
  }

  private function __construct() {

  }

  public function get($path, $action) {
    $this->saveRoute('GET', $path, $action);
    return $this;
  }

  public function post($path, $action) {
    $this->saveRoute('POST', $path, $action);
    return $this;
  }

  public function put($path, $action) {
    $this->saveRoute('PUT', $path, $action);
    return $this;
  }

  public function delete($path, $action) {
    $this->saveRoute('DELETE', $path, $action);
    return $this;
  }

  public function any($path, $action) {
    $this->get($path, $action);
    $this->post($path, $action);
    $this->put($path, $action);
    $this->delete($path, $action);
    return $this;
  }

  private function saveRoute($verb, $path, $action) {
    $path = preg_replace_callback("@{(\w+)(:(\d*,?\d*))?(\?)?}(/)?@", function($match) {
      $block = "?<" . $match[1] . ">[^/]";
      if (!empty($match[3])) {
        $block .= '{' . $match[3] . '}';
      } else {
        $block .= '+';
      }
      $block = "($block)";
      if (!empty($match[4]) && $match[4] == "?") {
        if (!empty($match[5]) && $match[5] == "/") {
          $block = "(" . $block . "/?)?";
        } else {
          $block = "(" . $block . ")?";
        }
      } else {
        if (!empty($match[5]) && $match[5] == "/") {
          $block .= "/";
        }
      }
      return $block;
    }, $path);

    $this->routes[$verb][$path] = $action;
  }

  public function fire() {
    $possibleUri = $_SERVER['REQUEST_URI'];
    foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $possiblePath => $action) {
      if (preg_match("@^$possiblePath$@", $possibleUri, $matches) === 1) {
        $this->callFunction($action, $this->getParametersFor($matches));
        exit;
      } elseif ($possibleUri[strlen($possibleUri) - 1] == "/") {
        $anotherPossibleUri = substr($possibleUri, 0, -1);
        if (preg_match("@^$possiblePath$@", $anotherPossibleUri, $matches) === 1) {
          $this->callFunction($action, $this->getParametersFor($matches));
          exit;
        }
      } else {
        $anotherPossibleUri = "$possibleUri/";
        if (preg_match("@^$possiblePath$@", $anotherPossibleUri, $matches) === 1) {
          $this->callFunction($action, $this->getParametersFor($matches));
          exit;
        }
      }
    }
    echo 'Error';
    exit;
  }

  private function getParametersFor($matches) {
    $foundMatches = [];
    foreach ($matches as $key => $value) {
      if (!is_integer($key)) {
        $foundMatches[$key] = $value;
      }
    }
    return $foundMatches;
  }

  private function callFunction($action, $parameters) {
    $invoker = new \Invoker\Invoker;

    $invoker->call($action, $parameters);
  }
}
