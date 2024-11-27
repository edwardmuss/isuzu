<table class="display table table-responsive table-bordered  table-striped">
    <thead>
    <tr>
        <th style="min-width: 50px">@sortablelink('id', 'ID')</th>
        <th style="min-width: 50px">Sacco Name</th>
        <th style="min-width: 50px">Sacco Route</th>
        <th>Client Name</th>
        <th style="min-width: 100px">Phone Number</th>
        <th style="min-width: 100px">Sacco Mail</th>
        <th style="min-width: 110px">@sortablelink('created_at', 'Created At')</th>
        <th>Comment</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($psv_awards as $data)
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->sacco_name}}</td>
            <td>{{$data->sacco_route}}</td>
            <td>{{$data->client_name}}</td>
            <td>{{$data->msisdn}}</td>
            <td>{{$data->s_email}}</td>
            <td>{{date('d/m/Y', strtotime($data->created_at))}}</td>
            <td>{{$data->comment}}</td>
            <td>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$data->id}}">
                    <i class="fa fa-edit"></i>
                </button>
            </td>
            <!-- Modal -->
            <div class="modal fade" id="{{$data->id}}" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form method="post" action="{{route('psv-awards.update', $data->id)}}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Comment on #{{$data->id}}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="well">
                                    <p>Commenting on <strong>{{$data->sacco_name}}'s {{$data->sacco_route}} route's award</strong> </p>
                                </div>
                                <label>Comment</label>
                                <textarea class="form-control" name="comment" rows="4">
                                    {{$data->comment}}
                            </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </tr>
    @endforeach
    </tbody>
</table>