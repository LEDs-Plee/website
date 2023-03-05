@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Toilets</div>

                    <div class="card-body">
                        <form action="{{ route('toilets.create') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="name">Name:</span>
                                        <input type="text" name="name" class="form-control" placeholder="Boven" aria-label="name" aria-describedby="name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Create toilet</button>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Secret</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($toilets as $toilet)
                                <tr>
                                    <td>{{ $toilet->id }}</td>
                                    <td>{{ $toilet->name }}</td>
                                    <td>{{ $toilet->secret }}</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm"
                                           href="{{ route('toilets.edit', ['toilet' => $toilet]) }}"
                                           data-bs-toggle="tooltip" data-bs-title="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="btn btn-secondary btn-sm"
                                           href="{{ route('toilets.regenerate', ['toilet' => $toilet]) }}"
                                           data-bs-toggle="tooltip" data-bs-title="Regenerate secret"
                                        >
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm"
                                           href="{{ route('toilets.delete', ['toilet' => $toilet]) }}"
                                           data-bs-toggle="tooltip" data-bs-title="Remove"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                There are no toilets.
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
