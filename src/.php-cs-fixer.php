<?php

$finder = PhpCsFixer\Finder::create()
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/tests')
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP81Migration' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'general_phpdoc_annotation_remove' => ['annotations' => ['expectedDeprecation']], // one should use PHPUnit built-in method instead
        'heredoc_indentation' => false,
        'modernize_strpos' => true, // needs PHP 8+ or polyfill
        'use_arrow_functions' => false, // TODO switch on when # of PR's is lower
    ])
    ->setFinder($finder)
;

return $config;
