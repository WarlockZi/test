<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\TestRunner\TestResult;

use PHPUnit\Event\Test\BeforeFirstTestMethodErrored;
use PHPUnit\Event\Test\BeforeFirstTestMethodErroredSubscriber;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
 *
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final readonly class BeforeTestClassMethodErroredSubscriber extends Subscriber implements BeforeFirstTestMethodErroredSubscriber
{
    public function notify(BeforeFirstTestMethodErrored $event): void
    {
        $this->collector()->beforeTestClassMethodErrored($event);
    }
}
