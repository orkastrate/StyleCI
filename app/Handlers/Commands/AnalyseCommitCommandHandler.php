<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands;

use Exception;
use StyleCI\Config\Exceptions\ConfigExceptionInterface;
use StyleCI\Fixer\Report;
use StyleCI\Fixer\ReportBuilder;
use StyleCI\StyleCI\Commands\AnalyseCommitCommand;
use StyleCI\StyleCI\Events\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Events\AnalysisHasStartedEvent;
use StyleCI\StyleCI\Models\Commit;

/**
 * This is the analyse commit command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyseCommitCommandHandler
{
    /**
     * The report builder instance.
     *
     * @var \StyleCI\Fixer\ReportBuilder
     */
    protected $builder;

    /**
     * Create a new analyse commit command handler instance.
     *
     * @param \StyleCI\Fixer\ReportBuilder $builder
     *
     * @return void
     */
    public function __construct(ReportBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the analyse commit command.
     *
     * @param \StyleCI\StyleCI\Commands\AnalyseCommitCommand $command
     *
     * @return void
     */
    public function handle(AnalyseCommitCommand $command)
    {
        $commit = $command->commit;

        // bail out if the repo is already analysed or canceled
        if ($commit->status > 0) {
            return;
        }

        event(new AnalysisHasStartedEvent($commit));

        try {
            $this->saveReport($this->builder->analyse($commit->name(), $commit->id), $commit);
        } catch (ConfigExceptionInterface $e) {
            $commit->status = 4;
            $commit->error_message = $e->getMessage();
            $commit->save();
        } catch (Exception $e) {
            $commit->status = 3;
            $commit->save();
        }

        if (isset($e)) {
            event(new AnalysisHasCompletedEvent($commit, $e));
        } else {
            event(new AnalysisHasCompletedEvent($commit));
        }
    }

    /**
     * Save the main report to the database.
     *
     * @param \StyleCI\Fixer\Report          $report
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return void
     */
    protected function saveReport(Report $report, Commit $commit)
    {
        $commit->time = $report->time();
        $commit->memory = $report->memory();
        $commit->diff = $report->diff();

        if ($report->successful()) {
            $commit->status = 1;
        } else {
            $commit->status = 2;
        }

        $commit->save();
    }
}
