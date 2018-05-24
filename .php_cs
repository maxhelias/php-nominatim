<?php

$header = <<<'EOF'
This file is part of PHP Nominatim.
(c) Maxime Hélias <maximehelias16@gmail.com>
This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->exclude(__DIR__ . '/docs')
    ->in(__DIR__ . '/examples')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'combine_consecutive_unsets' => true,
        '@PHP70Migration:risky' => true,
        '@PHP71Migration' => true,
        'binary_operator_spaces' => [
            'align_equals' => false,
            'align_double_arrow' => true
        ],
        'combine_consecutive_unsets' => true,
        'declare_strict_types' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'expectedException',
                'expectedExceptionMessage',
                'expectedExceptionMessageRegExp'
            ]
        ],
        'header_comment' => [
            'commentType' => 'PHPDoc',
            'header' => $header,
            'location' => 'after_declare_strict'
        ],
        'is_null' => [
            'use_yoda_style' => true
        ],
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'native_function_invocation' => true,
        'no_multiline_whitespace_before_semicolons' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => true,
        'php_unit_strict' => false,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
        'simplified_null_return' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'concat_space' => [
            'spacing' => 'one'
        ],
        'trailing_comma_in_multiline_array' => true
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/.php_cs.cache');
