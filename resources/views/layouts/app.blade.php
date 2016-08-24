<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>{{ config('project.name') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="{{ config('project.description') }}" name="description" />
        <meta content="{{ config('project.architect') }}" name="author" />
        <script src="{{ url('public/assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <link href="{{ url('public/assets/global/plugins/pace/themes/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300i,400,600,700|Source+Sans+Pro:300,400,600,700&subset=latin-ext" rel="stylesheet">
        <link href="{{ url('public/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ url('public/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ url('public/assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css" />
        @yield('pageLevelCssPlugins')
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ url('public/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ url('public/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->

        <!-- BEGIN PAGE LEVEL STYLES -->
        @yield('pageLevelStyles')
        <!-- END PAGE LEVEL STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ url('public/assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/layouts/layout/css/themes/'.\Auth::user()->profile->theme.'.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ url('public/assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/customize/css/style.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="{{ url('public/favicon.ico') }}" /> 
        <script>
            /* Globally accessible JS variables */
            var globalBaseUrl ='<?php echo url(''); ?>';
        </script>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white {{ (\Auth::user()->profile->sidebarOpen) ? '' : 'page-sidebar-closed' }}">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                <div class="menu-toggler sidebar-toggler"></div>
                </div>
                <a href="{{ url('/') }}" id="absLogo">
                    <img src="{{ url('public/assets/logo.png') }}" alt="logo" width="130" class="logo-default" style="margin:10px 0 0 0;" />
                </a>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="{{ url(\Auth::user()->profile->photo) }}" />
                                <span class="username username-hide-on-mobile"> {{ \Auth::user()->name }} </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{ url('/profiles/myprofile') }}">
                                        <i class="icon-user"></i> Profil Bilgileri </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="{{ url('/logout') }}">
                                        <i class="icon-key"></i> Çıkış Yap </a>
                                </li>
                            </ul>
                        </li>
                        @include('layouts.includes.topNotifications')
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="javascript:;" class="dropdown-toggle">
                                <i class="icon-bubbles noBeforeEnvelope"></i>
                                <span class="badge badge-default"{{ ($unreadMessageCount > 0) ? '' : 'style=display:none;' }} id="unreadMessageCount">{{ $unreadMessageCount }}</span>
                            </a>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            @include('layouts.includes.sideNav')
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    @yield('content')
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            @include('layouts.includes.sideMessages')
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2016 &copy; <a target="_blank" href="{{ config('project.clientWebsite') }}">{{ config('project.clientName') }}
                
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
            <form class="getMyNotifications" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            </form>
        </div>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
        <script src="{{ url('public/assets/global/plugins/respond.min.js') }}"></script>
        <script src="{{ url('public/assets/global/plugins/excanvas.min.js') }}"></script> 
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ url('public/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
        <script src="//js.pusher.com/3.0/pusher.min.js"></script>
       
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ url('public/assets/global/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/datatables/datatables.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
        @yield('pageLevelJsPlugins')
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('public/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>

        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ url('public/customize/js/postoffice.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/customize/js/main.js') }}" type="text/javascript"></script>
        @yield('pageLevelScripts')
        <script src="{{ url('public/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/pages/scripts/ui-toastr.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ url('public/assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/layouts/layout/scripts/demo.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/assets/layouts/global/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        @include('layouts.includes.flashMessages')
        <script>
            var pusherNot = new Pusher('{{env("PUSHER_KEY")}}');
            var channel = pusherNot.subscribe('notifications-channel');
            channel.bind("refresh-notifications", function(data) {
                $('.getMyNotifications').submit();
            });

            var pusherMsg = new Pusher('{{env("PUSHER_KEY")}}');
            var channel = pusherMsg.subscribe('messages-channel{{Auth::user()->id}}');
            channel.bind("refresh-messages", function(data) {
                getLatestMessage(data.id);
            });

            $(document).delegate('.getMyNotifications', 'submit', function(e){
                e.preventDefault();
                getMyNotifications($(this), '{!! csrf_field() !!}');
            });

            $(document).delegate('.unreadMessage', 'mouseenter', function(){
                readAMessage($(this), '{!! csrf_token() !!}');
            });
        </script>
    </body>

</html>