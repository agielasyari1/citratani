<!-- main content start-->

		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<h3 class="title1">Pengguna</h3>
                                        <button type="button" id="addBtn" class="btn btn-primary btn-small"><i class="fa fa-plus"></i> Tambah Pengguna </button>
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h4>
									</div>
									<div class="modal-body">
										<form id="addUserForm" class="form-horizontal" data-toggle="validator"> 
                                                                                    <div class="form-group"> 
                                                                                        <label for="username" class="col-sm-2 control-label">Username</label> 
                                                                                        <div class="col-sm-9"> 
                                                                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" readonly> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="form-group"> 
                                                                                            <label for="password" class="col-sm-2 control-label">Password</label> 
                                                                                            <div class="col-sm-9"> 
                                                                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"> 
                                                                                            </div> 
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                        <label for="nama" class="col-sm-2 control-label">Nama</label> 
                                                                                        <div class="col-sm-9"> 
                                                                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="form-group"> 
                                                                                            <label for="alamat" class="col-sm-2 control-label">Alamat</label> 
                                                                                            <div class="col-sm-9"> 
                                                                                                <textarea  id="alamat" name="alamat" class="form-control" placeholder="Alamat"></textarea>
                                                                                            </div> 
                                                                                    </div>
                                                                                    <div class="form-group"> 
                                                                                            <label for="no_telp" class="col-sm-2 control-label">No. Telp.</label> 
                                                                                            <div class="col-sm-9"> 
                                                                                                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon"> 
                                                                                            </div> 
                                                                                    </div>
                                                                                   
                                                                                    <style type="text/css">
                                                                                    #addUserForm .selectContainer .form-control-feedback {
                                                                                        /* Adjust feedback icon position */
                                                                                        right: -15px;
                                                                                    }
                                                                                    </style>
                                                                                    <div class="form-group">
                                                                                            <label for="posisi" class="col-sm-2 control-label">Hak Akses</label>
                                                                                            <div class="col-sm-4 selectContainer">
                                                                                                <select name="posisi" id="posisi" class="form-control1">
                                                                                                    <option value="">--Pilih Akses--</option>
                                                                                                    <option value="1">Admin</option>
                                                                                                    <option value="2">Pegawai</option>
                                                                                                </select>
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
						<h4>Daftar Pengguna:</h4>
                                                <table class="table-hover table-bordered responsive" id="example" style="width: 100%"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>#</th> 
                                                            <th>Nama</th> 
                                                            <th>Alamat</th> 
                                                            <th>No. Telp</th> 
                                                            <th>Posisi</th> 
                                                            <th>Status</th> 
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
<script src="<?php echo base_url('assets/js/app/pengguna.js');?>"></script>