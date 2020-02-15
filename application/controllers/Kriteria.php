<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {
	public function __construct(){    
	  parent::__construct();  
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      } 
	  $this->load->model(array('Kriteria_model'));
      $this->load->library('pagination');
	}

	function copydata(){
		$tahun_p1 =$this->input->post('tahun_p1');
		$tahun_p2 =$this->input->post('tahun_p2');

		$this->db->where('tahun_penilaian',$tahun_p1);
		if($this->db->get('master_kriteria')->num_rows()>0){
			$this->db->where('tahun_penilaian',$tahun_p2);  
			if($this->db->get('master_kriteria')->num_rows()>0){
				$this->session->set_flashdata('message', 'Kriteria Tahun penilaian <b>'.$tahun_p2.'</b>, data <b>sudah Tersedia</b>');
				$this->session->set_flashdata('info', '2');
			}else{
				$kriteria = $this->db->query("SELECT id_kriteria, kode_kriteria, nama_kriteria, bobot, tipe_kriteria FROM master_kriteria where tahun_penilaian = ".$tahun_p1)->result_array();
				foreach ($kriteria as $k) {
					$simpanK = array();
					$simpanK['kode_kriteria'] = $k['kode_kriteria'];
					$simpanK['nama_kriteria'] = $k['nama_kriteria'];
					$simpanK['bobot'] = $k['bobot'];
					$simpanK['tipe_kriteria'] = $k['tipe_kriteria'];
					$simpanK['tahun_penilaian'] = $tahun_p2;
					$simpanK['dibuat_oleh'] = $this->session->userdata('id_pengguna');
					$this->db->insert('master_kriteria',$simpanK);
					$id_kriteria = $this->db->insert_id();
					$subkriteria = $this->db->query("SELECT id_subkriteria, kode_subkriteria, keterangan,tipe_subkriteria FROM master_subkriteria where id_kriteria = ".$k['id_kriteria'])->result_array();
					foreach ($subkriteria as $sk) {
						$simpanSK = array();
						$simpanSK['kode_subkriteria'] = $sk['kode_subkriteria'];
						$simpanSK['keterangan'] = $sk['keterangan'];
						$simpanSK['id_kriteria'] = $id_kriteria;
						$simpanSK['tipe_subkriteria'] = $sk['tipe_subkriteria']; 
						$simpanSK['dibuat_oleh'] = $this->session->userdata('id_pengguna');
						$this->db->insert('master_subkriteria',$simpanSK);
						$id_subkriteria = $this->db->insert_id();
						$subkriteriadetail = $this->db->query('SELECT keterangan, nilai_akhir, nilai_awal, nilai_aktual, urutan_penilaian FROM master_subkriteriadetail where id_subkriteria = '.$sk['id_subkriteria'])->result_array();
						foreach ($subkriteriadetail as $skd) {
							$simpanSKD = array();
							$simpanSKD['keterangan'] = $skd['keterangan'];
							$simpanSKD['nilai_akhir'] = $skd['nilai_akhir'];
							$simpanSKD['nilai_awal'] = $skd['nilai_awal'];
							$simpanSKD['nilai_aktual']= $skd['nilai_aktual'];
							$simpanSKD['id_subkriteria'] = $id_subkriteria;
							$simpanSKD['urutan_penilaian'] = $skd['urutan_penilaian'];
							$this->db->insert('master_subkriteriadetail',$simpanSKD); 
						}
					} 
				} 
				$this->session->set_flashdata('message', 'Kriteria Tahun penilaian <b>'.$tahun_p2.'</b>, data <b>berhasil Ditambahkan</b>');
				$this->session->set_flashdata('info', '1');
			} 
		}else{
			$this->session->set_flashdata('message', 'Kriteria Tahun penilaian <b>'.$tahun_p1.'</b>, data <b>tidak Ditemukan</b>');
			$this->session->set_flashdata('info', '2');
		}
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/kriteria/add_kriteria';
		$data['modul'] = 'Master';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_kriteria"=>$search_text));
	    }else{
	      if($this->session->userdata('search_kriteria') != NULL){
	        $search_text = $this->session->userdata('search_kriteria');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_kriteria"=>$search_text));
	    }

        $config['base_url'] = site_url('kriteria/index');   
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        if($search_text==""){
        	$config['total_rows'] = $this->db->count_all('master_kriteria'); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['kriteria'] = $this->Kriteria_model->get_kriteria_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Kriteria_model->get_count_kriteria_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['kriteria'] = $this->Kriteria_model->get_kriteria_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $this->template->load('template_wp','kriteria/kriteria_view', $data);
	} 

	function add_kriteria(){
		$data['action'] = base_url().'index.php/kriteria/save_kriteria';
		$data['res']	= array();
		$data['modul'] = 'Master';
		$this->template->load('template_wp','kriteria/kriteria_add', $data);
	}

	function edit_kriteria(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/kriteria/update_kriteria'; 
		$this->db->where('id_kriteria',$id);
		$data['id']		=  $this->uri->segment(3);
		$data['res']	= $this->db->get('master_kriteria')->row_array();
		$data['modul'] = 'Master';
		$this->template->load('template_wp','kriteria/kriteria_edit', $data);
	}

	function hapus_kriteria(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_kriteria',$id);
		$cek = $this->db->get('master_kriteria');  
		if($cek->num_rows()>0){
			$dt = $cek->row_array();
			$cek2 = $this->Kriteria_model->cekpenilaian($dt['tahun_penilaian']);
			if($cek2>0){
				$this->session->set_flashdata('message', 'Kriteria gagal Dihapus');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('kriteria'));
			}else{
				$this->db->where('id_kriteria',$id);
				$delete = $this->db->delete('master_kriteria');  
				if($delete){
					$this->db->where('id_kriteria',$id);
					$this->db->delete('master_subkriteria'); 
					$this->session->set_flashdata('message', 'Kriteria <b>'.$dt['nama_kriteria'].'</b> berhasil Dihapus');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('kriteria'));
				}else{
					$this->session->set_flashdata('message', 'Kriteria gagal Dihapus');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('kriteria'));
				}
			} 
		}else{
			$this->session->set_flashdata('message', 'Kriteria gagal Dihapus');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('kriteria'));
		}
			
	}

	function save_kriteria(){
		$kode_kriteria = $this->input->post('kode_kriteria');
		$nama_kriteria = $this->input->post('nama_kriteria'); 
		$bobot = $this->input->post('bobot'); 
		$tahun_penilaian = $this->input->post('tahun_penilaian');
		$tipe_kriteria = $this->input->post('tipe_kriteria');  
		if($kode_kriteria=='' || $nama_kriteria=='' || $bobot==''){
			$this->session->set_flashdata('message', 'Kode Kriteria, Nama Kriteria, atau Bobot tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('kriteria/add_kriteria'));
		}else{
			$dataSimpan = array(
				'kode_kriteria'=>$kode_kriteria,
				'nama_kriteria'=>$nama_kriteria, 
				'bobot'=>$bobot, 
				'tipe_kriteria'=>$tipe_kriteria,  
				'tahun_penilaian' =>$tahun_penilaian,
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 

			$cek = $this->Kriteria_model->cek_kriteria($kode_kriteria,$tahun_penilaian);
			if($cek>0){
				$this->session->set_flashdata('message', 'Kriteria <b>'.$nama_kriteria.'</b>, Tahun <b>'.$tahun_penilaian.'</b> sudah tersedia');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('kriteria/add_kriteria')); 
			}else{
				$insert = $this->db->insert('master_kriteria',$dataSimpan);
				if($insert){
					$this->session->set_flashdata('message', 'Kriteria <b>'.$nama_kriteria.'</b>, Tahun <b>'.$tahun_penilaian.'</b> berhasil Ditambahkan');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('kriteria'));
				}else{
					$this->session->set_flashdata('message', 'Kriteria <b>'.$nama_kriteria.'</b>, Tahun <b>'.$tahun_penilaian.'</b> gagal Ditambahkan');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('kriteria/add_kriteria'));
				} 
			} 
		}
		
	}
	function update_kriteria(){
		$kode_kriteria = $this->input->post('kode_kriteria');
		$nama_kriteria = $this->input->post('nama_kriteria'); 
		$id = $this->encrypt->decode($this->input->post('id_kriteria'));
		$bobot = $this->input->post('bobot'); 
		$tipe_kriteria = $this->input->post('tipe_kriteria');
		$tahun_penilaian = $this->input->post('tahun_penilaian');


		if($nama_kriteria=='' || $kode_kriteria=='' || $bobot==''){
			$this->session->set_flashdata('message', 'Kode Kriteria atau Nama Kriteria tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('kriteria/add_kriteria'));
		}else{
			$dataSimpan = array(
				'kode_kriteria'=>$kode_kriteria,
				'nama_kriteria'=>$nama_kriteria,
				'bobot'=>$bobot, 
				'tipe_kriteria'=>$tipe_kriteria,
				'tahun_penilaian'=>$tahun_penilaian,
				'dibuat_oleh'=>$this->session->userdata('id_pengguna') 
			); 
			$cek = $this->Kriteria_model->cek_kriteriaupdate($kode_kriteria,$tahun_penilaian,$id);
			$cek2 = $this->Kriteria_model->cekpenilaian($tahun_penilaian);
			if($cek>0 || $cek2>0){
				$this->session->set_flashdata('message', 'Kriteria <b>'.$nama_kriteria.'</b>, Tahun <b>'.$tahun_penilaian.'</b> gagal diUpdate');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('kriteria/edit_kriteria/'.$this->input->post('id_kriteria')));
			}else{
				$this->db->where('id_kriteria',$id);
				$update = $this->db->update('master_kriteria',$dataSimpan);
				if($update){
					$this->session->set_flashdata('message', 'Kriteria <b>'.$nama_kriteria.'</b>, Tahun <b>'.$tahun_penilaian.'</b> berhasil diUpdate');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('kriteria'));
				}else{
					$this->session->set_flashdata('message', 'Kriteria <b>'.$nama_kriteria.'</b>, Tahun <b>'.$tahun_penilaian.'</b> gagal diUpdate');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('kriteria/edit_kriteria/'.$this->input->post('id_kriteria')));
				}
			}
			
		}
		
	}
}
