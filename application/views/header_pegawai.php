<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>CV. Citra Tani - Aplikasi Toko</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="CV. Citra Tani" />
<link rel="shortcut icon" href="<?=  base_url('');?>"/>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url('assets/css/bootstrap.css');?>" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url('assets/css/style.css');?>" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url('assets/css/datatables.min.css');?>" rel='stylesheet' type='text/css' />
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css"/>-->
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="<?php echo base_url('assets/css/font-awesome.css');?>" rel="stylesheet"> 
<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet"> 
<link href="<?php echo base_url('assets/css/jquery-ui.min.css');?>" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/modernizr.custom.js');?>"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="<?php echo base_url('assets/css/animate.css');?>" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url('assets/js/wow.min.js');?>"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- chart -->
<script src="<?php echo base_url('assets/js/Chart.js');?>"></script>
<!-- //chart -->

<!-- Metis Menu -->
<script src="<?php echo base_url('assets/js/metisMenu.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/custom.js');?>"></script>
<link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet">
<!--//Metis Menu -->
<style>
.datepicker{z-index:1151 !important;}
</style>
<script>
    var site_url = "<?= site_url();?>"+"/";
    var base_url = "<?= base_url();?>";
      $.ajax({
                url : site_url+"pengguna/foto" ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    var src;
                    $("#profpict").attr('src',base_url+data.photo);
                }
            });
</script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		<div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
					<ul class="nav" id="side-menu">
						<li>
							<a href="<?php echo site_url('dashboard');?>"><i class="fa fa-home nav_icon"></i>Dashboard</a>
						</li>
<!--                                                <li>
							<a href="<?php echo site_url('pembeli');?>"><i class="fa fa-users nav_icon"></i>Pembeli</a>
						</li>-->
						<li class="">
							<a href="#"><i class="fa fa-exchange nav_icon"></i>Transaksi<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?php echo site_url('a_pembelian');?>">Pembelian A</a>
								</li>
								<li>
									<a href="<?php echo site_url('b_pembelian');?>">Pembelian B</a>
								</li>
								<li>
									<a href="<?php echo site_url('penjualanpartai');?>">Penjualan Partai</a>
								</li>
								<li>
									<a href="<?php echo site_url('penjualanecer');?>">Penjualan Eceran</a>
								</li>
                                                                <li>
									<a href="<?php echo site_url('transaksi_lain');?>">Lain - Lain</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>
						
					</ul>
					<!-- //sidebar-collapse -->
				</nav>
			</div>
		</div>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<!--logo -->
				<div class="logo">
					<a href="<?= site_url();?>">
						<h1>CV. Citra Tani</h1>
						<span>Aplikasi Toko</span>
					</a>
				</div>
				<!--//logo-->
				
				<div class="clearfix"> </div>
			</div>
			<div class="header-right">
				<!--notification menu end -->
				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
                                                                     <span class="prfil-img"><img style="width: 50px; height: 50px;" id="profpict" src="<?= base_url('assets/images/a.png');?>" alt=""> </span> 
									<div class="user-name">
										<p><?php echo $this->session->userdata('nama')?></p>
										<span><?php 
                                                                                        if($this->session->userdata('posisi') == 1){
                                                                                                echo "Administrator";
                                                                                            }else{
                                                                                                echo "Pegawai";
                                                                                            }
                                                                                        ?>
                                                                                </span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu"> 
								<li> <a href="<?php echo site_url('profil')?>"><i class="fa fa-user"></i> Profile</a> </li> 
                                                                <li> <a href="<?php echo site_url('login/logout')?>"><i class="fa fa-sign-out"></i> Logout</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->