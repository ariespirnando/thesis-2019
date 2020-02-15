<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Master Kriteria
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Tambah Kriteria
						</small>
					</h1>
				</div>
				<div class="pull-right"><a href='<?php echo base_url().'index.php/kriteria' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
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
            <label class="col-sm-2 col-form-label">Kode Kriteria</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='kode_kriteria' placeholder="Kode Kriteria">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama Kriteria</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='nama_kriteria' placeholder="Nama Kriteria">
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Bobot</label>
            <div class="col-sm-10">
              <input type="text" class="form-control angka2"  name='bobot' placeholder="Bobot">
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tipe Kriteria</label>
            <div class="col-sm-10">
              <select class="form-control"  name='tipe_kriteria'>
                <option value='Benefit'>Benefit</option>
                <option value='Cost'>Cost</option>
              </select> 
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

<script type="text/javascript"> 
  $(".angka2").keyup(function(){
    this.value = this.value.replace(/[^0-9\.]/g,"");
  })
</script>

 
