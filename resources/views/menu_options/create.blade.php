@extends('layouts.app')

@section('content')
    <h1 class="text-muted mt-5">Add Menu Option</h1>

    <form action="{{ route('menu_options.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="option_code">Option Code</label>
            <input type="text" name="option_code" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="option_name">Option Name</label>
            <input type="text" name="option_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="parent_id">Parent Option</label>
            <select name="parent_id" class="form-control">
                <option value="">None</option>
                @foreach ($parentOptions as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->option_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="action">Action</label>
            <input type="text" name="action" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-5">Add Menu Option</button>
    </form>
@endsection
