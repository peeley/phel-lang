<?php

declare(strict_types=1);

namespace Phel\SourceMap;

final class SourceMapConsumer
{
    private VLQ $vlq;
    private array $lineMapping;

    public function __construct(string $mapping)
    {
        $this->vlq = new VLQ();
        $this->lineMapping = $this->decodeMapping($mapping);
    }

    protected function decodeMapping(string $mapping): array
    {
        $lines = explode(';', $mapping);

        $lineMapping = [];
        $lastMapping = [0, 0, 0, 0];
        foreach ($lines as $i => $line) {
            $segments = explode(',', $line);

            foreach ($segments as $j => $segment) {
                if (strlen($segment) > 0) {
                    $relMapping = $this->vlq->decode($segment);

                    $absMapping = [
                        $lastMapping[0] + $relMapping[0], // generated column
                        $lastMapping[1] + $relMapping[1], // source
                        $lastMapping[2] + $relMapping[2], // original line
                        $lastMapping[3] + $relMapping[3]  // original column
                    ];

                    $lastMapping = $absMapping;

                    $lineMapping[$i + 1][] = $absMapping[2] + 1;
                }
            }
        }

        return $lineMapping;
    }

    public function getOriginalLine(int $generatedLine): ?int
    {
        if (isset($this->lineMapping[$generatedLine])) {
            return min($this->lineMapping[$generatedLine]);
        }

        return null;
    }
}
