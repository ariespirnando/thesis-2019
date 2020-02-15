 <ul class="nav nav-tabs" role="tablist">
  <li class="nav-item active">
    <a class="nav-link" href="#tab1" role="tab" data-toggle="tab">Data Penilaian</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab2" role="tab" data-toggle="tab">Proses Seleksi</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab3" role="tab" data-toggle="tab">Hasil Seleksi</a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="#tab4" role="tab" data-toggle="tab" onclick="seleksi(<?php echo $res['id_seleksi']?>,2)">Peringkat ---</a>
  </li> 
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="tab1"> 
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
  </div>
  <div role="tabpanel" class="tab-pane fade" id="tab2">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="5%" class="center" rowspan="2">No</th>
          <th width="15%" class="center" rowspan="2">Divisi</th>
          <th width="5%" class="center" rowspan="2">Kode Divisi</th> 
          <?php 
          foreach ($kriteria as $k) {
            $hit = $k['totalrand']*2;
            echo '<th class="center" colspan="'.$hit.'">'.$k['kode_kriteria'].'</th>';
          }
          ?>
        </tr> 
        <tr>
          <?php
          foreach ($subkritera as $s) {
            echo '<th class="center" colspan="2">'.$s['kode_subkriteria'].'</th>'; 
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
              if($dt['hasil']=='TMS'){
                echo '<td class="center" ><b>'.$dt['nilai_aktual'].'</b></td>';
                echo '<td class="center" ><b>'.$dt['hasil'].'</b></td>';
              }else{
                echo '<td class="center" >'.$dt['nilai_aktual'].' </td>';
                echo '<td class="center" >'.$dt['hasil'].'</td>';
              } 
              
            }
            echo '<tr>';
          }
        ?>
      </tbody>
    </table>  
  </div>
  <div role="tabpanel" class="tab-pane fade" id="tab3">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="5%" class="center" >No</th>
          <th width="15%" class="center" >Divisi</th>
          <th width="5%" class="center" >Kode Divisi</th> 
          <?php 
          foreach ($kriteria_seleksi as $k) { 
            echo '<th class="center" colspan="2">'.$k['kode_kriteria'].'</th>';
          }
          ?>
          <th width="5%" class="center" >Hasil Seleksi</th> 
        </tr> 
         
      </thead> 
      <tbody>  
        <?php 
          $nn = 0;
          foreach ($penilaian_seleksi as $p) {
            $nn++;
            if($p['hasil']=='Dilanjutkan'){
              echo '<tr>';
            }else{
              echo '<tr bgcolor="#CEC3C1">';
            } 
            echo '<td>'.$nn.'</td>';
            echo '<td>'.$p['nama_divisi'].'</td>';
            echo '<td>'.$p['kode_divisi'].'</td>'; 
            foreach ($kriteria_seleksi as $k) { 
              $this->db->where('id_seleksi_hasil',$p['id_seleksi_hasil']);
              $this->db->where('id_kriteria',$k['id_kriteria']); 
              $dt = $this->db->get('seleksi_hasildetail')->row_array(); 
              if($dt['hasil']=='TMS'){
                echo '<td><b>'.$dt['nilai_awal'].'</b></td>';
                echo '<td><b>'.$dt['hasil'].'</b></td>'; 
              }else{
                echo '<td>'.$dt['nilai_awal'].'</td>';
                echo '<td>'.$dt['hasil'].'</td>'; 
              }
            } 
            if($p['hasil']=='Dilanjutkan'){
              echo '<td>'.$p['hasil'].'</td>';
            }else{
              echo '<td><b>'.$p['hasil'].'</b></td>';
            }
             
            echo '<tr>';
          }
        ?>
      </tbody>
    </table>  
  </div> 
</div>
         