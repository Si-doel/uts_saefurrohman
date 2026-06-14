<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Export Data - WebAPP Merchant</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('template/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('template/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('template/assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="main-panel">
            @include('layouts.header')

            <div class="container">
                <div class="page-inner">
                    @yield('page-header')
                    @yield('content')
                </div>
            </div>

            @include('layouts.footer')

            <script src="{{ asset('template/assets/js/core/jquery-3.7.1.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/core/popper.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/core/bootstrap.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/chart.js/chart.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/chart-circle/circles.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/datatables/datatables.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/jsvectormap/world.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/gmaps/gmaps.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/kaiadmin.min.js') }}"></script>
            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    if (calendarEl) {
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            height: 350
                        });
                        calendar.render();
                    }
                });
            </script>
        </div>
    </div>
</body>

</html>
