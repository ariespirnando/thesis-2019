<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link" href="#rangking" role="tab" data-toggle="tab" onclick="seleksi(<?php echo $res['id_seleksi']?>,1)">--- Seleksi</a>
  </li>
  <li class="nav-item active">
    <a class="nav-link" href="#rangking1" role="tab" data-toggle="tab">Matrik Keputusan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#rangking2" role="tab" data-toggle="tab">Normalisasi</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#rangking3" role="tab" data-toggle="tab">Normalisasi Terbobot</a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="#rangking4" role="tab" data-toggle="tab">Solusi Ideal</a>
  </li>   
  <li class="nav-item">
    <a class="nav-link" href="#rangking5" role="tab" data-toggle="tab">Separation Measure</a>
  </li>  
  <li class="nav-item">
    <a class="nav-link" href="#rangking6" role="tab" data-toggle="tab">Preferensi Rangking</a>
  </li>  
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="rangking1">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="5%" class="center" >No</th>
          <th width="15%" class="center" >Divisi</th>
          <th width="10%" class="center" >Kode Divisi</th> 
          <?php 
          foreach ($kriteria_seleksi as $k) { 
            echo '<th class="center" width="5%">'.$k['kode_kriteria'].'</th>';
          }
          ?> 
        </tr> 
         
      </thead> 
      <tbody>  
        <?php 
          $nn = 0;
          foreach ($penilaian_seleksi2 as $p) {
            $nn++; 
            echo '<tr>'; 
            echo '<td>'.$nn.'</td>';
            echo '<td>'.$p['nama_divisi'].'</td>';
            echo '<td>'.$p['kode_divisi'].'</td>'; 
            foreach ($kriteria_seleksi as $k) { 
              $this->db->where('id_seleksi_hasil',$p['id_seleksi_hasil']);
              $this->db->where('id_kriteria',$k['id_kriteria']); 
              $dt = $this->db->get('seleksi_hasildetail')->row_array();  
              echo '<td>'.$dt['nilai_awal'].'</td>';  
            }   
            echo '<tr>';
          }
        ?>
      </tbody>
    </table>  
  </div> 
  <div role="tabpanel" class="tab-pane fade" id="rangking2">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="5%" class="center" >No</th>
          <th width="15%" class="center" >Divisi</th>
          <th width="10%" class="center" >Kode Divisi</th> 
          <?php 
          foreach ($kriteria_seleksi as $k) { 
            echo '<th class="center" width="5%">'.$k['kode_kriteria'].'</th>';
          }
          ?> 
        </tr> 
         
      </thead> 
      <tbody>  
        <?php 
          $nn = 0;
          foreach ($penilaian_seleksi2 as $p) {
            $nn++; 
            echo '<tr>'; 
            echo '<td>'.$nn.'</td>';
            echo '<td>'.$p['nama_divisi'].'</td>';
            echo '<td>'.$p['kode_divisi'].'</td>'; 
            foreach ($kriteria_seleksi as $k) { 
              $this->db->where('id_seleksi_hasil',$p['id_seleksi_hasil']);
              $this->db->where('id_kriteria',$k['id_kriteria']); 
              $dt = $this->db->get('seleksi_hasildetail')->row_array();  
              echo '<td>'.$dt['nilai_normalisasi'].'</td>';  
            }   
            echo '<tr>';
          }
        ?>
      </tbody>
    </table>  
  </div> 
  <div role="tabpanel" class="tab-pane fade" id="rangking3">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="5%" class="center" >No</th>
          <th width="15%" class="center" >Divisi</th>
          <th width="10%" class="center" >Kode Divisi</th> 
          <?php 
          foreach ($kriteria_seleksi as $k) { 
            echo '<th class="center" width="5%">'.$k['kode_kriteria'].' ['.$k['bobot'].']</th>';
          }
          ?> 
        </tr> 
         
      </thead> 
      <tbody>  
        <?php 
          $nn = 0;
          foreach ($penilaian_seleksi2 as $p) {
            $nn++; 
            echo '<tr>'; 
            echo '<td>'.$nn.'</td>';
            echo '<td>'.$p['nama_divisi'].'</td>';
            echo '<td>'.$p['kode_divisi'].'</td>'; 
            foreach ($kriteria_seleksi as $k) { 
              $this->db->where('id_seleksi_hasil',$p['id_seleksi_hasil']);
              $this->db->where('id_kriteria',$k['id_kriteria']); 
              $dt = $this->db->get('seleksi_hasildetail')->row_array();  
              echo '<td>'.$dt['nilai_terbobot'].'</td>';  
            }   
            echo '<tr>';
          }
        ?>
      </tbody>
    </table>  
  </div> 
  <div role="tabpanel" class="tab-pane fade" id="rangking4">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="20%" class="center" ></th> 
          <?php 
          foreach ($solusi_ideal as $k) { 
            echo '<th class="center">['.$k['kode_kriteria'].'] '.$k['nama_kriteria'].'</th>';
          }
          ?> 
        </tr> 
         
      </thead> 
      <tbody>  
        <tr>
          <td>Matrik Ideal (+)</td>
          <?php 
          foreach ($solusi_ideal as $k) { 
            echo '<td class="center">'.$k['idealpositif'].'</td>';
          }
          ?> 
        </tr>
        <tr>
          <td>Matrik Ideal (-)</td>
          <?php 
          foreach ($solusi_ideal as $k) { 
            echo '<td class="center">'.$k['idealnegatif'].'</td>';
          }
          ?>
        </tr>   
      </tbody>
    </table>  
  </div> 
  <div role="tabpanel" class="tab-pane fade" id="rangking5">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="5%" class="center" >No</th>
          <th width="15%" class="center" >Divisi</th>
          <th width="10%" class="center" >Kode Divisi</th>
          <th width="5%" class="center" >Solusi Ideal (+)</th>
          <th width="5%" class="center" >Solusi Ideal (-)</th>  
        </tr> 
         
      </thead> 
      <tbody>  
        <?php 
          $nn = 0;
          foreach ($penilaian_seleksi2 as $p) {
            $nn++; 
            echo '<tr>'; 
            echo '<td>'.$nn.'</td>';
            echo '<td>'.$p['nama_divisi'].'</td>';
            echo '<td>'.$p['kode_divisi'].'</td>'; 
            echo '<td>'.$p['apositif'].'</td>'; 
            echo '<td>'.$p['anegatif'].'</td>'; 
            echo '<tr>';
          }
        ?>
      </tbody>
    </table>  
  </div> 
  <div role="tabpanel" class="tab-pane fade" id="rangking6">
    <table id="table" class="table table-bordered table-hover" width="90%">
      <thead> 
        <tr>
          <th width="5%" class="center" >No</th>
          <th width="15%" class="center" >Divisi</th>
          <th width="10%" class="center" >Kode Divisi</th>
          <th width="5%" class="center" >Preferensi</th>
          <th width="5%" class="center" >Peringkat</th>  
        </tr> 
         
      </thead> 
      <tbody>  
        <?php 
          $nn = 0;
          foreach ($preferensi_seleksi as $p) {
            $nn++; 
            echo '<tr>'; 
            echo '<td>'.$nn.'</td>';
            echo '<td>'.$p['nama_divisi'].'</td>';
            echo '<td>'.$p['kode_divisi'].'</td>'; 
            echo '<td>'.$p['prefrensi'].'</td>'; 
            echo '<td>'.$p['peringkat'].'</td>'; 
            echo '<tr>';
          }
        ?>
      </tbody>
    </table>  
  </div> 
</div> 