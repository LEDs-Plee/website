@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Washers</div>

                    <div class="card-body">
                        <form action="{{ route('washers.create') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="name">Name:</span>
                                        <input type="text" name="name" class="form-control" placeholder="Wasmachine" aria-label="name" aria-describedby="name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="name">Smartthings id:</span>
                                        <input type="text" name="smartthings_id" class="form-control" placeholder="abcdefghijklmnop" aria-label="name" aria-describedby="name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Create washer</button>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Smartthings id</th>
                                <th>State</th>
                                <th>Job state</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($washers as $washer)
                                <tr>
                                    <td>{{ $washer->name }}</td>
                                    <td>{{ $washer->smartthings_id }}</td>
                                    <td>{{ $washer->state }}</td>
                                    <td>{{ $washer->jobState }}</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm"
                                           href="{{ route('washers.edit', ['washer' => $washer]) }}"
                                           data-bs-toggle="tooltip" data-bs-title="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="btn btn-secondary btn-sm"
                                           href="{{ route('washers.update', ['washer' => $washer]) }}"
                                           data-bs-toggle="tooltip" data-bs-title="Update from API"
                                        >
                                            <i class="bi bi-cloud-download"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm"
                                           href="{{ route('washers.delete', ['washer' => $washer]) }}"
                                           data-bs-toggle="tooltip" data-bs-title="Remove"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                There are no washers.
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
