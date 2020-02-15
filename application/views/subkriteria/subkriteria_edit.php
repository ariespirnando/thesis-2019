<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Master Sub kriteria
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Ubah Sub kriteria
						</small>
					</h1>
				</div>
				<div class="pull-right"><a href='<?php echo base_url().'index.php/subkriteria' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
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
            <label class="col-sm-2 col-form-label">Nama kriteria</label>
            <div class="col-sm-10">
              <select class="form-control"  name='id_kriteria' >
              <?php foreach ($kriteria as $k) {
                if($k['id_kriteria']==$res['id_kriteria']){
                  echo '<option selected value="'.$k['id_kriteria'].'">'.$k['nama_kriteria'].' - Tahun Penilaian '.$k['tahun_penilaian'].'</option>';
                }else{
                  echo '<option value="'.$k['id_kriteria'].'">'.$k['nama_kriteria'].' - Tahun Penilaian '.$k['tahun_penilaian'].'</option>';
                }
              }?>
            </select> 
            </div>
          </div>
          <div class="form-group row">
            <input type="hidden" class="form-control"  name='id_subkriteria' value='<?php echo $id ?>'>
            <label class="col-sm-2 col-form-label">Kode Sub kriteria</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='kode_subkriteria' placeholder="Kode Sub kriteria" value="<?php echo $res['kode_subkriteria'] ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name='keterangan' placeholder="Keterangan" value="<?php echo $res['keterangan'] ?>">
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tipe Penilaian</label>
            <div class="col-sm-10">
              <?php 
                $tipe = array('Manual','Otomatis');
              ?>
              <select class="form-control"  name='tipe_subkriteria'>
                <?php 
                  foreach ($tipe as $t) { 
                    if($res['tipe_subkriteria'] == $t){
                      echo "<option selected value='".$t."'>".$t."</option>";
                    }else{
                      echo "<option value='".$t."'>".$t."</option>";
                    }
                  }
                ?> 
              </select> 
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Penilaian Detail</label>
            <div class="col-sm-10">
              <?php $this->load->view('subkriteria/subkriteria_edit_detail')?>
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

 
