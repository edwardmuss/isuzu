<table class="display table table-responsive table-bordered  table-striped">
    <thead>
    <tr>
        <th style="min-width: 50px">@sortablelink('ID')</th>
        <th>Client Name</th>
        <th style="min-width: 100px">Phone No.</th>
        <th>Quote Name</th>
        <th>Quote Number</th>
        <th style="min-width: 100px">Amount</th>
        <th style="min-width: 100px">Client Email</th>
        <th style="min-width: 110px">@sortablelink('created_at', 'Created At')</th>
        <th>Comment</th>
        <th>Dealer</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($vehicleSale as $data)
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->client_name}}</td>
            <td>{{$data->client_msisdn}}</td>
            <td>{{$data->quote_name}}</td>
            <td>{{$data->quote_number}}</td>
            <td>{{$data->amount}}</td>
            <td>{{$data->email_ad}}</td>
            <td>{{date('d/m/Y', strtotime($data->created_at))}}</td>
            <td>{{$data->comment}}</td>
            <td>
                {{$data->dealer}}
            </td>
            <td>
                <a class="btn btn-sm btn-success" href="{{ asset("storage/quotes/S" . $data->quote_number . ".pdf") }}" target="_blank" rel="noopener noreferrer">PDF</a>
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
                        <form method="post" action="{{route('vehicle-sales.update', $data->id)}}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Comment on #{{$data->id}}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="well">
                                    <p>Commenting on <strong>{{$data->client_name}}'s</strong> | Quote:
                                        <strong>{{$data->quote_name}}</strong></p>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Comment:</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="4">
                                    {{$data->comment}}
                                </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Dealer</label>
                                    <select class="form-control" name="dealer">
                                        @if(empty($data->dealer))
                                            <option selected disabled value="">-- Select Dealer --</option>
                                        @else
                                            <option value="{{$data->dealer}}">{{$data->dealer}}</option>
                                        @endif
                                        <option value="Associated Motors Limited">Associated Motors Limited</option>
                                        <option value="Africa Commercial Motors Group Ltd">Africa Commercial Motors
                                            Group Ltd
                                        </option>
                                        <option value="Central Farmers Garage">Central Farmers Garage</option>
                                        <option value="Kenya Coach Industries">Kenya Coach Industries</option>
                                        <option value="Ryce East Africa Ltd">Ryce East Africa Ltd</option>
                                        <option value="Thika Motor Dealers">Thika Motor Dealers</option>
                                        <option value="Mangu Auto & Hardware Ltd (Parts dealer only)">Mangu Auto &
                                            Hardware Ltd (Parts dealer only)
                                        </option>
                                        <option value="AutoXpres">AutoXpres</option>
                                        <option value="MAC East Africa Ltd">MAC East Africa Ltd</option>
                                        <option value="Quality Automotive & Mechanization Limited">Quality Automotive &
                                            Mechanization Limited
                                        </option>
                                        <option value="Isuzu East Africa">Isuzu East Africa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </tr>
    @endforeach
    </tbody>
</table>