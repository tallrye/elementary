@extends('layouts.app')
@section('pageLevelCssPlugins')
<link href="{{ url('public/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
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
                            <li class="active">
                                <a href="{{ url('profiles/myprofile') }}">
                                    <i class="icon-home"></i> Genel Görünüm 
                                </a>
                            </li>
                            <li>
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
                        <!-- BEGIN PORTLET -->
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold">Bildirimlerim</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab"> Tümü </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="scroller" style="height: 520px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                            <ul class="feeds">
                                                @foreach($myNotifications as $myNotification)
                                                <li>
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-{{ $myNotification->type->label }}">
                                                                    <i class="fa {{ $myNotification->type->icon }}"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"> {{ $myNotification->description }}
                                                                    <span class="label label-sm label-info"> <a href="{{ url($myNotification->action_link) }}">{{ $myNotification->action_name }}
                                                                        <i class="fa fa-share"></i></a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> {{ $myNotification->created_at->format('d/m/y @ h:i') }} </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
