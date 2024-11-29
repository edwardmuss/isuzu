<table class="display table table-responsive table-bordered  table-striped">
    <thead>
    <tr>
        <th style="min-width: 50px">@sortablelink('ID')</th>
        <th>@sortablelink('msisdn', 'Phone Number')</th>
        {{-- <th>@sortablelink('ussd_menu', 'USSD Menu')</th> --}}
        <th style="min-width: 100px">@sortablelink('ussd_string', 'USSD String')</th>
        <th style="min-width: 110px">@sortablelink('created_at', 'Created At')</th>
        <th>Comment</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->phone_number}}</td>
            {{-- <td>{{$user->ussd_menu}}</td> --}}
            <td>{{$user->ussd_string}}</td>
            <td>{{date('d/m/Y', strtotime($user->created_at))}}</td>
            <td>{{$user->comment}}</td>
            <td>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$user->id}}">
                    <i class="fa fa-edit"></i>
                </button>
            </td>
            <!-- Modal -->
            <div class="modal fade" id="{{$user->id}}" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form method="post" action="{{route('ussd-users.update', $user->id)}}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Comment on #{{$user->id}}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="well">
                                    <p>Commenting on <strong>{{$user->msisdn}}'s</strong></p>
                                </div>
                                <label>Comment</label>
                                <textarea class="form-control" name="comment" rows="4">
                                    {{$user->comment}}
                            </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <button type="submit" class="btn btn-success"><i class=" fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </tr>
    @endforeach
    </tbody>
</table>