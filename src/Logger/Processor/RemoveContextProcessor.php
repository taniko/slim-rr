<?php
declare(strict_types=1);

namespace App\Logger\Processor;

use Monolog\Processor\ProcessorInterface;
use Taniko\Context\ContextInterface;

class RemoveContextProcessor implements ProcessorInterface
{
    public function __invoke(array $record): array
    {
        if (isset($record['context'][ContextInterface::class])) {
            unset($record['context'][ContextInterface::class]);
        }
        return $record;
    }
}