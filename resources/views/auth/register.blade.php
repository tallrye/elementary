@extends('layouts.login')

@section('content')
    <form  action="{{ url('/register') }}" role="form" method="post">
        {!! csrf_field() !!}
        @if(Session::has('danger'))
        <h3 class="font-green">İllegal İşlem!!!</h3>
        <p>URL'i değiştirerek sistemde kayıt yapılmasına izin verilmemiş bir kullanıcıyı kayıt etmek istediniz. Değiştirilmiş URL bilgisi sistem yöneticilerine iletildi.
        <br><br>
        Bu basit bir hata ise, lütfen bu sekmeyi kapatın ve size gönderilmiş kayıt linkine tıklayarak, URL'li değiştirmeden işlemi tekrar deneyin. </p>
        @else
        <h3 class="font-green">Kayıt Ol</h3>
        <p class="hint"> Lütfen aşağıdaki alanları doldurun: </p>
        <input type="hidden" name="profile_id" value="{{\Request::get('profile')}}">
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Ad Soyad</label>
            <input class="form-control placeholder-no-fix " type="text" placeholder="Ad Soyad" name="name" value="{{\Request::get('name')}}" required readonly/> 
            @if($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">E-mail</label>
            <input class="form-control placeholder-no-fix {{ $errors->has('email') ? ' has-error' : '' }}" value="{{\Request::get('email')}}" type="text" placeholder="Email" name="email" required readonly/> 
            @if($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Şifre</label>
            <input class="form-control placeholder-no-fix {{ $errors->has('password') ? ' has-error' : '' }}" type="password" autocomplete="off" id="register_password" placeholder="Şifre" name="password" required/> 
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Şifre (Tekrar)</label>
            <input class="form-control placeholder-no-fix {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" type="password" autocomplete="off" placeholder="Şifre (Tekrar)" name="password_confirmation" required/> 
            @if($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-actions">
            <a href="{{ url('login') }}" type="button" id="register-back-btn" class="btn btn-default">Geri</a>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Kayıt Ol</button>
        </div>
        @endif
    </form>
@endsection