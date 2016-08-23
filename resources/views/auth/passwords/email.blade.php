@extends('layouts.login')

@section('content')
 <form action="{{ url('/password/email') }}" role="form"  method="post">
 	{!! csrf_field() !!}
    <h3 class="font-green">Şifremi Unuttum</h3>
    @if(session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@else
    <p>Lütfen sistemde kayıtlı e-mail adresini giriniz. </p>
    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> 
        @if($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-actions">
        <a href="{{ url('/login') }}" type="button" id="back-btn" class="btn btn-default">Geri</a>
        <button type="submit" class="btn btn-success uppercase pull-right">Gönder</button>
    </div>
    @endif
</form>
@endsection