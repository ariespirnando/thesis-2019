<?php
$rule = array(1=>'Human Resource',2=>'Head of Division', 3=>'Karyawan',4=>'Direksi & Manajemen', 5=>'Administrator');
?>
<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Pengguna
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Tambah Pengguna
						</small>
					</h1>
				</div>
				<div class="pull-right"><a href='<?php echo base_url().'index.php/pengguna' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
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
            <label class="col-sm-2 col-form-label">Nama Pengguna</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='nama_pengguna' placeholder="Nama Pengguna">
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='username' placeholder="Username">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Rule</label>
            <div class="col-sm-10">
              <select class="form-control"  name='rule'>
              <?php foreach ($rule as $d=>$v) {
                echo '<option value="'.$d.'">'.$v.'</option>';
              }?> 
              </select> 
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Divisi</label>
            <div class="col-sm-10">
              <select class="form-control"  name='id_divisi'>
              <?php foreach ($divisi as $d) {
                echo '<option value="'.$d['id_divisi'].'">'.$d['nama_divisi'].'</option>';
              }?> 
              </select> 
            </div>
          </div>

          
          <div class="hr hr2 hr-double"></div>
          <br>
          <div class="form-group row"> 
            <div class="col-sm-5">
              <button type="submit" class="btn btn-xs btn-primary">Simpan</button>
              <button type="reset" class="btn btn-xs btn-danger">Batal</button>
            </div>
          </div>
        </form>

		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
