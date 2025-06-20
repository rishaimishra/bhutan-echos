@extends('layouts.admin')

@section('title', 'Poll Results')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Poll Results: {{ $livePoll->question }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.live-polls.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Polls
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Session: {{ $livePoll->session->title }}</h5>
                            <p>Type: {{ $livePoll->multiple_choice ? 'Multiple Choice' : 'Single Choice' }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5>Total Responses: {{ $livePoll->responses->count() }}</h5>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($livePoll->options as $option)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $option->option }}</h5>
                                    @php
                                        $responseCount = $option->responses->count();
                                        $percentage = $livePoll->responses->count() > 0 
                                            ? round(($responseCount / $livePoll->responses->count()) * 100, 1)
                                            : 0;
                                    @endphp
                                    <div class="progress mb-2">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%">
                                            {{ $percentage }}%
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $responseCount }} responses</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($livePoll->responses->count() > 0)
                    <div class="mt-4">
                        <h5>Recent Responses</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Option</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($livePoll->responses->take(10) as $response)
                                    <tr>
                                        <td>{{ $response->user->name }}</td>
                                        <td>{{ $response->option->option }}</td>
                                        <td>{{ $response->created_at->format('M d, Y H:i:s') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 