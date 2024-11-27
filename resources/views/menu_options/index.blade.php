@extends('layouts.app')

@section('content')

    <h1 class="mt-5">Menu Options</h1>

    <!-- Add Menu Option Button (opens modal) -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMenuOptionModal">
        Add Menu Option
    </button>

    <!-- Table for Menu Options -->
    <ul id="sortableMenuOptions" class="list-group">
        @foreach ($menuOptions as $option)
            @include('menu_options.partials.menu_option', ['option' => $option])
            <!-- Add Submenu Button for each menu option -->
            <button type="button" class="btn btn-secondary m-2" onclick="openAddSubmenuModal({{ $option->id }}, '{{ $option->option_name }}')">
                Add Submenu to {{ $option->option_name }}
            </button>
        @endforeach
    </ul>

    <!-- Add Menu Modal -->
    <div class="modal fade" id="addMenuOptionModal" tabindex="-1" aria-labelledby="addMenuOptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('menu_options.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMenuOptionModalLabel">Add Menu Option</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="optionCode" class="form-label">Option Code</label>
                            <input type="text" class="form-control" id="optionCode" name="option_code">
                        </div>
                        <div class="mb-3">
                            <label for="optionName" class="form-label">Option Name</label>
                            <input type="text" class="form-control" id="optionName" name="option_name">
                        </div>
                        <div class="mb-3">
                            <label for="optionMenuMessage" class="form-label">Option Menu Message</label>
                            <input type="text" class="form-control" id="optionMenuMessage" name="menu_message">
                        </div>
                        <div class="mb-3">
                            <label for="parentId" class="form-label">Parent Option</label>
                            <select class="form-select" id="parentId" name="parent_id">
                                <option value="">None</option>
                                @foreach($menuOptions as $option)
                                    <option value="{{ $option->id }}">{{ $option->option_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="action" class="form-label">Action</label>
                            <input type="text" class="form-control" id="action" name="action">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Submenu Modal -->
    <div class="modal fade" id="addSubmenuModal" tabindex="-1" aria-labelledby="addSubmenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('menu_options.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSubmenuModalLabel">Add Submenu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="submenuCode" class="form-label">Submenu Code</label>
                            <input type="text" class="form-control" id="submenuCode" name="option_code">
                        </div>
                        <div class="mb-3">
                            <label for="submenuName" class="form-label">Submenu Name</label>
                            <input type="text" class="form-control" id="submenuName" name="option_name">
                        </div>
                        <div class="mb-3">
                            <label for="submenuMessage" class="form-label">Submenu Message</label>
                            <input type="text" class="form-control" id="submenuMessage" name="menu_message">
                        </div>
                        <input type="hidden" id="submenuParentId" name="parent_id">
                        <div class="mb-3">
                            <label for="submenuAction" class="form-label">Action</label>
                            <input type="text" class="form-control" id="submenuAction" name="action">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editMenuOptionModal" tabindex="-1" aria-labelledby="editMenuOptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editMenuOptionForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMenuOptionModalLabel">Edit Menu Option</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editOptionId" name="id">
                        <div class="mb-3">
                            <label for="editOptionCode" class="form-label">Option Code</label>
                            <input type="text" class="form-control" id="editOptionCode" name="option_code">
                        </div>
                        <div class="mb-3">
                            <label for="editOptionName" class="form-label">Option Name</label>
                            <input type="text" class="form-control" id="editOptionName" name="option_name">
                        </div>
                        <div class="mb-3">
                            <label for="editMenuMessage" class="form-label">Option Menu Message</label>
                            <input type="text" class="form-control" id="editMenuMessage" name="menu_message">
                        </div>
                        <div class="mb-3">
                            <label for="editParentId" class="form-label">Parent Option</label>
                            <select class="form-select" id="editParentId" name="parent_id">
                                <option value="">None</option>
                                @foreach($menuOptions as $option)
                                    <option value="{{ $option->id }}">{{ $option->option_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAction" class="form-label">Action</label>
                            <input type="text" class="form-control" id="editAction" name="action">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <Script>
        function openEditModal(id) {
            fetch(`/menu_options/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editOptionId').value = data.id;
                    document.getElementById('editOptionCode').value = data.option_code;
                    document.getElementById('editOptionName').value = data.option_name;
                    document.getElementById('editParentId').value = data.parent_id;
                    document.getElementById('editAction').value = data.action;
                    document.getElementById('editMenuMessage').value = data.menu_message;
                    document.getElementById('editMenuOptionForm').action = `/menu_options/${data.id}`;
                    const editModal = new bootstrap.Modal(document.getElementById('editMenuOptionModal'));
                    editModal.show();
                })
                .catch(error => console.error('Error fetching menu option data:', error));
        }

        function openAddSubmenuModal(parentId, parentName) {
            document.getElementById('submenuParentId').value = parentId;
            document.getElementById('addSubmenuModalLabel').innerText = `Add Submenu to ${parentName}`;
            const addSubmenuModal = new bootstrap.Modal(document.getElementById('addSubmenuModal'));
            addSubmenuModal.show();
        }

        // Initialize Sortable for drag-and-drop functionality
        // let sortable = new Sortable(document.getElementById('sortableMenuOptions'), {
        //     animation: 150,
        //     onEnd: function (evt) {
        //         let order = [];
        //         document.querySelectorAll('#sortableMenuOptions li').forEach((row, index) => {
        //             order.push({ id: row.dataset.id, position: index + 1 });
        //         });

        //         fetch('/menu_options/reorder', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //             },
        //             body: JSON.stringify({ order: order })
        //         }).then(response => {
        //             if (response.ok) {
        //                 alert('Order updated successfully!');
        //             }
        //         });
        //     }
        // });
    </Script>
@endsection
