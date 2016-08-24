@extends('layouts.login')

@section('content')
    <form class="login-form" method="post" role="form" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        <h3 class="form-title font-green">Giriş Yap</h3>
        <p class="hint">Giriş yapmak için aşağıdaki alanları doldurun: </p>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Tüm alanlar gereklidir. </span>
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">E-Mail</label>
            <input class="form-control form-control-solid placeholder-no-fix {{ $errors->has('email') ? ' has-error' : '' }}" type="email" value="{{ old('email') }}" placeholder="E-Mail" name="email" required/> 
            @if($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Şifre</label>
            <input class="form-control form-control-solid placeholder-no-fix{{ $errors->has('password') ? ' has-error' : '' }}" type="password" autocomplete="off" placeholder="Şifre" name="password" required/>
            @if($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif  
        </div>
        <div class="form-group {{ $errors->has('hash') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Doğrulama Kodu</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" id="defaultReal" placeholder="Doğrulama Kodu" name="defaultReal" required/>
            @if($errors->has('hash'))
                <span class="help-block">
                    <strong>{{ $errors->first('hash') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green">Giriş Yap</button>
            <label class="rememberme check">
                <input type="checkbox" name="remember" value="1" />Beni Hatırla </label>
            <a href="{{ url('password/reset') }}" class="forget-password">Şifremi Unuttum</a>
        </div>
        @if(!count(App\User::all()))
        <div class="create-account">
            <p>
                <a href="{{ url('/register?name='.config('project.initialRegisterName').'&email='.config('project.initialRegisterEmail').'&profile=1') }}" class="uppercase">Kayıt Ol</a>
            </p>
        </div>
        @endif
    </form>
@endsection