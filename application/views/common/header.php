<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Employee</title>
    <link href="<?php echo base_url(); ?>css/styles.css?v=1.2" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <style type="text/css">
        table tr th{background-color: #f3f3f3;}
        table tfoot tr th{background-color:#924d4d;}
        .gutter-b{clear: both;}
        .card-toolbar{float: right;margin-bottom: 10px;}
        .badge{padding-top: 5px !important;
            padding-bottom: 5px !important;}
            table th{font-size: 14px !important;background-color: #556473;color: #fff;}
            table tr th {
                background-color: #556473;color: #fff;
            }
            .bg-default{background-color: #556473;color:#fff;}
            .sb-sidenav-dark {
    background-color: #2f5984 !important;
    color: rgba(255, 255, 255, 0.5);
}
.btn{
    font-size: 12px !important;
}
h5, .h5 {
    font-size: 18px !important;
}
        </style>


    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url(); ?>employee" style="text-align:center;">Employee</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">


                </div>
            </form>
            <!-- Navbar-->

        </nav>
        <div id="layoutSidenav">
    