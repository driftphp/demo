<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('web')
    ->exclude('bin')
    ->exclude('var')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'single_line_after_imports' => false,
        'no_superfluous_phpdoc_tags' => false
    ])
    ->setFinder($finder)
;