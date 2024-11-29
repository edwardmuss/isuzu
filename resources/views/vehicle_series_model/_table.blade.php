<table class="display table table-responsive table-bordered table-striped">
    <thead>
        <tr>
            <th>@sortablelink('series', 'Series')</th>
            <th>Previous Name</th>
            <th>New Model Name (Backend)</th>
            <th>New Model Name (Customer)</th>
            <th>Description</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Amount</th>
            <th>@sortablelink('created_at', 'Created At')</th>
            <th>Photo</th>
            <th>Brochure</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicleSeries as $data)
        <tr>
            <td>{{ $data->series }}</td>
            <td>{{ $data->previous_name }}</td>
            <td>{{ $data->new_model_name_backend }}</td>
            <td>{{ $data->new_model_name_customer }}</td>
            <td>{{ $data->description }}</td>
            <td>{{ $data->price }}</td>
            <td>{{ $data->discount }}</td>
            <td>{{ $data->amount }}</td>
            <td>{{ date('d/m/Y', strtotime($data->created_at)) }}</td>
            <td>
                @if($data->photo)
                    <img src="{{ asset('storage/' . $data->photo) }}" alt="Photo" width="50">
                @endif
            </td>
            <td>
                @if($data->brochure)
                    <a class="btn btn-info btn-sm" href="{{ asset('storage/' . $data->brochure) }}" target="_blank" rel="noopener noreferrer">View</a>
                @endif
            </td>
            <td>
                <div class="d-inline-flex">
                    <button type="button" class="btn btn-info btn-sm mb-1 mr-1 me-1" data-toggle="modal" data-target="#{{$data->id}}">
                        <i class="fa fa-edit"></i>
                    </button>
                    <form action="{{ route('vehicle-series.destroy', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Delete entry?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>

            <!-- Add/Edit Modal -->
            <div class="modal fade" id="{{$data->id}}" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{  route('vehicle-series.update', $data) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                @method('PUT')
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Update {{ $data->new_model_name_customer }}</h4>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <!-- Series -->
                                <div class="form-group mb-3">
                                    <label for="series">Series</label>
                                    <input type="text" id="series" name="series" class="form-control" value="{{ $data->series ?? old('series') }}" required>
                                </div>
                            
                                <!-- Previous Name -->
                                <div class="form-group mb-3">
                                    <label for="previous_name">Previous Name (Backend)</label>
                                    <input type="text" id="previous_name" name="previous_name" class="form-control" value="{{ $data->previous_name ?? old('previous_name') }}">
                                </div>
                            
                                <!-- New Model Name Backend -->
                                <div class="form-group mb-3">
                                    <label for="new_model_name_backend">New Model Name (Backend)</label>
                                    <input type="text" id="new_model_name_backend" name="new_model_name_backend" class="form-control" value="{{ $data->new_model_name_backend ?? old('new_model_name_backend') }}">
                                </div>
                            
                                <!-- New Model Name Customer -->
                                <div class="form-group mb-3">
                                    <label for="new_model_name_customer">New Model Name (Customer)</label>
                                    <input type="text" id="new_model_name_customer" name="new_model_name_customer" class="form-control" value="{{ $data->new_model_name_customer ?? old('new_model_name_customer') }}">
                                </div>
                            
                                <!-- Description -->
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control">{{ $data->description ?? old('description') }}</textarea>
                                </div>
                            
                                <!-- Price -->
                                <div class="form-group mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" id="price" name="price" class="form-control" value="{{ $data->price ?? old('price') }}" step="0.01">
                                </div>
                            
                                <!-- Discount -->
                                <div class="form-group mb-3">
                                    <label for="discount">Discount</label>
                                    <input type="number" id="discount" name="discount" class="form-control" value="{{ $data->discount ?? old('discount') }}" step="0.01">
                                </div>
                            
                                <!-- Amount -->
                                <div class="form-group mb-3">
                                    <label for="amount">Amount</label>
                                    <input type="number" id="amount" name="amount" class="form-control" value="{{ $data->amount ?? old('amount') }}" step="0.01">
                                </div>
                            
                                <!-- Photo -->
                                <div class="form-group mb-3">
                                    <label for="photo">Photo</label>
                                    <input type="file" id="photo" name="photo" class="form-control">
                                    @if(isset($data->photo))
                                        <img src="{{ asset('storage/' . $data->photo) }}" alt="Vehicle Photo" width="100" class="mt-2">
                                    @endif
                                </div>

                                <!-- Brochure -->
                                <div class="form-group mb-3">
                                    <label for="brochure">Brochure</label>
                                    <input type="file" id="brochure" name="brochure" class="form-control">
                                    @if(isset($data->photo))
                                        <a href="{{ asset('storage/' . $data->photo) }}" target="_blank" rel="noopener noreferrer">View</a>
                                    @endif
                                </div>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </tr>
        @endforeach
    </tbody>
</table>
