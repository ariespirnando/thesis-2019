<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="clearfix">
        <div class="page-header">
					<h1>
						Laporan Penilaian
					</h1>
				</div> 
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
        <form method="post" action="<?php echo base_url().'index.php/laporan' ?>">
        <table id="table" class="table table-striped table-bordered table-hover" width="90%">
          <thead>
            <tr>  
              <td colspan="4" class="center"> 
                <input type="text" class="form-control btn-xs" name="search" value="<?php echo $search ?>" placeholder='Cari Data'>
              </td> 
              <td class="center"> 
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
              <th width="5%" class="center">Opsi</th>  
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
                  <td widtd="20%" class="">'.$k['status_keputusan'].'</td>';
                      echo'<td widtd="5%" class="center">';
                      echo '<a class="btn btn-xs btn-primary" target="_blank" href="'.base_url().'/index.php/laporan/print_laporan/'.$this->encrypt->encode($k['id_seleksi']).'">';
                      echo '<i class="ace-icon fa fa-print bigger-120"></i></a>';
                      echo '</td>';  
                     
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
 
 
 
