<div class="page-content">
  <div class="row">
    <div class="col-xs-12">
      <div class="clearfix">
        <div class="page-header">
          <h1>
            Keputusan
            <small>
              <i class="ace-icon fa fa-angle-double-right"></i>
              Pengambilan Keputusan
            </small>
          </h1>
        </div>
        <div class="pull-right"><a href='<?php echo base_url().'index.php/keputusan' ?>' class="btn btn-xs btn-warning">Kembali</a></div>
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
        <div class="col-sm-5">
          <input type="submit" name='draft' class="btn btn-xs btn-primary" value="Kepututsan (DRAFT)">
          <input type="submit" name='submit' class="btn btn-xs btn-danger" value="Keputusan (FINAL)">   
        </div>
      </div>

      <input type="hidden" name="id_seleksi" value="<?php echo $res['id_seleksi'] ?>">
      <input type="hidden" name="tahun_penilaian" value="<?php echo $res['tahun_penilaian'] ?>">
      
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
              echo '<tr>'; 
              if($p['ikeputusan']==1){
                echo '<td class="center" ><input type="checkbox" checked name="id_seleksi_hasil[]" value="'.$p['id_seleksi_hasil'].'"></td>';
              }else{
                echo '<td class="center" ><input type="checkbox" name="id_seleksi_hasil[]" value="'.$p['id_seleksi_hasil'].'"></td>';
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
      </form>

    </div><!-- /.col -->
  </div><!-- /.row -->
</div>


 
