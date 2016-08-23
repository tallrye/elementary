@extends('layouts.errors')

@section('content')

    <div class="row">
        <div class="col-md-12 page-404">
            <div class="number font-green" style="top:0;"> 404 </div>
            <div class="details">
                <h3>Oooops! Kayboldunuz...</h3>
                <p> Dilerseniz anasayfaya dönüp bir daha deneyin. 
                    <br/>
                    <br/>
                    <a class="btn green btn-outline" href="{!! route('home') !!}"> Anasayfaya Dön </a>  </p>
            </div>
        </div>
    </div>
     
@endsection