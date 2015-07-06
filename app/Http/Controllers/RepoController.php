<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Commands\AnalyseCommitCommand;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\GitHub\Repos;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Repositories\CommitRepository;
use StyleCI\StyleCI\Repositories\RepoRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This is the repo controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoController extends AbstractController
{
    /**
     * Create a new account controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth', ['except' => 'handleShow']);
    }

    /**
     * Handles the request to list the repos.
     *
     * @param \Illuminate\Contracts\Auth\Guard             $auth
     * @param \Illuminate\Http\Request                     $request
     * @param \StyleCI\StyleCI\Repositories\RepoRepository $repoRepository
     *
     * @return \Illuminate\View\View
     */
    public function handleList(Guard $auth, Request $request, RepoRepository $repoRepository)
    {
        $repos = $repoRepository->allByUser($auth->user());

        if ($request->ajax()) {
            return new JsonResponse(['data' => AutoPresenter::decorate($repos)->toArray()]);
        }

        return View::make('repos', compact('repos'));
    }

    /**
     * Handles the request to show a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo     $repo
     * @param \Illuminate\Http\Request         $request
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @param \StyleCI\StyleCI\GitHub\Repos    $repos
     *
     * @return \Illuminate\View\View
     */
    public function handleShow(Repo $repo, Request $request, Guard $auth, Repos $repos)
    {
        $commits = $repo->commits()->where('ref', "refs/heads/{$repo->default_branch}")->orderBy('created_at', 'desc')->paginate(50);

        if ($request->ajax()) {
            return new JsonResponse(['data' => AutoPresenter::decorate($commits->getCollection())->toArray()]);
        }

        if ($auth->user()) {
            $canAnalyse = (bool) array_get($repos->get($auth->user()), $repo->id);
        } else {
            $canAnalyse = false;
        }

        return View::make('repo', compact('repo', 'commits', 'canAnalyse'));
    }

    /**
     * Handles the request to analyse a repo.
     *
     * @param \Illuminate\Http\Request                       $request
     * @param \StyleCI\StyleCI\Models\Repo                   $repo
     * @param \StyleCI\StyleCI\GitHub\Branches               $branches
     * @param \StyleCI\StyleCI\Repositories\CommitRepository $commitRepository
     * @param \Illuminate\Contracts\Auth\Guard               $auth
     * @param \StyleCI\StyleCI\GitHub\Repos                  $repos
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\Http\Response
     */
    public function handleAnalyse(Request $request, Repo $repo, Branches $branches, CommitRepository $commitRepository, Guard $auth, Repos $repos)
    {
        if (!array_get($repos->get($auth->user()), $repo->id)) {
            throw new HttpException(403);
        }

        $branches = $branches->get($repo);

        foreach ($branches as $branch) {
            if ($branch['name'] !== $repo->default_branch) {
                continue;
            }

            $commit = $commitRepository->findForAnalysis($branch['commit'], $repo->id, $branch['name']);
            $this->dispatch(new AnalyseCommitCommand($commit));
            break;
        }

        if ($request->ajax()) {
            return new JsonResponse(['queued' => true]);
        }

        return Redirect::route('repo_path', $repo->id);
    }
}
