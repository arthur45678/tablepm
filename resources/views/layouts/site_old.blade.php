<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $title or 'Admin' }}</title>

    <!-- Bootstrap Core CSS -->

    <link href="{{ $assetPath }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ $assetPath }}/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="{{ $assetPath }}/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ $assetPath }}/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">



    <link href="{{ $assetPath }}/js/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ $assetPath }}/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">



    <script src="{{ $assetPath }}/js/plugins/ckeditor_4.6.2/ckeditor.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('styles')

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">Мой профиль</a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li>
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <ul class="nav navbar-top-links navbar-left">
            <li>
                <a href="{{ route('homeIndex') }}">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('searchAdvanced.index') }}">
                    Search Ads space
                </a>
            </li>

            <li>
                <a href="{{ route('bookmarked.getRestaurantShopBookmarked') }}">
                    Favorites
                </a>
            </li>

            <li><a href="{{ route('contacts.index') }}">Contact</a></li>

        </ul>
        <!-- /.navbar-top-links -->

        @yield('sidebar')
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        @include('admin.includes.info-box')

        @yield('content')


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{ $assetPath }}/js/plugins/jquery/jquery1_12_4.min.js"></script>


{{--<script src="{{ $assetPath }}/vendor/jquery/jquery.min.js"></script>--}}
<script src="{{ $assetPath }}/js/plugins/jquery-ui-1.12.1/jquery-ui.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ $assetPath }}/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ $assetPath }}/vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="{{ $assetPath }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="{{ $assetPath }}/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="{{ $assetPath }}/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="{{ $assetPath }}/js/plugins/bootstrap-filestyle-1.2.3/bootstrap-filestyle.min.js"></script>




<!-- Custom Theme JavaScript -->
<script src="{{ $assetPath }}/dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->

@yield('scripts')


</body>

</html>
