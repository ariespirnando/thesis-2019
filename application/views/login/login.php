<div class="page-content" style="">
	<div class="row" >
		<br>
		<br>
		<div class="col-xs-4">
		</div>
		<div class="col-xs-4">
			<br>
			<div class="clearfix">
        	<div class="page-header pull-right"> 
				</div>
				<div class="pull-right"> </div>
			</div>
			
			<?php
			    if($this->session->userdata('message') <> ''){
			        echo '<div class="alert alert-info">
					            <button class="close" data-dismiss="alert">
												<i class="ace-icon fa fa-times"></i>
											</button>
											'.$this->session->userdata('message').'
			        			</div>';
			    }
			?>
				
			<div>
				<div class="widget-box">  
				 <div class="widget-body">
					 <div class="widget-main no-padding">
						 <form action="<?php echo $action ?>" method="post">
							 <fieldset>  
								<table class="table" width="90%"> 
									<tr>
						 				<td width="20%"><img src="<?php echo base_url(); ?>assets/logo.png" class="login-logo img-responsive"></td>
						 				<td width="70%" style="text-align:left;vertical-align:middle"><h4> PT XYZ Laboratories</h4></td> 
						 			</tr>
								</table>
							 	<table class="table table-bordered " width="90%"> 
							 		<tbody>  
							 			<tr>
							 				<td width="20%">Username</td>
							 				<td width="70%"><input class="form-control" type="text" name="user" value=""></td> 
							 			</tr>
							 			<tr>
							 				<td width="20%">Password</td>
							 				<td width="70%"><input class="form-control" type="password" name="pass" value=""></td> 
							 			</tr> 
							 		</tbody>
							 	</table>
								
								 <br><br>
								 <button type="submit" class="btn btn-lg btn-success">
									 Login
								 </button> 
								 <button type="reset" class="btn btn-lg btn-warning">Reset</button> 
								 <br>
							 </fieldset>
						 </form>
					 </div>
				 </div>
			 </div>
        <br>

			</div> 
		</div><!-- /.col -->

		<div class="col-xs-4">

		</div>

		<div class="col-xs-12"> 
			<br><br><br><br><br><br><br>
		</div>
 
	</div><!-- /.row -->
</div>
