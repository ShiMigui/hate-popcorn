<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude(['vendor']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'strict_param'           => true,
        'declare_strict_types'   => true,
        'array_syntax'           => ['syntax' => 'short'],
        'ordered_imports'        => true,
        'no_unused_imports'      => true,
        'single_quote'           => true,
        'no_extra_blank_lines'   => true,
        'no_trailing_whitespace' => true,
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
        ],
        'phpdoc_to_comment'          => false,
        'no_superfluous_phpdoc_tags' => true,
        'no_useless_return'          => true,
        'no_useless_else'            => true,
        'ordered_class_elements'     => true,
        'concat_space'       => ['spacing' => 'one'],
    ])
    ->setFinder($finder);
