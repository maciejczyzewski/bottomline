<?php

const MIN_VERSION = '5.5.9';

if (\version_compare(PHP_VERSION, MIN_VERSION, '<')) {
    die(sprintf("This script should be run with a PHP version higher than %s due to dependency constraints.\n", MIN_VERSION));
}

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Serializer;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlockFactory;
use PhpParser\Comment;
use PhpParser\Comment\Doc;
use PhpParser\Node\Stmt;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

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
$bottomlineNamespaces = [];

foreach ($bottomlineFunctions as $fxn) {
    try {
        $functionDefinition = new ReflectionFunction($fxn);
        $docBlock = $docBlockFactory->create($functionDefinition->getDocComment());

        $functionNamespace = $functionDefinition->getNamespaceName();

        if (!isset($bottomlineNamespaces[$functionNamespace])) {
            $bottomlineNamespaces[$functionNamespace] = 1;
        } else {
            $bottomlineNamespaces[$functionNamespace]++;
        }

        $functionName = str_replace($functionNamespace . '\\', '', $functionDefinition->getName());
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

$loaderDocBlock = new DocBlock('', null, $bottomlineMethods);
$docBlockSerializer = new Serializer();
$docBlockLiteral = $docBlockSerializer->getDocComment($loaderDocBlock);

//
// Build our loader
//

$BOTTOMLINE_LOADER = __DIR__ . '/src/__/load.php';

$phpParser = (new ParserFactory())->create(ParserFactory::PREFER_PHP5);
$phpPrinter = new Standard();

$bottomlineLoaderFile = $phpParser->parse(file_get_contents($BOTTOMLINE_LOADER));
$bottomlineLoaderStatements = &$bottomlineLoaderFile[0]->stmts;

$commentRegex = '/\*\*\s([a-zA-Z]+)\s+\[(\d+)\]/m';

/** @var Stmt $statement */
foreach ($bottomlineLoaderStatements as &$statement) {
    if ($statement->getType() === 'Stmt_Class') {
        $statement->setDocComment(new Doc($docBlockLiteral));
    }
    elseif ($statement->getType() === 'Stmt_If') {
        $functionCount = [];

        /** @var Comment $comments */
        $comments = collections\first($statement->getAttribute('comments'));
        $commentLiteral = preg_replace_callback($commentRegex, function($matches) use ($bottomlineNamespaces) {
            $namespace = strtolower($matches[1]);

            return str_replace($matches[2], $bottomlineNamespaces[$namespace], $matches[0]);
        }, $comments->getText());

        $commentBlock = new Comment($commentLiteral);
        $statement->setAttribute('comments', [$commentBlock]);
    }
}

$builtLoader = "<?php\n\n" . $phpPrinter->prettyPrint($bottomlineLoaderFile) . "\n";

file_put_contents($BOTTOMLINE_LOADER, $builtLoader);
