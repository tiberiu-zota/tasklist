@extends('layouts.app')

@section('title', 'The list of tasks')

@section('content')

    <nav class="text-start flex gap-3 items-center">
        <a href="{{ route('tasks.create') }}" class="btn">Add Task</a>

        @if ($show_comp)
            <a href="{{ route('tasks.index-not-completed') }}" class="btn"> Hide completed </a>
        @else
            <a href="{{ route('tasks.index') }}" class="btn">Show completed </a>
        @endif



        <a href="{{ route('tasks.destroy-completed') }}" class="btn">Delete completed</a>
        <a href="{{ route('tasks.destroy-all') }}" class="btn">Delete all</a>

    </nav>
    <br>
    <hr><br>

    @forelse ($tasks as $task)
        <div class="flex relative items-center">
            <a href="{{ route('tasks.show', ['task' => $task->id, 'show_comp' => $show_comp]) }}" @class(['pe-5', 'line-through' => $task->completed])>{{ $task->title }}</a>
            <form action="{{ route('tasks.destroy', ['task' => $task->id, 'show_comp' => $show_comp]) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit">
                <span class="absolute top-0 bottom-0 right-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.8"
                        stroke="currentColor" class="h-6 w-6 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </form>
            </span>
        </div>
    @empty
        <div>There are no tasks!</div>
    @endforelse
    {{-- @endif --}}

    <br>
    <hr><br>

    @if ($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}

        </nav>
    @endif

@endsection
