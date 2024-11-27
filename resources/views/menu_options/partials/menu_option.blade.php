<li class="list-group-item" data-id="{{ $option->id }}">
    <div class="d-flex justify-content-between">
        <div>
            <span class="me-2">{{ $option->option_code }}.</span><strong>{{ $option->option_name }}</strong>
        </div>
        <div>
            <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="openEditModal({{ $option->id }})">Edit</a>
            <form action="{{ route('menu_options.destroy', $option->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>

    @if($option->children->count())
        <ul class="list-group mt-2">
            @foreach ($option->children as $child)
                @include('menu_options.partials.menu_option', ['option' => $child])
            @endforeach
        </ul>
    @endif
</li>
