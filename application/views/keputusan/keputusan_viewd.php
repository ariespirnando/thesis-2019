<div class="page-content">
  <div class="row">
    <div class="col-xs-12">
      <div class="clearfix">
        <div class="page-header">
          <h1>
            Keputusan
            <small>
              <i class="ace-icon fa fa-angle-double-right"></i>
              View Pengambilan Keputusan
            </small>
          </h1>
        </div>
        <div class="pull-right"><a href='<?php echo base_url().'index.php/keputusan' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
      </div>
       
      <div class="hr hr2 hr-double"></div>
      <br>  
      <?php 
      if($res['status_keputusan']!='Selesai'){
        echo '<span class="btn btn-xs btn-primary">Status : Keputusan belum Final</span>';
      }else{
        echo '<span class="btn btn-xs btn-primary">Status : Keputusan sudah Final</span>';
      }
      ?>
      <br><br>
      <table id="table" class="table table-bordered table-hover" width="90%">
        <thead> 
          <tr>
            <th width="5%" class="center" >Pilih</th>
            <th width="5%" class="center" >No</th>
            <th width="7%" class="center" >Kode Divisi</th>
            <th width="15%" class="center" >Divisi</th>
            
            <th width="5%" class="center" >Preferensi</th>
            <th width="5%" class="center" >Peringkat</th>  
          </tr> 
           
        </thead> 
        <tbody>  
          <?php 
            $nn = 0;
            foreach ($preferensi_seleksi as $p) {
              $nn++;  
              if($p['ikeputusan']==1){
                echo '<tr>';
                echo '<td class="center" ><input disabled type="checkbox" checked name="id_seleksi_hasil[]" value="'.$p['id_seleksi_hasil'].'"></td>';
              }else{
                echo '<tr bgcolor="#CEC3C1">';
                echo '<td class="center" ><input disabled type="checkbox" name="id_seleksi_hasil[]" value="'.$p['id_seleksi_hasil'].'"></td>';
              } 
              echo '<td class="center" >'.$nn.'</td>';
              echo '<td>'.$p['kode_divisi'].'</td>'; 
              echo '<td>'.$p['nama_divisi'].'</td>'; 
              echo '<td class="center" >'.$p['prefrensi'].'</td>'; 
              echo '<td class="center" >'.$p['peringkat'].'</td>'; 
              echo '<tr>';
            }
          ?>
        </tbody>
      </table>  
       

    </div><!-- /.col -->
  </div><!-- /.row -->
</div>


 
