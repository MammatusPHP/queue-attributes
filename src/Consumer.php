<?php

declare(strict_types=1);

namespace Mammatus\Queue\Attributes;

use Attribute;
use Mammatus\Kubernetes\Contracts\AddOn;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Consumer
{
    /** @var array<AddOn> */
    public array $addOns;

    public function __construct(
        public string $queue,
        public string $dtoClass,
        public int $concurrency,
        AddOn ...$addOns,
    ) {
        $this->addOns = $addOns;
    }
}
