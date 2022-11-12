@extends('layouts.app')
@section('content')
    <div class="container">
        @guest
            <div class="row justify-content-center main-page">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                                    </div>
                                </div>

                                <div class="row mb-0">

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            Start chat
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center main-page">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                                <div class="row mb-0">
                                    <div class="col-md-12">
                                        <a href="/chat">
                                            <button type="submit" class="btn btn-primary">
                                                Start chat
                                            </button>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        @endguest
    </div>
@endsection
