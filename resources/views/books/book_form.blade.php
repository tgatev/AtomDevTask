@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$action}} Book</div>

                    <div class="card-body">
                        <form method="POST" action="{{$route}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{@$book->id}}">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{@old('name', $book->name)}}" maxlength="100" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ISBN" class="col-md-4 col-form-label text-md-right">{{ __('ISBN') }}</label>

                                <div class="col-md-6">
                                    <input id="ISBN" type="text" class="form-control{{ $errors->has('ISBN') ? ' is-invalid' : '' }}" name="ISBN" value="{{ @old('ISBN', $book->ISBN)  }}"  maxlength="20" required autofocus>

                                    @if ($errors->has('ISBN'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ISBN') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="year" class="col-md-4 col-form-label text-md-right" >{{ __('Year') }}</label>

                                <div class="col-md-6">
                                    <input id="year" type="text" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" name="year" value="{{ @old('year', $book->year )}}" maxlength="4"  required>

                                    @if ($errors->has('year'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea name="Description" id="Description" cols="45" rows="8"  style="resize:none"  maxlength="500"  >{{@old('Description', $book->Description)}}</textarea>
                                    @if ($errors->has('Description'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('Description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                                <div class="col-md-6">
                                    @if(isset($img))
                                        <div>
                                            <img src="{{$img}}">
                                        </div>
                                    @endif
                                    <input type="file" name="image" class="form-control">
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $action }}
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
