<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Master Sub kriteria 
					</h1>
				</div>
        <?php if($this->session->userdata('rule')==1){ ?>
				<div class="pull-right"><a href='<?php echo $add ?>' class="btn btn-xs btn-primary">Tambah Sub kriteria</a></div>
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
        <form method="post" action="<?php echo base_url().'index.php/subkriteria' ?>">
        <table id="table" class="table table-striped table-bordered table-hover" width="90%">
          <thead>
            <tr> 
              <td colspan="5" class="center">
                <input type="text" class="form-control btn-xs" name="search" value="<?php echo $search ?>" placeholder='Cari Data'>
              </td>
              <?php if($this->session->userdata('rule')==1){ ?>
              <td colspan="2" class="center">
              <?php }else{ echo '<td class="center">'; }?>
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
              <th width="15%" class="center">Kode Sub kriteria</th>
              <th width="30%" class="center">Keterangan</th>
              <th width="30%" class="center">Nama kriteria</th>  
              <th width="5%" class="center">Tahun Penilaian</th> 
              <?php if($this->session->userdata('rule')==1){ ?>
              <th width="16%" colspan='2' class="center">Opsi</th> 
              <?php }else{ echo '<td width="16%" class="center">Opsi</th>'; }?>
            </tr> 
          </thead> 
          <tbody> 
           <?php
            $n = $page+1;
            foreach ($subkriteria as $k) {
              echo '
                <tr>
                  <td widtd="5%" class="center">'.$n++.'</td>
                  <td widtd="15%" class="">'.$k['kode_subkriteria'].'</td>
                  <td widtd="30%" class="">'.$k['keterangan'].'</td>
                  <td widtd="30%" class="">'.$k['nama_kriteria'].'</td>
                  <td widtd="5%" class="">'.$k['tahun_penilaian'].'</td>';
                  if($this->session->userdata('rule')==1){
                    echo'<td widtd="8%" class="center">'; 
                    echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/subkriteria/edit_subkriteria/'.$this->encrypt->encode($k['id_subkriteria']).'">';
                    echo '<i class="ace-icon fa fa-pencil bigger-120"></i>';
                    echo '</a></td>';
                    echo '<td widtd="8%" class="center"><a class="btn btn-xs btn-danger" href="'.base_url().'/index.php/subkriteria/hapus_subkriteria/'.$this->encrypt->encode($k['id_subkriteria']).'">';
                    echo '<i class="ace-icon fa fa-trash-o bigger-120"></i></td>';
                  }else{
                    echo '<td class="center">';
                    echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/subkriteria/view_subkriteria/'.$this->encrypt->encode($k['id_subkriteria']).'">';
                    echo '<i class="ace-icon fa fa-eye bigger-120"></i>';
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
			<div class="hr hr2 hr-double"></div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

 
 
