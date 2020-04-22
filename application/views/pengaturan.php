<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<h3 class="title1">Pengaturan</h3>
					<div class=" form-grids row form-grids-right">
						<div class="widget-shadow " data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Form Pengaturan :</h4>
							</div>
							<div class="form-body">
								<form id="formSetting" class="form-horizontal"> 
                                                                    <div class="form-group"> 
                                                                            <label for="ppn" class="col-sm-2 control-label">PPN</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="input-group">
                                                                                    <input type="number" class="form-control" id="ppn" name="ppn" placeholder="PPN">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa">%</i>
                                                                                    </span>
                                                                                </div>

                                                                            </div> 
                                                                    </div>
                                                          
                                                                    <div class="form-group"> 
                                                                    </div> 
                                                                    <div class="col-sm-offset-2"> 
                                                                        <button type="button" id="saveBtn" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button> 
                                                                    </div> 
                                                                </form> 
							</div>
						</div>
					</div>
					
				
				</div>
                            
                            <div class="forms">
					
					<div class=" form-grids row form-grids-right">
						<div class="widget-shadow " data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Backup Database :</h4>
							</div>
							<div class="form-body">
								<form id="formSetting2" class="form-horizontal"> 
                                                                    
                                                                    <div class="col-sm-offset-2">  
                                                                        <a href="<?php echo site_url('pengaturan/backup_db')?>" id="backupBtn" class="btn btn-primary"><i class="fa fa-download"></i> Backup</a> 
                                                                    </div> 
                                                                </form> 
							</div>
						</div>
					</div>
					
				
				</div>
                            
                            <div class="forms">
					
					<div class=" form-grids row form-grids-right">
						<div class="widget-shadow " data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Restore Database :</h4>
							</div>
							<div class="form-body">
                                                            <form id="formSetting3" class="form-horizontal"> 
                                                                     <div class="form-group"> 
                                                                            <label for="filesql" class="col-sm-2 control-label">File SQL</label>
                                                                            <div class="col-sm-2">
                                                                                    <input type="file" id="filesql" name="filesql">
                                                                            </div> 
                                                                    </div>
                                                                    <div class="col-sm-offset-2"> 
                                                                        <button type="button" id="restoreBtn" class="btn btn-primary"><i class="fa fa-upload"></i> Restore</button> 
                                                                    </div> 
                                                                </form> 
							</div>
						</div>
					</div>
					
				
				</div>
			</div>
		</div>
<script src="<?php echo base_url('assets/js/app/pengaturan.js');?>"> </script>