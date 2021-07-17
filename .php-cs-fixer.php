<?php

$header = <<<'EOF'
This file is part of PHP Nominatim.
(c) Maxime Hélias <maximehelias16@gmail.com>
This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/examples')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP74Migration:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        'date_time_immutable' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'expectedException',
                'expectedExceptionMessage',
                'expectedExceptionMessageRegExp'
            ]
        ],
        'global_namespace_import' => true,
        'header_comment' => [
            'comment_type' => 'PHPDoc',
            'header' => $header,
            'location' => 'after_declare_strict'
        ],
        'linebreak_after_opening_tag' => true,
        'list_syntax' => ['syntax' => 'short'],
        'mb_str_functions' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_interfaces' => true,
        'php_unit_strict' => false,
        'phpdoc_line_span' => true,
        'self_static_accessor' => true,
        'simplified_null_return' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/.php_cs.cache');
