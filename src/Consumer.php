<?php

declare(strict_types=1);

namespace Mammatus\Queue\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Consumer
{
    public function __construct(
        public string $queue,
        public int $concurrency,
    ) {
    }
}
