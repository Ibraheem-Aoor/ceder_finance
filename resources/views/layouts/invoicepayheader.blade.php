
@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_favicon=\App\Models\Utility::getValByName('company_favicon');
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{env('SITE_RTL') == 'on'?'rtl':''}}">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{(\App\Models\Utility::getValByName('title_text')) ? App\Models\Utility::getValByName('title_text') : config('app.name', 'AccountGo')}} - @yield('page-title')</title>
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">

    @stack('css-page')

    <link rel="stylesheet" href="{{ asset('assets/css/site.css')}}" >
    <link rel="stylesheet" href="{{ asset('assets/css/ac.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stylesheet.css') }}">

    @if(env('SITE_RTL')=='on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @endif
</head>

<body class="application application-offset">
<div class="container-fluid container-application">
    <div class="main-content position-relative">
        <div class="page-content">
            <div class="page-title">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-4 col-lg-4 col-md-4 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                        <div class="d-inline-block">
                            <h5 class="h4 d-inline-block font-weight-400 mb-0 ">@yield('page-title')</h5>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 d-flex align-items-center justify-content-between justify-content-md-end">
                        @yield('action-button')
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
</div>



<script src="{{ asset('assets/js/site.core.js')}}"></script>
<script src="{{ asset('assets/libs/progressbar.js/dist/progressbar.min.js') }}"></script>
<script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/nicescroll/jquery.nicescroll.min.js')}} "></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script>moment.locale('en');</script>
@stack('theme-script')
@stack('scripts')



<script src="{{ asset('assets/js/site.js') }}"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/jscolor.js') }} "></script>
<script>
    var toster_pos = "{{env('SITE_RTL')=='on' ?'left' : 'right'}}";
</script>
<script src="{{ asset('assets/js/custom.js') }} "></script>
@if(\App\Models\Utility::getValByName('gdpr_cookie') == 'on')
    <script type="text/javascript">
        var defaults = {
            'messageLocales': {
                /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                'en': "{{\App\Models\Utility::getValByName('cookie_text')}}"
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'cookieNoticePosition': 'bottom',
            'learnMoreLinkEnabled': false,
            'learnMoreLinkHref': '/cookie-banner-information.html',
            'learnMoreLinkText': {
                'it': 'Saperne di più',
                'en': 'Learn more',
                'de': 'Mehr erfahren',
                'fr': 'En savoir plus'
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'expiresIn': 30,
            'buttonBgColor': '#d35400',
            'buttonTextColor': '#fff',
            'noticeBgColor': '#051c4b',
            'noticeTextColor': '#fff',
            'linkColor': '#009fdd'
        };
    </script>
    <script src="{{ asset('assets/js/cookie.notice.js')}}"></script>
@endif

@if($message = Session::get('success'))
    <script>
        show_toastr('Success', '{!! $message !!}', 'success');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('Error', '{!! $message !!}', 'error');
    </script>
@endif
@stack('script-page')
</body>
</html>
