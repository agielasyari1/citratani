<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CV. Citra Tani</title>
    <link rel="shortcut icon" href="<?=  base_url('');?>"/>
	<!-- BOOTSTRAP STYLES-->
        <link href="<?php echo base_url('assets/css/bootstrap.css');?>" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="<?php echo base_url('assets/css/font-awesome.css');?>" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <style>
       .background-image {
        position: fixed;
        left: 0;
        right: 0;
        z-index: -1;

        display: block;
        background-image: url('');
        width: 1376px;
        height: 768px;

        -webkit-filter: blur(5px);
        -moz-filter: blur(5px);
        -o-filter: blur(5px);
        -ms-filter: blur(5px);
        filter: blur(5px);
      }
   </style>
</head>
    <body>
    <div class="background-image"></div>
    <div class="container" style="z-index: 9999;">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <h2 style="color: #0081c1;"> CV. Citra Tani | TOSERBA </h2>
               
                <h5 style="color: white;"><strong> Aplikasi Toko </strong></h5>
                 <br />
            </div>
        </div>
         <div class="row ">
               
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>   Masukkan Username dan Password </strong>  
                            </div>
                            <div class="panel-body">
                                <div style="color: red">
                                <?php 

                                if($this->session->flashdata('login_error'))
                                  {
                                          echo 'Username atau password salah.';
                                  }

                                ?>
                                </div>
                                <form role="form" action="<?php echo site_url('login/check_login')?>" method="post">
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                            <input type="text" name="username" class="form-control" placeholder="Username Anda" required/>
                                        </div>
                                    <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" name="password" class="form-control"  placeholder="Password Anda" required/>
                                        </div>
                                    <div class="form-group">
                                            <label class="checkbox-inline">
                                                
                                            </label>
                                            <span class="pull-right">
                                                <a href="javascript:void(0);" onclick="alert('Mohon Hubungi Admin.')" >Lupa Password ? </a> 
                                            </span>
                                        </div>
                                     <button type="submit" class="btn btn-primary">Masuk</button>
                                     <!--<a href="index.html" class="btn btn-primary ">Masuk</a>-->
                                    <hr />
                                    &copy <a href="">CV. Citra Tani</a> 2016
                                </form>
                            </div>
                           
                        </div>
                    </div>
                
                
        </div>
    </div>


     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="<?php echo base_url('assets/js/jquery.metisMenu.js');?>"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="<?php echo base_url('assets/js/custom.js');?>"></script>
   
</body>
</html>
