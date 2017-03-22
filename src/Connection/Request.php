<?php

namespace Dwarf\Connection;

class Request {
  private $rawServerData = null;
  private $parameters = null;
  private $method = null;

  public function __construct($serverData = null, $parameters = null) {
    if (isset($serverData)) {
      $this->rawServerData = $serverData;
    } else {
      $this->rawServerData = $_SERVER;
    }
    $this->prepareServerData();

    if (isset($parameters)) {
      $this->parameters = $parameters;
    } else {
      switch ($this->method) {
        case 'GET':
          $this->parameters = $_GET;
          break;
        case 'POST':
          $this->parameters = array_merge($_GET, $_POST);
          break;
        case 'PUT':
          $this->parameters = [];
          break;
        case 'DELETE':
          $this->parameters = [];
          break;
      }
    }
  }

  private function prepareServerData() {
    $this->method = strtoupper($this->rawServerData['REQUEST_METHOD']);
  }

  public function getMethod() {
    return $this->method;
  }

  public function getParameters() {
    return $this->parameters;
  }

  public function param($key, $default = null) {
    return isset($this->parameters[$key])? $this->parameters[$key] : $default;
  }
}
