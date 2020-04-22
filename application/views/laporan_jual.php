<!-- main content start-->

		<div id="page-wrapper">
			<div class="main-page">
                            
				<div class="tables">
					<h3 class="title1">Laporan Penjualan</h3>
                                        <div class="row">
                                            <div class="form-two widget-shadow col-lg-12">
                                                            <div class="form-body" data-example-id="simple-form-inline">
                                                                    <form class="form-inline"> 
                                                                       
                                                                        <div class="form-group"> 
                                                                            <label for="jenis">Tanggal</label>
                                                                            <input type="text" class="form-control"  id="range" name="range">
                                                                        </div>
                                                                        <button type="button" id="okBtn" class="btn btn-primary"><i class="fa fa-check"></i> OK </button> 
                                                                    </form> 
                                                            </div>
                                            </div>
                                        </div>	
					<div class="bs-example widget-shadow">
						<h4>Laporan Penjualan: </h4>
                                                <div class="well">
                                                    <strong>Total Jumlah: </strong><span id="tt"></span>
                                                    <strong>|Total Pembayaran: </strong><span id="tp"></span>
                                                    <strong>|Total Sisa: </strong><span id="ts"></span>  
                                                </div>
                                                <table class="table-hover table-bordered responsive" id="example" style="width: 100%"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>#</th> 
                                                            <th>Tanggal</th> 
                                                            <th>Pembeli</th> 
                                                            <th>Total</th> 
                                                            <th>Pembayaran</th> 
                                                            <th>Sisa</th> 
                                                        </tr> 
                                                    </thead> 
                                                    <tbody> 
                                                    </tbody> 
                                                </table> 
					</div>
                                        
                                       
                                        
				</div>
			</div>
		</div>
<!--<script src="<?php echo base_url('assets/js/validator.min.js');?>"></script>-->
<script src="<?php echo base_url('assets/js/formValidation.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/framework_bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"> </script>
<script>
    var t_month = "<?php echo date('m');?>";
    var t_year = "<?php echo date('Y');?>";
</script>
<script src="<?php echo base_url('assets/js/app/laporan_jual.js');?>"> </script>