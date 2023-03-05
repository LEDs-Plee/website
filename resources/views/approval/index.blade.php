@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Approve Users</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Approve</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($unapprovedUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><a class="btn btn-primary btn-sm" href="{{ route('approval.approve', ['user' => $user]) }}">Approve</a></td>
                                </tr>
                            @empty
                                There are no unapproved users.
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
