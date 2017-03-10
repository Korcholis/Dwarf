<?php

namespace Dwarf\System;

class Brush extends \Dwarf\Bases\DwarfPlugin {

  private $templateAliases = [];
  private $templatePath = null;

  public function __construct() {
    parent::__construct();
    $this->templatePath = $this->getDwarf()->getTemplatePath();
  }

  public function addTemplateDirectory($alias, $path) {
    if (isset($this->templateAliases[$alias])) {
      // FIXME
    } else {
      $this->templateAliases[$alias] = $this->templatePath . DIRECTORY_SEPARATOR . $path;
    }
  }

  public function render($template, $variables = []) {
    $templateFullPath = $this->guessTemplateFullPath($template);
    $this->show($templateFullPath, $variables);
  }

  private function guessTemplateFullPath($template) {
    $templateParts = explode("/", $template);
    switch (count($templateParts)) {
      case 1:
        $templateName = $template;
        $tempFullPath = $this->templatePath . DIRECTORY_SEPARATOR . $template;
        break;
      default:
        $templateName = array_pop($templateParts);
        $templateDir = implode("/", $templateParts);
        if (isset($this->templateAliases[$templateDir])) {
          $tempFullPath = $this->templateAliases[$templateDir] . DIRECTORY_SEPARATOR . $templateName;
        } else {
          $tempFullPath = $this->templatePath . DIRECTORY_SEPARATOR . $templateDir . DIRECTORY_SEPARATOR . $templateName;
        }
        break;
    }
    return $tempFullPath . ".php";
  }

  private function show($templateFullPath, $variables) {
    foreach ($variables as $key => $value) {
      $$key = $value;
    }
    require $templateFullPath;
  }

  public function include($template, $variables = []) {
    $templateFullPath = $this->guessTemplateFullPath($template);
    $this->show($templateFullPath, $variables);
  }
}
