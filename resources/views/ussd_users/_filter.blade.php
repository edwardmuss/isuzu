<div class="col-md-12">
    <section class="panel">
        <header class="panel-heading">
            <b><i class="fa fa-search"></i> Filter</b>
        </header>
        <div class="panel-body">
            <form class="col-md-12" method="get">
                <div class="col-md-3">
                    <label>Phone Number</label>
                    <input type="text" value="{{ isset($filters['msisdn']) ? $filters['msisdn'] : '' }}" class="form-control" name="msisdn" placeholder="msisdn">
                </div>
                <div class="col-md-3">
                    <label>Date Range</label>
                    <input type="text" class="form-control" autocomplete="off" name="daterange" value="{{ isset($filters['daterange']) ? $filters['daterange'] : '' }}" placeholder="Select Date Range" id="reportrange">
                </div>
                <div class="col-md-3">
                    <label></label>
                    <button type="submit" class="form-control btn btn-primary"><i class="fa fa-search"></i> Search</button>
                </div>
                <div class="col-md-3">
                    <label></label>
                    <a href="{{route('ussd-users.index')}}" class="form-control btn btn-default">Clear</a>
                </div>

            </form>
        </div>
    </section>
</div>