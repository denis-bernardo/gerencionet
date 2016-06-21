<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Acesso | Gerencionet</title>

        <!-- Bootstrap Core CSS -->
        {{ HTML::style('css/bootstrap.min.css') }}

        <!-- MetisMenu CSS -->
        {{ HTML::style('css/metisMenu.min.css') }}

        <!-- Timeline CSS -->
        {{ HTML::style('css/timeline.css') }}

        <!-- Morris Charts CSS -->
        {{ HTML::style('css/morris.css') }}

        <!-- Custom Fonts -->
        {{ HTML::style('css/font-awesome.min.css') }}

        <!-- Custom CSS -->
        {{ HTML::style('css/sb-admin-2.css') }}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        @yield('content')
        <!-- /#wrapper -->

        <!-- jQuery -->
        {{ HTML::script('js/vendor/jquery.min.js') }}

        <!-- Bootstrap Core JavaScript -->
        {{ HTML::script('js/vendor/bootstrap.min.js') }}

        <!-- Metis Menu Pluginipt -->
        {{ HTML::script('js/vendor/metisMenu.min.js') }}

        <!-- Cust JavaScript -->
        {{ HTML::script('js/vendor/sb-admin-2.js') }}|

    </body>

</html>
