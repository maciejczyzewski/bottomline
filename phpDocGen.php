<?php

if (\version_compare(PHP_VERSION, '5.5.9', '<')) {
    die("This script should be run with a PHP version higher than 5.5.9 due to dependency constraints.\n");
}

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Serializer;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlockFactory;

require_once __DIR__ . '/vendor/autoload.php';

//
// Find all registered bottomline functions
//

$phpFunctions = get_defined_functions();

foreach (glob(__DIR__ . '/src/__/**/*.php') as $file) {
    include $file;
}

$newFunctions = get_defined_functions();
$bottomlineFunctions = array_diff($newFunctions['user'], $phpFunctions['user']);

//
// Setup
//

$markdown = new Parsedown();
$docBlockFactory = DocBlockFactory::createInstance();
$bottomlineMethods = [];

foreach ($bottomlineFunctions as $fxn) {
    try {
        $functionDefinition = new ReflectionFunction($fxn);
        $docBlock = $docBlockFactory->create($functionDefinition->getDocComment());

        $functionName = str_replace($functionDefinition->getNamespaceName() . '\\', '', $functionDefinition->getName());
        $functionArguments = $docBlock->getTagsByName('param');

        $argDefs = [];

        /** @var Param $argument */
        foreach ($functionArguments as $argument) {
            $argDefs[] = [
                'name' => $argument->getName(),
                'type' => $argument->getType(),
            ];
        }

        $functionSummary = $markdown->text($docBlock->getSummary());
        $functionDescription = $markdown->text($docBlock->getDescription()->render());

        $descriptionBody = trim(preg_replace('/\n/', '', nl2br($functionSummary . "\n" . $functionDescription)));
        $description = new Description($descriptionBody);

        $functionReturnType = collections\first($docBlock->getTagsByName('return'));

        if ($functionReturnType !== null) {
            $functionReturnType = $functionReturnType->getType();
        }

        $bottomlineMethods[] = new Method($functionName, $argDefs, $functionReturnType, true, $description);
    }
    catch (\Exception $e) {
        printf("Exception message: %s\n", $e->getMessage());
        printf("  %s\n\n", $fxn);
    }
}

$serializer = new Serializer();
$bottomlineDocBlock = new DocBlock('', null, $bottomlineMethods);

echo $serializer->getDocComment($bottomlineDocBlock) . "\n";
