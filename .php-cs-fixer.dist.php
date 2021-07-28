<?php

$finder = (new PhpCsFixer\Finder())
	->in(__DIR__)
	->exclude('var')
;

return (new PhpCsFixer\Config())
	->setUsingCache(false)
	->setRules([
		'@Symfony' => true,
		'indentation_type' => true,
		'linebreak_after_opening_tag' => false,
		'blank_line_after_opening_tag' => false,
	])
	->setIndent("\t")
	->setLineEnding("\n")
	->setFinder($finder)
;
