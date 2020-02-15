<?php $option = array('MAX','MIN');?>
<table id='aturan_add_detail' class="aturan_add_detail table table-striped table-bordered table-hover" width="90%">
    <thead>
      <tr>
        <th width="5%" class="center">No</th>
        <th width="40%" class="center">Keterangan Aturan (AND)</th>
        <th width="10%" class="center">Nilai</th>   
        <th width="5%" class="center">Kondisi Nilai</th>   
        <th width="5%" class="center">Opsi</th>   
      </tr>
    </thead>    
    <tbody>
      <tr> 
        <td style="width:5%;text-align: center;"><span class="aturan_add_detail_numasd">1</span></td> 
        <td style="width:40%;"> 
          <select class="form-control"  name='id_subkriteria[]'>
            <?php 
              foreach ($subkriteria as $ad) {
                echo '<option value="'.$ad['id_subkriteria'].'">['.$ad['kode_subkriteria'].'] '.$ad['keterangan'].'</option>';
              }
            ?>
          </select> 
        </td> 
        <td style="width:5%;">  
          <input type="text" class="form-control angka2" required name='nilai[]' placeholder="Nilai"> 
        </td> 
        <td style="width:5%;">  
          <select class="form-control"  name='kondisi[]'>
            <?php 
              foreach ($option as $o) {
                echo '<option value="'.$o.'">'.$o.'</option>';
              }
            ?>
          </select> 
        </td>   
        <td style="width:10%;text-align: center;"><span onClick="del_row(this,'aturan_add_detail')" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="false"></span></span></td>
       </tr> 
    </tbody>  
    <tfoot> 
      <tr>
        <td colspan="4" align="left"> 
          <span onClick="add_row2('aturan_add_detail')" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="false"> Tambah</span> </span> 
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
      row_content  += '<td style="width:5%;text-align: center;"><span class="aturan_add_detail_numasd">'+c+'</span></td> ';
      row_content  += '<td style="width:40%;"> ';
      row_content  += '  <select class="form-control"  name="id_subkriteria[]">';
          <?php 
            foreach ($subkriteria as $ad) {
              echo "row_content  += '<option value=".'"'.$ad['id_subkriteria'].'"'.">[".$ad['kode_subkriteria']."] ".$ad['keterangan']."</option>';";
            }
          ?>
      row_content  += '  </select> ';
      row_content  += '</td> ';
      row_content  += '<td style="width:5%;">  ';
      row_content  += '  <input type="text" class="form-control angka2'+c+'" required  name="nilai[]" placeholder="Nilai"> ';
      row_content  += '</td> ';
      row_content  += '<td style="width:5%;">  ';
      row_content  += '  <select class="form-control"  name="kondisi[]">';
          <?php 
            foreach ($option as $o) {
              echo "row_content  += '<option value=".'"'.$o.'"'.">".$o."</option>';";
            }
          ?>
      row_content  += '  </select> ';
      row_content  += '</td>  ';  
      row_content  += '<td style="width:10%;text-align: center;"><span onClick="del_row(this,\'aturan_add_detail\')" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="false"></span></span></td>';
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