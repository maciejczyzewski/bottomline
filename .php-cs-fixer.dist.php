<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('./vendor/')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
$config
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
    ])
    ->setFinder($finder)
;

return $config;
