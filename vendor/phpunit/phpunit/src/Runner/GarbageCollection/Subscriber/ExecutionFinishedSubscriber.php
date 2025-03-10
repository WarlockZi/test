<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Runner\GarbageCollection;

use PHPUnit\Event\InvalidArgumentException;
use PHPUnit\Event\TestRunner\ExecutionFinished;
use PHPUnit\Event\TestRunner\ExecutionFinishedSubscriber as TestRunnerExecutionFinishedSubscriber;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
 *
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final readonly class ExecutionFinishedSubscriber extends Subscriber implements TestRunnerExecutionFinishedSubscriber
{
    /**
     * @throws \PHPUnit\Framework\InvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function notify(ExecutionFinished $event): void
    {
        $this->handler()->executionFinished();
    }
}
