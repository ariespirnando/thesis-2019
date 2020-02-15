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
						Master Kriteria 
					</h1>
				</div>
        <?php if($this->session->userdata('rule')==1){ ?>
				<div class="pull-right"><a href='<?php echo $add ?>' class="btn btn-xs btn-primary">Tambah Kriteria</a></div>
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

      <div class="hilangkan_table">
      <?php if($this->session->userdata('rule')==1){?>
      <span class='btn btn-xs btn-primary' onclick='_copydata()'>Copy Data</span><br>
      <?php } ?> 
      <br> 
        <form method="post" action="<?php echo base_url().'index.php/kriteria' ?>">
        <table id="table" class="table table-striped table-bordered table-hover" width="90%">
          <thead>
            <tr> 
              <td colspan="6" class="center">
                <input type="text" class="form-control btn-xs" name="search" value="<?php echo $search ?>" placeholder='Cari Data'>
              </td>
              <td colspan="2" class="center">
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
              <th width="15%" class="center">Kode Kriteria</th>
              <th width="30%" class="center">Nama Kriteria</th>
              <th width="15%" class="center">Bobot Kriteria</th>
              <th width="15%" class="center">Tipe Kriteria</th> 
              <th width="5%" class="center">Tahun Penilaian</th> 
              <th width="16%" colspan='2' class="center">Opsi</th> 
            </tr> 
          </thead> 
          <tbody> 
           <?php
            $n = $page+1;
            foreach ($kriteria as $k) {
              echo '
                <tr>
                  <td widtd="5%" class="center">'.$n++.'</td>
                  <td widtd="15%" class="">'.$k['kode_kriteria'].'</td>
                  <td widtd="30%" class="">'.$k['nama_kriteria'].'</td>
                  <td widtd="15%" class="">'.$k['bobot'].'</td>
                  <td widtd="15%" class="">'.$k['tipe_kriteria'].'</td>
                  <td widtd="5%" class="">'.$k['tahun_penilaian'].'</td>';                  
                  if($this->session->userdata('rule')==1){
                    echo'<td widtd="8%" class="center">'; 
                    echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/kriteria/edit_kriteria/'.$this->encrypt->encode($k['id_kriteria']).'">';
                    echo '<i class="ace-icon fa fa-pencil bigger-120"></i>';
                    echo '</a></td>';
                    echo '<td widtd="8%" class="center"><a class="btn btn-xs btn-danger" href="'.base_url().'/index.php/kriteria/hapus_kriteria/'.$this->encrypt->encode($k['id_kriteria']).'">';
                    echo '<i class="ace-icon fa fa-trash-o bigger-120"></i></td>';
                  }else{
                    echo '<td>-</td>';
                    echo '<td>-</td>';
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
function _copydata(){
    $.confirm({
        title: '<b>Copy Data Kriteria</b>',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Dari Tahun</label><br>' +
        '<select class="tahun_p1 form-control" required >'+
        <?php for ($i=2015; $i < 2025; $i++) { 
           echo "'".'<option value="'.$i.'">Tahun '.$i.'</option>'."'+";
        }?> 
        '</select><br><label>Ke Tahun</label><br>'+
        '<select class="tahun_p2 form-control" required >'+
        <?php for ($i=2015; $i < 2025; $i++) { 
           echo "'".'<option value="'.$i.'">Tahun '.$i.'</option>'."'+";
        }?> 
        '</select>'+
        '</div>' +
        '</form>',
        type: 'blue',
        typeAnimated: true,
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var tahun_p1 = this.$content.find('.tahun_p1').val(); 
                    var tahun_p2 = this.$content.find('.tahun_p2').val();
                    $.ajax({
                         url: "<?php echo base_url().'index.php/kriteria/copydata'?>",
                         type: 'post',
                         data: "tahun_p1="+tahun_p1+"&tahun_p2="+tahun_p2, 
                         beforeSend: function(){
                           $(".hilangkan_table").html("<div class='spinner'><br><img id='img-spinner' src='<?php echo base_url(); ?>assets/load.gif' ><br><b>Loading Proses</b></div>");
                         },  
                         success: function(response){
                            window.location ="<?php echo base_url().'index.php/kriteria'?>";
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

 
 
