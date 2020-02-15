<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {
	public function __construct(){    
	  parent::__construct(); 
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      }  
	  $this->load->model(array('Penilaian_model'));
      $this->load->library('pagination');
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/penilaian/add_penilaian';
		$data['modul'] = 'Transaksi';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_penilaian"=>$search_text));
	    }else{
	      if($this->session->userdata('search_penilaian') != NULL){
	        $search_text = $this->session->userdata('search_penilaian');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_penilaian"=>$search_text));
	    }

        $config['base_url'] = site_url('penilaian/index');   
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter

        if($this->session->userdata('rule')==2 || $this->session->userdata('rule')==3){
        	if($search_text==""){
	        	$config['total_rows'] = $this->Penilaian_model->get_penilaian_count_wrule();
	        	$choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice); 
		        $this->pagination->initialize($config);
		        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
		        $data['pagination'] = $this->pagination->create_links();
		        $data['search'] = $search_text;
	        	$data['penilaian'] = $this->Penilaian_model->get_penilaian_list_wrule($config["per_page"], $data['page'])->result_array(); 
	        }else{
	        	$config['total_rows'] = $this->Penilaian_model->get_count_penilaian_list_wrule($search_text); 
	        	$choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice); 
		        $this->pagination->initialize($config);
		        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
		        $data['pagination'] = $this->pagination->create_links();
		        $data['search'] = $search_text;
	        	$data['penilaian'] = $this->Penilaian_model->get_penilaian_list_search_wrule($config["per_page"], $data['page'],$search_text)->result_array(); 
	        } 
        }else{
        	if($search_text==""){
	        	$config['total_rows'] = $this->db->count_all('penilaian'); 
	        	$choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice); 
		        $this->pagination->initialize($config);
		        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
		        $data['pagination'] = $this->pagination->create_links();
		        $data['search'] = $search_text;
	        	$data['penilaian'] = $this->Penilaian_model->get_penilaian_list($config["per_page"], $data['page'])->result_array(); 
	        }else{
	        	$config['total_rows'] = $this->Penilaian_model->get_count_penilaian_list($search_text); 
	        	$choice = $config["total_rows"] / $config["per_page"];
		        $config["num_links"] = floor($choice); 
		        $this->pagination->initialize($config);
		        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
		        $data['pagination'] = $this->pagination->create_links();
		        $data['search'] = $search_text;
	        	$data['penilaian'] = $this->Penilaian_model->get_penilaian_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
	        } 
        }
         
        $this->template->load('template_wp','penilaian/penilaian_view', $data);
	} 

	function add_penilaian(){
		$data['action']  = base_url().'index.php/penilaian/save_penilaian';
		$data['res']	 = array();
		$data['modul']   = 'Transaksi';
		$data['id_divisi']  = $this->session->userdata('id_divisi');
		$this->db->where('id_divisi',$this->session->userdata('id_divisi'));
		$data['loaddivisi'] = $this->db->get('master_divisi')->row_array(); 
		$this->template->load('template_wp','penilaian/penilaian_add', $data);
	}

	function edit_penilaian(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/penilaian/update_penilaian'; 

		$this->db->where('id_penilaian',$id);
		$data['id']		=  $this->uri->segment(3);
		$res 			=  $this->db->get('penilaian')->row_array();
		$data['res']	=  $res;
		$data['modul'] = 'Transaksi'; ;

		$data['id_divisi']  = $res['id_divisi'];
		$this->db->where('id_divisi',$res['id_divisi']);
		$data['loaddivisi'] = $this->db->get('master_divisi')->row_array();

		$this->db->where('tahun_penilaian', $res['tahun_penilaian']); 
		$data['loadkriteria'] = $this->db->get('master_kriteria')->result_array();
		$this->template->load('template_wp','penilaian/penilaian_edit', $data);
	}

	function view_penilaian(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/penilaian/update_penilaian'; 

		$this->db->where('id_penilaian',$id);
		$data['id']		=  $this->uri->segment(3);
		$res 			=  $this->db->get('penilaian')->row_array();
		$data['res']	=  $res;
		$data['modul'] = 'Transaksi'; ;

		$data['id_divisi']  = $res['id_divisi'];
		$this->db->where('id_divisi',$res['id_divisi']);
		$data['loaddivisi'] = $this->db->get('master_divisi')->row_array();

		$this->db->where('tahun_penilaian', $res['tahun_penilaian']); 
		$data['loadkriteria'] = $this->db->get('master_kriteria')->result_array();
		$this->template->load('template_wp','penilaian/penilaian_viewd', $data);
	}

	function hapus_penilaian(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_penilaian',$id); 
		if($this->db->get('penilaian')->num_rows()>0){ 

			$this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner');
			$this->db->where('id_penilaian',$id);
    		$dt = $this->db->get('penilaian')->row_array();

			$this->db->where('id_penilaian',$id);
			$delete = $this->db->delete('penilaian'); 
			if($delete){
				$this->session->set_flashdata('message', 'Penilaian <b>'.$dt['nama_divisi'].' Tahun '.$dt['tahun_penilaian'].'</b> berhasil Dihapus');
				$this->session->set_flashdata('info', '1');

				$this->db->where('id_penilaian',$id);
				$delete = $this->db->delete('penilaian_detail'); 

  				redirect(site_url('penilaian'));
			}else{
				$this->session->set_flashdata('message', 'Penilaian gagal Dihapus');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('penilaian'));
			}
		}else{
			$this->session->set_flashdata('message', 'Penilaian gagal Dihapus');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('penilaian'));
		}
			
	}

	function save_penilaian(){
		$id_divisi = $this->input->post('id_divisi');
		$tahun_penilaian = $this->input->post('tahun_penilaian'); 

		$this->db->where('id_divisi',$id_divisi);
		$div = $this->db->get('master_divisi')->row_array();

		if($id_divisi=='' || $tahun_penilaian==''){
			$this->session->set_flashdata('message', 'Divisi atau Tahun Penilaian tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('penilaian/add_penilaian'));
		}else{

			if($this->input->post('draft') != NULL){
				$status = 'Draft';
			}else{
				$status = 'Waiting Review';
			}

			$dataSimpan = array(
				'id_divisi'=>$id_divisi,
				'tahun_penilaian'=>$tahun_penilaian, 
				'status'=>$status,
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 

			$cek = $this->Penilaian_model->cek_penilaian($id_divisi,$tahun_penilaian);
			$cek2 = $this->Penilaian_model->cekpenialainkriteria($tahun_penilaian);
			if($cek2>0){
				if($cek>0){ 
					$this->session->set_flashdata('message', 'Penilaian Divisi <b>'.$div['nama_divisi'].' Tahun '.$tahun_penilaian.'</b> sudah tersedia');
					$this->session->set_flashdata('info', '2');
		  			redirect(site_url('penilaian/add_penilaian')); 
				}else{
					$insert = $this->db->insert('penilaian',$dataSimpan);
					$id_penilaian = $this->db->insert_id();
					if($insert){ 
						$this->session->set_flashdata('message', 'Penilaian <b>'.$div['nama_divisi'].' Tahun '.$tahun_penilaian.'</b> berhasil Ditambahkan');
						$this->session->set_flashdata('info', '1');
		  				redirect(site_url('penilaian'));
					}else{
						$this->session->set_flashdata('message', 'Penilaian <b>'.$div['nama_divisi'].' Tahun '.$tahun_penilaian.'</b> gagal Ditambahkan');
						$this->session->set_flashdata('info', '2');
		  				redirect(site_url('penilaian/add_penilaian'));
					} 
				}
			}else{
				$this->session->set_flashdata('message', 'Penilaian Divisi <b>'.$div['nama_divisi'].' Tahun '.$tahun_penilaian.'</b> sudah tersedia');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('penilaian/add_penilaian')); 
			} 
		}
		
	}

	function review_penilaian(){
		$id_penilaian = $this->input->post('id'); 
		$up['status'] = 'Finish';
		$this->db->where('id_penilaian',$id_penilaian);
		$this->db->update('penilaian',$up);

		$this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner');  
		$this->db->where('id_penilaian',$id_penilaian);
		$ress = $this->db->get('penilaian')->row_array(); 
		$this->session->set_flashdata('message', 'Penilaian <b>'.$ress['nama_divisi'].'</b> Tahun <b>'.$ress['tahun_penilaian'].'</b> status diubah menjadi <b>Finish</b>'); 
	}
	function update_penilaian(){
		$id_divisi = $this->input->post('id_divisi');
		$tahun_penilaian = $this->input->post('tahun_penilaian'); 
		$id = $this->encrypt->decode($this->input->post('id_penilaian'));

		$this->db->where('id_divisi',$id_divisi);
		$div = $this->db->get('master_divisi')->row_array();

		if($id_divisi=='' || $tahun_penilaian==''){
			$this->session->set_flashdata('message', 'Divisi atau Tahun Penilaian tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('penilaian/edit_penilaian'));
		}else{
			if($this->input->post('draft') != NULL){
				$status = 'Draft';
			}else{
				$status = 'Waiting Review';
			}

			$dataSimpan = array(
				'id_divisi'=>$id_divisi,
				'tahun_penilaian'=>$tahun_penilaian, 
				'status'=>$status,
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 

			$cek = $this->Penilaian_model->cek_penilaianupdate($id_divisi,$tahun_penilaian,$id);
			if($cek>0){
				$this->db->where('id_divisi',$id_divisi);
				$div = $this->db->get('master_divisi')->row_array();
				$this->session->set_flashdata('message', 'Penilaian Divisi <b>'.$div['nama_divisi'].' Tahun '.$tahun_penilaian.'</b> sudah tersedia');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('penilaian/edit_penilaian/'.$this->input->post('id_penilaian')));
			}else{
				$this->db->where('id_penilaian',$id);
				$update = $this->db->update('penilaian',$dataSimpan);
				if($update){
					$datachecked = $this->Penilaian_model->get_subkriteria_list($tahun_penilaian)->result_array();
					$this->db->where('id_penilaian',$id);
					$this->db->delete('penilaian_detail');
					foreach ($datachecked as $d) { 
						$pemdet = array(); 
						$pemdet['id_penilaian'] 		= $id;  
			            $pemdet['id_kriteria'] 			= $d['id_kriteria'];  
			            $pemdet['id_subkriteria'] 		= $d['id_subkriteria'];   
			            $pemdet['id_subkriteriadetail'] = $this->input->post('radiochecked_1_'.$d['id_kriteria'].'_'.$d['id_subkriteria']); 
			            $pemdet['dibuat_oleh']          = $this->session->userdata('id_pengguna'); 
			            $this->db->insert('penilaian_detail', $pemdet); 
					} 
					$this->session->set_flashdata('message', 'Penilaian <b>'.$div['nama_divisi'].' Tahun '.$tahun_penilaian.'</b> berhasil diUpdate');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('penilaian'));
				}else{
					$this->session->set_flashdata('message', 'Penilaian <b>'.$div['nama_divisi'].' Tahun '.$tahun_penilaian.'</b> gagal diUpdate');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('penilaian/edit_penilaian/'.$this->input->post('id_penilaian')));
				}
			}
			
		}
		
	}

}
