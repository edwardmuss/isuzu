@extends('layouts.app')

@section('content')
    <h1>Edit Menu Option</h1>

    <form id="editMenuOptionForm" method="POST" action="{{ route('menu_options.update', ['menu_option' => $menuOption->id]) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuOptionModalLabel">Edit Menu Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editOptionId" name="id" value="{{ $menuOption->id }}">
                <div class="mb-3">
                    <label for="editOptionCode" class="form-label">Option Code</label>
                    <input type="text" class="form-control" id="editOptionCode" name="option_code" value="{{ $menuOption->option_code }}">
                </div>
                <div class="mb-3">
                    <label for="editOptionName" class="form-label">Option Name</label>
                    <input type="text" class="form-control" id="editOptionName" name="option_name" value="{{ $menuOption->option_name }}">
                </div>
                <div class="mb-3">
                    <label for="editParentId" class="form-label">Parent Option</label>
                    <select class="form-select" id="editParentId" name="parent_id">
                        <option value="">None</option>
                        @foreach($allMenuOptions as $option)
                            <option value="{{ $option->id }}" {{ $menuOption->parent_id == $option->id ? 'selected' : '' }}>
                                {{ $option->option_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editAction" class="form-label">Action</label>
                    <input type="text" class="form-control" id="editAction" name="action" value="{{ $menuOption->action }}">
                </div>
                <div class="mb-3">
                    <label for="editMenuMessage" class="form-label">Menu Title('If contains sub menus')</label>
                    <input type="text" class="form-control" id="editMenuMessage" name="menu_message" value="{{ $menuOption->menu_message }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </form>
@endsection
