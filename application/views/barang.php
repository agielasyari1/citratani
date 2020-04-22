<!-- main content start-->

		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<h3 class="title1">Barang</h3>
                                        <button type="button" id="addBtn" class="btn btn-primary btn-small"><i class="fa fa-plus"></i> Tambah Barang </button>
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel">Tambah Barang</h4>
									</div>
									<div class="modal-body">
										<form id="addUserForm" class="form-horizontal" data-toggle="validator"> 
                                                                                    <div class="form-group"> 
                                                                                        <label for="nama_barang" class="col-sm-2 control-label">Nama</label> 
                                                                                        <div class="col-sm-9"> 
                                                                                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="form-group"> 
                                                                                            <label for="stok" class="col-sm-2 control-label">Stok</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok">
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                            <label for="satuan" class="col-sm-2 control-label">Satuan Barang</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <select type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan">
                                                                                                       
                                                                                                    </select>
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
<!--                                                                                    <div class="form-group"> 
                                                                                            <label for="harga_beli" class="col-sm-2 control-label">Beli</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli">
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>-->
                                                                                    <div class="form-group"> 
                                                                                            <label for="harga_beli" class="col-sm-2 control-label">H. Beli</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli">
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                            <label for="harga_jual" class="col-sm-2 control-label">H. Eceran</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="harga_jual_eceran" name="harga_jual_eceran" placeholder="Harga Jual Eceran">
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                            <label for="harga_jual" class="col-sm-2 control-label">H. Grosir</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa">Rp.</i>
                                                                                                    </span>
                                                                                                    <input type="text" class="form-control" id="harga_jual_grosir" name="harga_jual_grosir" placeholder="Harga Jual Grosir">
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                            <label for="gudang" class="col-sm-2 control-label">Gudang</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <select type="text" class="form-control" id="gudang" name="gudang" placeholder="Gudang">
                                                                                                        <option value="">-- Pilih Gudang --</option>
                                                                                                        <option value="Gudang A">Gudang A</option>
                                                                                                        <option value="Gudang B">Gudang B</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                
                                                                                            </div> 
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                            <label for="gudang" class="col-sm-2 control-label">Kategori</label>
                                                                                            <div class="col-sm-5">
                                                                                                <div class="input-group">
                                                                                                    <select type="text" class="form-control" id="kategori" name="kategori" placeholder="Kategori">
                                                                                                       
                                                                                                    </select>
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
						<h4>Daftar Barang:</h4>
                                                <table class="table-hover table-bordered responsive" id="example" style="width: 100%"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>#</th> 
                                                            <th>Barang</th> 
                                                            <th>Stok</th> 
                                                            <th>Satuan</th> 
                                                            <th>Harga Beli(Rp)</th> 
                                                            <th>Harga Jual Eceran(Rp)</th> 
                                                            <th>Harga Jual Grosir(Rp)</th> 
                                                            <th>Gudang</th> 
                                                            <th>Kategori</th> 
                                                            <th>Action</th> 
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
<script src="<?php echo base_url('assets/js/app/barang.js');?>"></script>