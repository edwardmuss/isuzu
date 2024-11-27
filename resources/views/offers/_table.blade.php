<table class="display table table-responsive table-bordered table-striped">
    <thead>
    <tr>
        <th style="min-width: 50px">@sortablelink('id', 'ID')</th>
        <th style="min-width: 100px">Offer Name</th>
        <th>Client Names</th>
        <th style="min-width: 100px">Phone Number</th>
        <th style="min-width: 100px">Client Email</th>
        <th style="min-width: 110px">@sortablelink('created_at', 'Created At')</th>
        <th>Comment</th>
        <th>Responsible</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($offers as $data)
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->offer_name}}</td>
            <td>{{$data->client_name}}</td>
            <td>{{$data->msisdn}}</td>
            <td>{{$data->client_email}}</td>
            <td>{{date('d/m/Y', strtotime($data->created_at))}}</td>
            <td>{{$data->comment}}</td>
            <td>{{$data->responsible}}</td>
            <td>
                @if($data->status == 1)
                    <button class="btn btn-sm btn-danger"
                            style="cursor: default">
                        {{empty($data->status) ? '' : \App\Helpers\DbHelper::decode_status($data->status)}}
                    </button>
                @elseif($data->status == 2)
                    <button class="btn btn-sm btn-warning"
                            style="cursor: default">
                        {{empty($data->status) ? '' : \App\Helpers\DbHelper::decode_status($data->status)}}
                    </button>
                @elseif($data->status == 3)
                    <button class="btn btn-sm btn-success"
                            style="cursor: default">
                        {{empty($data->status) ? '' : \App\Helpers\DbHelper::decode_status($data->status)}}
                    </button>
                @endif
            </td>
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
                        <form method="post" action="{{route('offers.update', $data->id)}}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Comment on #{{$data->id}}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="well">
                                    <p>Commenting on <strong>{{$data->offer_name}}</strong> offer</p>
                                </div>
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea class="form-control" name="comment" rows="4">
                                        {{$data->comment}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Responsible</label>
                                    <select class="form-control" name="responsible">
                                        @if(empty($data->responsible))
                                            <option selected disabled value="">-- Assign Responsibility --</option>
                                        @else
                                            <option value="{{$data->responsible}}">{{$data->responsible}}</option>
                                        @endif
                                        <option value="Dealer">Dealer</option>
                                        <option value="Sales">Sales</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        @if(empty($data->status))
                                            <option selected disabled value="">-- Select Status --</option>
                                        @else
                                            <option value="{{$data->status}}">{{\App\Helpers\DbHelper::decode_status($data->status)}}</option>
                                        @endif
                                        <option value="1">Open</option>
                                        <option value="2">On Going</option>
                                        <option value="3">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </tr>
    @endforeach
    </tbody>
</table>