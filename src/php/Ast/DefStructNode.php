<?php

declare(strict_types=1);

namespace Phel\Ast;

use Phel\Lang\Keyword;
use Phel\Lang\SourceLocation;
use Phel\Lang\Symbol;
use Phel\NodeEnvironment;

final class DefStructNode extends Node
{
    private string $namespace;

    private Symbol $name;

    /** @var Symbol[] */
    private array $params;

    public function __construct(
        NodeEnvironment $env,
        string $namespace,
        Symbol $name,
        array $params,
        ?SourceLocation $sourceLocation = null
    ) {
        parent::__construct($env, $sourceLocation);
        $this->namespace = $namespace;
        $this->name = $name;
        $this->params = $params;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getName(): Symbol
    {
        return $this->name;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getParamsAsKeywords(): array
    {
        $result = [];
        foreach ($this->params as $param) {
            $keyword = new Keyword($param->getName());
            $keyword->setStartLocation($this->getStartSourceLocation());
            $result[] = $keyword;
        }

        return $result;
    }
}
