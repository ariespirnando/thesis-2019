<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleksi extends CI_Controller {
	public function __construct(){    
	  parent::__construct();  
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      } 
	  $this->load->model(array('Seleksi_model'));
      $this->load->library('pagination');
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/seleksi/add_seleksi';
		$data['modul'] = 'Transaksi';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_seleksi"=>$search_text));
	    }else{
	      if($this->session->userdata('search_seleksi') != NULL){
	        $search_text = $this->session->userdata('search_seleksi');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_seleksi"=>$search_text));
	    }

        $config['base_url'] = site_url('seleksi/index');   
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        if($search_text==""){
        	$config['total_rows'] = $this->db->count_all('seleksi'); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['seleksi'] = $this->Seleksi_model->get_seleksi_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Seleksi_model->get_count_seleksi_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['seleksi'] = $this->Seleksi_model->get_seleksi_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $this->template->load('template_wp','seleksi/seleksi_view', $data);
	} 

	function add_seleksi(){
		$data['action'] = base_url().'index.php/seleksi/save_seleksi';
		$data['res']	= array();
		$data['modul'] = 'Transaksi';
		$this->template->load('template_wp','seleksi/seleksi_add', $data);
	}

	function hapus_seleksi(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_seleksi',$id);
		$cek = $this->db->get('seleksi');  
		if($cek->num_rows()>0){
			$dt = $cek->row_array();
			$this->db->where('id_seleksi',$id);
			$delete = $this->db->delete('seleksi'); 
			if($delete){
				$this->session->set_flashdata('message', 'Seleksi tahun penilaian <b>'.$dt['tahun_penilaian'].'</b> berhasil Dihapus');
				$this->session->set_flashdata('info', '1');
  				redirect(site_url('seleksi'));
			}else{
				$this->session->set_flashdata('message', 'Seleksi gagal Dihapus');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('seleksi'));
			}
		}else{
			$this->session->set_flashdata('message', 'Seleksi gagal Dihapus');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('seleksi'));
		}
			
	}

	function save_seleksi(){
		$keterangan = $this->input->post('keterangan');
		$tahun_penilaian = $this->input->post('tahun_penilaian');   
		if($tahun_penilaian==''){
			$this->session->set_flashdata('message', 'Tahun penilaian tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('seleksi/add_seleksi'));
		}else{
			$dataSimpan = array(
				'keterangan'=>$keterangan,
				'tahun_penilaian'=>$tahun_penilaian,   
				'status_seleksi' =>'Belum diproses seleksi',
				'status_keputusan' =>'Menunggu Keputusan', 
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 

			$cek = $this->Seleksi_model->cek_seleksi($tahun_penilaian);
			if($cek>0){
				$this->session->set_flashdata('message', 'Seleksi Tahun penilaian <b>'.$tahun_penilaian.'</b> sudah tersedia');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('seleksi/add_seleksi')); 
			}else{
				$insert = $this->db->insert('seleksi',$dataSimpan);
				if($insert){
					$this->session->set_flashdata('message', 'Seleksi Tahun penilaian <b>'.$tahun_penilaian.'</b> berhasil Ditambahkan');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('seleksi'));
				}else{
					$this->session->set_flashdata('message', 'Seleksi Tahun penilaian <b>'.$tahun_penilaian.'</b> gagal Ditambahkan');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('seleksi/add_seleksi'));
				} 
			} 
		}
	}

	function viewd1_seleksi(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_seleksi',$id);
		$dt = $this->db->get('seleksi')->row_array(); 
		$data['res'] = $dt; 
		
		$data['kriteria'] = $this->db->query('SELECT COUNT(k.`id_kriteria`) AS totalrand,
			k.`kode_kriteria`, k.`nama_kriteria` 
			FROM `master_subkriteria` s JOIN `master_kriteria` k 
			ON k.`id_kriteria` = s.`id_kriteria` WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			GROUP BY k.`id_kriteria` ORDER BY k.`id_kriteria`')->result_array();
		$data['subkritera'] = $this->db->query('SELECT s.`id_subkriteria`, s.`kode_subkriteria`, k.`id_kriteria`
			FROM `master_subkriteria` s JOIN `master_kriteria` k ON k.`id_kriteria` = s.`id_kriteria`
			WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			ORDER BY k.`id_kriteria`')->result_array();
		$data['penilaian'] = $this->db->query('SELECT p.`id_divisi`, p.`id_penilaian`, p.`tahun_penilaian`,m.`kode_divisi`, m.`nama_divisi`
			FROM `penilaian` p JOIN `master_divisi` m ON m.`id_divisi` = p.`id_divisi`
			WHERE p.`status`="Finish" AND p.`tahun_penilaian`='.$dt['tahun_penilaian'])->result_array(); 

		$data['modul'] = 'Transaksi';
		$this->template->load('template_wp','seleksi/seleksi_viewd1', $data); 
	}

	function viewd2_seleksi(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_seleksi',$id);
		$dt = $this->db->get('seleksi')->row_array(); 
		$data['res'] = $dt; 
		
		$data['kriteria'] = $this->db->query('SELECT COUNT(k.`id_kriteria`) AS totalrand,
			k.`kode_kriteria`, k.`nama_kriteria` 
			FROM `master_subkriteria` s JOIN `master_kriteria` k 
			ON k.`id_kriteria` = s.`id_kriteria` WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			GROUP BY k.`id_kriteria` ORDER BY k.`id_kriteria`')->result_array();
		$data['subkritera'] = $this->db->query('SELECT s.`id_subkriteria`, s.`kode_subkriteria`, k.`id_kriteria`
			FROM `master_subkriteria` s JOIN `master_kriteria` k ON k.`id_kriteria` = s.`id_kriteria`
			WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			ORDER BY k.`id_kriteria`')->result_array();
		$data['penilaian'] = $this->db->query('SELECT p.`id_divisi`, p.`id_penilaian`, p.`tahun_penilaian`,m.`kode_divisi`, m.`nama_divisi`
			FROM `penilaian` p JOIN `master_divisi` m ON m.`id_divisi` = p.`id_divisi`
			WHERE p.`status`="Finish" AND p.`tahun_penilaian`='.$dt['tahun_penilaian'].' ORDER BY m.id_divisi')->result_array(); 

		$data['kriteria_seleksi'] =$this->db->query('SELECT shd.`id_kriteria`, mk.`nama_kriteria`, mk.kode_kriteria FROM seleksi_hasil sh 
			JOIN seleksi_hasildetail shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			JOIN master_kriteria mk ON mk.`id_kriteria` = shd.`id_kriteria`
			WHERE sh.`id_seleksi` = '.$id.' GROUP BY shd.`id_kriteria` ORDER BY shd.`id_kriteria` ')->result_array();
		$data['penilaian_seleksi']=$this->db->query('SELECT md.kode_divisi, sh.`id_seleksi_hasil`, sh.`id_seleksi`, sh.`id_divisi`, md.`nama_divisi`, sh.`hasil` 
			FROM seleksi_hasil sh JOIN master_divisi md ON md.`id_divisi` = sh.`id_divisi`
			WHERE sh.`id_seleksi` = '.$id.' ORDER BY md.`id_divisi`')->result_array();

		$data['modul'] = 'Transaksi';
		$this->template->load('template_wp','seleksi/seleksi_viewd2', $data); 
	}

	function viewd3_seleksi(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_seleksi',$id);
		$dt = $this->db->get('seleksi')->row_array(); 
		$data['res'] = $dt; 
		
		$data['kriteria'] = $this->db->query('SELECT COUNT(k.`id_kriteria`) AS totalrand,
			k.`kode_kriteria`, k.`nama_kriteria` 
			FROM `master_subkriteria` s JOIN `master_kriteria` k 
			ON k.`id_kriteria` = s.`id_kriteria` WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			GROUP BY k.`id_kriteria` ORDER BY k.`id_kriteria`')->result_array();
		$data['subkritera'] = $this->db->query('SELECT s.`id_subkriteria`, s.`kode_subkriteria`, k.`id_kriteria`
			FROM `master_subkriteria` s JOIN `master_kriteria` k ON k.`id_kriteria` = s.`id_kriteria`
			WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			ORDER BY k.`id_kriteria`')->result_array();
		$data['penilaian'] = $this->db->query('SELECT p.`id_divisi`, p.`id_penilaian`, p.`tahun_penilaian`,m.`kode_divisi`, m.`nama_divisi`
			FROM `penilaian` p JOIN `master_divisi` m ON m.`id_divisi` = p.`id_divisi`
			WHERE p.`status`="Finish" AND p.`tahun_penilaian`='.$dt['tahun_penilaian'].' ORDER BY m.id_divisi')->result_array(); 

		$data['kriteria_seleksi'] =$this->db->query('SELECT shd.`id_kriteria`, mk.`nama_kriteria`, mk.kode_kriteria FROM seleksi_hasil sh 
			JOIN seleksi_hasildetail shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			JOIN master_kriteria mk ON mk.`id_kriteria` = shd.`id_kriteria`
			WHERE sh.`id_seleksi` = '.$id.' GROUP BY shd.`id_kriteria` ORDER BY shd.`id_kriteria` ')->result_array();
		$data['penilaian_seleksi']=$this->db->query('SELECT md.kode_divisi, sh.`id_seleksi_hasil`, sh.`id_seleksi`, sh.`id_divisi`, md.`nama_divisi`, sh.`hasil` 
			FROM seleksi_hasil sh JOIN master_divisi md ON md.`id_divisi` = sh.`id_divisi`
			WHERE sh.`id_seleksi` = '.$id.' ORDER BY md.`id_divisi`')->result_array();

		$data['modul'] = 'Transaksi';
		$this->template->load('template_wp','seleksi/seleksi_viewd3', $data); 
	}

	function seleksi_view(){
		$id =  $this->input->post('id');
		$tipe =  $this->input->post('tipe');
		$this->db->where('id_seleksi',$id);
		$dt = $this->db->get('seleksi')->row_array(); 
		$data['res'] = $dt; 
		
		$data['kriteria'] = $this->db->query('SELECT COUNT(k.`id_kriteria`) AS totalrand,
			k.`kode_kriteria`, k.`nama_kriteria` 
			FROM `master_subkriteria` s JOIN `master_kriteria` k 
			ON k.`id_kriteria` = s.`id_kriteria` WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			GROUP BY k.`id_kriteria` ORDER BY k.`id_kriteria`')->result_array();
		$data['subkritera'] = $this->db->query('SELECT s.`id_subkriteria`, s.`kode_subkriteria`, k.`id_kriteria`
			FROM `master_subkriteria` s JOIN `master_kriteria` k ON k.`id_kriteria` = s.`id_kriteria`
			WHERE k.tahun_penilaian = '.$dt['tahun_penilaian'].'
			ORDER BY k.`id_kriteria`')->result_array();
		$data['penilaian'] = $this->db->query('SELECT p.`id_divisi`, p.`id_penilaian`, p.`tahun_penilaian`,m.`kode_divisi`, m.`nama_divisi`
			FROM `penilaian` p JOIN `master_divisi` m ON m.`id_divisi` = p.`id_divisi`
			WHERE p.`status`="Finish" AND p.`tahun_penilaian`='.$dt['tahun_penilaian'].' ORDER BY m.id_divisi')->result_array(); 

		$data['kriteria_seleksi'] =$this->db->query('SELECT shd.`id_kriteria`, mk.bobot, mk.`nama_kriteria`, mk.kode_kriteria FROM seleksi_hasil sh 
			JOIN seleksi_hasildetail shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			JOIN master_kriteria mk ON mk.`id_kriteria` = shd.`id_kriteria`
			WHERE sh.`id_seleksi` = '.$id.' GROUP BY shd.`id_kriteria` ORDER BY shd.`id_kriteria` ')->result_array();
		$data['penilaian_seleksi']=$this->db->query('SELECT md.kode_divisi, sh.`id_seleksi_hasil`, sh.`id_seleksi`, sh.`id_divisi`, md.`nama_divisi`, sh.`hasil` 
			FROM seleksi_hasil sh JOIN master_divisi md ON md.`id_divisi` = sh.`id_divisi`
			WHERE sh.`id_seleksi` = '.$id.' ORDER BY md.`id_divisi`')->result_array();
		$data['penilaian_seleksi2']=$this->db->query('SELECT sh.apositif, sh.anegatif, md.kode_divisi, sh.`id_seleksi_hasil`, sh.`id_seleksi`, sh.`id_divisi`, md.`nama_divisi`, sh.`hasil` 
			FROM seleksi_hasil sh JOIN master_divisi md ON md.`id_divisi` = sh.`id_divisi`
			WHERE sh.`id_seleksi` = '.$id.' AND hasil = "Dilanjutkan" ORDER BY md.`id_divisi`')->result_array();
		$data['preferensi_seleksi']=$this->db->query('SELECT  md.`nama_divisi`, md.`kode_divisi`, sh.`peringkat`, sh.`prefrensi`
			FROM seleksi_hasil sh JOIN master_divisi md ON md.`id_divisi` = sh.`id_divisi`
			WHERE sh.`id_seleksi` = '.$id.' AND hasil = "Dilanjutkan" ORDER BY sh.`peringkat`')->result_array();
		$data['solusi_ideal'] = $this->db->query('SELECT p.`id_kriteria`, p.`idealnegatif`, p.`idealpositif` , m.`nama_kriteria`, m.`kode_kriteria` FROM `param_matrik` p 
			JOIN `master_kriteria` m ON p.`id_kriteria` = m.`id_kriteria`	
			WHERE p.`id_seleksi` ='.$id.' ORDER BY p.`id_kriteria`')->result_array();

		if($tipe==1){
			echo $this->load->view('seleksi/penilaian_view',$data,true); 
		}else{
			echo $this->load->view('seleksi/peringkat_view',$data,true);
		} 
	}

	function seleksi_topsis(){
		$id_seleksi = $this->input->post('id');
		$tahun = $this->input->post('tahun');
		$this->topsisproses($id_seleksi);   
		$this->db->set('status_seleksi','Sudah diproses');
		$this->db->where('id_seleksi',$id_seleksi);
		$this->db->where('tahun_penilaian',$tahun);
		$this->db->update('seleksi'); 
		$this->session->set_flashdata('message', 'Seleksi Tahun penilaian <b>'.$tahun.'</b>, status diubah menjadi <b>Sudah diproses</b>');
		$this->session->set_flashdata('info', '1');  
	}
	function seleksi_rulebase(){
		$id_seleksi = $this->input->post('id');
		$tahun = $this->input->post('tahun');

		$cek = $this->db->query("SELECT p.`id_penilaian` FROM `penilaian` p
		WHERE p.`status`='Finish'  AND p.`tahun_penilaian`='".$tahun."'")->num_rows();  
		if($cek>0){ 
			$this->rulebaseproses($id_seleksi);  
			$this->db->set('status_seleksi','Belum diproses pemeringkatan');
			$this->db->where('id_seleksi',$id_seleksi);
			$this->db->where('tahun_penilaian',$tahun);
			$this->db->update('seleksi');  
			$this->session->set_flashdata('message', 'Seleksi Tahun penilaian <b>'.$tahun.'</b>, status diubah menjadi <b>Belum diproses pemeringkatan</b>');
			$this->session->set_flashdata('info', '1'); 
		}else{
			$this->session->set_flashdata('message', 'Seleksi Tahun penilaian <b>'.$tahun.'</b>, data <b>tidak Ditemukan</b>');
			$this->session->set_flashdata('info', '2'); 
		}
	}

	function topsisproses($id_seleksi){
		$this->db->where('id_seleksi',$id_seleksi);
		$dt = $this->db->get('seleksi')->row_array(); 
		$matsim = $this->db->query("SELECT FORMAT(SQRT(SUM(POW(shd.`nilai_awal`,2))),4) AS nilai, shd.`id_kriteria`  
			FROM seleksi_hasil sh JOIN `seleksi_hasildetail` shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			WHERE sh.`hasil` = 'Dilanjutkan' AND sh.`id_seleksi`= ".$id_seleksi." GROUP BY shd.`id_kriteria` 
			ORDER BY shd.`id_kriteria`")->result_array();
		$parammatrik = array();
		$this->db->where('id_seleksi',$id_seleksi);
		$this->db->delete('param_matrik');
		foreach ($matsim as $m) { 
			$simpan = array();
			$simpan['dibuat_oleh']  = $this->session->userdata('id_pengguna');
			$simpan['nilai'] 		= $m['nilai'];
			$simpan['id_kriteria'] 	= $m['id_kriteria'];
			$simpan['id_seleksi']   = $id_seleksi;
			$this->db->insert('param_matrik',$simpan); 
  			$parammatrik[$m['id_kriteria']] = $m['nilai']; 
		}   
		$queryMatriktnn = $this->db->query("SELECT shd.`id_seleksi_hasildetail`, sh.`id_seleksi`, shd.`nilai_awal`, shd.`id_kriteria` 
			FROM seleksi_hasil sh JOIN `seleksi_hasildetail` shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			WHERE sh.`hasil` = 'Dilanjutkan' AND sh.`id_seleksi`= ".$id_seleksi." ORDER BY shd.`id_kriteria`")->result_array();
		foreach ($queryMatriktnn as $qm) {
			$nilaiawal = $qm['nilai_awal'] / $parammatrik[$qm['id_kriteria']];
			$nilai_normalisasi = number_format($nilaiawal,4);
			$this->db->set('nilai_normalisasi',$nilai_normalisasi);
			$this->db->where('id_seleksi_hasildetail',$qm['id_seleksi_hasildetail']); 
			$this->db->where('id_kriteria',$qm['id_kriteria']);
			$this->db->update('seleksi_hasildetail');
		}
		$bobotmatrik = array(); 
		$kriteria = $this->db->query("SELECT `id_kriteria`, bobot, tipe_kriteria FROM master_kriteria WHERE tahun_penilaian=".$dt['tahun_penilaian'])->result_array();
		foreach ($kriteria as $b) { 
			$bobotmatrik[$b['id_kriteria']] = $b['bobot'];     
		}
		$queryMatriktbb = $this->db->query("SELECT shd.`id_seleksi_hasildetail`, sh.`id_seleksi`, shd.`nilai_normalisasi`, shd.`id_kriteria` 
			FROM seleksi_hasil sh JOIN `seleksi_hasildetail` shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			WHERE sh.`hasil` = 'Dilanjutkan' AND sh.`id_seleksi`= ".$id_seleksi." ORDER BY shd.`id_kriteria`")->result_array();
		foreach ($queryMatriktbb as $qm) {
			$nilaiawal = $qm['nilai_normalisasi'] * $bobotmatrik[$qm['id_kriteria']];
			$nilai_terbobot = number_format($nilaiawal,4);
			$this->db->set('nilai_terbobot',$nilai_terbobot);
			$this->db->where('id_seleksi_hasildetail',$qm['id_seleksi_hasildetail']); 
			$this->db->where('id_kriteria',$qm['id_kriteria']);
			$this->db->update('seleksi_hasildetail');
		}
		$nilaiMax = array();
		$nilaiMin = array();
		$queryNilaiMaxmin = $this->db->query("SELECT FORMAT(MAX(shd.`nilai_terbobot`),4) AS nilaiMax, FORMAT(MIN(shd.`nilai_terbobot`),4) AS nilaiMin, shd.`id_kriteria`
			FROM seleksi_hasil sh JOIN `seleksi_hasildetail` shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			WHERE sh.`hasil` = 'Dilanjutkan' AND sh.`id_seleksi`= ".$id_seleksi." 
			GROUP BY shd.`id_kriteria` ORDER BY shd.`id_kriteria`")->result_array();
		foreach ($queryNilaiMaxmin as $qm) {
			$nilaiMin[$qm['id_kriteria']] = $qm['nilaiMin']; 
			$nilaiMax[$qm['id_kriteria']] = $qm['nilaiMax']; 
		} 
		foreach ($kriteria as $b) {  
			$idealpositif = $nilaiMin[$b['id_kriteria']]; 
			if($b['tipe_kriteria']=='Benefit'){
				$idealpositif = $nilaiMax[$b['id_kriteria']];
			}

			$idealnegatif = $nilaiMin[$b['id_kriteria']];
			if($b['tipe_kriteria']=='Benefit'){
				$idealnegatif = $nilaiMin[$b['id_kriteria']]; 
			}  
			$this->db->set('idealnegatif',$idealnegatif);
			$this->db->set('idealpositif',$idealpositif);
			$this->db->where('id_seleksi',$id_seleksi);
			$this->db->where('id_kriteria',$b['id_kriteria']); 
			$this->db->update('param_matrik'); 
		}
		$queryseparation = $this->db->query("SELECT sh.`id_seleksi_hasil`, sh.`id_seleksi`,
			FORMAT(SUM(SQRT(pm.`idealpositif`- shd.`nilai_terbobot`)),4) AS apositif,
			FORMAT(SUM(SQRT(shd.`nilai_terbobot`-pm.`idealnegatif`)),4) AS anegatif
			FROM seleksi_hasil sh JOIN `seleksi_hasildetail` shd ON sh.`id_seleksi_hasil` = shd.`id_seleksi_hasil`
			JOIN param_matrik pm ON pm.`id_seleksi` = sh.`id_seleksi` AND pm.`id_kriteria` = shd.`id_kriteria`
			WHERE sh.`hasil` = 'Dilanjutkan' AND sh.`id_seleksi`= ".$id_seleksi." 
			GROUP BY shd.`id_seleksi_hasil` ORDER BY shd.`id_seleksi_hasil`") ->result_array();
		foreach ($queryseparation as $qs) {
			$this->db->set('apositif',$qs['apositif']);
			$this->db->set('anegatif',$qs['anegatif']);
			$this->db->where('id_seleksi_hasil',$qs['id_seleksi_hasil']);
			$this->db->where('id_seleksi',$id_seleksi);
			$this->db->update('seleksi_hasil'); 
		}
		$queryprefrensi = $this->db->query("SELECT sh.`id_seleksi`, sh.`id_seleksi_hasil`,
			FORMAT((sh.anegatif/(sh.apositif+sh.anegatif)),4) AS prefrensi
			FROM `seleksi_hasil` sh WHERE sh.`id_seleksi` = ".$id_seleksi."  AND sh.`hasil` = 'Dilanjutkan'
			ORDER BY (sh.anegatif/(sh.apositif+sh.anegatif)) DESC")->result_array();
		$rank = 1;
		foreach ($queryprefrensi as $qp) {
			$this->db->set('prefrensi',$qp['prefrensi']);
			$this->db->set('peringkat',$rank);
			$this->db->where('id_seleksi_hasil',$qp['id_seleksi_hasil']);
			$this->db->where('id_seleksi',$id_seleksi);
			$this->db->update('seleksi_hasil'); 
			$rank++;
		}
	}

	function rulebaseproses($id_seleksi){
		$this->db->where('id_seleksi',$id_seleksi);
		$dt = $this->db->get('seleksi')->row_array();  
		//Prosess Seleksi penilaian sub kriteria 
		$query = "SELECT p.`id_penilaian`, pd.`id_kriteria`, pd.`id_subkriteria`, pd.`id_subkriteriadetail`,
					       pd.`id_penilaian_detail`, ms.`nilai_awal`, ms.`nilai_akhir`,  ma.`nilai`, ma.`kondisi`
					FROM `penilaian` p JOIN `penilaian_detail` pd ON pd.`id_penilaian` = p.`id_penilaian`
					JOIN `master_subkriteriadetail` ms ON ms.`id_subkriteriadetail` = pd.`id_subkriteriadetail`
					JOIN `master_aturan` m ON m.`id_kriteria` = pd.`id_kriteria`
					JOIN `master_aturandetail` ma ON ma.`id_aturan` = m.`id_aturan` AND ma.`id_subkriteria` = pd.`id_subkriteria`
					WHERE p.`status`='Finish'  AND p.`tahun_penilaian`='".$dt['tahun_penilaian']."'"; 
		$aturanCek = $this->db->query($query)->result_array();
		foreach ($aturanCek as $a) {
			$hasil = 'TMS';    
			if($a['kondisi']=='MIN'){
				if(($a['nilai'] <= $a['nilai_awal'])|| ($a['nilai'] <= $a['nilai_akhir'])){
					$hasil ='MS';
				} 
			}else if($a['kondisi']=='MAX'){ 
				if(($a['nilai'] >= $a['nilai_awal'])|| ($a['nilai'] >= $a['nilai_akhir'])){
					$hasil ='MS';
				}
			} 
			$this->db->set('hasil', $hasil);
			$this->db->where('id_subkriteria',$a['id_subkriteria']);
			$this->db->where('id_kriteria',$a['id_kriteria']);
			$this->db->where('id_penilaian',$a['id_penilaian']);
			$this->db->where('id_penilaian_detail',$a['id_penilaian_detail']);
			$this->db->where('id_subkriteriadetail',$a['id_subkriteriadetail']);
			$this->db->update('penilaian_detail'); 
		} 
		//Prosess Seleksi penilaian kriteria dan pindah ketabel hasil_seleksi 
		$param  = 'SELECT paramMax FROM `master_aturancustume` LIMIT 1';
		$paramd = $this->db->query($param)->row_array();
		if(empty($paramd['paramMax'])){
			$paramd['paramMax'] = 0;
		}  
		//Tampung Kriteria didalam array
		$query_kriteria = 'SELECT id_kriteria FROM master_kriteria WHERE tahun_penilaian="'.$dt['tahun_penilaian'].'"';
		$kriteria = $this->db->query($query_kriteria)->result_array(); 		
		$query_penilaian ="SELECT id_penilaian, id_divisi FROM penilaian";
		$divisi = $this->db->query($query_penilaian)->result_array();
		foreach ($divisi as $d) {
			$simdiv = array();
			$simdiv['id_seleksi'] 	= $id_seleksi;
			$simdiv['id_divisi'] 	= $d['id_divisi'];
			$simdiv['dibuat_oleh'] 	= $this->session->userdata('id_pengguna');
			$this->db->insert('seleksi_hasil',$simdiv);
			$id_seleksi_hasil = $this->db->insert_id(); 
			$cekTMS = 0; 
			$cekMS = 0; 
			foreach ($kriteria as $k) {
				$query_penilaiandetail = "SELECT AVG(DISTINCT ms.`nilai_aktual`) AS ratarata, 
				(SELECT COUNT(pdif.hasil) FROM penilaian_detail pdif 
					WHERE pdif.`id_penilaian` = ".$d['id_penilaian']." AND pdif.`id_kriteria` = ".$k['id_kriteria']." 
					AND pdif.hasil='MS') AS totalms, 
				COUNT(pd.hasil) AS totalall
				FROM penilaian_detail pd JOIN `master_subkriteriadetail` ms 
				ON ms.`id_subkriteriadetail` = pd.`id_subkriteriadetail`
				WHERE pd.`id_penilaian` = ".$d['id_penilaian']." AND pd.`id_kriteria` = ".$k['id_kriteria'];
				$cek = $this->db->query($query_penilaiandetail);
				if($cek->num_rows()>0){
					$datap = $cek->row_array(); 
					if($datap['totalms'] == $datap['totalall']){
						$hasil = 'MS';
						$cekMS++;
					}else{
						$hasil = 'TMS';
						$cekTMS++;
					} 
					$simdiv2 = array();
					$simdiv2['id_seleksi_hasil'] = $id_seleksi_hasil;
					$simdiv2['id_kriteria']		 = $k['id_kriteria'];
					$simdiv2['nilai_awal']		 = $datap['ratarata'];
					$simdiv2['hasil'] 			 = $hasil;
					$simdiv2['dibuat_oleh'] 	 = $this->session->userdata('id_pengguna');
					$this->db->insert('seleksi_hasildetail',$simdiv2);
				}
			}	 
			$updatahasil = 'Dilanjutkan';
			if($cekTMS>=$paramd['paramMax']){
				$updatahasil = 'Tidak Dilanjutkan';
			} 
			$this->db->set('hasil',$updatahasil);
			$this->db->where('id_seleksi_hasil',$id_seleksi_hasil);
			$this->db->update('seleksi_hasil');	
		} 
	}
}
