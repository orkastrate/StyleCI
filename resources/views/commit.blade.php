@extends('layouts.default')

@section('title', $commit->repo->name)

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>{{ $commit->repo->name }} &mdash; Commit Analysis</h1>
        <p>Here you can see the results of the analysed commit.</p>
    </div>
</div>
@stop

@section('content')
<div id="js-commit-{{ $commit->shorthandId }}" class="commit js-channel" data-channel="{{ $commit->repo->id }}">
    <div class="well">
        <div class="pull-right">
            <a href="#" data-toggle="modal" data-target="#badge-modal">
                <img src="{{ route('repo_shield_path', $commit->repo->id) }}" alt="StyleCI Shield">
            </a>
        </div>
        <p class="js-status" style="@if ($commit->status === 1) color:green; @elseif ($commit->status > 1) color:red; @else color:grey; @endif">
            <i class="{{ $commit->icon }}"></i>
            {{ $commit->description }}
        </p>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <h3>{{ $commit->message }}</h3>
                <p>{{ $commit->id }}</p>
                <br>
                <ul class="list-inline">
                    <li>
                        <span>
                            <i class="fa fa-calendar"></i>
                            <span class="js-time-ago" title="{{ $commit->createdAtToISO }}">{{ $commit->timeAgo }}</span>
                        </span>
                    </li>
                    <li>
                        <a class="btn" href="https://github.com/{{ $commit->repo->name }}/commit/{{ $commit->id }}">
                            <i class="fa fa-github"></i>
                            Commit {{ $commit->shorthandId }}
                        </a>
                    </li>
                    @if ($commit->status === 2)
                    <li>
                        <a class="btn" href="{{ route('commit_download_path', $commit->id) }}">
                            <i class="fa fa-cloud-download"></i> Download patch
                        </a>
                    </li>
                    <li>
                        <a class="btn" href="{{ route('commit_diff_path', $commit->id) }}">
                            <i class="fa fa-code"></i> Open diff file
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @if ($commit->error_message)
    <div class="alert alert-danger commit-alert" role="alert">
        <h4>Error details:</h4>
        <p>{{ $commit->error_message }}</p>
    </div>
    @endif
    @if ($commit->status === 4)
    <div class="alert alert-info commit-alert" role="alert">
        <h4>Need a hand?</h4>
        <p>Feel free to contact support at <a href="mailto:support@alt-three.com">support@alt-three.com</a>.</p>
    </div>
    @elseif ($commit->status === 3)
    <div class="alert alert-danger commit-alert" role="alert">
        <h4>Something went wrong on our end.</h4>
        <p>Feel free to contact support at <a href="mailto:support@alt-three.com">support@alt-three.com</a>.</p>
    </div>
    @elseif ($commit->status === 2)
    <hr>
    <p>
        <i class="fa fa-file-code-o"></i>
        <small>Showing <b>{{ $commit->diff->count() }} changed files</b> with <b>{{ $commit->diff->additions() }} additions</b> and <b>{{ $commit->diff->deletions() }} deletions</b>.</small>
    </p>
    <br>
    @foreach ($commit->diff->files() as $name => $file)
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $name }}
        </div>
        <div class="panel-body">
            <pre class="brush: diff">
                {{ $file }}
            </pre>
        </div>
    </div>
    @endforeach
    @endif
</div>

<div class="modal fade" id="badge-modal" tabindex="-1" role="dialog" aria-labelledby="badge-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal">Embed StyleCI Shield</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="image-url">Raw Image</label>
                    <textarea class="form-control" rows="3" cols="40" id="image-url" readonly>{{ route('repo_shield_path', $commit->repo->id) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="markdown-url">Markdown</label>
                    <textarea class="form-control" rows="3" cols="40" id="markdown-url" readonly>[![StyleCI]({{ route('repo_shield_path', $commit->repo->id) }})]({{ route('repo_path', $commit->repo->id) }})</textarea>
                </div>
                <div class="form-group">
                    <label for="html-url">HTML</label>
                    <textarea class="form-control" rows="3" cols="40" id="html-url" readonly><a href="{{ route('repo_path', $commit->repo->id) }}"><img src="{{ route('repo_shield_path', $commit->repo->id) }}" alt="StyleCI"></a></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.defaults['gutter'] = false;
    SyntaxHighlighter.all();
    $(function() {
        StyleCI.Commit.RealTimeStatus();
    });
</script>
@stop
