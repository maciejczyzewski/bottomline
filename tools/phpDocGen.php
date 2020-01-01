<?php

const MIN_VERSION = '5.5.9';
const PREFIX_FN_BOTTOMLINE = 'bottomline_';

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

require_once dirname(__DIR__) . '/vendor/autoload.php';

//
// Factories and other setup
//

$phpParser = (new ParserFactory())->create(ParserFactory::PREFER_PHP5);
$phpPrinter = new Standard();
$markdown = new Parsedown();
$docBlockFactory = DocBlockFactory::createInstance();
$bottomlineMethods = [];

function _registerBottomlineFunction($functionName, Comment $docBlockRaw, $namespace, $fqfn)
{
    global $docBlockFactory, $bottomlineMethods, $markdown;

    // If function name starts with an underscore, it's a helper function not part of the API
    if (substr($functionName, 0, 1) === '_') {
        return;
    }

    $docBlock = $docBlockFactory->create($docBlockRaw->getText());

    if ($namespace !== null) {
        $fullyQualifiedFunctionName = sprintf("%s\\%s", $namespace, $functionName);
    } elseif ($fqfn !== null) {
        $fullyQualifiedFunctionName = $fqfn;
    } else {
        $fullyQualifiedFunctionName = $functionName;
    }

    $functionDefinition = new ReflectionFunction($fullyQualifiedFunctionName);
    $functionArguments = $docBlock->getTagsByName('param');
    $functionArgumentDefinitions = $functionDefinition->getParameters();
    $isInternal = count($docBlock->getTagsByName('internal')) > 0;

    if ($isInternal) {
        return;
    }

    $argDefs = [];

    /** @var Param $argument */
    foreach ($functionArguments as $argument) {
        $varName = $argument->getVariableName();

        $hasDefaultValue = false;
        $defaultVal = null;

        foreach ($functionArgumentDefinitions as $argumentDefinition) {
            if ($varName === $argumentDefinition->getName() && $argumentDefinition->isOptional()) {
                $hasDefaultValue = true;
                $defaultVal = $argumentDefinition->getDefaultValue();
                break;
            }
        }

        if ($hasDefaultValue) {
            if ($defaultVal === null) {
                $varName .= ' = null';
            } elseif (is_bool($defaultVal)) {
                $varName .= ' = ' . ($defaultVal ? 'true' : 'false');
            } elseif (is_string($defaultVal)) {
                $varName .= " = '" . $defaultVal . "'";
            } elseif (is_array($defaultVal)) {
                $varName .= ' = []';
            } else {
                $varName .= ' = ' . $defaultVal;
            }
        }

        $argDefs[] = [
            'name' => $varName,
            'type' => $argument->getType(),
        ];
    }

    $functionSummary = $markdown->text($docBlock->getSummary());
    $functionDescription = $markdown->text($docBlock->getDescription()->render());

    // Extract <pre> blocks and replace their new lines with `<br>` so they can be formatted nicely by IDEs
    $codeBlocks = [];
    preg_match_all("/(<pre>(?:\s|.)*?<\/pre>)/", $functionDescription, $codeBlocks);

    // This means there were a few code blocks
    if (count($codeBlocks) == 2) {
        foreach ($codeBlocks[1] as $codeBlock) {
            $functionDescription = str_replace($codeBlock, nl2br($codeBlock), $functionDescription);
        }
    }

    $sinceChangeLog = $docBlock->getTagsByName('since');
    $exceptions = $docBlock->getTagsByName('throws');

    if (count($sinceChangeLog) > 0) {
        $functionDescription .= '<h2>Changelog</h2>';
        $functionDescription .= '<ul>';

        /** @var DocBlock\Tags\Since $item */
        foreach ($sinceChangeLog as $item) {
            $body = $markdown->text(vsprintf('`%s` - %s', [
                $item->getVersion(),
                $item->getDescription(),
            ]));

            $functionDescription .= sprintf('<li>%s</li>', $body);
        }

        $functionDescription .= '</ul>';
    }

    if (count($exceptions) > 0) {
        $functionDescription .= '<h2>Exceptions</h2>';
        $functionDescription .= '<ul>';

        /** @var DocBlock\Tags\Throws $exception */
        foreach ($exceptions as $exception) {
            $body = $markdown->text(vsprintf('`%s` - %s', [
                $exception->getType(),
                $exception->getDescription()->render(),
            ]));

            $functionDescription .= sprintf('<li>%s</li>', $body);
        }

        $functionDescription .= '</ul>';
    }
    
    $returnStatements = $docBlock->getTagsByName('return');
    /** @var DocBlock\Tags\Return_|null $functionReturnTag */
    $functionReturnTag = array_shift($returnStatements);
    
    if ($functionReturnTag !== null) {
        $functionReturnType = $functionReturnTag->getType();
        $body = $functionReturnTag->getDescription()->render();

        if ($body) {
            $functionDescription .= '<h2>Returns</h2>';
            $functionDescription .= $markdown->text($body);
        }
    } else {
        $functionReturnType = 'mixed';
    }

    $descriptionBody = trim(preg_replace('/\n/', ' ', $functionSummary . '<br>' . $functionDescription));
    $descriptionBody = preg_replace('/<br>$/', '', $descriptionBody);
    $description = new Description($descriptionBody);
    
    // Change documented names for function like max which are declared in files
    // with a function prefix name (to avoid clash with PHP generic function max).
    if (substr($functionName, 0, strlen(PREFIX_FN_BOTTOMLINE)) === PREFIX_FN_BOTTOMLINE) {
        $functionName = str_replace(PREFIX_FN_BOTTOMLINE, '', $functionName);
    }

    $bottomlineMethods[] = new Method($functionName, $argDefs, $functionReturnType, true, $description);
}

