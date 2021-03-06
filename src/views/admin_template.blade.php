<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ ($page_title)?CRUDBooster::getSetting('appname').': '.strip_tags($page_title):"Admin Area" }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name='generator' content='CRUDBooster 5.4.0.1'/>
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon"
          href="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):cbAsset('logo_crudbooster.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    {!! cbStyleSheet('adminlte/bootstrap/css/bootstrap.min.css') !!}

    {!! cbStyleSheet('adminlte/font-awesome/css/font-awesome.min.css') !!}
    <!-- Ionicons -->
    <link href="{{asset("vendor/crudbooster/ionic/css/ionicons.min.css")}}" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    {!! cbStyleSheet('adminlte/dist/css/AdminLTE.min.css') !!}
    {!! cbStyleSheet('adminlte/dist/css/skins/_all-skins.min.css') !!}

    <!-- support rtl-->
    @if (App::getLocale() == 'ar')
        <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
        <link href="{{ cbAsset("rtl.css")}}" rel="stylesheet" type="text/css"/>
    @endif

    <link rel='stylesheet' href='{{cbAsset("css/main.css").'?r='.time()}}'/>

    <!-- load css -->
    <style type="text/css">
        @if($style_css)
            {!! $style_css !!}
        @endif
    </style>
    @if($load_css)
        @foreach($load_css as $css)
            <link href="{{$css}}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif

    <style type="text/css">
        .dropdown-menu-action {
            left: -130%;
        }

        .btn-group-action .btn-action {
            cursor: default
        }

        #box-header-module {
            box-shadow: 10px 10px 10px #dddddd;
        }

        .sub-module-tab li {
            background: #F9F9F9;
            cursor: pointer;
        }

        .sub-module-tab li.active {
            background: #ffffff;
            box-shadow: 0px -5px 10px #cccccc
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
            border: none;
        }

        .nav-tabs > li > a {
            border: none;
        }

        .breadcrumb {
            margin: 0 0 0 0;
            padding: 0 0 0 0;
        }

        .form-group > label:first-child {
            display: block
        }
    </style>

    @stack('head')
</head>
<body class="{!! Session::get('theme_color','skin-blue') !!} {!! cbConfig('ADMIN_LAYOUT') !!}">
<div id='app' class="wrapper">

    <!-- Header -->
@include('crudbooster::header')

<!-- Sidebar -->
@include('crudbooster::sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
            <?php
            $module = CRUDBooster::getCurrentModule();
            ?>
            @if($module)
                <h1>
                    <i class='{{$module->icon}}'></i>
                    {{($page_title)?:$module->name}} &nbsp;&nbsp;

                    <!--START BUTTON -->

                    @if(CRUDBooster::getCurrentMethod() == 'getIndex')
                        @if($button_show)
                            <a href="{{ CRUDBooster::mainpath().'?'.http_build_query(Request::all()) }}"
                               id='btn_show_data' class="btn btn-sm btn-primary"
                               title="{{cbTrans('action_show_data')}}">

                                {!!  CB::icon('table') !!}
                                {{cbTrans('action_show_data')}}
                            </a>
                        @endif

                        @if($button_add && CRUDBooster::canCreate())
                            <a href="{{ CRUDBooster::mainpath('add').'?return_url='.urlencode(Request::fullUrl()).'&parent_id='.g('parent_id').'&parent_field='.$parent_field }}"
                               id='btn_add_new_data' class="btn btn-sm btn-success"
                               title="{{cbTrans('action_add_data')}}">

                                {!!  CB::icon('plus-circle') !!}
                                {{cbTrans('action_add_data')}}
                            </a>
                        @endif
                    @endif


                    @if($button_export && CRUDBooster::getCurrentMethod() == 'getIndex')
                        <a href="javascript:void(0)" id='btn_export_data' data-url-parameter='{{$build_query}}'
                           title='Export Data' class="btn btn-sm btn-primary btn-export-data">

                            {!!  CB::icon('upload') !!}
                            {{cbTrans("button_export")}}
                        </a>
                    @endif

                    @if($button_import && CRUDBooster::getCurrentMethod() == 'getIndex')
                        <a href="{{ CRUDBooster::mainpath('import-data') }}" id='btn_import_data'
                           data-url-parameter='{{$build_query}}' title='Import Data'
                           class="btn btn-sm btn-primary btn-import-data">

                            {!!  CB::icon('download') !!}
                            {{cbTrans("button_import")}}
                        </a>
                    @endif

                <!--ADD ACTIon-->
                    @if(count($index_button))

                        @foreach($index_button as $ib)
                            <a href='{{$ib["url"]}}' id='{{str_slug($ib["label"])}}'
                               class='btn {{($ib['color'])?'btn-'.$ib['color']:'btn-primary'}} btn-sm'
                               @if($ib['onClick']) onClick='return {{$ib["onClick"]}}' @endif
                               @if($ib['onMouseOever']) onMouseOever='return {{$ib["onMouseOever"]}}' @endif
                               @if($ib['onMoueseOut']) onMoueseOut='return {{$ib["onMoueseOut"]}}' @endif
                               @if($ib['onKeyDown']) onKeyDown='return {{$ib["onKeyDown"]}}' @endif
                               @if($ib['onLoad']) onLoad='return {{$ib["onLoad"]}}' @endif
                            >
                                <i class='{{$ib["icon"]}}'></i>
                                {{$ib["label"]}}
                            </a>
                    @endforeach
                @endif
                <!-- END BUTTON -->
                </h1>


                <ol class="breadcrumb">
                    <li><a href="{{CRUDBooster::adminPath()}}">
                            {!!  CB::icon('dashboard') !!}
                            {{ cbTrans('home') }}</a>
                    </li>
                    <li class="active">{{$module->name}}</li>
                </ol>
            @else
                <h1>{{CRUDBooster::getSetting('appname')}}
                    <small>Information</small>
                </h1>
            @endif
        </section>


        <!-- Main content -->
        <section id='content_section' class="content">

            @if(@$alerts)
                @foreach(@$alerts as $alert)
                    <div class='callout callout-{{$alert[type]}}'>
                        {!! $alert['message'] !!}
                    </div>
                @endforeach
            @endif


            @if (Session::get('message')!='')
                <div class='alert alert-{{ Session::get("message_type") }}'>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>
                        <i class="icon fa fa-info"></i>
                        {{ cbTrans("alert_".Session::get("message_type")) }}</h4>
                    {!!Session::get('message')!!}
                </div>
            @endif



        <!-- Your Page Content Here -->
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('crudbooster::footer')

</div><!-- ./wrapper -->


@include('crudbooster::admin_template_plugins')

<!-- load js -->
@if($load_js)
    @foreach($load_js as $js)
        <script src="{{$js}}"></script>
    @endforeach
@endif
<script type="text/javascript">
    var site_url = "{{url('/')}}";
    @if($script_js)
        {!! $script_js !!}
    @endif
</script>

@stack('bottom')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>
