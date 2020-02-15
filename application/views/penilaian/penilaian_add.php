<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Penilaian
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Tambah Penilaian
						</small>
					</h1>
				</div>
				<div class="pull-right"><a href='<?php echo base_url().'index.php/penilaian' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
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
            <label class="col-sm-2 col-form-label">Divisi</label>
            <div class="col-sm-10">
              <input type="hidden" class="form-control"  name='id_divisi' value="<?php echo $id_divisi ?>">
              <input readonly type="text" class="form-control"  name='divisi' value="<?php echo $loaddivisi['nama_divisi'] ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tahun Penilaian</label>
            <div class="col-sm-10">
              <select class="form-control"  name='tahun_penilaian'>
              <?php for ($i=2015; $i < 2025; $i++) { 
                 echo '<option value="'.$i.'">Tahun '.$i.'</option>';
              }?>
              </select>
            </div>
          </div> 
          <div class="hr hr2 hr-double"></div>
          <br> 
          <div class="hr hr2 hr-double"></div>

          <br>
          <div class="form-group row"> 
            <div class="col-sm-5">
              <input type="submit" name='draft' class="btn btn-xs btn-primary" value="Submit"> 
            </div>
          </div>
        </form>

		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
