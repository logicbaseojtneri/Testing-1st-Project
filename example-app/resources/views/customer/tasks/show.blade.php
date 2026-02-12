@extends('customer.layouts.app')

@section('title', $task->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-customer border-0">
                <div class="card-body p-4 p-md-5">
                    <p class="text-muted small mb-2">Project: <a href="{{ route('customer.projects.show', $task->project) }}" class="link-accent">{{ $task->project->name }}</a></p>
                    <h1 class="h4 fw-600 mb-4">{{ $task->title }}</h1>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <span class="text-muted small d-block">Category</span>
                            <span class="badge badge-customer">{{ $task->category->label() }}</span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted small d-block">Status</span>
                            <span class="badge bg-light text-dark border">{{ $task->status }}</span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted small d-block">Assigned to</span>
                            {{ $task->category->positionLabel() }}
                            @if ($task->assignee)
                                – <span class="fw-500">{{ $task->assignee->name }}</span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-600 mb-2">Description</h5>
                    <p class="text-muted mb-0">{{ $task->description ?? 'No description provided.' }}</p>

                    <hr class="my-4">

                    <div class="row text-muted small">
                        <div class="col-sm-6">Created {{ $task->created_at->format('M d, Y H:i') }}</div>
                        <div class="col-sm-6">Updated {{ $task->updated_at->format('M d, Y H:i') }}</div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('customer.projects.tasks.index', $task->project) }}" class="btn btn-outline-primary rounded-3"><i class="fas fa-arrow-left me-2"></i>Back to tasks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
