<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Sub kriteria
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Ubah Sub kriteria
						</small>
					</h1>
				</div>
				<div class="pull-right"><a href='<?php echo base_url().'index.php/subkriteria' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
			</div>
			 <div>   
			 </div>
			<div class="hr hr2 hr-double"></div>
      <br> 
        <form method="post" action="<?php echo $action ?>"> 
          <div class="form-group row"> 
            <label class="col-sm-2 col-form-label">Nama kriteria</label>
            <div class="col-sm-10"> 
              <?php foreach ($kriteria as $k) {
                if($k['id_kriteria']==$res['id_kriteria']){
                  echo ''.$k['nama_kriteria'].' - Tahun Penilaian '.$k['tahun_penilaian'];
                } 
              }?> 
            </div>
          </div>
          <div class="form-group row">
            <input type="hidden" class="form-control"  name='id_subkriteria' value='<?php echo $id ?>'>
            <label class="col-sm-2 col-form-label">Kode Sub kriteria</label>
            <div class="col-sm-10">
              <?php echo $res['kode_subkriteria'] ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
              <?php echo $res['keterangan'] ?>
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tipe Penilaian</label>
            <div class="col-sm-10">
              <?php echo $res['tipe_subkriteria'] ?> 
            </div>
          </div> 
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Penilaian Detail</label>
            <div class="col-sm-10">
              <?php $this->load->view('subkriteria/subkriteria_viewdd')?>
            </div>
          </div> 
          <div class="hr hr2 hr-double"></div>
          <br> 
        </form>

		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
