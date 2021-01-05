@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <img src="{{ asset('images/logo-primary.png') }}" alt="logo" width="150">
            </div>
            <div class="card card-primary">
                <div class="card-header"><h4>Masuk</h4></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="text-md-right">Alamat Email</label>

                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Kata Sandi</label>
                                <div class="float-right">
                                    <a href="{{route('password.request')}}" class="text-small">
                                        Lupa kata sandi?
                                    </a>
                                </div>
                            </div>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">
                            <div class="invalid-feedback">
                                please fill in your password
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" {{old('remember') ? 'checked' : null}}>
                                <label class="custom-control-label" for="remember-me">Ingat Saya</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="simple-footer">
                © 2020 Hak Cipta Terpelihara {{config('app.name')}}
            </div>
        </div>
    </div>
@endsection
