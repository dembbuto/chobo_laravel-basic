@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="px-64">
        <h1 class="font-bold text-3xl">Create Task</h1>
        <form action="/tasks" method="POST">
            @csrf
            <label class="block" for="tilte">Title</label>
            <input class="border border-gray-800 w-full @error('title') border border-red-700 @enderror" type="text" name="title" id="title" value="{{ old('title') ? old('title') : '' }}"><br>
            @error('title')
                <small class="text-red-700">{{ $message }}</small>
            @enderror

            <label class="block" for="body">Body</label>
            <textarea class="border border-gray-800 w-full @error('body') border border-red-700 @enderror" name="body" id="body" cols="30" rows="10">{{ old('body') ? old('body') : '' }}</textarea><br>
            @error('body')
                <small class="text-red-700">{{ $message }}</small>
            @enderror

            <button class="bg-blue-600 text-white px-4 py-2 float-right">Submit</button>
        </form>
        @if($errors->any())
            {{ $errors }}
        @endif
    </div>
@endsection
