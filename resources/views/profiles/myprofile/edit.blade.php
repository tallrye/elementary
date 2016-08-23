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
	{!! Html::breadcrumb('Profilim') !!}
    {!! Html::pagetitle($profile->name, ' profil bilgilerim') !!}
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <div class="portlet light profile-sidebar-portlet ">
                    <div class="profile-userpic">
                        <img alt="" class="img-circle img-responsive" src="{{ url(\Auth::user()->profile->photo) }}" />
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> {{ $profile->name }} </div>
                        <div class="profile-usertitle-job"> {{ $profile->title }} @ {{ $profile->organization }}</div>
                    </div>
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-circle green btn-sm">
                            {{ hasUser($profile->id) ? 'AKTIF' : 'PASIF' }}
                        </button>
                    </div>
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li>
                                <a href="{{ url('profiles/myprofile') }}">
                                    <i class="icon-home"></i> Genel Görünüm 
                                </a>
                            </li>
                            <li class="active">
                                <a href="{{ url('profiles/myprofile/edit') }}">
                                    <i class="icon-settings"></i> Ayarlar 
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="portlet light ">
                    <div class="row list-separated">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 37 </div>
                            <div class="uppercase profile-stat-text"> Projects </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 51 </div>
                            <div class="uppercase profile-stat-text"> Tasks </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 61 </div>
                            <div class="uppercase profile-stat-text"> Uploads </div>
                        </div>
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
                                    <span class="caption-subject font-blue-madison bold">Profili Düzenle</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">Temel Bilgiler</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">Profil Fotoğrafını Değiştir</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        {!! Form::model($profile, array('route' => 'profiles.myprofile.update')) !!}
                                            <div class="form-group">
                                                <label class="control-label">Ad Soyad</label>
                                                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Telefon</label>
                                                {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => '+90..........')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">E-Posta</label>
                                                {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'kullanici@ornek.com')) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('sidebarOpen', 'Yan Menü', ['class' => 'control-label']) !!}
                                                <select id="sidebarOpen" name="sidebarOpen" class="form-control select2" style="width:100%;">
                                                    <option {{ ($profile->sidebarOpen) ? 'selected': '' }} value="1">Açık</option>
                                                    <option {{ (!$profile->sidebarOpen) ? 'selected': '' }} value="0" >Kapalı</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('theme', 'Tema', ['class' => 'control-label']) !!}
                                                <select id="theme" name="theme" class="form-control select2" style="width:100%;">
                                                    <option {{ (!$profile->theme == 'default') ? 'selected': '' }} value="default" >Standart</option>
                                                    <option {{ ($profile->theme == 'blue') ? 'selected': '' }} value="blue">Mavi</option>
                                                    <option {{ ($profile->theme == 'darkblue') ? 'selected': '' }} value="darkblue">Koyu Mavi</option>
                                                    <option {{ ($profile->theme == 'grey') ? 'selected': '' }} value="grey">Koyu Gri</option>
                                                    <option {{ ($profile->theme == 'light') ? 'selected': '' }} value="light">Açık Gri</option>
                                                    <option {{ ($profile->theme == 'light2') ? 'selected': '' }} value="light2">Beyaz</option>
                                                </select>
                                            </div>
                                            <div class="margiv-top-10">
                                                <button type="submit" class="btn green"> Kaydet </button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                    <!-- CHANGE AVATAR TAB -->
                                    <div class="tab-pane" id="tab_1_2">
                                        <div class="row">
                                            <div class="col-md-12 responsive-1024">
                                                <img src="" id="cropMe" alt="Herhangi bir görsel seçilmedi" /> 
                                                <br>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Görsel Seç </span>
                                                        <span class="fileinput-exists"> Değiştir </span>
                                                        <input type="file" name="cropMe"> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-md-12 responsive-1024">
                                                <br><br>
                                                {!! Form::open(array('route' => 'profiles.myprofile.updatemyphoto', 'id' => 'uploadPhoto')) !!}
                                                    <input type="hidden" id="human_id" name="human_id" value="{{ $profile->id }}" />
                                                    <input type="hidden" id="crop_x" name="x" />
                                                    <input type="hidden" id="crop_y" name="y" />
                                                    <input type="hidden" id="crop_w" name="w" />
                                                    <input type="hidden" id="crop_h" name="h" />
                                                    <input type="hidden" id="theFile" name="theFile" />
                                                    <input type="submit" value="Kırp ve Yükle" class="btn btn-large green" /> 
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END CHANGE AVATAR TAB -->
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
    <script>
        $('#uploadPhoto').submit(function(){
            if (parseInt($('#crop_w').val())) return true;
            toastr.error("Lütfen bir görsel seçiniz.");
            return false;
        });
        $('.select2').select2();
    </script>
@endSection
