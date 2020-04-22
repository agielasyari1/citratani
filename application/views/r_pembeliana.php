<!-- main content start-->
<style>
	.ui-autocomplete {
		max-height: 300px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 100px;
	}
        
	</style>
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<h3 class="title1">No : <?=$id_pembelian;?></h3>
                                        <input type="text" id="no_pembelian" name="no_pembelian" value="<?=$id_pembelian;?>" hidden>
					
					<div class="bs-example widget-shadow">
						 <h4>Total: <span id="totalTxt" style="color: red; background-color: greenyellow; font-weight: bold"></span></h4>
                                                <table class="table-hover table-bordered responsive" id="example" style="width: 100%"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>#</th> 
                                                            <th>Barang</th> 
                                                            <th>Qty</th>
                                                            <th>Harga Satuan</th> 
                                                            <th>Total</th> 
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
    var ppn = <?php echo $ppn?>;
</script>
<script src="<?php echo base_url('assets/js/app/r_pembeliana.js');?>"> </script>