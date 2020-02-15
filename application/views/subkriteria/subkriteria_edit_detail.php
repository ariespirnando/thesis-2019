<?php $option = array('<','=','>','<=','>=','!=');?>
<table id='subkriteria_add_detail' class="subkriteria_add_detail table table-striped table-bordered table-hover" width="90%">
    <thead>
      <tr>
        <th width="5%" class="center">No</th>
        <th width="40%" class="center">Keterangan Penilaian</th>
        <th width="5%" class="center">Batas Bawah</th>  
        <th width="5%" class="center">Batas Atas</th>    
        <th width="10%" class="center">Nilai Aktual</th> 
        <th width="5%" class="center">Opsi</th>   
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
                <input type="hidden" required name='id_subkriteriadetail[]' value="<?php echo $kd['id_subkriteriadetail'] ?>">  
                <input type="text" class="form-control"  required name='keteranganp[]' placeholder="Keterangan" value="<?php echo $kd['keterangan'] ?>">  
              </td> 
              <td style="width:5%;">  
                <input type="text" class="form-control angka2" maxlength="4" required name='nilai_awal[]' placeholder="Nilai" value="<?php echo $kd['nilai_awal'] ?>">
              </td> 
              <td style="width:5%;">   
                <input type="text" class="form-control angka2" maxlength="4" required name='nilai_akhir[]' placeholder="Nilai" value="<?php echo $kd['nilai_akhir'] ?>">
              </td>  
              <td style="width:5%;">   
                <input type="text" class="form-control angka2" maxlength="4" required name='nilai_aktual[]' placeholder="Nilai" value="<?php echo $kd['nilai_aktual'] ?>">
              </td>  
              <td style="width:10%;text-align: center;"><span onClick="del_row(this,'subkriteria_add_detail')" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="false"></span></span></td>
             </tr>
          <?php
        }
      }else{
      ?>
      <tr> 
        <td style="width:5%;text-align: center;"><span class="subkriteria_add_detail_numasd">1</span></td> 
        <td style="width:40%;"> 
          <input type="hidden" required name='id_subkriteriadetail[]'>  
          <input type="text" class="form-control"  required name='keteranganp[]' placeholder="Keterangan">  
        </td> 
        <td style="width:5%;">  
          <input type="text" class="form-control angka2" maxlength="4" required name='nilai_awal[]' placeholder="Nilai">
        </td> 
        <td style="width:5%;">   
          <input type="text" class="form-control angka2" maxlength="4" required name='nilai_akhir[]' placeholder="Nilai">
        </td> 
        <td style="width:5%;">   
          <input type="text" class="form-control angka2" maxlength="4" required name='nilai_aktual[]' placeholder="Nilai">
        </td>  
        <td style="width:10%;text-align: center;"><span onClick="del_row(this,'subkriteria_add_detail')" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="false"></span></span></td>
       </tr>
       <?php } ?> 
    </tbody>  
    <tfoot> 
      <tr>
        <td colspan="5" align="left"> 
          <span onClick="add_row2('subkriteria_add_detail')" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="false"> Tambah</span> </span> 
        </td>
      </tr>
    </tfoot> 
  </table>


  <script>
  function add_row2(table_id) {   
      $("span."+table_id+"_numasd:first").text('1');
      var n = $("span."+table_id+"_numasd:last").text(); 
      var no = parseInt(n);
      var c = no + 1;  
      var row_content = ''; 
      row_content  += '<tr> ';
      row_content  += '<td style="width:5%;text-align: center;"><span class="subkriteria_add_detail_numasd">'+c+'</span></td> ';
      row_content  += '<td style="width:40%;"> ';
      row_content  += '  <input type="hidden" required name="id_subkriteriadetail[]">';
      row_content  += '  <input type="text" class="form-control" required name="keteranganp[]" placeholder="Keterangan"> '; 
      row_content  += '</td> ';
      row_content  += '<td style="width:5%;">  ';
      row_content  += '  <input type="text" class="form-control angka2'+c+'" maxlength="4" required  name="nilai_awal[]" placeholder="Nilai"> ';
      row_content  += '</td> ';
      row_content  += '<td style="width:5%;">  '; 
      row_content  += '  <input type="text" class="form-control angka2'+c+'" maxlength="4" required  name="nilai_akhir[]" placeholder="Nilai"> ';
      row_content  += '</td>  ';
      row_content  += '<td style="width:5%;">  '; 
      row_content  += '  <input type="text" class="form-control angka2'+c+'" maxlength="4" required name="nilai_aktual[]" placeholder="Nilai">';
      row_content  += '</td>  ';
      row_content  += '<td style="width:10%;text-align: center;"><span onClick="del_row(this,\'subkriteria_add_detail\')" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="false"></span></span></td>';
      row_content  += '</tr> ';

      $('table#'+table_id+' tbody tr:last').after(row_content);
      $('table#'+table_id+' tbody tr:last input').val("");
      $('table#'+table_id+' tbody tr:last div').text("");
      $("span."+table_id+"_num:last").text(c);  

      $(".angka2"+c).keyup(function(){
        this.value = this.value.replace(/[^0-9\.]/g,"");
      })  
  } 

  function del_row(dis, conname) { 
     if($('.'+conname+' tr').length > 3) {
       $(dis).parent().parent().remove();  
     }
     else {
        _costume_alert('Info', 'Tidak Bisa di Hapus');
     } 
  }   
  $(".angka2").keyup(function(){
    this.value = this.value.replace(/[^0-9\.]/g,"");
  }) 

</script>