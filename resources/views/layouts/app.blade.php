<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BnBMS - @if(auth()->user() == null) Belle n Beau @elseif( auth()->user()->role == '1' ) Admin Panel @else SuperAdmin Panel @endif</title>

    {{--Icon image here--}}
    <link rel="icon" type="image/png" sizes="180x180" href="{{ asset('panelAssets/img/circle-cropped.png')}}">

    @if(auth()->user() == null)

        {{-- Welcome main assets --}}
        <link rel="stylesheet" href="{{ asset('panelAssets/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('panelAssets/fonts/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{ asset('panelAssets/fonts/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('panelAssets/fonts/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{ asset('panelAssets/fonts/fontawesome5-overrides.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <link rel="stylesheet" href="{{ asset('panelAssets/css/styles.css')}}">

        {{--Toastr Notification--}}
        <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @else

        {{-- Admin main assets --}}
        <link rel="stylesheet" href="{{ asset('panelAssets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('panelAssets/fonts/fontawesome-all.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    @endif
<!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.x/dist/alpine.min.js" defer></script>

    @livewireStyles
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.x.x/dist/trix.css">

    {{--Sweet Alert Notification--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" />
</head>
@if(auth()->user() == null)

    {{-- Welcome Body --}}
    <body style="font-family: font-family: &quot;Raleway&quot;, Helvetica, Arial, sans-serif;">

    {{--Content Here--}}
    {{ $slot }}
    @else

        {{-- Admin Body --}}
        <body class="antialiased font-sans bg-gray-200" id="page-top">
    <div id="wrapper">
        {{--Navigation Bar--}}
        @if( auth()->user()->role == '1' ) @include('admin.navbar') @else @include('superadmin.navbar') @endif
        <div class="flex-column" id="content-wrapper">
            <div id="content">

                {{--Content Here--}}
                {{ $slot }}

                {{--Footer Here--}}
                @include('layouts.footer')
            </div>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    @endif



    @if(auth()->user() == null)

        {{-- Extension Script Welcome Page --}}
        <script src="{{ asset('panelAssets/js/jquery.min.js')}}"></script>
        <script src="{{ asset('panelAssets/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('panelAssets/js/bs-init.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
    @else

        {{-- Extension Script Admin Panel --}}
        <script src="{{ asset('panelAssets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('panelAssets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
        <script src="{{ asset('panelAssets/js/script.min.js') }}"></script>
    @endif

    @livewireScripts
    @stack('scripts')

    {{-- Livewire Script --}}
    <script src="https://unpkg.com/moment"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://unpkg.com/trix@1.x.x/dist/trix.js"></script>

    {{-- Sweetalet2 js --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    {{-- Essential Script --}}
    <script>

        {{-- Google Captcha --}}
        $("form").submit(function(event) {
            var recaptcha = $("#g-recaptcha-response").val();
            if (recaptcha === "") {
                event.preventDefault();
                alert("Please check the recaptcha");
            }
        });

        {{-- Toastr Notification --}}
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif

        /* Hide Modal Store and Update */
        window.livewire.on('modalStore', () => {
            $('#exampleModal').modal('hide');
            $('#updateModal').modal('hide');
        });

        /* Hide Modal Delete */
        window.livewire.on('modalDelete', () => {
            $('#deleteModal').modal('hide');
        });

        /* Sweetalert2 */
        window.addEventListener('swal',function(e){
            Swal.fire(e.detail);
        });

        /* Currency Format */
        $('.number').keypress(function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
                ((event.which < 48 || event.which > 57) &&
                    (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }

            var text = $(this).val();

            if ((text.indexOf('.') != -1) &&
                (text.substring(text.indexOf('.')).length > 2) &&
                (event.which != 0 && event.which != 8) &&
                ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
            }
        });
    </script>
</body>
