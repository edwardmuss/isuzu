@extends('layouts.app')
@section('css')
    <style>
        .panel-heading{
            color: red;
        }
        thead, thead tr th a {
            color: red;
        }
    </style>
@endsection
@section('content')
    <!-- page start-->
    <div class="row">
        @include('test_drives._filter')
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <b><i class="fa fa-car"></i> Test Drives ({{$test_drives->total()}})</b>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @php
                            $filters['export'] = 'excel';
                            @endphp
                            <li><a href="{{route('test-drives.index', $filters)}}">Excel</a></li>
                            @php
                                $filters['export'] = 'pdf';
                            @endphp
                            <li><a href="{{route('test-drives.index', $filters)}}">Pdf</a></li>
                        </ul>
                    </div>
                </header>
                <div class="panel-body">
                    <div class="">
                        <div class="table-responsive nicescroll-rails" style="width: 100%; overflow-x: scroll">
                            @include('test_drives._table')
                        </div>
                        <div class="col-md-12">
                            {{ $test_drives->appends(request()->except('page')) }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
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