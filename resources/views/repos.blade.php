@extends('layouts.default')

@section('title', 'Analysed Repos')

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>Analysed Repos</h1>
        <p>Here you can see all your analysed repos.</p>
    </div>
</div>
@stop

@section('content')
<div class="repos">
    @forelse($repos as $repo)
    <div id="js-repo-{{ $repo->id }}">
        <div class="row">
            <div class="col-sm-8">
            <h3>{{ $repo->name }}</h3>
                @if ($commit = $repo->lastCommit)
                <p class="js-status" style="@if ($commit->status === 1) color:green; @elseif ($commit->status > 1) color:red; @else color:grey; @endif">
                    <strong>{{ $commit->summary }}</strong>
                </p>
                @else
                <p class="js-status">
                    <strong>No commits on the {{ $repo->default_branch }} branch have been analysed yet.</strong>
                </p>
                @endif
            </div>
            <div class="col-sm-4 list-vcenter">
                <a class="btn btn-primary" href="{{ route('repo_path', $repo->id) }}"><i class="fa fa-history"></i> Show Commits</a>
            </div>
        </div>
        <hr>
    </div>
    @empty
    <p class="lead">We haven't analysed anything yet.</p>
    <p>You can enable repos on your <a href="{{ route('account_path') }}">account page</a>.</p>
    @endforelse
</div>
@stop

@section('js')
<script id="repos-template" type="text/x-lodash-template">
    <div id="js-repo-<%= repo.id %>">
        <div class="row">
            <div class="col-sm-8">
            <h3><%= repo.name %></h3>
                <% if (repo.last_commit) { %>
                <p class="js-status" style="<% if (repo.last_commit.status === 1) { %> color:green; <% } else if (repo.last_commit.status > 1) { %> color:red; <% } else { %> color:grey; <% } %>">
                    <strong><%- repo.last_commit.summary %></strong>
                </p>
                <% } else { %>
                <p class="js-status">
                    <strong>No commits have been pushed to the <%= repo.default_branch %> branch yet.</strong>
                </p>
                <% } %>
            </div>
            <div class="col-sm-4 list-vcenter">
                <a class="btn btn-primary" href="<%= repo.link %>"><i class="fa fa-history"></i> Show Commits</a>
            </div>
        </div>
        <hr>
    </div>
</script>

<script type="text/javascript">
    $(function() {
        StyleCI.Repos.RealTimeStatus();
    });
</script>
@stop
