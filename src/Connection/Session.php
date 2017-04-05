<?php

namespace Dwarf\Connection;

class Session {
  private $sessionData;

  public function __construct($sessionData = null) {
    if (isset($sessionData)) {
      $this->sessionData = $sessionData;
    } else {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      $this->sessionData = $_SESSION;
    }
  }

  public function isUserLoggedIn() {
    return false;
  }
}