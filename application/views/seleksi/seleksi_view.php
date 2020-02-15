<style type="text/css">
.spinner {
    position: ;
    margin-left: 0px; 
    margin-right: 0px;
    text-align:center;
    overflow: auto;
    padding: 10px 10px 10px 10px;
} 
</style>

<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Seleksi & Peringkat 
					</h1>
				</div>
        <?php if($this->session->userdata('rule')==1){ ?>
				<div class="pull-right"><a href='<?php echo $add ?>' class="btn btn-xs btn-primary">Tambah Data</a></div>
        <?php } ?>
			</div>
			<div>
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

        <br
        <div class="row">
            <div class="col-md-6"> 
              
            </div>
            <div class="col-md-6 text-right"> 
              <div class="input-group">
                  
                  <span class="input-group-btn"> 
                    
                  </span>
              </div>
            </div>
        </div>

      <br> 
      <div class="hilangkan_table">
        <form method="post" action="<?php echo base_url().'index.php/seleksi' ?>">
        <table id="table" class="table table-striped table-bordered table-hover" width="90%">
          <thead>
            <tr> 
              <?php if($this->session->userdata('rule')==1){ ?>  
              <td colspan="5" class="center">
              <?php }else { ?>
              <td colspan="4" class="center">
              <?php } ?>
                <input type="text" class="form-control btn-xs" name="search" value="<?php echo $search ?>" placeholder='Cari Data'>
              </td>
              <?php if($this->session->userdata('rule')==1){ ?> 
              <td colspan="2" class="center">
              <?php }else { ?>
              <td class="center">
              <?php } ?>
                <input type="submit" name='submit' class="btn btn-xs btn-success" value="Cari Data"> 
                <?php 
                  if($search!=''){
                    ?>
                      <input type="submit" name='reset' class="btn btn-xs btn-primary" value="Reset"> 
                    <?php
                  }
                ?>
              </td>
            </tr>
            <tr>
              <th width="5%" class="center">No</th>
              <th width="30%" class="center">Keterangan</th>
              <th width="5%" class="center">Tahun penilaian</th>
              <th width="20%" class="center">Status</th>
              <?php if($this->session->userdata('rule')==1){ ?>  
              <th width="16%" colspan='3' class="center">Opsi</th> 
              <?php }else { ?>
              <th width="5%" class="center">Opsi</th> 
              <?php } ?>
            </tr> 
          </thead> 
          <tbody> 
           <?php
            $n = $page+1;
            foreach ($seleksi as $k) {
              echo '
                <tr>
                  <td widtd="5%" class="center">'.$n++.'</td>
                  <td widtd="30%" class="">'.$k['keterangan'].'</td>
                  <td widtd="5%" class="">'.$k['tahun_penilaian'].'</td>
                  <td widtd="20%" class="">'.$k['status_seleksi'].'</td>';
                  if($this->session->userdata('rule')==1){ 
                    if($k['status_seleksi']=='Belum diproses seleksi' || $k['status_seleksi']=='Belum diproses pemeringkatan'){ 
                      echo'<td widtd="8%" class="center">'; 
                      if($k['status_seleksi']=='Belum diproses seleksi'){
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd1_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                        echo '<i class="ace-icon fa fa-eye bigger-120"></i></a>';
                        echo '</td>';
                        echo'<td widtd="8%" class="center">'; 
                        ?>
                        <span class="btn btn-xs btn-primary" onclick="_costume_seleksi('<?php echo $k['keterangan'] ?>','<?php echo $k['tahun_penilaian'] ?>','<?php echo $k['id_seleksi'] ?>')"> 
                        <i class="ace-icon fa fa-check bigger-120"></i></span>
                        <?php 
                        echo '</td>';
                        echo '<td widtd="8%" class="center"><a class="btn btn-xs btn-danger" href="'.base_url().'/index.php/seleksi/hapus_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                        echo '<i class="ace-icon fa fa-trash-o bigger-120"></i></td>';
                      }else{
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd2_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                        echo '<i class="ace-icon fa fa-eye bigger-120"></i></a>';
                        echo '</td>';
                        echo'<td widtd="8%" class="center">'; 
                        ?>
                        <span class="btn btn-xs btn-primary" onclick="_costume_rangking('<?php echo $k['keterangan'] ?>','<?php echo $k['tahun_penilaian'] ?>','<?php echo $k['id_seleksi'] ?>')"> 
                        <i class="ace-icon fa fa-check bigger-120"></i></span>
                        <?php 
                        echo '</td>';
                        echo '<td widtd="8%" class="center">-</i></td>';
                      }  
                    }else{
                      echo'<td widtd="8%" class="center">'; 
                      if($k['status_seleksi']=='Belum diproses seleksi'){
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd1_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                      }else if($k['status_seleksi']=='Belum diproses pemeringkatan'){
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd2_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                      }else{
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd3_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                      }
                      echo '<i class="ace-icon fa fa-eye bigger-120"></i></a>';
                      echo '</td>'; 
                      echo '<td widtd="8%" class="center">-</td>';
                      echo '<td widtd="8%" class="center">-</td>';
                    }
                  }else{
                      echo'<td widtd="8%" class="center">'; 
                      if($k['status_seleksi']=='Belum diproses seleksi'){
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd1_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                      }else if($k['status_seleksi']=='Belum diproses pemeringkatan'){
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd2_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                      }else{
                        echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/seleksi/viewd3_seleksi/'.$this->encrypt->encode($k['id_seleksi']).'">';
                      }
                      echo '<i class="ace-icon fa fa-eye bigger-120"></i></a>';
                      echo '</td>';
                  } 
                echo '</tr>';
            }
           ?>
          </tbody>
        </table> 
        </form>
          <div class="col">
              <!--Tampilkan pagination-->
              <?php echo $pagination; ?>
          </div>  
        <br>
        <div class="row">
            <div class="col-md-6 text-left">  
              <div style='margin-top: 10px;' id='pagination'></div>
            </div>
            <div class="col-md-6 text-right">  
            </div>
        </div>
      </div>

			</div>
			<div class="hr hr2 hr-double"></div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

