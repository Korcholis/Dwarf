<?php

namespace Dwarf\System;

class Brush extends Dwarf\Bases\DwarfPlugin {

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

  public function render($template) {
    $templateFullPath = $this->guessTemplateFullPath($template);
    $this->show($templateFullPath);
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

  private function show($templateFullPath) {
    require $templateFullPath;
  }

  public function include($template) {
    $templateFullPath = $this->guessTemplateFullPath($template);
    $this->show($templateFullPath);
  }
}
