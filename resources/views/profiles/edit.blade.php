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
	{!! Html::breadcrumb('Kullanıcılar', 'profiles.admin.index', 'Düzenle') !!}
     {!! Html::pagetitle($profile->name, ' profil bilgileri') !!}
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <div class="portlet light profile-sidebar-portlet ">
                    <div class="profile-userpic">
                        <img alt="" class="img-circle img-responsive" src="{{ url($profile->photo) }}" />
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> {{ $profile->name }} </div>
                        <div class="profile-usertitle-job"> {{ $profile->title }} @ {{ $profile->organization }}</div>
                    </div>
                    <div class="profile-userbuttons">
                        <a class="btn btn-circle green btn-sm">
                            {{ hasUser($profile->id) ? 'Aktif' : 'Pasif' }}
                        </a>
                        @if(!hasUser($profile->id))
                            @if($profile->isActivationSent)
                            <a class="btn btn-circle purple btn-sm"> Aktivasyon Linki Gönderildi </a>
                            @else
                            <a class="btn btn-circle blue btn-sm" data-toggle="modal" href="#sendActivation"> Aktivasyon Linki Gönder </a>
                            <div class="modal fade" id="sendActivation" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="">
                                    <div class="modal-content">
                                        {!! Form::open(array('route' => 'profiles.admin.sendlink')) !!}
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Aktivasyon Linki Gönder</h4>
                                        </div>
                                        <div class="modal-body"><em class="underlined">{{ $profile->name }}</em> için <em class="underlined">{{ $profile->email }}</em> adresine aktivasyon linki gönderiyorsunuz. <br><br>Emin misiniz? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Vazgeç</button>
                                            <button type="submit" class="btn green">Gönder</button>
                                        </div>
                                        {!! Form::close(); !!}
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        @endif
                        @else
                            @if($profile->isBlocked)
                            <a class="btn btn-circle yellow btn-sm" data-toggle="modal" href="#blockProfile"> Blokeyi Kaldır </a>
                            <div class="modal fade" id="blockProfile" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="">
                                    <div class="modal-content">
                                        {!! Form::open(array('route' => 'profiles.admin.unblock')) !!}
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Kullanıcı Blokesini Kaldır</h4>
                                        </div>
                                        <div class="modal-body"><em class="underlined">{{ $profile->name }}</em> kullanıcısının sisteme olan erişimini aktif hale getiriyorsunuz. <br><br>Emin misiniz? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Vazgeç</button>
                                            <button type="submit" class="btn yellow">Blokeyi Kaldır.</button>
                                        </div>
                                        {!! Form::close(); !!}
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            @else
                            <a class="btn btn-circle red btn-sm" data-toggle="modal" href="#blockProfile"> Bloke Et </a>
                            <div class="modal fade" id="blockProfile" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="">
                                    <div class="modal-content">
                                        {!! Form::open(array('route' => 'profiles.admin.block')) !!}
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Kullanıcıyı Bloke Et</h4>
                                        </div>
                                        <div class="modal-body"><em class="underlined">{{ $profile->name }}</em> kullanıcısının sisteme olan erişimini engelliyorsunuz. <br><br>Emin misiniz? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Vazgeç</button>
                                            <button type="submit" class="btn red">Bloke Et</button>
                                        </div>
                                        {!! Form::close(); !!}
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            @endif
                        @endif
                    </div>
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li>
                                <a href="{{ url('profiles/admin/detail/'.$profile->id) }}">
                                    <i class="icon-home"></i> Genel Görünüm 
                                </a>
                            </li>
                            <li class="active">
                                <a href="{{ url('profiles/admin/edit/'.$profile->id) }}">
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
                                    <span class="caption-subject font-blue-madison bold">Profili Güncelle</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">Temel Bilgiler</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">Profil Fotoğrafı</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab">Yetkili IP'ler</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_4" data-toggle="tab">Roller</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        {!! Form::model($profile, array('route' => 'profiles.admin.update')) !!}
                                        	<input type="hidden" name="id" value="{{ $profile->id }}">
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
                                                {!! Form::open(array('route' => 'profiles.admin.updatephoto', 'id' => 'uploadPhoto')) !!}
                                                    <input type="hidden" id="id" name="id" value="{{ $profile->id }}" />
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
                                    <!-- IPs TAB -->
                                    <div class="tab-pane" id="tab_1_3">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption font-yellow">
                                                            <i class="icon-arrow-right font-yellow"></i>
                                                            <span class="caption-subject bold"> {{ $profile->name }} için yeni IP girin.</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        {!! Form::open(array('route' => 'profiles.admin.addip')) !!}
                                                            {!! Form::hidden('profile_id', $profile->id) !!}
                                                            <div class="input-group">
                                                                {!! Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'IP Adresi')) !!}
                                                                <span class="input-group-btn">
                                                                    <button class="btn green-soft" type="submit">
                                                                        Ekle <i class="fa fa-long-arrow-right fa-fw"></i></button>
                                                                </span>
                                                            </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption font-yellow">
                                                            <i class="icon-arrow-right font-yellow"></i>
                                                            <span class="caption-subject bold"> "{{ $profile->name }}" şu IP'lerde işlem yapabilir.</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <table class="table table-light table-hover">
                                                            @if(!count($profile->servers))
                                                                Bu kullanıcı herhangi bir IP'den işlem yapamaz.
                                                            @elseif(count($profile->servers) == 1)
                                                                Bu kullanıcı sadece <strong class="font-blue">{{ $profile->servers[0]->address }}</strong> adresinden işlem yapabilir. Bu IP adresini kaldırabilmek için, bu kullanıcıya başka bir IP adresi vermeniz gerekir. 
                                                                <br><br>
                                                                @if($profile->isBlocked)
                                                                Bu kullanıcı bloke edilmiş olduğu için bu kendisine atanan IP dahil olmak üzere hiçbir IP üzerinden sisteme erişemez.
                                                                @else
                                                                Eğer bu kullanıcının herhangi bir IP adresinde işlem yapmasını istemiyorsanız, <a class="font-red" data-toggle="modal" href="#blockProfile"> kullanıcıyı bloke edin. </a>
                                                                @endif
                                                            @else
                                                                @foreach($profile->servers as $server)
                                                                <tr>
                                                                    {!! Form::open(array('route' => 'profiles.admin.removeip')) !!}
                                                                        {!! Form::hidden('id', $server->id) !!}
                                                                        <td><button type="submit" class="btn btn-sm red"><i class="fa fa-close"></i></button> {{ $server->address }} ({{ $server->createdBy->name }} tarafından eklendi.)</td>
                                                                    {!! Form::close() !!}
                                                                </tr>
                                                                @endforeach
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END IPs TAB -->
                                    <!-- IPs TAB -->
                                    <div class="tab-pane" id="tab_1_4">
                                        @if($profile->user)
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption font-yellow">
                                                            <i class="icon-arrow-right font-yellow"></i>
                                                            <span class="caption-subject bold"> {{ $profile->name }} için yeni rol girin.</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        {!! Form::open(array('route' => 'profiles.admin.addrole')) !!}
                                                            {!! Form::hidden('user_id', $profile->user->id) !!}
                                                            <div class="input-group">
                                                                    <select id="role_id" name="role_id" class="form-control select2" style="width:100%;">
                                                                        <option></option>
                                                                        @foreach($roles as $role)
                                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                <span class="input-group-btn">
                                                                    <button class="btn green-soft" type="submit">
                                                                        Ekle <i class="fa fa-long-arrow-right fa-fw"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption font-yellow">
                                                            <i class="icon-arrow-right font-yellow"></i>
                                                            <span class="caption-subject bold"> "{{ $profile->user->name }}" rolü.</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <table class="table table-light table-hover">
                                                            @if(!count($profile->user->roles))
                                                                Bu kullanıcının tanımlanmış bir rolü bulunmamaktadır.
                                                            @elseif(count($profile->user->roles) == 1)
                                                                Bu kullanıcı <strong class="font-blue">{{ $profile->user->roles[0]->name }} ({{ $profile->user->roles[0]->description }})</strong> rolündedir. Sistemdeki bir rol kaldırılamaz. Bu rolü değiştirmek için, sol taraftan başka bir rol vermeniz gerekmektedir.
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ $profile->name }} kullanıcısının sisteme erişimi bulunmadığı için, sistemde de herhangi bir rol tanımlaması yapılamaz. {{ $profile->name }} kullanıcısını sisteme dahil etmek için 
                                                @if($profile->isActivationSent)
                                                <strong class="font-purple">gönderdiğiniz aktivasyon işleminin tamamlanmasını bekleyin.</strong>
                                                @else
                                                <a class="font-blue" data-toggle="modal" href="#sendActivation"> aktivasyon linki gönderin. </a> 
                                                @endif
                                                <br><br>
                                                {{ $profile->name }} şifresini belirleyip sisteme kayıt olduktan sonra bu kullanıcıya yeni rol tanımlayabilirsiniz.
                                                <br><br>
                                                Not: Yeni kayıt olan kullanıcılara sistem tarafından otomatik olarak <strong class="font-blue">boş kullanıcı ('Sistemde hiç bir işlem yapamaz')</strong> rolü verilir.
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- END IPs TAB -->
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
        $('.select2').select2({placeholder:'Seçiniz'});
    </script>
@endSection
