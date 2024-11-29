@extends('layouts.app')
@section('css')
<style>
    .panel-heading {
        color: red;
        font-size: 1.5rem;
        font-weight: bold;
        /* text-align: center; */
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    thead,
    thead tr th a {
        color: red;
    }

    .ck-editor__editable_inline {
        min-height: 200px;
    }

    .card.custom-shadow {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(45deg, #FF0000, #FFA07A);
        color: #fff;
        padding: 20px;
        text-align: center;
        font-size: 1.25rem;
        font-weight: bold;
        border-radius: 10px 10px 0 0;
    }

    .card-body {
        padding: 30px;
    }

    .form-control,
    .form-control-file {
        border-radius: 5px;
        padding: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <b><i class="fa fa-gift"></i> Loyalties</b>
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

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="card custom-shadow">
                            <div class="card-header">
                                Loyalty Management
                            </div>
                            <div class="card-body">
                                <form action="{{ route('loyalty.update-or-create') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $loyalty->id ?? '' }}">

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input
                                            type="text"
                                            name="title"
                                            id="title"
                                            class="form-control"
                                            value="{{ old('title', $loyalty->title ?? '') }}"
                                            placeholder="Enter Title"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email_subject">Email Subject</label>
                                        <input
                                            type="text"
                                            name="email_subject"
                                            id="email_subject"
                                            class="form-control"
                                            value="{{ old('email_subject', $loyalty->email_subject ?? '') }}"
                                            placeholder="Enter Email Subject"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="sms_message">SMS Message (Merge tag: {name})</label>
                                        <textarea
                                            name="sms_message"
                                            id="sms_message"
                                            class="form-control"
                                            rows="5"
                                            placeholder="Enter SMS Message">{{ old('sms_message', $loyalty->sms_message ?? '') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="email_body">Email Body (Merge tag: {name})</label>
                                        <textarea
                                            name="email_body"
                                            id="email_body"
                                            class="form-control"
                                            rows="5"
                                            placeholder="Enter Email Body">{{ old('email_body', $loyalty->email_body ?? '') }}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="file">Upload File</label>
                                        <input type="file" name="file" id="file" class="form-control-file">
                                        @if (!empty($loyalty->file))
                                        <h4>Current File: <a href="{{ asset('storage/' . $loyalty->file) }}" target="_blank">View File</a></h4>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/29.2.0/ckeditor.min.js" integrity="sha512-wwT0JJH+SBiBr/tGqYtpnYLSMOpDt3fLdY1XHWyGSN7YWPnmdz/CoSYUa+ystmwqnb07QvtslyRjciQ9uIhVkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('js')
<script>
    ClassicEditor.create(document.getElementById('email_body'))
        .then(editor => {
            // Set the fixed height
            editor.ui.view.editable.element.style.height = '200px';

            // Optional: Prevent collapsing by explicitly setting the overflow behavior
            editor.ui.view.editable.element.style.overflow = 'auto';
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
