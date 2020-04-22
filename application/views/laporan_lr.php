<!-- main content start-->

		<div id="page-wrapper">
			<div class="main-page">
                            
				<div class="tables">
					<h3 class="title1">Laporan Laba Rugi</h3>
                                        <div class="row">
                                            <div class="form-two widget-shadow col-lg-12">
                                                            <div class="form-body" data-example-id="simple-form-inline">
                                                                    <form class="form-inline"> 
                                                                       
                                                                        <div class="form-group"> 
                                                                            <label for="bulan">Bulan</label> 
                                                                            <select name="bulan" id="bulan" class="form-control" style="width: 200px;">
                                                                                <option value="01">Januari</option>
                                                                                <option value="02">Februari</option>
                                                                                <option value="03">Maret</option>
                                                                                <option value="04">April</option>
                                                                                <option value="05">Mei</option>
                                                                                <option value="06">Juni</option>
                                                                                <option value="07">Juli</option>
                                                                                <option value="08">Agustus</option>
                                                                                <option value="09">September</option>
                                                                                <option value="10">Oktober</option>
                                                                                <option value="11">Nopember</option>
                                                                                <option value="12">Desember</option>
                                                                            </select>
                                                                        </div> 
                                                                        <div class="form-group"> 
                                                                            <label for="tahun">Tahun</label> 
                                                                            <input name="tahun" id="tahun" value="<?=  date("Y");?>"  class="form-control" readonly style="width: 75px;">
                                                                        </div> 
                                                                        <button type="button" id="okBtn" class="btn btn-primary"><i class="fa fa-check"></i> OK </button> 
                                                                    </form> 
                                                            </div>
                                            </div>
                                        </div>	
					<div class="bs-example widget-shadow">
						<h4>Laporan Laba Rugi: </h4>
                                                <table class="table-hover table-bordered responsive" id="example" style="width: 100%"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>Jenis</th> 
                                                            <th>Keterangan</th> 
                                                            <th>Debit</th> 
                                                            <th>Kredit</th> 
                                                        </tr> 
                                                    </thead> 
                                                    <tbody> 
                                                    </tbody> 
                                                </table> 
                                                <br>
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
<script src="<?php echo base_url('assets/js/app/laporan_lr.js');?>"> </script>