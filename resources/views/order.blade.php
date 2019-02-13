@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Подача заявки в систему поиска заявок пользователей') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('order.create') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ФИО') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="order" class="col-md-4 col-form-label text-md-right">{{__('Текст заявки')}}</label>
                                <div class="col-md-6">
                                    @isset($errors)
                                        <textarea name="order" class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" id="order" maxlength="200">{{ old('order') }}</textarea>
                                    @else
                                        <textarea name="order" class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" id="order" maxlength="200"></textarea>
                                    @endisset
                                    @if ($errors->has('order'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Город(Ростовская область)') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" required>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="adres" class="col-md-4 col-form-label text-md-right">{{ __('Адрес') }}</label>

                                <div class="col-md-6">
                                    <input id="adres" type="text" class="form-control{{ $errors->has('adres') ? ' is-invalid' : '' }}" name="adres" value="{{ old('adres') }}" required>
                                    @if ($errors->has('adres'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('adres') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Опубликовать') }}
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="{ $errors->has('rezult') ? ' is-invalid' : '' }}">
                                @if ($errors->has('rezult'))
                                    <span class="invalid-feedback" role="alert" style="display: inline">
                                        <strong>{{ $errors->first('rezult') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
