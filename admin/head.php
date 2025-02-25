<?php
/*
 * head.php
 * Description: Global HTML Head
 * Author: 
 * Modified: 11-23-2024
 */
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
<!-- Data Tables -->
<link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Daterange Picker -->
<link rel="stylesheet" href="../bower_components/bootstrap-daterangepicker/daterangepicker.css">
<!-- Bootstrap Datepicker -->
<link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- AdminLTE Theme Style -->
<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins -->
<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
<!-- Other CSS -->  
<link rel="stylesheet" href="../asset/css/login.css">
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../images/logo.png">

<title>FNVTTC Financial Reporting System v1.0</title>

<!-- Static Styles -->
<style type="text/css">
  .mt20{
    margin-top:20px;
  }
  .bold{
    font-weight:bold;
  }

  /*chart style*/
  #legend ul {
    list-style: none;
  }

  #legend ul li {
    display: inline;
    padding-left: 30px;
    position: relative;
    margin-bottom: 4px;
    /* border-radius: 5px;*/
    padding: 2px 8px 2px 28px;
    font-size: 14px;
    cursor: default;
    -webkit-transition: background-color 200ms ease-in-out;
    -moz-transition: background-color 200ms ease-in-out;
    -o-transition: background-color 200ms ease-in-out;
    transition: background-color 200ms ease-in-out;
  }

  #legend li span {
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 100%;
    /* border-radius: 5px;*/
  }
  /*
  body > div > header > nav,
  body > div > header > a{
    background-color: #00693e !important;
  }
    */
  .radios{
    transform: scale(1.4);
  }
</style>

<style type="text/css">
  @-webkit-keyframes blinker {
    from {opacity: 1.0;}
    to {opacity: 0.0;}
  }

  .mobile_name{
    margin-top: 10px;
    margin-left: 5px;
    font-weight: bold;
    position: absolute;
    top: -5px;
    left: 60px;
    width: 200px;
    background-color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    display: none;
    z-index: 1;
  }

  @media screen and (max-width: 768px){
    .holdleft:hover .mobile_name{
      display: block;
    }
    .desktop_name{
      display: none;
    }
  }

  .chat{
    background-color: #edf0f5;
    width: 100%;
    height: 100%;
    border-radius: 10px;
    padding: 0px;
  }
  .box_data_wrapper,.box_data_wrapper2{
  height: 70vh;
    overflow-y: auto;
  }
  .box_data,.box_data2{
  
    padding: 10px;
  }
  .conversation__view__bubbles {
      margin-bottom: 50px;
  }
  .conversation__view__bubbles::before{
    content: '';
      display: table;
      clear: both;
  }
  .chat__right__bubble {
      float: right;
      position: relative;
      border-bottom-right-radius: 0;
      color: hsl(342, 100%, 95%);font-size: 0.9em;
      padding: 8px;
      border-radius: 50px;
      word-break: break-all;
  }
  .chat__right__bubble:after{
    content: '';
    display: block;
  }


  .conversation__view__bubbles2 {
      margin-bottom: 50px;
  }
  .conversation__view__bubbles2::before{
    content: '';
      display: table;
      clear: both;
  }
  .chat__right__bubble2 {
      float: left;
      position: relative;
      border-bottom-right-radius: 0;
      padding: 8px;
      border-radius: 50px;
      word-break: break-all;
  }
  .chat__right__bubble2:after{
    content: '';
    display: block;
  }
  .messages_count,.customers_info_count{
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    text-align: center;
    width: 20px;
    height: 20px;
    font-weight: bold;
    background-color: red;
    border-radius: 50%;
  }

  .downpayment,.date_harvest,.downpayment2,.date_harvest2,.MonthlyChart,.WeeklyChart,.DailyChart{
    display: none;
  }
  .date_harvest_show,.date_harvest2_show,.DailyChart_show,.MonthlyChart_show,.WeeklyChart_show{
    display: block;
  }

  .notif{
    position: absolute;
    top: 18px;
    left: 23px;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background-color: red;
  }

  .cardnotif{
    position: absolute;
    right: 0px;
    top: 50px;
    z-index: 1000;
    width: 300px;
    height: 350px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    background-color: #fff;
    display: none;
  }
  .cardnotif_show{
    display: block;
  }
</style>

<style type="text/css">
  /* Axis Styles */
  .axis-btn-green {
    background-color: #00693e;
    color: #fff;
    padding: 8px 15px;
    font-size: 16px;
    border-radius: 8px !important;
  }
  .axis-btn-green:hover, .axis-btn-green:visited, .axis-btn-green:focus, {
    color: #fff;
  }
  .axis-btn-red {
    background-color: #990f02;
    color: #fff;
    padding: 8px 15px;
    font-size: 16px;
    border-radius: 8px !important;
  }
  .axis-btn-red:hover, .axis-btn-red:visited, .axis-btn-red:focus, {
    color: #fff;
  }
  .axis-form-control {
    height: 42px;
    border: 1px solid #00693e;
    border-radius: 8px !important;
  }
  .axis-form-control:focus {
    border: 1px solid #00693e;
  }
  .axis-header {
    display: none;
  }
  .axis-header img {
    display: inline-block;
    margin: 5px 15px;
    width: 40px;
    height: 40px;
  }
  .sidebar-collapse .axis-header {
    display: block;
  }

  /* Overrides */
  .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    background-color: #00693e;
    border-color: #00693e;
  }
  .sidebar-menu.tree li:hover a {
    background-color: #008851;
    border-radius: 10px 0 0 10px;
  }
  .sidebar-menu.tree li.active>a {
    background-color: #ecf0f5;
    border-radius: 10px 0 0 10px;
    color: #004a2b;
  }
  .sidebar-collapse .sidebar-menu.tree li a {
    border-radius: 0;
  }
  .sidebar-menu li {
    margin-left: 25px;
    border-radius: 0 0 30px 30px;
  }
  .sidebar-collapse .sidebar-menu li {
    margin-left: 0;
  }
  .sidebar-collapse .sidebar-menu li a i {
    padding-left: 5px;
  }
  .sidebar-collapse .axis-header img {
    margin-left: 10px;
  }
  .sidebar-menu li i {
    margin-right: 10px;
  }
  .navbar-nav>.user-menu>.dropdown-menu>li.user-header {
    height: 150px;
  }
  .btn:focus, .btn:hover {
    color: #fff;
  }
  .treeview>ul.treeview-menu, .treeview:hover>ul.treeview-menu a, .treeview>ul.treeview-menu:hover a, li.active>ul.treeview-menu a {
    background-color: transparent !important;
  }
  .treeview>ul.treeview-menu>li>a {
    color: #aaa !important;
  }
  .treeview>ul.treeview-menu>li>a:hover, .treeview>ul.treeview-menu>li.active>a {
    color: #fff !important;
  }
  .content-wrapper {
    margin-top: 50px;
  }
</style>