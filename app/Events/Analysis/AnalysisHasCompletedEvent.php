<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events\Analysis;

use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analysis has completed event class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class AnalysisHasCompletedEvent implements AnalysisEventInterface
{
    /**
     * The analysis object.
     *
     * @var \StyleCI\StyleCI\Models\Analysis
     */
    public $analysis;

    /**
     * The exception that occurred during analysis.
     *
     * @var \Throwable|null
     */
    public $exception;

    /**
     * Create a new analysis has completed event instance.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     * @param \Throwable|null                  $exception
     *
     * @return void
     */
    public function __construct(Analysis $analysis, $exception = null)
    {
        $this->analysis = $analysis;
        $this->exception = $exception;
    }
}
