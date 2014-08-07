<?php
session_start();
?>
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

              .navbar-inverse .navbar-nav>.active>a {
                background-image: linear-gradient(to bottom,#5cb85c 0,#419641 100%) !important;  
              }
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/jquery.fileupload.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="js/tinymce/tinymce.min.js"></script>
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
          <a class="navbar-brand" href="#"><img src="/img/logo.png" border="0" style="margin-top:-7px;"/>Portal Proveedores</a>
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
        <p>&copy; 
            <a href="<?php echo BAZARINGA_WWWPATH; ?>"><img src="http://prueba.bazaringa.com/img/logo.jpg" border="0" style="margin-top:-7px;" width="200px"/>
            </a></p>
      </footer>
    </div> <!-- /container -->        <script src="/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/bootbox.min.js"></script>
        <script src="js/jquery.tablesorter.js"></script>
        <script src="js/jquery.tablesorter.widgets.js"></script>
        <script src="js/main.js"></script>
        

        <script src="js/vendor/jquery.ui.widget.js"></script>
        <script src="js/load-image.min.js"></script>
        <script src="js/canvas-to-blob.min.js"></script>
        <script src="js/jquery.iframe-transport.js"></script>
        <script src="js/jquery.fileupload.js"></script>
        <script src="js/jquery.fileupload-process.js"></script>
        <script src="js/jquery.fileupload-image.js"></script>
        <script src="js/jquery.fileupload-audio.js"></script>
        <script src="js/jquery.fileupload-video.js"></script>
        <script src="js/jquery.fileupload-validate.js"></script>



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

        <script>
        $(document).on("click", ".alert", function(e) {
            bootbox.alert("Hello world!", function() {
                console.log("Alert Callback");
            });
        });
        </script>
    </body>
</html>
