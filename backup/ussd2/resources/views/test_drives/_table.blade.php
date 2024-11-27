<table class="display table table-responsive table-bordered table-striped">
    <thead>
    <tr>
        <th style="min-width: 50px">@sortablelink('id', 'ID')</th>
        <th>Client Names</th>
        <th style="min-width: 100px">Phone Number</th>
        <th style="min-width: 100px">Client Email</th>
        <th style="min-width: 100px">Request</th>
        <th style="min-width: 100px">Location</th>
        <th style="min-width: 110px">@sortablelink('created_at', 'Created At')</th>
        <th>Comment</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($test_drives as $data)
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->client_name}}</td>
            <td>{{$data->msisdn}}</td>
            <td>{{$data->client_email}}</td>
            <td>{{$data->request}}</td>
            <td>{{$data->location}}</td>
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
                        <form method="post" action="{{route('test-drives.update', $data->id)}}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Comment on #{{$data->id}}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="well">
                                    <p>Commenting on <strong>{{$data->client_name}}'s</strong> test drive request</p>
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