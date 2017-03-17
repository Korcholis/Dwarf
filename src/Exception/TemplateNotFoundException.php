<?php

namespace Dwarf\Exception;

class TemplateNotFoundException extends \ErrorException {
  public function __construct($template) {
    parent::__construct("There is no template file at {$template}.");
  }
}