function registerBottomlineFunction($functionName, Comment $docBlockRaw, $namespace = null, $fqfn = null)
{
    try {
        _registerBottomlineFunction($functionName, $docBlockRaw, $namespace, $fqfn);
    } catch (\Exception $e) {
        printf("Exception message: %s\n", $e->getMessage());
        printf("  %s\n\n", $functionName);
    }
}

//
// Find all registered bottomline functions
//

$bottomlineNamespaces = [];

foreach (glob(dirname(__DIR__) . '/src/__/**/*.php') as $file) {
    $filename = basename($file);
    $namespace = basename(dirname($file));

    // If the file starts with an uppercase letter, then it's a class so let's not count it
    if (preg_match('/[A-Z]/', substr($filename, 0, 1)) === 1) {
        continue;
    }

    if (!isset($bottomlineNamespaces[$namespace])) {
        $bottomlineNamespaces[$namespace] = 1;
    } else {
        $bottomlineNamespaces[$namespace]++;
    }

    include $file;

    $parsedPhp = $phpParser->parse(file_get_contents($file));

    /** @var Stmt\Namespace_|Stmt\Return_ $rootElement */
    $rootElement = array_shift($parsedPhp);

    switch ($rootElement->getType()) {
        case 'Stmt_Namespace':
        {
            $nodes = $rootElement->stmts;

            foreach ($nodes as $node) {
                if ($node->getType() !== 'Stmt_Function') {
                    continue;
                }

                $functionName = $node->name;
                $comments = $node->getAttribute('comments');
                $docBlock = array_pop($comments);

                registerBottomlineFunction($functionName, $docBlock, $namespace);
            }
        }
        break;

        case 'Stmt_Return':
        {
            $functionName = pathinfo($filename, PATHINFO_FILENAME);
            $comments = $rootElement->getAttribute('comments');
            $docBlock = array_pop($comments);

            registerBottomlineFunction($functionName, $docBlock, null, $rootElement->expr->value);
        }
        break;

        default:
            break;
    }
}

$loaderDocBlock = new DocBlock('', null, $bottomlineMethods);
$docBlockSerializer = new Serializer();
$docBlockLiteral = $docBlockSerializer->getDocComment($loaderDocBlock);

//
// Build our loader
//

$BOTTOMLINE_LOADER = dirname(__DIR__) . '/src/__/load.php';

$bottomlineLoaderFile = $phpParser->parse(file_get_contents($BOTTOMLINE_LOADER));
$bottomlineLoaderStatements = &$bottomlineLoaderFile[0]->stmts;

$commentRegex = '/\*\*\s([a-zA-Z]+)\s+\[(\d+)\]/m';

/** @var Stmt $statement */
foreach ($bottomlineLoaderStatements as &$statement) {
    if ($statement->getType() === 'Stmt_Class') {
        $statement->setDocComment(new Doc($docBlockLiteral));
    } elseif ($statement->getType() === 'Stmt_If') {
        $functionCount = [];

        /** @var Comment $comments */
        $comments = collections\first($statement->getAttribute('comments'));
        $commentLiteral = preg_replace_callback($commentRegex, function ($matches) use ($bottomlineNamespaces) {
            $namespace = strtolower($matches[1]);

            return str_replace($matches[2], $bottomlineNamespaces[$namespace], $matches[0]);
        }, $comments->getText());

        $commentBlock = new Comment($commentLiteral);
        $statement->setAttribute('comments', [$commentBlock]);
    }
}

$builtLoader = "<?php\n\n" . $phpPrinter->prettyPrint($bottomlineLoaderFile) . "\n";
$builtLoader = preg_replace('/ +$/m', '', $builtLoader);
$builtLoader = preg_replace('/(}\n)(\s+\w)/m', "$1\n$2", $builtLoader);

file_put_contents($BOTTOMLINE_LOADER, $builtLoader);
