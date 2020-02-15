<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {
	public function __construct(){    
	  parent::__construct(); 
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      }  
	  $this->load->model(array('Pengguna_model'));
      $this->load->library('pagination');
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/pengguna/add_pengguna';
		$data['modul'] = 'Pengaturan';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_pengguna"=>$search_text));
	    }else{
	      if($this->session->userdata('search_pengguna') != NULL){
	        $search_text = $this->session->userdata('search_pengguna');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_pengguna"=>$search_text));
	    }

        $config['base_url'] = site_url('pengguna/index');   
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        if($search_text==""){
        	$config['total_rows'] = $this->db->count_all('pengguna'); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['pengguna'] = $this->Pengguna_model->get_pengguna_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Pengguna_model->get_count_pengguna_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['pengguna'] = $this->Pengguna_model->get_pengguna_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $this->template->load('template_wp','pengguna/pengguna_view', $data);
	} 

	function add_pengguna(){
		$data['action'] = base_url().'index.php/pengguna/save_pengguna';
		$data['res']	= array();
		$data['modul'] = 'Pengaturan';
		$data['divisi'] = $this->db->get('master_divisi')->result_array();
		$this->template->load('template_wp','pengguna/pengguna_add', $data);
	}

	function ganti_pwpengguna(){
		$data['action'] = base_url().'index.php/pengguna/ubah_password';
		$data['res']	= array();
		$data['modul'] = 'Pengaturan'; 
		$this->template->load('template_wp','pengguna/pengguna_ubahpw', $data);
	}

	function edit_pengguna(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/pengguna/update_pengguna'; 
		$this->db->where('id_pengguna',$id);
		$data['id']		=  $this->uri->segment(3);
		$data['res']	= $this->db->get('pengguna')->row_array();
		$data['modul'] = 'Pengaturan';
		$data['divisi'] = $this->db->get('master_divisi')->result_array();
		$this->template->load('template_wp','pengguna/pengguna_edit', $data);
	}
	function ubah_password(){
		$id_pengguna = $this->session->userdata('id_pengguna');
		$passwordL = $this->input->post('passwordL');
		$passwordB = $this->input->post('passwordB');

		$this->db->where('id_pengguna',$id_pengguna);
		$this->db->where('password',md5($passwordL));
		$cek = $this->db->get('pengguna')->num_rows(); 
		if($cek>0){ 
			$this->db->set('password',md5($passwordB));
			$this->db->where('id_pengguna',$id_pengguna);
			$this->db->update('pengguna');
			$this->session->set_flashdata('message', '<b>Password</b> berhasil diUpdate');
			$this->session->set_flashdata('info', '1');
			redirect(site_url('pengguna/ganti_pwpengguna'));
		}else{
			$this->session->set_flashdata('message', '<b>Password</b> gagal diUpdate');
			$this->session->set_flashdata('info', '2');
			redirect(site_url('pengguna/ganti_pwpengguna'));
		}
	}
	function hapus_pengguna(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_pengguna',$id);
		$cek = $this->db->get('pengguna');  
		if($cek->num_rows()>0){
			$dt = $cek->row_array(); 
			$this->db->where('id_pengguna',$id);
			$delete = $this->db->delete('pengguna'); 
			if($delete){
				$this->session->set_flashdata('message', 'Pengguna <b>'.$dt['nama_pengguna'].'</b> berhasil Dihapus');
				$this->session->set_flashdata('info', '1');
  				redirect(site_url('pengguna'));
			}else{
				$this->session->set_flashdata('message', 'Pengguna <b>'.$dt['nama_pengguna'].'</b> gagal Dihapus');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('pengguna'));
			} 
		}else{
			$this->session->set_flashdata('message', 'Pengguna gagal Dihapus');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('pengguna'));
		}
			
	}

	function save_pengguna(){
		$nama_pengguna = $this->input->post('nama_pengguna');
		$username = $this->input->post('username'); 
		$rule = $this->input->post('rule');
		$id_divisi = $this->input->post('id_divisi'); 

		if($username=='' || $nama_pengguna==''){
			$this->session->set_flashdata('message', 'Username atau Nama Pengguna tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('pengguna/add_pengguna'));
		}else{
			$dataSimpan = array(
				'nama_pengguna'=>$nama_pengguna,
				'username'=>$username, 
				'password'=>md5($username),
				'rule'=>$rule,
				'id_divisi'=>$id_divisi 
			); 

			$cek = $this->Pengguna_model->cek_pengguna($username);
			if($cek>0){
				$this->session->set_flashdata('message', 'Username <b>'.$username.'</b> sudah tersedia');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('pengguna/add_pengguna')); 
			}else{
				$insert = $this->db->insert('pengguna',$dataSimpan);
				if($insert){
					$this->session->set_flashdata('message', '<b>'.$nama_pengguna.'</b> berhasil Ditambahkan');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('pengguna'));
				}else{
					$this->session->set_flashdata('message', '<b>'.$nama_pengguna.'</b> gagal Ditambahkan');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('pengguna/add_pengguna'));
				} 
			} 
		}
		
	}
	function update_pengguna(){
		$nama_pengguna = $this->input->post('nama_pengguna');
		$username = $this->input->post('username'); 
		$rule = $this->input->post('rule');
		$id_divisi = $this->input->post('id_divisi');  
		$id = $this->encrypt->decode($this->input->post('id_pengguna'));

		if($username=='' || $nama_pengguna==''){
			$this->session->set_flashdata('message', 'Username atau Nama Pengguna tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('pengguna/add_pengguna'));
		}else{
			$dataSimpan = array(
				'nama_pengguna'=>$nama_pengguna,
				'username'=>$username, 
				'password'=>md5($username),
				'rule'=>$rule,
				'id_divisi'=>$id_divisi 
			); 
			$cek = $this->Pengguna_model->cek_penggunaupdate($username,$id);
			if($cek>0){
				$this->session->set_flashdata('message', '<b>'.$nama_pengguna.'</b> gagal diUpdate');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('pengguna/edit_pengguna/'.$this->input->post('id_pengguna')));
			}else{
				$this->db->where('id_pengguna',$id);
				$update = $this->db->update('pengguna',$dataSimpan);
				if($update){
					$this->session->set_flashdata('message', '<b>'.$nama_pengguna.'</b> berhasil diUpdate');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('pengguna'));
				}else{
					$this->session->set_flashdata('message', '<b>'.$nama_pengguna.'</b> gagal diUpdate');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('pengguna/edit_pengguna/'.$this->input->post('id_pengguna')));
				}
			}
			
		}
		
	}
}
