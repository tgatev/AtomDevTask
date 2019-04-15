@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">View Book</div>
                    <div class="card-body">
                        <div class="text-md-center">
                             <img src="{{$img}}" align="middle">
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <p id="name" class="col-md-6 text-md-center"> {{$book->name}}
                            </p>
                        </div>

                        <div class="form-group row">
                            <label for="ISBN" class="col-md-4 col-form-label text-md-right">{{ __('ISBN') }}</label>
                            <p id="ISBN" class="col-md-6 text-md-center"> {{$book->ISBN}}
                            </p>
                        </div>

                        <div class="form-group row">
                            <label for="year" class="col-md-4 col-form-label text-md-right" >{{ __('Year') }}</label>
                            <p id="year" class="col-md-6 text-md-center"> {{$book->year}}
                            </p>
                        </div>

                        <div class="form-group row">
                            <label for="Description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <p id="Description" class="col-md-6 text-md-center"> {{$book->Description}}
                            </p>
                        </div>
                        <form method="POST" action="{{ route("updateBook" , [ 'id' => $book->id ]) }}" >
                            @csrf
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" href="" >
                                        {{ __('Change') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
