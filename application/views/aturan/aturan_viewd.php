<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Aturan
						<small>
							<i class="ace-icon fa fa-angle-double-right"></i>
							Lihat Aturan
						</small>
					</h1>
				</div>
				<div class="pull-right"><a href='<?php echo base_url().'index.php/aturan' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
			</div> 
			<div class="hr hr2 hr-double"></div>
      <br> 
        <form method="post" action="<?php echo $action ?>"> 
          <div class="form-group row"> 
            <label class="col-sm-2 col-form-label">Nama kriteria</label>
            <div class="col-sm-10">
              <?php foreach ($kriteria as $k) {
                if($k['id_kriteria']==$res['id_kriteria']){
                  echo ''.$k['nama_kriteria'].'- Tahun Penilaian '.$k['tahun_penilaian'];
                }
              }?>
            </select> 
            </div>
          </div>
          <div class="form-group row"> 
            <label class="col-sm-2 col-form-label">Kode Aturan</label>
            <div class="col-sm-10">
              <?php echo $res['kode_aturan'] ?>
            </div>
          </div> 

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tipe Kriteria</label>
            <div class="col-sm-10">
              <?php echo $res['hasil'] ?>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Aturan Detail</label>
            <div class="col-sm-10">
              <?php $this->load->view('aturan/aturan_viewdd')?>
            </div>
          </div>

          <div class="hr hr2 hr-double"></div>
          <br> 
        </form>

		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
