@extends('layouts.login')

@section('content')
<form action="{{ url('/password/reset') }}" role="form" method="post">
	{!! csrf_field() !!}
    <h3 class="font-green">Şifremi Unuttum</h3>
    <p> Lütfen sistemdeki e-posta adresinizi yazıp yeni şifrenizi belirleyin. </p>
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group">
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" /> 
    </div>
    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Şifre</label>
        <input class="form-control placeholder-no-fix {{ $errors->has('password') ? ' has-error' : '' }}" type="password" autocomplete="off" id="register_password" placeholder="Şifre" name="password" required/> 
    </div>
    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Şifre (Tekrar)</label>
        <input class="form-control placeholder-no-fix {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" type="password" autocomplete="off" placeholder="Şifre (Tekrar)" name="password_confirmation" required/> 
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-actions">
        <a href="{{ url('/login') }}" type="button" id="back-btn" class="btn btn-default">Geri</a>
        <button type="submit" class="btn btn-success uppercase pull-right">Gönder</button>
    </div>
</form>
@endsection
