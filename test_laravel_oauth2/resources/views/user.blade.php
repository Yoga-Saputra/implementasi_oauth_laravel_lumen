@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error: </strong> {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">

                    <div class="card-header">Users</div>

                    <div class="card-body">
                        @if (!auth()->user()->token)
                            <a href="/oauth/redirect">Authorize from server</a>
                        @else
                            @foreach ($users as $user)
                                <div class="py-3 border-bottom">
                                    <div>Name : {{ $user['name'] }}</div>
                                    <div>Email : {{ $user['email'] }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
