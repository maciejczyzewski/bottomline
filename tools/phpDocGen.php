#!/usr/bin/env php
<?php

const MIN_VERSION = '5.5.9';
const PREFIX_FN_BOTTOMLINE = 'bottomline_';

if (\version_compare(PHP_VERSION, MIN_VERSION, '<')) {
    die(sprintf("This script should be run with a PHP version higher than %s due to dependency constraints.\n", MIN_VERSION));
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Serializer;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Since;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Void_;
use PhpParser\Comment;
use PhpParser\Comment\Doc;
use PhpParser\Node\Stmt;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

abstract class Parsers
{
    /** @var DocBlockFactory */
    public static $docBlockParser;

    /** @var Parser */
    public static $phpParser;

    /** @var Parsedown */
    public static $markdown;

    public static function setup()
    {
        if (!isset(self::$docBlockParser)) {
            self::$docBlockParser = DocBlockFactory::createInstance();
        }

        if (!isset(self::$phpParser)) {
            self::$phpParser = (new ParserFactory())->create(ParserFactory::PREFER_PHP5);
        }

        if (!isset(self::$markdown)) {
            self::$markdown = new Parsedown();
        }
    }
}

class DocumentationRegistry implements JsonSerializable
{
    /** @var array<string, int> */
    public $namespaceCount;

    /** @var array<int, FunctionDocumentation> */
    public $methods;

    public function __construct()
    {
        $this->namespaceCount = [];
        $this->methods = [];
    }

    /**
     * @param string $filePath
     *
     * @return bool
     */
    public function registerDocumentationFromFile($filePath)
    {
        $fileName = basename($filePath);
        $namespace = basename(dirname($filePath));

        // If the file starts with an uppercase letter, then it's a class so let's not count it
        if (preg_match('/[A-Z]/', substr($fileName, 0, 1)) === 1) {
            return false;
        }

        if (!isset($bottomlineNamespaces[$namespace])) {
            $this->namespaceCount[$namespace] = 1;
        } else {
            $this->namespaceCount[$namespace]++;
        }

        include $filePath;

        $this->parsePhpSource($filePath, $fileName, $namespace);

        return true;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @param string $namespace
     */
    private function parsePhpSource($filePath, $fileName, $namespace)
    {
        $parsedPhp = Parsers::$phpParser->parse(file_get_contents($filePath));
        /** @var Stmt\Namespace_|Stmt\Return_ $rootElement */
        $rootElement = array_shift($parsedPhp);

        switch ($rootElement->getType()) {
            case 'Stmt_Namespace':
                $nodes = $rootElement->stmts;

                foreach ($nodes as $node) {
                    if ($node->getType() !== 'Stmt_Function') {
                        continue;
                    }

                    $fxnName = $node->name;
                    $comments = $node->getAttribute('comments');

                    /** @var Comment $docBlock */
                    $docBlock = array_pop($comments);

                    $this->registerBottomlineFunction($fxnName, $docBlock, $namespace);
                }

                break;

            case 'Stmt_Return':
                $fxnName = pathinfo($fileName, PATHINFO_FILENAME);
                $comments = $rootElement->getAttribute('comments');

                /** @var Comment $docBlock */
                $docBlock = array_pop($comments);

                $this->registerBottomlineFunction($fxnName, $docBlock, null, $rootElement->expr->value);

                break;

            default:
                break;
        }
    }

    /**
     * @param string      $functionName
     * @param Comment     $docBlock
     * @param string|null $namespace
     * @param string|null $fqfn
     */
    private function registerBottomlineFunction($functionName, Comment $docBlock, $namespace = null, $fqfn = null)
    {
        try {
            // If function name starts with an underscore, it's a helper function not part of the API
            if (substr($functionName, 0, 1) === '_') {
                return;
            }

            if ($namespace !== null) {
                $fullyQualifiedFunctionName = sprintf("%s\\%s", $namespace, $functionName);
            } elseif ($fqfn !== null) {
                $fullyQualifiedFunctionName = $fqfn;
            } else {
                $fullyQualifiedFunctionName = $functionName;
            }

            $docBlock = Parsers::$docBlockParser->create($docBlock->getText());
            $isInternal = count($docBlock->getTagsByName('internal')) > 0;

            if ($isInternal) {
                return;
            }

            $functionDefinition = new ReflectionFunction($fullyQualifiedFunctionName);
            $this->methods[] = new FunctionDocumentation($functionDefinition, $docBlock);
        } catch (\Exception $e) {
            printf("Exception message: %s\n", $e->getMessage());
            printf("  %s\n\n", $functionName);
        }
    }
}

class FunctionDocumentation implements JsonSerializable
{
    /** @var ReflectionFunction */
    private $reflectedFunction;

    /** @var DocBlock */
    private $docBlock;

    /** @var string */
    public $name;

    /** @var string */
    public $namespace;

    /** @var string */
    public $summary;

    /** @var string */
    public $description;

    /** @var array<int, ArgumentDocumentation> */
    public $arguments;

    /** @var array<string, string> */
    public $changelog;

    /** @var array<string, string> */
    public $exceptions;

    /** @var Type */
    public $returnType;

    /** @var string */
    public $returnDescription;

    public function __construct(ReflectionFunction $reflectedFunction, DocBlock $docBlock)
    {
        $this->reflectedFunction = $reflectedFunction;
        $this->docBlock = $docBlock;

        $this->namespace = $reflectedFunction->getNamespaceName();
        $this->name = str_replace("{$this->namespace}\\", '', $reflectedFunction->getName());
        $this->arguments = [];
        $this->changelog = [];
        $this->exceptions = [];

        $this->parse();
    }

    /**
     * @return Method
     */
    public function asMethodTag()
    {
        $description = $this->description;

        if (count($this->changelog) > 0) {
            $description .= '<h2>Changelog</h2>';
            $description .= '<ul>';

            foreach ($this->changelog as $version => $description) {
                $body = Parsers::$markdown->text("`{$version}` - {$description}");
                $description .= "<li>{$body}</li>";
            }

            $description .= '</ul>';
        }

        if (count($this->exceptions) > 0) {
            $description .= '<h2>Exceptions</h2>';
            $description .= '<ul>';

            foreach ($this->exceptions as $name => $description) {
                $body = Parsers::$markdown->text("`{$name}` - {$description}");
                $description .= "<li>{$body}</li>";
            }

            $description .= '</ul>';
        }

        if ($this->returnDescription) {
            $description .= '<h2>Returns</h2>';
            $description .= Parsers::$markdown->text($this->returnDescription);
        }

        $descriptionBody = trim(preg_replace('/\n/', ' ', $this->summary . '<br>' . $description));
        $descriptionBody = preg_replace('/<br>$/', '', $descriptionBody);
        $description = new Description($descriptionBody);

        $argDefs = [];
        /** @var ArgumentDocumentation $argument */
        foreach ($this->arguments as $argument) {
            $argDefs[] = [
                'name' => $argument->getSignature(),
                'type' => $argument->type,
            ];
        }

        return new Method($this->name, $argDefs, $this->returnType, true, $description);
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }

    private function parse()
    {
        /** @var Param[] $documentedArgs */
        $documentedArgs = $this->docBlock->getTagsByName('param');
        /** @var ReflectionParameter[] $actualArgs */
        $actualArgs = [];

        foreach ($this->reflectedFunction->getParameters() as $parameter) {
            $actualArgs[$parameter->getName()] = $parameter;
        }

        foreach ($documentedArgs as $documentedArg) {
            $varName = $documentedArg->getVariableName();

            if (!isset($actualArgs[$varName])) {
                continue;
            }

            $this->arguments[] = new ArgumentDocumentation($actualArgs[$varName], $documentedArg);
        }

        $this->summary = Parsers::$markdown->text($this->docBlock->getSummary());
        $this->description = Parsers::$markdown->text($this->docBlock->getDescription()->render());

        $this->parseCodeBlocks();
        $this->parseChangelog();
        $this->parseExceptions();
        $this->parseReturnType();

        // Change documented names for function like max which are declared in files
        // with a function prefix name (to avoid clash with PHP generic function max).
        if (substr($this->name, 0, strlen(PREFIX_FN_BOTTOMLINE)) === PREFIX_FN_BOTTOMLINE) {
            $this->name = str_replace(PREFIX_FN_BOTTOMLINE, '', $this->name);
        }
    }

    private function parseCodeBlocks()
    {
        // Extract <pre> blocks and replace their new lines with `<br>` so they can be formatted nicely by IDEs
        $codeBlocks = [];
        preg_match_all("/(<pre>(?:\s|.)*?<\/pre>)/", $this->description, $codeBlocks);

        // This means there were a few code blocks
        if (count($codeBlocks) == 2) {
            foreach ($codeBlocks[1] as $codeBlock) {
                $this->description = str_replace($codeBlock, nl2br($codeBlock), $this->description);
            }
        }
    }

    private function parseChangelog()
    {
        $sinceChangeLog = $this->docBlock->getTagsByName('since');

        if (count($sinceChangeLog) === 0) {
            return;
        }

        /** @var Since $item */
        foreach ($sinceChangeLog as $item) {
            $this->changelog[$item->getVersion()] = $item->getDescription();
        }
    }

    private function parseExceptions()
    {
        $exceptions = $this->docBlock->getTagsByName('throws');

        if (count($exceptions) === 0) {
            return;
        }

        /** @var DocBlock\Tags\Throws $exception */
        foreach ($exceptions as $exception) {
            $this->exceptions[(string)$exception->getType()] = $exception->getDescription()->render();
        }
    }

    private function parseReturnType()
    {
        $returns = $this->docBlock->getTagsByName('return');
        /** @var DocBlock\Tags\Return_|null $tag */
        $tag = array_shift($returns);

        if ($tag !== null) {
            $this->returnType = $tag->getType();
            $this->returnDescription = Parsers::$markdown->text($tag->getDescription()->render());
        } else {
            $this->returnType = new Mixed_();
            $this->returnDescription = '';
        }
    }
}

class ArgumentDocumentation implements JsonSerializable
{
    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var mixed */
    public $defaultValue;

    /** @var string|null */
    public $defaultValueAsString;

    /** @var Type */
    public $type;

    public function __construct(ReflectionParameter $reflectedParam, Param $documentedParam)
    {
        $this->name = $reflectedParam->getName();
        $this->description = $documentedParam->getDescription();
        $this->type = $documentedParam->getType();

        if ($reflectedParam->isOptional()) {
            try {
                $defaultValue = $reflectedParam->getDefaultValue();
                $this->defaultValue = $defaultValue;

                if ($defaultValue === null) {
                    $this->defaultValueAsString = 'null';
                } elseif (is_bool($defaultValue)) {
                    $this->defaultValueAsString = $defaultValue ? 'true' : 'false';
                } elseif (is_string($defaultValue)) {
                    $this->defaultValueAsString = sprintf("'%s'", $defaultValue);
                } elseif (is_array($defaultValue)) {
                    $this->defaultValueAsString = '[]';
                } else {
                    $this->defaultValueAsString = $defaultValue;
                }
            } catch (Exception $e) {
            }
        }
    }

    public function getSignature()
    {
        if ($this->defaultValueAsString) {
            return "{$this->name} = {$this->defaultValueAsString}";
        }

        return $this->name;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}

Parsers::setup();
$registry = new DocumentationRegistry();

/**
 * @param DocBlock $docBlock
 *
 * @return string
 */
function writeDocBlock(DocBlock $docBlock)
{
    return (new Serializer())->getDocComment($docBlock);
}

// Find all registered bottomline functions
foreach (glob(dirname(__DIR__) . '/src/__/**/*.php') as $file) {
    $registry->registerDocumentationFromFile($file);
}

$methods = [];
foreach ($registry->methods as $method) {
    $methods[] = $method->asMethodTag();
}

$loaderDocBlock = new DocBlock('', null, $methods);
$docBlockSerializer = new Serializer();
$docBlockLiteral = $docBlockSerializer->getDocComment($loaderDocBlock);

//
// Build our Sequence wrapper
//

$chainableMethods = [];
/** @var FunctionDocumentation $method */
foreach ($registry->methods as $method) {
    if ($method->returnType instanceof Void_) {
        continue;
    }

    $arguments = $method->arguments;
    array_shift($arguments);

    $argDefs = [];
    /** @var ArgumentDocumentation $argument */
    foreach ($arguments as $argument) {
        $argDefs[] = [
            'name' => $argument->getSignature(),
            'type' => $argument->type,
        ];
    }

    $returnType = new Object_(new Fqsen('\BottomlineWrapper'));

    $chainableMethods[] = new Method(
        $method->name,
        $argDefs,
        $returnType,
        true,
        new Description($method->description)
    );
}

$wrapperDocBlock = new DocBlock(
    'An abstract base class for documenting our sequence support',
    null,
    array_merge(
        [
            new Generic('internal'),
        ],
        $chainableMethods
    )
);

$wrapperDocBlockLiteral = $docBlockSerializer->getDocComment($wrapperDocBlock);
$wrapperTemplate = <<<'TEMPLATE'
<?php

// Do NOT modify this file! This file is automatically generated.

{phpDoc}
abstract class BottomLineWrapperBase
{
}
TEMPLATE;

$baseSequenceWrapper = strtr($wrapperTemplate, [
    '{phpDoc}' => $wrapperDocBlockLiteral,
]);

$BOTTOMLINE_SEQ_WRAPPER = dirname(__DIR__) . '/src/__/sequences/BottomlineWrapperBase.php';
file_put_contents($BOTTOMLINE_SEQ_WRAPPER, $baseSequenceWrapper . "\n");

//
// Build our loader
//

$BOTTOMLINE_LOADER = dirname(__DIR__) . '/src/__/load.php';

$bottomlineLoaderFile = Parsers::$phpParser->parse(file_get_contents($BOTTOMLINE_LOADER));
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
        $commentLiteral = preg_replace_callback($commentRegex, function ($matches) use ($registry) {
            $namespace = strtolower($matches[1]);

            return str_replace($matches[2], $registry->namespaceCount[$namespace], $matches[0]);
        }, $comments->getText());

        $commentBlock = new Comment($commentLiteral);
        $statement->setAttribute('comments', [$commentBlock]);
    }
}

$phpPrinter = new Standard();
$builtLoader = "<?php\n\n" . $phpPrinter->prettyPrint($bottomlineLoaderFile) . "\n";
$builtLoader = preg_replace('/ +$/m', '', $builtLoader);
$builtLoader = preg_replace('/(}\n)(\s+\w)/m', "$1\n$2", $builtLoader);

file_put_contents($BOTTOMLINE_LOADER, $builtLoader);
