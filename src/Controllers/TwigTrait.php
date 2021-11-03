<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait TwigTrait
{
    protected Environment $templating;

    public function renderHtml($template, array $params = [])
    {
        $this->configure();
        return $this->templating->render($template, $params);
    }

    protected function configure()
    {
        $loader = new FilesystemLoader(__DIR__.'/../../templates');
        $this->templating = new Environment($loader);
        $this->templating->addGlobal('session', $_SESSION);
    }
}
