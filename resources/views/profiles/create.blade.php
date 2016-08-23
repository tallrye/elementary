@extends('layouts.app')
@section('pageLevelStyles')
<link href="{{ url('public/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('pageLevelCssPlugins')
    <link href="{{ url('public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/assets/global/plugins/jcrop/css/jquery.Jcrop.min.css') }}" rel="stylesheet" type="text/css" />
@endSection
@section('content')
	{!! Html::breadcrumb('Kullanıcılar') !!}
    {!! Html::pagetitle('Yeni Kullanıcı Ekle', ' detayları girin') !!}
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <div class="portlet light profile-sidebar-portlet ">
                    <div class="profile-userpic">
                        <img alt="" class="img-circle img-responsive" src="{{ url('public/assets/newuser.png') }}" />
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> Yeni Kullanıcı </div>
                        <p>Yeni kullanıcı ekledikten sonra, bu kullanıcı için rol tanımlamalarını yapıp, aktivasyon e-postası gönderebilirsiniz. </p>
                        <br><br>
                    </div>
                </div>
                
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold">Profili Oluştur</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">Temel Bilgiler</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        {!! Form::open(array('route' => 'profiles.admin.store')) !!}
                                            <div class="form-group">
                                                <label class="control-label">Ad Soyad</label>
                                                {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Kullanıcı adı soyadı')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">E-Mail</label>
                                                {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'kullanici@ornek.com')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Telefon</label>
                                                {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => '+90..........')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Görevi</label>
                                                {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Yazınız...')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Organizasyonu</label>
                                                {!! Form::text('organization', null, array('class' => 'form-control', 'placeholder' => 'Yazınız...')) !!}
                                            </div>
                                            <div class="margiv-top-10">
                                                <button type="submit" class="btn green"> Kaydet </button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageLevelJsPlugins')  
    <script src="{{ url('public/assets/global/plugins/jcrop/js/jquery.Jcrop.min.js') }}" type="text/javascript"></script>s
    <script src="{{ url('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>

    <script src="{{ url('public/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>

    <script src="{{ url('public/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/assets/global/plugins/jcrop/js/jquery.color.js') }}" type="text/javascript"></script>
    

@endSection
@section('pageLevelScripts')
    <script src="{{ url('public/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
    
@endSection
