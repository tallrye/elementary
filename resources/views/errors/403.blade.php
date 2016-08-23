@extends('layouts.errors')

@section('content')

	<div class="row">
        <div class="col-md-12 page-404">
            <div class="number font-green" style="top:0;"> 403 </div>
            <div class="details">
                <h3>Bu sayfa yetki alanınızın dışındadır.</h3>
                <p> Lütfen sistem yönetimi ile iletişime geçin.
                    <br/>
                    <br/>
                    <a class="btn green btn-outline" href="{!! route('home') !!}"> Anasayfaya Dön </a>  </p>
               
            </div>
        </div>
    </div>
     
@endsection