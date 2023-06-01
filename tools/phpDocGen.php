#!/usr/bin/env php
<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

const PREFIX_FN_BOTTOMLINE = 'bottomline_';

use __\DocGen\DocumentationRegistry;
use __\DocGen\FunctionDocumentation;
use __\DocGen\Parsers;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Serializer;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Void_;
use PhpParser\Comment;
use PhpParser\Comment\Doc;
use PhpParser\Node\Stmt;
use PhpParser\PrettyPrinter\Standard;

/**
 * Render a given DocBlock as a string.
 *
 * @param DocBlock $docBlock
 *
 * @return string
 */
function writeDocBlock(DocBlock $docBlock)
{
    return (new Serializer())->getDocComment($docBlock);
}

//
// Documentation registration
//

Parsers::setup();
$registry = new DocumentationRegistry();

// Find all registered bottomline functions
foreach (glob(dirname(__DIR__) . '/src/__/**/*.php') as $file) {
    $registry->registerDocumentationFromFile($file);
}

//
// Build our Sequence wrapper
//

function buildSequenceWrapper()
{
    global $registry;

    $methodDocs = __::chain($registry->methods)
        ->map(function (FunctionDocumentation $fxnDoc) {
            if ($fxnDoc->returnType instanceof Void_) {
                return null;
            }

            $method = $fxnDoc->asMethodTag();

            return new Method(
                $method->getMethodName(),
                __::drop($method->getArguments(), 1),
                new Object_(new Fqsen('\BottomlineWrapper')),
                true,
                $method->getDescription()
            );
        })
        ->filter()
        ->value()
    ;

    $docBlock = new DocBlock(
        'An abstract base class for documenting our sequence support',
        null,
        $methodDocs
    );
    $docBlockLiteral = writeDocBlock($docBlock);

    $filePath = dirname(__DIR__) . '/src/__/sequences/BottomlineWrapper.php';
    $fileAST = Parsers::$phpParser->parse(file_get_contents($filePath));

    /** @var Stmt\Class_ $classAST */
    $classAST = $fileAST[0];
    $classAST->setAttribute('comments', []); // Strip all comments, We'll take care of them
    $classAST->setDocComment(new Doc($docBlockLiteral));

    $phpPrinter = new Standard();
    $builtWrapper = <<<WRAPPER
<?php

// Do NOT modify this doc block, it is automatically generated.
{$phpPrinter->prettyPrint($fileAST)}
WRAPPER;

    file_put_contents($filePath, $builtWrapper . "\n");
}

buildSequenceWrapper();

//
// Build our loader
//

function buildCoreFunctionLoader()
{
    global $registry;

    $loaderFilePath = dirname(__DIR__) . '/src/__/__.php';
    $loaderAST = Parsers::$phpParser->parse(file_get_contents($loaderFilePath));
    $astNodes = &$loaderAST[0]->stmts;

    $docBlockLiteral = writeDocBlock(new DocBlock(
        '',
        null,
        __::map($registry->methods, static fn (FunctionDocumentation $fxnDoc) => $fxnDoc->asMethodTag())
    ));

    /** @var Stmt $astNode */
    foreach ($astNodes as &$astNode) {
        if ($astNode->getType() === 'Stmt_Class') {
            // We found our class definition, let's update all the @method definitions
            $astNode->setDocComment(new Doc($docBlockLiteral));
        } elseif ($astNode->getType() === 'Stmt_If') {
            $commentRegex = '/\*\*\s([a-zA-Z]+)\s+\[(\d+)\]/m';

            /** @var Comment $comment */
            $comment = __::first($astNode->getAttribute('comments'));
            $commentLiteral = preg_replace_callback($commentRegex, function ($matches) use ($registry) {
                $namespace = strtolower($matches[1]);

                return str_replace($matches[2], $registry->namespaceCount[$namespace], $matches[0]);
            }, $comment->getText());

            $commentBlock = new Comment($commentLiteral);
            $astNode->setAttribute('comments', [$commentBlock]);
        }
    }

    $phpPrinter = new Standard();
    $builtLoader = "<?php\n\n" . $phpPrinter->prettyPrint($loaderAST) . "\n";
    $builtLoader = preg_replace('/ +$/m', '', $builtLoader);
    $builtLoader = preg_replace('/(}\n)(\s+\w)/m', "$1\n$2", $builtLoader);

    file_put_contents($loaderFilePath, $builtLoader);
}

buildCoreFunctionLoader();

//
// Build our registry for our documentation website
//

function buildWebsiteFunctionRegistry()
{
    global $registry;

    $filePath = dirname(__DIR__) . '/docs/_data/fxn_registry.json';

    file_put_contents(
        $filePath,
        json_encode($registry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    );
}

buildWebsiteFunctionRegistry();
