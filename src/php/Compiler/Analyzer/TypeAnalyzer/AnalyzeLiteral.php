<?php

declare(strict_types=1);

namespace Phel\Compiler\Analyzer\TypeAnalyzer;

use Phel\Compiler\Analyzer\Ast\LiteralNode;
use Phel\Compiler\Analyzer\Environment\NodeEnvironmentInterface;
use Phel\Lang\AbstractType;

final class AnalyzeLiteral
{
    /**
     * @param AbstractType|string|float|int|bool|null $value
     */
    public function analyze($value, NodeEnvironmentInterface $env): LiteralNode
    {
        $sourceLocation = ($value instanceof AbstractType)
            ? $value->getStartLocation()
            : null;

        return new LiteralNode($env, $value, $sourceLocation);
    }
}
