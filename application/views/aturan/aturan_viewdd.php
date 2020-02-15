<?php $option = array('<','=','>','<=','>=','!=');?>
<table id='aturan_add_detail' class="aturan_add_detail table table-striped table-bordered table-hover" width="90%">
    <thead>
      <tr>
        <th width="5%" class="center">No</th>
        <th width="40%" class="center">Keterangan Aturan (OR)</th>
        <th width="10%" class="center">Nilai</th>   
        <th width="5%" class="center">Kondisi Nilai</th>   
      </tr>
    </thead>    
    <tbody>

      <?php  
      if($aturandetailnum>0){
        $num=1;
        foreach ($aturandetail as $adt) {
        ?>
        <tr> 
          <td style="width:5%;text-align: center;"><span class="aturan_add_detail_numasd"><?php echo $num++ ?></span></td> 
          <td style="width:40%;">  
              <?php 
                foreach ($subkriteria as $ad) {
                  if($ad['id_subkriteria']==$adt['id_subkriteria']){
                    echo '['.$ad['kode_subkriteria'].'] '.$ad['keterangan'].'';
                  } 
                }
              ?>
          </td> 
          <td style="width:5%;">  
            <?php echo $adt['nilai'] ?> 
          </td> 
          <td style="width:5%;">   
              <?php echo $adt['kondisi'] ?> 
          </td>   
         </tr> 
        <?php
        }
      }else{
      ?>
      <tr> 
        <td colspan="4"><i>Tidak ada data yang ditampilkan</i></td> 
      </tr> 
    <?php } ?>
    </tbody>   
  </table>


   