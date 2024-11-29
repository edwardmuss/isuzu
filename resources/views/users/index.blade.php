@extends('layouts.app')
@section('css')
<style>
    .panel-heading {
        color: red;
    }
    thead, thead tr th a {
        color: red;
    }
</style>
@endsection
@section('content')
<div class="row">
    @include('users._filter')
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <b><i class="fa fa-car"></i> Users ({{ $admin_users->total() }})</b>
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus"></i> Add User
                    </button>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @php
                            $filters['export'] = 'excel';
                            @endphp
                            <li><a href="{{route('users.index', $filters)}}">Excel</a></li>
                            @php
                                $filters['export'] = 'pdf';
                            @endphp
                            <li><a href="{{route('users.index', $filters)}}">Pdf</a></li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class="panel-body">
                <!-- Display Success Message -->
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Display Error Message -->
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <div class="table-responsive">
                    @include('users._table')
                </div>
                <div class="col-md-12">
                    {{ $admin_users->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Add -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{  route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Add New User</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Name -->
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                
                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email">Email (Backend)</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                
                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">New Password (Leave blank to maintain current password)</label>
                        <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript">
        $(function() {
            $('#reportrange').daterangepicker({
                "locale": {
                    "format": "YYYY-MM-DD",
                    cancelLabel: 'Clear'
                },
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>


    <!--script for this page only-->
@endsection
