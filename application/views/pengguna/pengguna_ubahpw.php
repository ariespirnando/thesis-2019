<?php
$rule = array(1=>'Human Resource',2=>'Head of Division', 3=>'Karyawan',4=>'Direksi & Manajemen', 5=>'Administrator');
?>
<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Ubah Password 
					</h1>
				</div>
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
            <label class="col-sm-2 col-form-label">Password Lama</label>
            <div class="col-sm-10">
              <input type="password" class="form-control"  name='passwordL' placeholder="Password Lama">
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Password Baru</label>
            <div class="col-sm-10">
              <input type="password" class="form-control"  name='passwordB' placeholder="Password Baru">
            </div>
          </div> 
          <div class="hr hr2 hr-double"></div>
          <br>
          <div class="form-group row"> 
            <div class="col-sm-5">
              <button type="submit" class="btn btn-xs btn-primary">Ubah</button>
              <button type="reset" class="btn btn-xs btn-danger">Batal</button>
            </div>
          </div>
        </form>

		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
