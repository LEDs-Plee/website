@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit washer "{{ $washer->name }}"</div>

                    <div class="card-body">
                        <form action="{{ route('washers.store', ['washer' => $washer]) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input value="{{ $washer->name }}" type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="smartthings_id" class="form-label">Smartthings id</label>
                                <input name="smartthings_id" value="{{ $washer->smartthings_id }}" type="text" class="form-control" id="smartthings_id">
                            </div>
                            <button type="submit" class="btn btn-primary">Update washer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
