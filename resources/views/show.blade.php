@extends('layouts.app')

{{-- @section('title')
{{ $task->title }}
@endsection --}}

@section('title', $task->title)

@section('content')

    <div class="mb-4">
        @if ($show_comp)
        <a href="{{ route('tasks.index') }}"
        class="btn"><< Go back to task list</a>
        @else
        <a href="{{ route('tasks.index-not-completed') }}"
        class="btn"><< Go back to task list</a>
        @endif
        
    </div>

    <p class="mb-4 text-slate-700">{{ $task->description }}</p>

    @if ($task->long_description)
        <p  class="mb-4 text-slate-700">{{ $task->long_description }} </p>
    @else
        <p  class="mb-4 text-slate-300">{{ '- details unavailable -' }} </p>
    @endif

    <p class="mb-4 text-sm text-slate-500">
        <span class="text-pink-800">Created:</span> {{ $task->created_at->diffForHumans() }} 
        &#12539; <span class="text-pink-800">Updated:</span> {{ $task->updated_at->diffForHumans() }}</p>

    <p class="mb-4">
        @if ($task->completed)
            <span class="font-medium text-green-500">Completed</span>
        @else
        <span class="font-medium text-red-500">Not completed</span>
        @endif
    </p>

    <div class="flex gap-2">
        <a href="{{ route('tasks.edit', ['task' => $task]) }}"
            class="btn">Edit</a> {{-- Laravel knows to take the id  --}}
    
        <form action="{{ route('tasks.toggle', ['task' => $task]) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>
    
        <form action="{{ route('tasks.destroy', ['task' => $task->id, 'show_comp' => $show_comp]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Delete</button>

        </form>
    </div>

@endsection
