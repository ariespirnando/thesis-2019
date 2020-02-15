<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Master Divisi
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Ubah Divisi
						</small>
					</h1>
				</div>
				<div class="pull-right"><a href='<?php echo base_url().'index.php/divisi' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
			</div>
			 <div>  
        <?php
            if($this->session->userdata('message') <> ''){
                $msg = 'warning';
                if($this->session->userdata('info')==1){
                  $msg = 'info';
                }
                echo '<br><div class="alert alert-'.$msg.'">
                        <button class="close" data-dismiss="alert">
                          <i class="ace-icon fa fa-times"></i>
                        </button>
                        '.$this->session->userdata('message').'
                      </div>';
            }
        ?> 
			 </div>
			<div class="hr hr2 hr-double"></div>
      <br> 
        <form method="post" action="<?php echo $action ?>">
          <div class="form-group row">
            <input type="hidden" class="form-control"  name='id_divisi' value='<?php echo $id ?>'>
            <label class="col-sm-2 col-form-label">Kode Divisi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='kode_divisi' placeholder="Kode Divisi" value="<?php echo $res['kode_divisi'] ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama Divisi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='nama_divisi' placeholder="Nama Divisi" value="<?php echo $res['nama_divisi'] ?>">
            </div>
          </div>  
          <div class="hr hr2 hr-double"></div>
          <br>
          <div class="form-group row"> 
            <div class="col-sm-5">
              <button type="submit" class="btn btn-xs btn-primary">Update</button> 
            </div>
          </div>
        </form>

		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
