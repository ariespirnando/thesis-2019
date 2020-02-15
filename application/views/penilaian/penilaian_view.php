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
						Penilaian 
					</h1>
				</div>
        <?php if($this->session->userdata('rule')==2){ ?>
				<div class="pull-right"><a href='<?php echo $add ?>' class="btn btn-xs btn-primary">Tambah Penilaian</a></div>
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
        <form method="post" action="<?php echo base_url().'index.php/penilaian' ?>">
        <table id="table" class="table table-striped table-bordered table-hover" width="90%">
          <thead>
            <tr> 
              <td colspan="4" class="center">
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
              <th width="15%" class="center">Nama Divisi</th>
              <th width="15%" class="center">Tahun Penilaian</th>
              <th width="15%" class="center">Status Penilaian</th>   
              <th width="16%" colspan='2' class="center">Opsi</th> 
            </tr> 
          </thead> 
          <tbody> 
           <?php
            $n = $page+1;
            foreach ($penilaian as $k) {
              echo '
                <tr>
                  <td widtd="5%" class="center">'.$n++.'</td>
                  <td widtd="15%" class="">'.$k['nama_divisi'].'</td>
                  <td widtd="15%" class="">'.$k['tahun_penilaian'].'</td>
                  <td widtd="15%" class="">'.$k['status'].'</td>';
                  if($this->session->userdata('rule')==2){
                    echo'<td widtd="8%" class="center">'; 
                    if($k['status']=='Draft'){
                      echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/penilaian/edit_penilaian/'.$this->encrypt->encode($k['id_penilaian']).'">';
                      echo '<i class="ace-icon fa fa-pencil bigger-120"></i>';
                      echo '</a>';
                    }else{
                      echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/penilaian/view_penilaian/'.$this->encrypt->encode($k['id_penilaian']).'">'; 
                      echo '<i class="ace-icon fa fa-eye bigger-120"></i>';
                      echo '</a>';
                    }
                    echo '</td><td widtd="8%" class="center">';
                    if($k['status']=='Draft'){
                      echo '<a class="btn btn-xs btn-danger" href="'.base_url().'/index.php/penilaian/hapus_penilaian/'.$this->encrypt->encode($k['id_penilaian']).'">';
                      echo '<i class="ace-icon fa fa-trash-o bigger-120"></i>';
                      echo '</a>';
                    }else{
                      echo '-';
                    }
                    echo '</td>';
                  }else if($this->session->userdata('rule')==4){
                    echo '<td class="center">';
                    echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/penilaian/view_penilaian/'.$this->encrypt->encode($k['id_penilaian']).'">'; 
                    echo '<i class="ace-icon fa fa-eye bigger-120"></i>';
                    echo '</a>';
                    echo '</td>';
                    if($k['status']=='Waiting Review'){
                      echo '<td class="center">';
                      ?>
                      <span class="btn btn-xs btn-primary" onclick="_costume_update('<?php echo $k['nama_divisi'] ?>','<?php echo $k['tahun_penilaian'] ?>','<?php echo $k['id_penilaian'] ?>')"> 
                      <i class="ace-icon fa fa-check bigger-120"></i></span>
                      <?php 
                      echo '</td>';
                    }else{ 
                      echo '<td></td>';
                    }
                  }else{
                    echo '<td colspan="2" class="center">'; 
                    echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/penilaian/view_penilaian/'.$this->encrypt->encode($k['id_penilaian']).'">'; 
                    echo '<i class="ace-icon fa fa-eye bigger-120"></i>';
                    echo '</a>';
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
  function _costume_update(nama,tahun,id){
    $.confirm({
        title: 'Review Penilaian',
        content: '' + 
        '<div class="form-group">' +
        '<label><b>'+nama+'</b>, Tahun Penilaian <b>'+tahun+'</b></label>' + 
        '</div>',
        type: 'blue',
        typeAnimated: true,
        buttons: {
            formSubmit: {
                text: 'Disetujui',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val(); 
                    var tnotes = this.$content.find('.tnotes').val();
                    $.ajax({
                         url: "<?php echo base_url().'index.php/penilaian/review_penilaian'?>",
                         type: 'post', 
                         data: "id="+id, 
                         beforeSend: function(){
                           $(".hilangkan_table").html("<div class='spinner'><br><img id='img-spinner' src='<?php echo base_url(); ?>assets/load.gif' ><br><b>Loading Review Penilaian Tahun "+tahun+"</b></div>");
                         }, 
                         success: function(response){
                            window.location ="<?php echo base_url().'index.php/penilaian'?>";
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

 
 