<script>
function _costume_seleksi(nama,tahun,id){
    $.confirm({
        title: 'Proses Seleksi',
        content: '' + 
        '<div class="form-group">' +
        '<label><b>'+nama+'</b>, Tahun Penilaian <b>'+tahun+'</b></label>' + 
        '</div>',
        type: 'blue',
        typeAnimated: false,
        buttons: {
            formSubmit: {
                text: 'Lakukan Seleksi',
                btnClass: 'btn-blue',
                action: function () { 
                    $.ajax({
                     url: "<?php echo base_url().'index.php/seleksi/seleksi_rulebase'?>",
                     type: 'post', 
                     data: "id="+id+"&tahun="+tahun, 
                     beforeSend: function(){
                       $(".hilangkan_table").html("<div class='spinner'><br><img id='img-spinner' src='<?php echo base_url(); ?>assets/load.gif' ><br><b>Loading Prosess Seleksi Tahun "+tahun+"</b></div>");
                     },  
                     success: function(response){
                        window.location ="<?php echo base_url().'index.php/seleksi'?>";
                     }
                   }); 
                }
            }, 
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
}
function _costume_rangking(nama,tahun,id){
    $.confirm({
        title: 'Proses Pemeringkatan',
        content: '' + 
        '<div class="form-group">' +
        '<label><b>'+nama+'</b>, Tahun Penilaian <b>'+tahun+'</b></label>' + 
        '</div>',
        type: 'blue',
        typeAnimated: true,
        buttons: {
            formSubmit: {
                text: 'Lakukan Perangkingan',
                btnClass: 'btn-blue',
                action: function () {
                    $.ajax({
                     url: "<?php echo base_url().'index.php/seleksi/seleksi_topsis'?>",
                     type: 'post', 
                     data: "id="+id+"&tahun="+tahun, 
                     beforeSend: function(){
                       $(".hilangkan_table").html("<div class='spinner'><br><img id='img-spinner' src='<?php echo base_url(); ?>assets/load.gif' ><br><b>Loading Prosess Pemeringkatan Tahun "+tahun+"</b></div>");
                     },  
                     success: function(response){
                        window.location ="<?php echo base_url().'index.php/seleksi'?>";
                     }
                   });  
                }
            }, 
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
}
</script>
 
 
