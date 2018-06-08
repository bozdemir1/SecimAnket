<?php
ob_start();
session_start();
require_once '../ayarlar/baglan.php';
if (!isset($_SESSION['userkullanici_mail']))
{

    header("Location:login.php?durum=izinsizgiris");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

    <title>Seçim anket paneli</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="../vendor/jquery/jquery.min.js"></script>          
        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- MetisMenu CSS -->
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
                <!-- DataTables CSS -->
                <link href="../vendor//datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

                    <!-- DataTables Responsive CSS -->
                    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

                        <!-- Morris Charts CSS -->
                        <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

                            <!-- Custom Fonts -->
                            <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

                                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                                <!--[if lt IE 9]>
                                    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                                    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
                                <![endif]-->

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
                                            <a class="navbar-brand" href="index.html">Seçim Anket Panel</a>
                                        </div>
                                        <!-- /.navbar-header -->

                                        <ul class="nav navbar-top-links navbar-right">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-user">
                                        <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                                    </li>
                                                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                                    </li>-->
                                                    <li class="divider"></li>
                                                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Güvenli Çıkış</a>
                                                    </li>
                                                </ul>
                                                <!-- /.dropdown-user -->
                                            </li>
                                            <!-- /.dropdown -->
                                        </ul>
                                        <!-- /.navbar-top-links -->
                                        <?php require_once 'sidebar.php'; ?>
                                        <!-- /.navbar-static-side -->
                                    </nav>