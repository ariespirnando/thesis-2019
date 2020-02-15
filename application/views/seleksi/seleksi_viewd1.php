<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Seleksi & Peringkat 
            <small>
              <i class="ace-icon fa fa-angle-double-right"></i>
              View Matrik Penilaian Tahun <?php echo $res['tahun_penilaian'] ?>
            </small>
					</h1>
				</div>
        <div class="pull-right"><a href='<?php echo base_url().'index.php/seleksi' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
      </div>
		<div>
	<div>   
</div> 
      <div class="hr hr2 hr-double"></div>  
        
        <br>  
        <table id="table" class="table table-bordered table-hover" width="90%">
          <thead> 
            <tr>
              <th width="5%" class="center" rowspan="2">No</th>
              <th width="15%" class="center" rowspan="2">Divisi</th>
              <th width="5%" class="center" rowspan="2">Kode Divisi</th> 
              <?php 
              foreach ($kriteria as $k) {
                echo '<th class="center" colspan="'.$k['totalrand'].'">'.$k['kode_kriteria'].'</th>';
              }
              ?>
            </tr> 
            <tr>
              <?php
              foreach ($subkritera as $s) {
                echo '<th class="center" >'.$s['kode_subkriteria'].'</th>';
              }
              ?> 
            </tr>
          </thead> 
          <tbody>  
            <?php 
              $nn = 0;
              foreach ($penilaian as $p) {
                $nn++;
                echo '<tr>';
                echo '<td>'.$nn.'</td>';
                echo '<td>'.$p['nama_divisi'].'</td>';
                echo '<td>'.$p['kode_divisi'].'</td>';
                foreach ($subkritera as $s) {
                  $this->db->join('master_subkriteriadetail','master_subkriteriadetail.id_subkriteriadetail = penilaian_detail.id_subkriteriadetail','inner');  
                  $this->db->where('id_penilaian',$p['id_penilaian']);
                  $this->db->where('penilaian_detail.id_kriteria',$s['id_kriteria']);
                  $this->db->where('penilaian_detail.id_subkriteria',$s['id_subkriteria']); 
                  $dt = $this->db->get('penilaian_detail')->row_array();  
                  echo '<td class="center" >'.$dt['nilai_aktual'].'</td>';
                }
                echo '<tr>';
              }
            ?>
          </tbody>
        </table>   
        <br> 
			</div>
			<div class="hr hr2 hr-double"></div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
 
