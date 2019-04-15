@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Profile Data</div>

                <div class="card-body">
                    <form method="POST" action="{{route('ChangeUserData')}}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                            <label for="username" class="col-md-6 col-form-label text-md-center">{{ Auth::user()->username }}</label>
                            <input id="username" type="hidden" class="form-control" name="username" value="{{Auth::user()->username}}" >
                        </div>

                        @include('partials.personal_data')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Change') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <form method="POST" action="#">
                        @csrf
                        @include('partials.passwords')
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
