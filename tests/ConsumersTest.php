<?php

declare(strict_types=1);

namespace Mammatus\Tests\Queue\Attributes;

use Mammatus\Queue\Attributes\Consumer;
use Mammatus\Queue\Attributes\Consumers;
use PHPUnit\Framework\Attributes\Test;
use WyriHaximus\TestUtilities\TestCase;

final class ConsumersTest extends TestCase
{
    #[Test]
    public function sharedAddOns(): void
    {
        $addonA = new StubAddOn();
        $addonB = new StubAddOn();
        $addonC = new StubAddOn();

        $consumers = new Consumers(
            new Consumer(
                'A',
                'a',
                DTOStub::class,
                13,
                $addonA,
            ),
            new Consumer(
                'B',
                'b',
                DTOStub::class,
                69,
                $addonB,
            ),
            $addonC,
        );

        self::assertSame('A', $consumers->consumers[0]->friendlyName);
        self::assertSame('a', $consumers->consumers[0]->queue);
        self::assertSame(DTOStub::class, $consumers->consumers[0]->dtoClass);
        self::assertSame(13, $consumers->consumers[0]->concurrency);
        self::assertSame([$addonA, $addonC], $consumers->consumers[0]->addOns);
        self::assertSame('B', $consumers->consumers[1]->friendlyName);
        self::assertSame('b', $consumers->consumers[1]->queue);
        self::assertSame(DTOStub::class, $consumers->consumers[1]->dtoClass);
        self::assertSame(69, $consumers->consumers[1]->concurrency);
        self::assertSame([$addonB, $addonC], $consumers->consumers[1]->addOns);
    }
}
