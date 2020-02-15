<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Master Aturan 
					</h1>
				</div>
        <?php if($this->session->userdata('rule')==1){ ?>
				<div class="pull-right"><a href='<?php echo $add ?>' class="btn btn-xs btn-primary">Tambah Aturan</a></div>
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
        <form method="post" action="<?php echo base_url().'index.php/aturan' ?>">
        <table id="table" class="table table-striped table-bordered table-hover" width="90%">
          <thead>
            <tr> 
              <td colspan="4" class="center">
                <input type="text" class="form-control btn-xs" name="search" value="<?php echo $search ?>" placeholder='Cari Data'>
              </td>
              <?php if($this->session->userdata('rule')==1){ $cl = 5;?>
              <td colspan="2" class="center">
              <?php }else{ echo '<td class="center">'; $cl = 4;}?>
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
              <th width="15%" class="center">Kode Aturan</th> 
              <th width="15%" class="center">Ketentuan</th> 
              <th width="30%" class="center">Nama kriteria</th>   
              <?php if($this->session->userdata('rule')==1){ ?>
              <th width="16%" colspan='2' class="center">Opsi</th> 
              <?php }else{ echo '<td width="16%" class="center">Opsi</th>'; }?>
            </tr> 
          </thead> 
          <tbody> 
           <?php
            $n = $page+1;
            foreach ($aturan as $k) {
              echo '
                <tr>
                  <td widtd="5%" class="center">'.$n++.'</td>
                  <td widtd="15%" class="">'.$k['kode_aturan'].'</td> 
                  <td widtd="15%" class="">'.$k['hasil'].'</td> 
                  <td widtd="30%" class="">'.$k['nama_kriteria'].' - Tahun Penilaian '.$k['tahun_penilaian'].'</td>';
                  if($this->session->userdata('rule')==1){
                    $cl = 5;
                    echo'<td widtd="8%" class="center">'; 
                    echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/aturan/edit_aturan/'.$this->encrypt->encode($k['id_aturan']).'">';
                    echo '<i class="ace-icon fa fa-pencil bigger-120"></i>';
                    echo '</a></td>';
                    echo '<td widtd="8%" class="center"><a class="btn btn-xs btn-danger" href="'.base_url().'/index.php/aturan/hapus_aturan/'.$this->encrypt->encode($k['id_aturan']).'">';
                    echo '<i class="ace-icon fa fa-trash-o bigger-120"></i></td>';
                  }else{
                    $cl = 4;
                    echo '<td class="center">';
                    echo '<a class="btn btn-xs btn-warning" href="'.base_url().'/index.php/aturan/view_aturan/'.$this->encrypt->encode($k['id_aturan']).'">';
                    echo '<i class="ace-icon fa fa-eye bigger-120"></i>';
                    echo '</td>'; 
                  } 
                echo '</tr>';
            }
            foreach ($aturancostume as $at) {
              echo '
                <tr>
                  <td widtd="5%" class="center">'.$n++.'</td>
                  <td colspan='.$cl.'>'.$at['keterangan'].'</td> 
                <tr>';
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

 
 
