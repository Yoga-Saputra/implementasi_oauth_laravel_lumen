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

                    <div class="card-header">Home</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (!auth()->user()->token)
                            <a href="/oauth/redirect">Authorize from server</a>
                        @else
                            <div class="alert alert-success" role="alert">
                                <h4>Token : </h4>{{ auth()->user()->token->access_token }}
                                <h4>expired token : </h4>{{ auth()->user()->token->expires_in }}
                            </div>
                        @endif

                        @foreach ($posts as $post)
                            <div class="py-3 border-bottom">
                                <h3>{{ $post['title'] }}</h3>
                                <div>{{ $post['body'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
