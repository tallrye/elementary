@extends('layouts.lock')

@section('content')
    <div class="page-body">
        <div class="lock-head"> İzinsiz IP </div>
        <div class="lock-body">
            <div class="pull-left lock-avatar-block">
                @if(\Auth::user()->profile->photo)
                <img alt="" class="lock-avatar" src="{{ url(\Auth::user()->profile->photo) }}" />
                @else
                <img alt="" class="lock-avatar" src="{{ url('public/assets/team.png') }}" />
                @endif
            </div>
            <div class="lock-form pull-left col-md-8" >
                <br>
                <h4 class="font-red">{{ \Auth::user()->name }}</h4>
                <div class="form group font-white">Giriş yapmaya çalıştığınız IP adresi sizin için tanımlanmamış. Bu IP adresinden erişim sağlamak için, sistem yöneticileriyle görüşmeniz gerekmektedir.</div>
            </div>
        </div>
        <div class="lock-bottom">
            <a href="{{ url('/logout') }}">{{ \Auth::user()->name }} değil misiniz?</a>
        </div>
    </div>
@endsection