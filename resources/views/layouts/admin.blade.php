<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="https://d23hiuzhfk4xdw.cloudfront.net/wp-content/uploads/2023/05/03073537/cropped-favicon-32x32.png" sizes="32x32" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="NEW BALAJI COMPUTER CLASSES, SOFTWARE DEVELOPMENT COMPANY">
    <meta name="author" content="">
    <title>@yield('title')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <!-- Admin Style-->
    <link href="{{ asset('public/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Include Datatables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <!-- Custom Style -->
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">

    <!-- Main JS File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body id="page-top">
    <div id="page-loader">
        <div class="spinner"></div>
    </div>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- end Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('partials.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('partials.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- JavaScriptS-->
    <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('public/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Input Digit Only Validation
        var elements = document.querySelectorAll('.digit-only');
        for (i in elements) {
            elements[i].onkeypress = function(e) {
                this.value = this.value.replace(/^0+/, '');
                if (isNaN(this.value + "" + String.fromCharCode(e.charCode)))
                    return false;
            }
        }

        $('.digit-only').on('keyup', function(e) {
            $(this).val($(this).val().replace(/\s/g, ''));
        });

        // Input Char Only Validation

        $('.char-only').keydown(function(e) {
            if (e.ctrlKey || e.altKey) {
                e.preventDefault();
            } else {
                var key = e.keyCode;
                if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                    e.preventDefault();
                }
            }
        });
        $('input').attr('autocomplete', 'off');
        // Stop autocomplete
        $(document).ready(function() {
            $('input').attr('autocomplete', 'off');
        });
        // Loader
        $(window).on('load', function() {
            $("#page-loader").fadeOut("slow");
        });
    </script>
    <script>
        // Function to get scrollbar width
        function getScrollbarWidth() {
            return window.innerWidth - document.documentElement.clientWidth;
        }

        // Adjust padding on modal open
        $(document).on('show.bs.modal', function() {
            var scrollbarWidth = getScrollbarWidth();
            if (scrollbarWidth > 0) {
                $('body').css('padding-right', scrollbarWidth);
            }
        });

        // Remove padding adjustment on modal close
        $(document).on('hidden.bs.modal', function() {
            $('body').css('padding-right', 0);
        });

        $(document).ready(function() {
            $('#accordionSidebar .nav-link').on('click', function() {
                $(this).parent().addClass('bg-active');
            });
        });

        $(document).ready(function() {
            // Get the current URL path
            var currentUrl = window.location.href;

            // Loop through each nav-item
            $('.nav-link span').each(function() {
                // Get the URL from the data-url attribute
                var itemUrl = $(this).data('url');

                // Check if the current URL matches the item URL
                if (currentUrl === itemUrl) {
                    // Add 'active' class to the current nav-item
                    $(this).addClass('active');
                }
            });
        });
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>

</body>

</html>