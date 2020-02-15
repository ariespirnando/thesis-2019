<table id='penilaian_adddetail' class="penilaian_adddetail table table-bordered" width="90%">
  <thead>
    <tr>
      <th width="5%" class="center">Kriteria</th> 
      <th width="75%" class="center">Penilaian</th>  
    </tr>
  </thead>    
  <tbody>
    <?php 
      foreach ($loadkriteria as $l) {  
        ?>
          <tr>
            <td width="5%"><?php echo $l['nama_kriteria'] ?></td>  
            <td width="75%" style="vertical-align:middle">
              <table class="table table-bordered"width="90%"> 
                  <?php 
                    $this->db->where('id_kriteria',$l['id_kriteria']);
                    $loadsubkriteria = $this->db->get('master_subkriteria')->result_array();
                    foreach ($loadsubkriteria as $ls) {
                      ?>
                        <tr>
                          <td width="20%"><?php echo $ls['keterangan']?></td>
                          <td width="55%" style="vertical-align:middle">
                            <table class="table table-bordered"width="90%">
                            <?php 
                              $this->db->where('id_subkriteria',$ls['id_subkriteria']);
                              $loadsubkriteriadet = $this->db->get('master_subkriteriadetail')->result_array();
                              foreach ($loadsubkriteriadet as $lsd) {
                                ?>
                                  <tr> 
                                    <td width="50%"><?php echo $lsd['keterangan']?></td>
                                    <td width="5%"><?php echo $lsd['nilai_aktual']?></td>
                                    <td width="5%">
                                      <?php 
                                        $this->db->where('id_penilaian',$res['id_penilaian']);
                                        $this->db->where('id_kriteria',$ls['id_kriteria']);
                                        $this->db->where('id_subkriteria',$ls['id_subkriteria']);
                                        $this->db->where('id_subkriteriadetail',$lsd['id_subkriteriadetail']);
                                        $checked = $this->db->get('penilaian_detail')->num_rows();
                                        if($checked>0){
                                          ?>
                                            <input disabled onchange="ganti(<?php echo $lsd['nilai_aktual'] ?>,<?php echo $l['id_kriteria']?>,<?php echo $ls['id_subkriteria'] ?>)" checked class="radio_<?php echo $l['id_kriteria'].'_'.$ls['id_subkriteria']?>" name="radiochecked_1_<?php echo $l['id_kriteria'].'_'.$ls['id_subkriteria'] ?>" type="radio" value="<?php echo $lsd['id_subkriteriadetail'] ?>"> 
                                          <?php
                                        }else{
                                          ?>
                                            <input disabled onchange="ganti(<?php echo $lsd['nilai_aktual'] ?>,<?php echo $l['id_kriteria']?>,<?php echo $ls['id_subkriteria'] ?>)" class="radio_<?php echo $l['id_kriteria'].'_'.$ls['id_subkriteria']?>" name="radiochecked_1_<?php echo $l['id_kriteria'].'_'.$ls['id_subkriteria'] ?>" type="radio" value="<?php echo $lsd['id_subkriteriadetail'] ?>"> 
                                          <?php
                                        }
                                      ?>
                                     </td> 
                                  </tr>
                                <?php
                              }
                            ?>
                            </table>
                          </td>
                          <td width="5%" style="vertical-align:middle"> <span class="ganti_<?php echo $l['id_kriteria'].'_'.$ls['id_subkriteria']?>">
                          <?php 
                            $this->db->join('master_subkriteriadetail','master_subkriteriadetail.id_subkriteriadetail = penilaian_detail.id_subkriteriadetail','inner');  
                            $this->db->where('id_penilaian',$res['id_penilaian']);
                            $this->db->where('penilaian_detail.id_kriteria',$ls['id_kriteria']);
                            $this->db->where('penilaian_detail.id_subkriteria',$ls['id_subkriteria']); 
                            $dt = $this->db->get('penilaian_detail')->row_array(); 
                            echo $dt['nilai_aktual'];
                          ?>
                          </span></td>
                        </tr>
                      <?php
                    }
                  ?> 
                </tbody> 
              </table>
            </td>  
        <?php
      }
    ?>
  </tbody>
</table>

<script>
  function ganti(a,b,c){
    $('.ganti_'+b+'_'+c).html(a); 
  }
</script>