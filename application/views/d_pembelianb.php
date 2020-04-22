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
                                       <button type="button" id="prosessBtn" class="btn btn-primary btn-small"><i class="fa fa-forward"></i> Proses </button>
                                        <?php
                                           if($this->uri->segment(2) == "pembelian_baru"){
                                               ?>
                                        <button type="button" id="batalBtn" class="btn btn-danger btn-small"><i class="glyphicon glyphicon-remove"></i> Batal </button>
                                        <?php
                                           }
                                        ?>	
							<div class="inline-form widget-shadow" role="document">
								
									<div class="form-body">
										<form id="addUserForm" class="form-inline" data-toggle="validator"> 
                                                                                    <input type="text" id="no_pembelian" name="no_pembelian" value="<?=$id_pembelian;?>" hidden>
                                                                                   
                                                                                      <div class="form-group">
                                                                                        <input type="text" class="form-control" id="id_barang" name="id_barang" placeholder="Cari.." style="width: 200px">
                                                                                    </div>
                                                                                   
                                                                                    <style type="text/css">
                                                                                    #addUserForm .selectContainer .form-control-feedback {
                                                                                        /* Adjust feedback icon position */
                                                                                        right: -15px;
                                                                                    }
                                                                                    </style>
                                                                                    <div class="form-group"> 
                                                                                         <input type="text" class="form-control" id="qty" name="qty" placeholder="Qty" style="width: 100px">
                                                                                    
                                                                                    </div>
                                                                                     <div class="form-group"> 
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" placeholder="Harga Satuan" style="width: 150px">
                                                                                                </div>
                                                                                    </div>
                                                                                     <div class="form-group"> 
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="total" name="total" placeholder="Harga Total" style="width: 100px" readonly>
                                                                                               </div>
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                         <button type="button" id="saveBtn" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                                                                    </div>
                                                                                    <input type="text" id="username2" name="username2" hidden>
                                                                                </form> 
									</div>
							</div>
                                        
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel">Pembelian Baru</h4>
									</div>
									<div class="modal-body">
										<form id="addUserForm2" class="form-horizontal" data-toggle="validator"> 
                                                                                    <div class="form-group"> 
                                                                                        <label for="pno_pembelian" class="col-sm-2 control-label">No. </label> 
                                                                                        <div class="col-sm-9"> 
                                                                                            <input type="text" class="form-control" id="pno_pembelian" name="pno_pembelian" value="<?=$id_pembelian;?>"  readonly> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                     <div class="form-group"> 
                                                                                            <label for="tanggal_permintaan" class="col-sm-2 control-label">Tanggal</label> 
                                                                                            <div class="col-sm-3"> 
                                                                                                <input type="text" class="form-control" id="tanggal_permintaan" name="tanggal_permintaan" placeholder="Tanggal Permintaan"> 
                                                                                            </div> 
                                                                                            <label for="batas_pembayaran" class="col-sm-2 control-label">Pelunasan</label> 
                                                                                            <div class="col-sm-4"> 
                                                                                                <input type="text" class="form-control" id="batas_pembayaran" name="batas_pembayaran" placeholder="Tanggal Pelunasan"> 
                                                                                            </div> 
                                                                                          
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                            <label for="id_supplier" class="col-sm-2 control-label">Supplier</label>
                                                                                            <div class="col-sm-5 selectContainer">
                                                                                                <input type="text" class="form-control" id="id_supplier" name="id_supplier" placeholder="Cari Supplier">
                                                                                                
                                                                                            </div>
                                                                                           
                                                                                    </div>
                                                                                    
                                                                                    <style type="text/css">
                                                                                    #addUserForm2 .selectContainer .form-control-feedback {
                                                                                        /* Adjust feedback icon position */
                                                                                        right: -15px;
                                                                                    }
                                                                                    </style>
                                                                                     <div class="form-group"> 
                                                                                            
                                                                                            <label for="ptotal" class="col-sm-2 control-label">Total</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="ptotal" name="ptotal" placeholder="Harga Total" readonly>
                                                                                                   
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                     <div class="form-group"> 
                                                                                            
                                                                                            <label for="ppembayaran" class="col-sm-2  control-label">Pembayaran</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="ppembayaran" name="ppembayaran" placeholder="Pembayaran">
                                                                                                   
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                  
                                                                                     <div class="form-group"> 
                                                                                            
                                                                                            <label for="psisa" class="col-sm-2  control-label">Sisa</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="psisa" name="psisa" placeholder="Sisa Pembayaran" readonly>
                                                                                                   
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                    <input type="text" id="username2" name="username2" hidden>
                                                                                </form> 
									</div>
									<div class="modal-footer">
										<button type="button" id="cancelBtn" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                                <button type="button" id="saveBtn2" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							</div>
						</div>
                                        
                                                <div id="modal-confirm" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content"> 
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel">Hapus Data</h4> 
									</div> 
									<div class="modal-body"> Anda yakin ingin menghapus data ini?
									</div>
                                                                        <div class="modal-footer">
										<button type="button" id="noBtn" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                                                <button type="button" id="yesBtn" class="btn btn-primary">Ya</button>
                                                                        </div>
								</div>
                                                                
							</div>
						</div>
					
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
                                                            <th>Aksi</th> 
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
<script src="<?php echo base_url('assets/js/app/d_pembelianb.js');?>"> </script>