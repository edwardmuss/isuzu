<table class="display table table-responsive table-bordered table-striped">
    <thead>
        <tr>
            <th>@sortablelink('name', 'Full Name')</th>
            <th>@sortablelink('email', 'Email')</th>
            <th>@sortablelink('created_at', 'Created At')</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admin_users as $data)
        <tr>
            <td>{{ $data->name }}</td>
            <td>{{ $data->email }}</td>
            <td>{{ date('d/m/Y', strtotime($data->created_at)) }}</td>
            <td>
                <div class="d-inline-flex">
                    <button type="button" class="btn btn-info btn-sm mb-1 mr-1 me-1" data-toggle="modal" data-target="#{{$data->id}}">
                        <i class="fa fa-edit"></i>
                    </button>
                    <form action="{{ route('users.destroy', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Delete User?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>

            <!-- Edit Modal -->
            <div class="modal fade editForm" id="{{$data->id}}" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{  route('users.update', $data) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                @method('PUT')
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Update {{ $data->name }}</h4>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <!-- Name -->
                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $data->name ?? old('name') }}" required>
                                </div>
                            
                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email">Email (Backend)</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ $data->email ?? old('email') }}">
                                </div>
                            
                                <!-- Change Password -->
                                <div class="form-group mb-3">
                                    <label for="password">New Password (Leave blank to maintain current password)</label>
                                    <input type="text" id="password" name="password" class="form-control" value="">
                                </div>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </tr>
        @endforeach
    </tbody>
</table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // This will clear the password field when the modal is triggered
    $('.editForm').on('show.bs.modal', function (e) {
        $('#password').val(''); // Clear password field
    });
</script>
