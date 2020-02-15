<?php $option = array('<','=','>','<=','>=','!=');?>
<table id='subkriteria_add_detail' class="subkriteria_add_detail table table-striped table-bordered table-hover" width="90%">
    <thead>
      <tr>
        <th width="5%" class="center">No</th>
        <th width="40%" class="center">Keterangan Penilaian</th>
        <th width="5%" class="center">Batas Bawah</th>  
        <th width="5%" class="center">Batas Atas</th>    
        <th width="10%" class="center">Nilai Aktual</th> 
      </tr>
    </thead>    
    <tbody>
      <?php
      if($kriteria_detailnums>0){
        $kdp = 1;
        foreach ($kriteria_detail as $kd) {
          ?>
            <tr> 
              <td style="width:5%;text-align: center;"><span class="subkriteria_add_detail_numasd"><?php echo $kdp++ ?></span></td> 
              <td style="width:40%;"> 
                <?php echo $kd['keterangan'] ?>
              </td> 
              <td style="width:5%;"> 
                <?php echo $kd['nilai_awal'] ?> 
              </td> 
              <td style="width:5%;">  
                <?php echo $kd['nilai_akhir'] ?>
              </td>  
              <td style="width:10%;">
                <?php echo $kd['nilai_aktual'] ?>
              </td>  
             </tr>
          <?php
        }
      } ?>
    </tbody>    
  </table>


  