<script src="{{ asset('assets/js/site.core.js')}}"></script>
<!-- Page JS -->
<script src="{{ asset('assets/libs/progressbar.js/dist/progressbar.min.js')}}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ asset('assets/libs/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.min.js')}}"></script>

<script src="{{ asset('js/jquery.form.js') }}"></script>
@stack('pre-purpose-script-page')
<script src="{{ asset('assets/js/site.js')}}"></script>
<script src="{{ asset('js/datatable/jquery.dataTables.min.js')}}"></script>

<script src="{{ asset('js/letter.avatar.js')}}"></script>


<script src="{{ asset('assets/js/demo.js')}}"></script>


<script>
    var dataTabelLang = {
        paginate: {
            previous: "{{__('Previous')}}",
            next: "{{__('Next')}}"
        },
        lengthMenu: "{{__('Show')}} _MENU_ {{__('entries')}}",
        zeroRecords: "{{__('No data available in table')}}",
        info: "{{__('Showing')}} _START_ {{__('to')}} _END_ {{__('of')}} _TOTAL_ {{__('entries')}}",
        infoEmpty: " ",
        search: "{{__('Search:')}}"
    }
    var toster_pos = "{{env('SITE_RTL')=='on' ?'left' : 'right'}}";
</script>

<script src="{{ asset('js/custom.js') }} "></script>

@if(Utility::getValByName('gdpr_cookie') == 'on')
    <script type="text/javascript">

        var defaults = {
            'messageLocales': {
                /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                'en': "{{Utility::getValByName('cookie_text')}}"
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


@if(Session::has('success'))
    <script>
        toastrs('{{__('Success')}}', '{!! session('success') !!}', 'success');
    </script>
    {{ Session::forget('success') }}
@endif
@if(Session::has('error'))
    <script>
        toastrs('{{__('Error')}}', '{!! session('error') !!}', 'error');
    </script>
    {{ Session::forget('error') }}
@endif

<script>
    var timer = '';
    var timzone = '{{env("TIMEZONE")}}';

    function TrackerTimer(start_time) {
        timer = setInterval(function () {
            var start = new Date(start_time);
            //var end = new Date();

            var here = new Date();
            var end = changeTimezone(here, timzone);

            var hrs = end.getHours() - start.getHours();

            var min = end.getMinutes() - start.getMinutes();
            var sec = end.getSeconds() - start.getSeconds();
            var hour_carry = 0;
            var Timer = $(".timer-counter");
            var minutes_carry = 0;
            if (min < 0) {
                min += 60;
                hour_carry += 1;
            }
            hrs = hrs - hour_carry;
            if (sec < 0) {
                sec += 60;
                minutes_carry += 1;
            }
            min = min - minutes_carry;

            Timer.text(minTwoDigits(hrs) + ':' + minTwoDigits(min) + ':' + minTwoDigits(sec));
        }, 1000);
    }


    function minTwoDigits(n) {
        return (n < 10 ? '0' : '') + n;
    }

    function changeTimezone(date, ianatz) {

        var invdate = new Date(date.toLocaleString('en-US', {
            timeZone: ianatz
        }));
        var diff = date.getTime() - invdate.getTime();
        return new Date(date.getTime() - diff);

    }
</script>

@stack('script-page')
