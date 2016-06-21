<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Painel | Gerencionet</title>

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
        
        @section('styles')
        @show
        
        <!-- Custom CSS -->
        {{ HTML::style('css/sb-admin-2.css') }}
        
        <!-- Datetime Picker -->
        {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}
        
        <!-- Custom Fonts -->
        {{ HTML::style('css/admin.css') }}
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <![endif]-->

    </head>

    <body>
        <div class="loading"><div class="loading__icon fa fa-spinner fa-pulse"></div></div>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <div id="wrapper">

            @include('partials.header')
            
            @include('partials.sidebar')

            <div id="page-wrapper">
                @yield('content')
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

            <!-- jQuery -->
            {{ HTML::script('js/vendor/jquery.min.js') }}

            <!-- Bootstrap Core JavaScript -->
            {{ HTML::script('js/vendor/bootstrap.min.js') }}

            <!-- Metis Menu Plugin JavaScript -->
            {{ HTML::script('js/vendor/metisMenu.min.js') }}

            <!-- Morris Charts JavaScript -->
            <!--<script src="js/vendor/raphael-min.js"></script>-->
            <!--<script src="js/vendor/morris.min.js"></script>-->
            <!--<script src="js/vendor/morris-data.js"></script>-->

            <!-- Custom Theme JavaScript -->
            {{ HTML::script('js/vendor/sb-admin-2.js') }}
        
        <!-- Jquery Masks -->
        {{ HTML::script('js/vendor/jquery.mask.js') }}
        
        <!-- Moment.js -->
        {{ HTML::script('js/vendor/moment.js') }}
        
        <!-- Datetime Picker -->
        {{ HTML::script('js/vendor/bootstrap-datetimepicker.min.js') }}

        <!-- Numbers.js -->
        {{ HTML::script('js/vendor/numeral.min.js') }}
        {{ HTML::script('js/vendor/pt-br.min.js') }}
        
        @section('scripts')
        @show
        
        <!-- Admin -->
        {{ HTML::script('js/admin.js') }}
                
        
    </body>

</html>
