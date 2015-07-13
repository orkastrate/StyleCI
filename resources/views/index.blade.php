@extends('layouts.default')

@section('title', 'Home')

@section('top')
<header id="top" class="home-header">
    <div class="text-vertical-center">
        <div class="home-logo-wrapper"><img class="home-logo-img" src="{{ asset('img/logo.png') }}" alt="StyleCI"></div>
        <h3>The PHP Coding Style Continuous Integration Service</h3>
        <h3>Analyse all your <strong>public repos</strong> for <strong>free.</strong></h3>
        <br>
        <div class="btn-toolbar" role="toolbar" aria-label="Login">
            @if($currentUser)
            <a href="{{ route('repos_path') }}" class="btn navbar-btn btn-dark btn-lg"><i class="fa fa-github"></i> View Repositories</a>
            @else
            <a href="{{ route('auth_login_path') }}" class="btn navbar-btn btn-dark btn-lg" data-method="POST"><i class="fa fa-github"></i> Login with GitHub</a>
            @endif
            <a href="https://twitter.com/intent/user?screen_name=TeamStyleCI" class="btn navbar-btn btn-light btn-lg" target="_blank"><i class="fa fa-twitter"></i> Follow us on Twitter</a>
        </div>
    </div>
</header>
<div class="highlights">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <i class="fa fa-5x fa-gear"></i>
                    </div>
                    <div class="panel-body">
                        <h3>Configure</h3>
                        <p>Fix PSR-1, PSR-2, PSR-5, Symfony and more.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <i class="fa fa-5x fa-code-fork"></i>
                    </div>
                    <div class="panel-body">
                        <h3 class="featurette-heading">Analyse</h3>
                        <p>We watch all of your pull requests and automatically analyse them.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <i class="fa fa-5x fa-code"></i>
                    </div>
                    <div class="panel-body">
                        <h3>Patch</h3>
                        <p>Keep your code aligned with the best coding standards.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="features">
    <div class="row featurette">
        <div class="col-sm-6">
            <div class="fake-browser-ui">
                <div class="frame">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img class="featurette-image img-responsive" src="{{ asset('img/analyse-repo.jpg') }}" alt="Analyse">
            </div>
        </div>
        <div class="col-sm-6">
            <h2 class="featurette-heading">Analysis of pull requests</h2>
            <p class="lead">StyleCI automatically analyses all of your pull requests and will display a build status within GitHub before you merge.</p>
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-sm-6 pull-right text-right">
            <div class="fake-browser-ui">
                <div class="frame">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img class="featurette-image img-responsive" src="{{ asset('img/patch-commit.jpg') }}" alt="Patch">
            </div>
        </div>
        <div class="col-sm-6 pull-left">
            <h2 class="featurette-heading">Patches provided</h2>
            <p class="lead">Did the changes not meet the coding standards? Don't worry, StyleCI provides a patch file that you can download and <code>git apply patch.txt</code> , or you can view within your browser.</p>
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-sm-6">
            <div class="fake-browser-ui">
                <div class="frame">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img class="featurette-image img-responsive" src="{{ asset('img/php-cs.jpg') }}" alt="PHP CS Fixer">
            </div>
        </div>
        <div class="col-sm-6">
            <h2 class="featurette-heading">Configure to your needs</h2>
            <p class="lead">StyleCI is powered by <a href="https://github.com/FriendsOfPHP/PHP-CS-Fixer" target="_blank">PHP CS Fixer</a>, and coming fully configurable to fix PSR-1, PSR-2, PSR-5, Symfony and various other checks via a <code>.styleci.yml</code> file, committed to the root your repository.</p>
        </div>
    </div>
</div>
@stop
