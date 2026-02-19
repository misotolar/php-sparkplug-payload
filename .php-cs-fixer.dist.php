<?php

/**
 * This file is part of PHP Sparkplug Payload.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require 'vendor/autoload.php';

$header = <<<'EOF'
This file is part of PHP Sparkplug Payload.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return (new PhpCsFixer\Config)
    ->setFinder((new PhpCsFixer\Finder)->ignoreVCSIgnored(true)->exclude([
        'Metadata',
        'Payload',
        'DataType.php',
        'Payload.php',
    ])->in('src'))
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        'blank_line_before_statement' => false,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'echo_tag_syntax' => [
            'format' => 'short',
        ],
        'header_comment' => [
            'header' => $header,
            'comment_type' => 'PHPDoc',
            'location' => 'after_open',
            'separate' => 'both',
        ],
        'increment_style' => [
            'style' => 'post',
        ],
        'native_function_invocation' => [
            'include' => ['@internal'],
        ],
        'native_constant_invocation' => [
            'include' => ['@internal'],
        ],
        'new_with_braces' => false,
        'no_alternative_syntax' => [
            'fix_non_monolithic_code' => false,
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => [
                'const',
                'class',
                'function',
            ],
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_no_package' => false,
        'phpdoc_to_comment' => false,
        'phpdoc_summary' => false,
        'protected_to_private' => false,
        'return_assignment' => false,
    ])
;
