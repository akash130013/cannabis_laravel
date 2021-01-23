<html>

    <head>
    <link rel="icon" type="image/png" href="{{asset('asset-store/images/cannabis_leaf.ico')}}" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link href="{{asset('asset-admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('asset-admin/css/dashboardapp.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('asset-admin/css/cropper.min.css')}}" />
    <link href="{{asset('asset-admin/js/circle-loader/css/jCirclize.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('asset-admin/css/bootstrap-select.min.css')}}">
    {{-- <link rel="stylesheet" href="/css/style.class"> --}}
    <link rel="stylesheet" href="{{asset('asset-admin/css/loader.css')}}">
    <link rel="stylesheet" href="{{asset('asset-admin/css/icons.css')}}">
    <link rel="stylesheet" href="{{asset('asset-admin/css/sweet-alert.css')}}">
    <link rel="stylesheet" href="{{asset('asset-admin/css/selectric.css')}}">
     {{-- data table css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    {{-- end data table css --}}
    
    </head>

    <body>
           
          
            @yield('content')
            <script>
                var csrf_token = "<?php echo csrf_token(); ?>"
           </script>
    </body>

    {{-- <script src="{{asset('asset-admin/js/jquery.min.new.js')}}"></script>
    <script src="{{asset('asset-admin/js/bootstrap.min.new.js')}}"></script>
    <script src="{{asset('asset-admin/js/custom.js')}}"></script> --}}
    @include('Admin::includes.footer')
    @yield('pagescript')
    <script>
        <?php
            if (Session::has('message')) {
                 if ('error' === session('type')) {
                 ?>
                 toastr.error( "<?php echo session('message'); ?>", "", {
                  "closeButton": true
                 } );
             
                 <?php
            }
                 else if ('success' === session('type')) {
                 ?>
                 toastr.success( '<?php echo trim(session('message')); ?>', {
                  "closeButton": true
                 } );
                 <?php
            }
            }
            ?>
</script>
</html>