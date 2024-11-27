@extends('layouts.app')
@section('css')
    <style>
        .panel-heading {
            color: red;
            font-family: "Century Gothic" !important;
        }

        thead, thead tr th a {
            color: red;
        }
        .state-overview .value h1, .state-overview .value p{
            color: black;
        }
    </style>
@endsection
@section('content')
    <!-- page start-->
    <div class="col-md-12">
        <h4>DashBoard</h4>


        <div class="row state-overview">

            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-car"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count2">
                            0
                        </h1>
                        <p>Test Drives Requested</p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-file-pdf-o"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count3">
                            0
                        </h1>
                        <p>Brochures Requested</p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-gift"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count4">
                            0
                        </h1>
                        <p>Offers</p>
                    </div>
                </section>
            </div>

            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-wrench"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count5">
                            0
                        </h1>
                        <p>Services Requested</p>
                    </div>
                </section>
            </div>

            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-sliders"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count6">
                            0
                        </h1>
                        <p>Parts Requested</p>
                    </div>
                </section>
            </div>

            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count7">
                            0
                        </h1>
                        <p>Psv Awards</p>
                    </div>
                </section>
            </div>

            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count8">
                            0
                        </h1>
                        <p>Locate Dealer Requests</p>
                    </div>
                </section>
            </div>

            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="fa fa-hospital-o"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count9">
                            0
                        </h1>
                        <p>Tech Assistance Requests</p>
                    </div>
                </section>
            </div>


            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        General Summary
                        <div class="pull-right">
                            <input id="reportrange" type="text" >
                            <button class="btn btn-primary" onclick="pullData()">Filter</button>
                        </div>
                    </header>
                    <div class="panel-body">
                        <div id="container3" style="width:100%; height:500px;"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        Vehicle Sales
                    </header>
                    <div class="panel-body">
                        <div id="container9" style="width:100%; height:400px;"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="panel">
                    <header class="panel-heading">
                        Pickup Requests
                    </header>
                    <div class="panel-body">
                        <div id="container1" style="width:100%; height:400px;"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-6">
                <section class="panel">
                    <header class="panel-heading">
                        Pickup Requests Overview
                    </header>
                    <div class="panel-body">
                        <div id="container2" style="width:100%; height:400px;"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
        <!-- page end-->
        @endsection
        @section('js')
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="{{asset('js/count.js')}}"></script>
            <script>
                $(function () {
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

                    $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                    });

                    $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
                        $(this).val('');
                    });
                });
            </script>
            <script>
                var myChart3;

                function pullData(){
                    var range = $('#reportrange').val();
                    console.log(range.replace(/ /g, '+'));
                    console.log(BASE_URL + '/index/counts?range='+range);
                    $.getJSON(BASE_URL + '/index/counts?range='+range.replace(/ /g, '+'), function (response) {
                        var labels = new Array(), counts = new Array(), key;
                        console.log(response);
                        for (key in response) {
                            if (response.hasOwnProperty(key)) {
                                labels.push(key);
                                //cards.push(response[key]);
                                counts.push({y:response[key]});
                                //console.log(key + " = " + response[key]);
                            }
                        }
                        console.log('counts     '+counts   );
                        myChart3.series[0].setData(counts, true);
                    });
                }


                $(function () {
                    var labels = new Array(), counts = new Array(), key;
                    var cards = new Array();
                    //var allCounts = new Array(), key;
                    $.getJSON(BASE_URL + '/index/counts', function (response) {
                        console.log(response);
                        for (key in response) {
                            if (response.hasOwnProperty(key)) {
                                labels.push(key);
                                cards.push(response[key]);
                                counts.push({y:response[key]});
                                //console.log(key + " = " + response[key]);
                            }
                        }
                        console.log(labels);
                        console.log(counts[3]);
                        countUp2(cards[0]);
                        countUp3(cards[1]);
                        countUp4(cards[2]);
                        countUp5(cards[3]);
                        countUp6(cards[4]);
                        countUp7(cards[5]);
                        countUp8(cards[6]);
                        countUp9(cards[7]);
                        var dt = [1, 2, 3];

                        myChart3 = Highcharts.chart('container3', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Summary'
                            },
                            credits: {
                                enabled: false
                            },
                            xAxis: {
                                categories: labels
                            },
                            yAxis: {
                                title: {
                                    text: 'Total Count'
                                }
                            },
                            series: [{
                                name: 'Counts',
                                data: counts,
                            }]
                        });
                    });

                    var labelsPickup = new Array(), countsPickups = new Array(), keyPickup;
                    $.getJSON(BASE_URL + '/index/cabs', function (response) {
                        console.log(response);
                        for (keyPickup in response) {
                            if (response.hasOwnProperty(keyPickup)) {
                                labelsPickup.push(keyPickup);
                                countsPickups.push(response[keyPickup]);
                            }
                        }
                        console.log(labelsPickup);
                        console.log(countsPickups);

                        var myChart1 = Highcharts.chart('container1', {
                            chart: {
                                type: 'pie'
                            },
                            credits: {
                                enabled: false
                            },
                            title: {
                                text: 'Pickup Sales'
                            },
                            yAxis: {
                                title: {
                                    text: 'Fruit eaten'
                                }
                            },
                            series: [{
                                name: 'Brands',
                                colorByPoint: true,
                                data: [{
                                    name: labelsPickup[0],
                                    y: countsPickups[0],
                                }, {
                                    name: labelsPickup[1],
                                    y: countsPickups[1],
                                }]
                            }]
                        });
                    });


                    var labelsYearly = new Array(), countsYearly = new Array(), keyYearly;
                    $.getJSON(BASE_URL + '/index/cabs-yearly', function (response) {
                        console.log('hahah');
                        console.log(response);
                        for (keyYearly in response) {
                            if (response.hasOwnProperty(keyYearly)) {
                                labelsYearly.push(keyYearly);
                                countsYearly.push(response[keyYearly]);
                            }
                        }

                        var myChart2 = Highcharts.chart('container2', {
                            chart: {
                                type: 'line'
                            },
                            title: {
                                text: 'Current Year Pickup Requests'
                            },
                            xAxis: {
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                            },
                            credits: {
                                enabled: false
                            },
                            yAxis: {
                                title: {
                                    text: 'Pickup Requests'
                                }
                            },
                            series: [{
                                name: 'Single Cab',
                                data: countsYearly[0]
                            }, {
                                name: 'Double Cab',
                                data: countsYearly[1]
                            }]
                        });
                    });

                    var labelYearly = new Array(), countYearly = new Array(), keysYearly;
                    $.getJSON(BASE_URL + '/index/vehicle-yearly', function (response) {
                        console.log(response);
                        for (keysYearly in response) {
                            if (response.hasOwnProperty(keysYearly)) {
                                labelYearly.push(keysYearly);
                                countYearly.push(response[keysYearly]);
                            }
                        }

                        var myChart9 = Highcharts.chart('container9', {
                            chart: {
                                type: 'line'
                            },
                            title: {
                                text: 'Current Year Vehicle sales'
                            },
                            xAxis: {
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                            },
                            credits: {
                                enabled: false
                            },
                            yAxis: {
                                title: {
                                    text: 'Vehicle Sales'
                                }
                            },
                            series: [{
                                name: 'PickUp',
                                data: countYearly[0]
                            }, {
                                name: 'Bus',
                                data: countYearly[1]
                            }, {
                                name: 'Truck',
                                data: countYearly[2]
                            }, {
                                name: 'Prime Movers',
                                data: countYearly[3]
                            }, {
                                name: 'mu-X',
                                data: countYearly[4]
                            }]
                        });
                    });

                });
            </script>
@endsection