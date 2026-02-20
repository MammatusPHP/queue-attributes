<?php

declare(strict_types=1);

namespace Mammatus\Queue\Attributes;

use Attribute;
use Mammatus\Kubernetes\Contracts\AddOn;

use function array_filter;
use function array_map;
use function array_values;

/** @api */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Consumers
{
    /** @var array<Consumer> */
    public array $consumers;

    public function __construct(
        Consumer|AddOn ...$objects,
    ) {
        $addons          = array_filter($objects, static fn (Consumer|AddOn $object): bool => $object instanceof AddOn);
        $this->consumers = array_map(static fn (Consumer $consumer): Consumer => new Consumer(
            $consumer->friendlyName,
            $consumer->queue,
            $consumer->dtoClass,
            $consumer->concurrency,
            ...[
                ...array_values($consumer->addOns),
                ...array_values($addons),
            ],
        ), array_filter($objects, static fn (Consumer|AddOn $object): bool => $object instanceof Consumer));
    }
}
