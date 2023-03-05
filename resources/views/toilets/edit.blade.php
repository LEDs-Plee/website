@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit toilet "{{ $toilet->name }}"</div>

                    <div class="card-body">
                        <form action="{{ route('toilets.store', ['toilet' => $toilet]) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="id" class="form-label">Id</label>
                                <input disabled value="{{ $toilet->id }}" type="number" class="form-control" id="id" aria-describedby="id">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input value="{{ $toilet->name }}" type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="secret" class="form-label">Secret</label>
                                <input disabled value="{{ $toilet->secret }}" type="text" class="form-control" id="secret">
                            </div>
                            <button type="submit" class="btn btn-primary">Update toilet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
