
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
                            <div class="tables">
                                
                                <div class="charts">
					<div class="col-md-12 widget-shadow">
						<h4 class="title">Keuntungan Penjualan Tahun <?= date("Y");?></h4>
						<canvas id="bar_pupuk" height="100" width="400" style="padding-left:10px; padding-right:30px;"> </canvas>
					</div>
                                </div>
                                <div class="clearfix"> </div>
                                        <br>
                                
                               
				<div class="bs-example widget-shadow">
                                            <select class="form-control" id="tipe" name="tipe" style="width: 150px;">
                                    <option value="ecer">Penjualan Ecer</option>
                                    <option value="partai">Penjualan Partai</option>
                                </select>
                                    <br>
                                    <h4>Daftar Penjualan Belum Lunas:</h4>
                                            <table class="table-hover table-bordered responsive" id="example" style="width: 100%"> 
                                                <thead> 
                                                    <tr> 
                                                        <th>#</th> 
                                                        <th>Tanggal</th> 
                                                        <th>Customer</th>
                                                        <th>Total</th> 
                                                        <th>Pembayaran</th> 
                                                        <th>Sisa</th> 
                                                        <th>Lunas</th> 
                                                    </tr> 
                                                </thead> 
                                                <tbody> 
                                                </tbody> 
                                            </table> 
                                    </div>
                                <div id="modal-confirm" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                        <div class="modal-dialog modal-sm">
                                                <div class="modal-content"> 
                                                        <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title" id="mySmallModalLabel">Confirmasi!</h4> 
                                                        </div> 
                                                        <div class="modal-body"> Anda yakin pembayaran sudah lunas?
                                                        </div>
                                                        <div class="modal-footer">
                                                                <button type="button" id="noBtn" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                                                <button type="button" id="yesBtn" class="btn btn-primary">Ya</button>
                                                        </div>
                                                </div>

                                        </div>
                                </div>
                            </div>
			</div>
		</div>
<script src="<?php echo base_url('assets/js/app/dashboard.js');?>"> </script>