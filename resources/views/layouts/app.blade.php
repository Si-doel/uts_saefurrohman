<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>WebAPP Merchant</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="template/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

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

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
    <!-- link Kalender -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('layouts.header')

            <div class="container">
                <div class="page-inner">
                    @yield('page-header')
                    @yield('content')
                </div>
            </div>

            @include('layouts.footer')
            <!--   Core JS Files   -->
            <script src="{{ asset('template/assets/js/core/jquery-3.7.1.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/core/popper.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/core/bootstrap.min.js') }}"></script>

            <!-- jQuery Scrollbar -->
            <script src="{{ asset('template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

            <!-- Chart JS -->
            <script src="{{ asset('template/assets/js/plugin/chart.js/chart.min.js') }}"></script>

            <!-- jQuery Sparkline -->
            <script src="{{ asset('template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

            <!-- Chart Circle -->
            <script src="{{ asset('template/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

            <!-- Datatables -->
            <script src="{{ asset('template/assets/js/plugin/datatables/datatables.min.js') }}"></script>

            <!-- Bootstrap Notify -->
            <script src="{{ asset('template/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

            <!-- jQuery Vector Maps -->
            <script src="{{ asset('template/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
            <script src="{{ asset('template/assets/js/plugin/jsvectormap/world.js') }}"></script>

            <!-- Google Maps Plugin -->
            <script src="{{ asset('template/assets/js/plugin/gmaps/gmaps.js') }}"></script>

            <!-- Sweet Alert -->
            <script src="{{ asset('template/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

            <!-- Kaiadmin JS -->
            <script src="{{ asset('template/assets/js/kaiadmin.min.js') }}"></script>

            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

            <!--CDN Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- kalender -->
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
</body>

</html>
