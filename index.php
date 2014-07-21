<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Proveedores Bazaringa</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
            @media (min-width: 768px) {
              .sidebar-nav .navbar .navbar-collapse {
                padding: 0;
                max-height: none;
              }
              .sidebar-nav .navbar ul {
                float: none;
              }
              .sidebar-nav .navbar ul:not {
                display: block;
              }
              .sidebar-nav .navbar li {
                float: none;
                display: block;
              }
              .sidebar-nav .navbar li a {
                padding-top: 12px;
                padding-bottom: 12px;
              }
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Proveedores</a>
        </div>
        <div class="navbar-collapse collapse">
          <?php include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/login.php"; ?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div id="contenido_principal" class="container">
        <div class="row">
          <div class="col-sm-3">
            <?php include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/menu.php"; ?>
          </div>
          <div class="col-sm-9">
            <?php include_once $_SERVER["DOCUMENT_ROOT"]."/proveedores.php"; ?>
          </div>
        </div> 
      </div>
    </div>
    <div class="container">
      <!-- Example row of columns -->

      <hr>

      <footer>
        <p>&copy; Bazaringa Company 2014</p>
      </footer>
    </div> <!-- /container -->        <script src="/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <?php loadEspecialJS(); ?>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>
