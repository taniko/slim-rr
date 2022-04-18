<?php
declare(strict_types=1);

namespace App\Logger\Processor;

use Monolog\Logger;
use Monolog\Processor\ProcessorInterface;
use Taniko\Context\Context;
use Taniko\Context\ContextInterface;

/**
 * @psalm-import-type Record from Logger
 */
class RequestIDProcessor implements ProcessorInterface
{
    /**
     * @param array<string,mixed> $record
     * @return array
     *
     * @psalm-param Record $record
     * @psalm-return Record
     */
    public function __invoke(array $record): array
    {
        /**
         * @var Context|null $context
         * @var string|null $id
         */
        $context = $record['context'][ContextInterface::class] ?? null;
        $id = $context?->get('request-id');
        if ($id !== null) {
            $record['extra']['request-id'] = $id;
        }
        return $record;
    }
}