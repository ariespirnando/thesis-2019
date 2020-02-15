<ul class="nav nav-list">
	<?php
	$class = '';
	if($modul=='Home'){
		$class = 'active open';
	}
	?>
	<li class="<?php echo $class ?>">
		<a href="<?php echo base_url()?>index.php/home">
			<i class="menu-icon fa fa-home"></i>
			<span class="menu-text"> Home </span>
		</a>

		<b class="arrow"></b>
	</li>
<?php if($this->session->userdata('rule')!=5){ ?> 
	<?php
	$class = '';
	if($modul=='Transaksi'){
		$class = 'active open';
	}
	?>
	 <li class="<?php echo $class ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-desktop"></i>
			<span class="menu-text">
				Transaksi
			</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="">
				<a href="<?php echo base_url()?>index.php/penilaian">
					<i class="menu-icon fa fa-caret-right"></i>
					Penilaian
				</a>

				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="<?php echo base_url()?>index.php/seleksi">
					<i class="menu-icon fa fa-caret-right"></i>
					Seleksi & Peringkat
				</a> 
				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="<?php echo base_url()?>index.php/keputusan">
					<i class="menu-icon fa fa-caret-right"></i>
					Keputusan
				</a>
				<b class="arrow"></b>
			</li>

		</ul>
	</li>
	<?php
	$class = '';
	if($modul=='Master'){
		$class = 'active open';
	}
	?>
	 <li class="<?php echo $class ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text">
				Master
			</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<?php if($this->session->userdata('rule')==1){ ?> 
				<li class="">
					<a href="<?php echo base_url()?>index.php/divisi">
						<i class="menu-icon fa fa-caret-right"></i>
						Master Divisi
					</a> 
					<b class="arrow"></b>
				</li> 
				<li class="">
					<a href="<?php echo base_url()?>index.php/kriteria">
						<i class="menu-icon fa fa-caret-right"></i>
						Master Kriteria
					</a> 
					<b class="arrow"></b>
				</li> 
				<li class="">
					<a href="<?php echo base_url()?>index.php/subkriteria">
						<i class="menu-icon fa fa-caret-right"></i>
						Master Sub Kriteria
					</a> 
					<b class="arrow"></b>
				</li> 
			<?php }?> 
			<li class="">
				<a href="<?php echo base_url()?>index.php/aturan">
					<i class="menu-icon fa fa-caret-right"></i>
					Master Aturan
				</a> 
				<b class="arrow"></b>
			</li> 
		</ul>
	</li>

	<?php
	$class = '';
	if($modul=='Laporan'){
		$class = 'active open';
	}
	?>
	 <li class="<?php echo $class ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text">
				Laporan
			</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="">
				<a href="<?php echo base_url().'index.php/laporan'?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Laporan Penilaian
				</a> 
				<b class="arrow"></b>
			</li> 
		</ul>
		 
	</li>
<?php }?>

	<?php
	$class = '';
	if($modul=='Pengaturan'){
		$class = 'active open';
	}
	?>

	<li class="<?php echo $class ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-gear"></i>
			<span class="menu-text">
				Pengaturan
			</span>
			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<?php if($this->session->userdata('rule')==5){ ?> 
			<li class="">
				<a href="<?php echo base_url().'index.php/pengguna' ?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Pengguna
				</a> 
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?php echo base_url().'index.php/pengguna/ganti_pwpengguna'?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Ubah Password
				</a> 
				<b class="arrow"></b>
			</li> 
			<?php }else{?>

			<li class="">
				<a href="<?php echo base_url().'index.php/pengguna/ganti_pwpengguna'?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Ubah Password
				</a> 
				<b class="arrow"></b>
			</li>  
			<li class="">
				<a href="<?php echo base_url().'index.php/login/logout'?>">
					<i class="menu-icon fa fa-caret-right"></i>
					Keluar Sistem
				</a> 
				<b class="arrow"></b>
			</li> 
			<?php }?> 
		</ul> 
	</li> 
</ul><!-- /.nav-list -->
