<?php

namespace __\DocGen;

use __;
use __\DocGen\ArgumentDocumentation;
use JsonSerializable;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Since;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Mixed_;
use ReflectionFunction;
use ReflectionParameter;

class FunctionDocumentation implements JsonSerializable
{
    private ReflectionFunction $reflectedFunction;

    private DocBlock $docBlock;

    public string $name;

    public string $namespace;

    public string $summary;

    public string $summaryRaw;

    public string $description;

    public string $descriptionRaw;

    /** @var array<int, ArgumentDocumentation> */
    public array $arguments;

    /** @var array<string, string> */
    public array $changelog;

    /** @var array<string, string> */
    public array $exceptions;

    public Type $returnType;

    public string $returnDescription;

    public function __construct(ReflectionFunction $reflectedFunction, DocBlock $docBlock, $functionName, $namespace)
    {
        $this->reflectedFunction = $reflectedFunction;
        $this->docBlock = $docBlock;
        $this->namespace = $namespace === null ? $reflectedFunction->getNamespaceName() : $namespace;
        $this->name = $functionName;
        $this->arguments = [];
        $this->changelog = [];
        $this->exceptions = [];
        $this->parse();
    }

    public function asMethodTag(): Method
    {
        $description = $this->description;
        if (count($this->changelog) > 0) {
            $description .= '<h2>Changelog</h2>';
            $description .= '<ul>';
            foreach ($this->changelog as $version => $desc) {
                $body = Parsers::$markdown->text("`{$version}` - {$desc}");
                $description .= "<li>{$body}</li>";
            }
            $description .= '</ul>';
        }
        if (count($this->exceptions) > 0) {
            $description .= '<h2>Exceptions</h2>';
            $description .= '<ul>';
            foreach ($this->exceptions as $name => $desc) {
                $body = Parsers::$markdown->text("`{$name}` - {$desc}");
                $description .= "<li>{$body}</li>";
            }
            $description .= '</ul>';
        }
        if ($this->returnDescription) {
            $description .= '<h2>Returns</h2>';
            $description .= Parsers::$markdown->text($this->returnDescription);
        }

        //
        // Perform some cleanup on the description we just built
        //

        // Replace newlines with `<br>` tags since IDEs parse docblocks as HTML
        $descriptionBody = trim(preg_replace('/\n/', ' ', $this->summary . '<br>' . $description));

        // Don't allow trailing `<br>` tags
        $descriptionBody = preg_replace('/<br>$/', '', $descriptionBody);

        // Escape percent signs because this string will go through a `sprintf()` call so having a single `%` will cause an error
        $descriptionBody = preg_replace('/([^%])%([^%])/m', '\1%%\2', $descriptionBody);

        return new Method(
            $this->name,
            __::map($this->arguments, function (ArgumentDocumentation $argument) {
                return $argument->getMethodArgumentDefinition();
            }),
            $this->returnType,
            true,
            new Description($descriptionBody)
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'namespace' => $this->namespace,
            'summary' => $this->summary,
            'summaryRaw' => $this->summaryRaw,
            'description' => $this->description,
            'descriptionRaw' => $this->descriptionRaw,
            'arguments' => $this->arguments,
            'changelog' => __::map($this->changelog, static fn ($message, $version) => [
                'version' => $version,
                'message' => $message,
            ]),
            'exceptions' => __::map($this->exceptions, static fn ($message, $exception) => [
                'exception' => $exception,
                'message' => $message,
            ]),
            'return' => [
                'type' => (string)$this->returnType,
                'description' => $this->returnDescription,
            ],
        ];
    }

    private function parse(): void
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
            $isBuiltin = !$this->reflectedFunction->isUserDefined();
            $isVariadic = $documentedArg->isVariadic();
            $reflectedArg = ($isBuiltin || $isVariadic) ? null : $actualArgs[$varName];
            $this->arguments[] = new ArgumentDocumentation($documentedArg, $reflectedArg);
        }

        $this->summary = Parsers::$markdown->text($this->docBlock->getSummary());
        $this->summaryRaw = $this->docBlock->getSummary();
        $this->description = Parsers::$markdown->text($this->docBlock->getDescription()->render());
        $this->descriptionRaw = $this->docBlock->getDescription()->render();
        $this->parseCodeBlocks();
        $this->parseChangelog();
        $this->parseExceptions();
        $this->parseReturnType();

        // Change documented names for function like max which are declared in files
        // with a function prefix name (to avoid clash with PHP generic function max).
        if (strpos($this->name, PREFIX_FN_BOTTOMLINE) === 0) {
            $this->name = str_replace(PREFIX_FN_BOTTOMLINE, '', $this->name);
        }
    }

    private function parseCodeBlocks(): void
    {
        // Extract <pre> blocks and replace their new lines with `<br>` so they can be formatted nicely by IDEs
        $codeBlocks = [];
        preg_match_all("/(<pre>(?:\s|.)*?<\/pre>)/", $this->description, $codeBlocks);

        // This means there were a few code blocks
        if (count($codeBlocks) === 2) {
            foreach ($codeBlocks[1] as $codeBlock) {
                $this->description = str_replace($codeBlock, nl2br($codeBlock), $this->description);
            }
        }
    }

    private function parseChangelog(): void
    {
        $sinceChangeLog = $this->docBlock->getTagsByName('since');
        if (count($sinceChangeLog) === 0) {
            return;
        }

        /** @var Since $item */
        foreach ($sinceChangeLog as $item) {
            $this->changelog[$item->getVersion()] = $item->getDescription()->render();
        }
    }

    private function parseExceptions(): void
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

    private function parseReturnType(): void
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
