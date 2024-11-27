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
    @include('vehicle_series_model._filter')
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <b><i class="fa fa-car"></i> Vehicle Series ({{ $vehicleSeries->total() }})</b>
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModal">
                        <i class="fa fa-upload"></i> Upload Excel
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus"></i> Add Record
                    </button>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @php
                            $filters['export'] = 'excel';
                            @endphp
                            <li><a href="{{route('vehicle-series.index', $filters)}}">Excel</a></li>
                            @php
                                $filters['export'] = 'pdf';
                            @endphp
                            <li><a href="{{route('vehicle-series.index', $filters)}}">Pdf</a></li>
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
                    @include('vehicle_series_model._table')
                </div>
                <div class="col-md-12">
                    {{ $vehicleSeries->appends(request()->except('page'))->links() }}
                    <!-- Add pagination links -->
                    {{-- {{ $vehicleSeriesModels->appends(Request::except('page'))->links() }} --}}
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('vehicle-series.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload Vehicle Series Data</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Select Excel File:</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('vehicle-series.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Vehicle Series/Model</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Series -->
                    <div class="form-group mb-3">
                        <label for="series">Series</label>
                        <input type="text" id="series" name="series" class="form-control" value="{{ old('series') }}" required>
                    </div>
                
                    <!-- Previous Name -->
                    <div class="form-group mb-3">
                        <label for="previous_name">Previous Name (Backend)</label>
                        <input type="text" id="previous_name" name="previous_name" class="form-control" value="{{ old('previous_name') }}">
                    </div>
                
                    <!-- New Model Name Backend -->
                    <div class="form-group mb-3">
                        <label for="new_model_name_backend">New Model Name (Backend)</label>
                        <input type="text" id="new_model_name_backend" name="new_model_name_backend" class="form-control" value="{{ old('new_model_name_backend') }}">
                    </div>
                
                    <!-- New Model Name Customer -->
                    <div class="form-group mb-3">
                        <label for="new_model_name_customer">New Model Name (Customer)</label>
                        <input type="text" id="new_model_name_customer" name="new_model_name_customer" class="form-control" value="{{ old('new_model_name_customer') }}">
                    </div>
                
                    <!-- Description -->
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                
                    <!-- Price -->
                    <div class="form-group mb-3">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" step="0.01">
                    </div>
                
                    <!-- Discount -->
                    <div class="form-group mb-3">
                        <label for="discount">Discount</label>
                        <input type="number" id="discount" name="discount" class="form-control" value="{{ old('discount') }}" step="0.01">
                    </div>
                
                    <!-- Amount -->
                    <div class="form-group mb-3">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount') }}" step="0.01">
                    </div>
                
                    <!-- Photo -->
                    <div class="form-group mb-3">
                        <label for="photo">Photo</label>
                        <input type="file" id="photo" name="photo" class="form-control">
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New</button>
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
