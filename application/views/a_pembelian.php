<!-- main content start-->

		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<h3 class="title1">Pembelian Barang Gudang A</h3>
                                        <button type="button" id="addBtn" class="btn btn-primary btn-small"><i class="fa fa-plus"></i> Pembelian Baru </button>
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel">Penjualan Baru</h4>
									</div>
									<div class="modal-body">
										<form id="addUserForm" class="form-horizontal" data-toggle="validator"> 
                                                                                    <div class="form-group"> 
                                                                                        <label for="no_penjualan" class="col-sm-2 control-label">No. </label> 
                                                                                        <div class="col-sm-9"> 
                                                                                            <input type="text" class="form-control" id="no_penjualan" name="no_penjualan" readonly> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="form-group">
                                                                                            <label for="id_customer" class="col-sm-2 control-label">Pembeli</label>
                                                                                            <div class="col-sm-5 selectContainer">
                                                                                                <select name="id_customer" id="id_customer" class="form-control1">
                                                                                                </select>
                                                                                            </div>
                                                                                           
                                                                                    </div>
                                                                                   
                                                                                    <style type="text/css">
                                                                                    #addUserForm .selectContainer .form-control-feedback {
                                                                                        /* Adjust feedback icon position */
                                                                                        right: -15px;
                                                                                    }
                                                                                    </style>
                                                                                     <div class="form-group"> 
                                                                                            
                                                                                            <label for="total" class="col-sm-2 control-label">Total</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="total" name="total" placeholder="Harga Total" readonly>
                                                                                                   
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                     <div class="form-group"> 
                                                                                            
                                                                                            <label for="pembayaran" class="col-sm-2  control-label">Pembayaran</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="pembayaran" name="pembayaran" placeholder="Pembayaran">
                                                                                                   
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                     <div class="form-group"> 
                                                                                            
                                                                                            <label for="kembali" class="col-sm-2  control-label">Kembali</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="kembali" name="kembali" placeholder="Kembali">
                                                                                                   
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                     <div class="form-group"> 
                                                                                            
                                                                                            <label for="sisa" class="col-sm-2  control-label">Sisa</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="sisa" name="sisa" placeholder="Sisa Pembayaran" readonly>
                                                                                                   
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                    <input type="text" id="username2" name="username2" hidden>
                                                                                </form> 
									</div>
									<div class="modal-footer">
										<button type="button" id="cancelBtn" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                                <button type="button" id="saveBtn" class="btn btn-primary">Simpan</button>
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
						<h4>Daftar Pembelian:</h4>
                                                <table class="table-hover table-bordered responsive" id="example" style="width: 100%"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>#</th> 
                                                            <th>Tanggal</th> 
                                                            <th>Pelunasan</th> 
                                                            <th>Supplier</th>
                                                            <th>Pembayaran</th> 
                                                            <th>Sisa</th> 
                                                            <th>Total</th> 
                                                            <th>Created By</th> 
                                                            <th>Last Edited By</th> 
                                                            <th>Date Edited</th> 
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
<script src="<?php echo base_url('assets/js/app/a_pembelian.js');?>"> </script>