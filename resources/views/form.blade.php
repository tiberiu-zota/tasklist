@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')


@section('content')
    {{-- {{ $errors }} --}}
    <form method="post" action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
        @csrf
        @isset($task)
            @method('put')
        @endisset
        <div class="mb-4">
            <label for="title">
                Title
            </label>
            <input text="text" name="title" id="title" 
                @class(['border-red-500' => $errors->has('title')])
                value="{{ $task->title ?? old('title') }}" />
            @error('title')
                <p class="err-message">{{ $message }} </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="5"
                @class(['border-red-500' => $errors->has('description')])>{{ $task->description ?? old('description') }}</textarea>
            @error('description')
                <p class="err-message">{{ $message }} </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="long_description">Long description</label>
            <textarea name="long_description" id="long_description" rows="10"
                @class(['border-red-500' => $errors->has('long_description')])>{{ $task->long_description ?? old('long_description') }}</textarea>
            @error('long_description')
                <p class="err-message">{{ $message }} </p>
            @enderror
        </div>

        <div class="flex gap-2 items-center">
            <button type="submit" class="btn">
                @isset($task)
                    Update Task
                @else
                    Add Task
                @endisset
            </button>
            <a class="btn" href="{{ route('tasks.index')}}">Cancel</a>
        </div>

    </form>
@endsection