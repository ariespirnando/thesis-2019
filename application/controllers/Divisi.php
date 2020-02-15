<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {
	public function __construct(){    
	  parent::__construct(); 
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      }  
	  $this->load->model(array('Divisi_model'));
      $this->load->library('pagination');
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/divisi/add_divisi';
		$data['modul'] = 'Master';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_divisi"=>$search_text));
	    }else{
	      if($this->session->userdata('search_divisi') != NULL){
	        $search_text = $this->session->userdata('search_divisi');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_divisi"=>$search_text));
	    }

        $config['base_url'] = site_url('divisi/index');   
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        if($search_text==""){
        	$config['total_rows'] = $this->db->count_all('master_divisi'); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['divisi'] = $this->Divisi_model->get_divisi_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Divisi_model->get_count_divisi_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['divisi'] = $this->Divisi_model->get_divisi_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $this->template->load('template_wp','divisi/divisi_view', $data);
	} 

	function add_divisi(){
		$data['action'] = base_url().'index.php/divisi/save_divisi';
		$data['res']	= array();
		$data['modul'] = 'Master';
		$this->template->load('template_wp','divisi/divisi_add', $data);
	}

	function edit_divisi(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/divisi/update_divisi'; 
		$this->db->where('id_divisi',$id);
		$data['id']		=  $this->uri->segment(3);
		$data['res']	= $this->db->get('master_divisi')->row_array();
		$data['modul'] = 'Master';
		$this->template->load('template_wp','divisi/divisi_edit', $data);
	}

	function hapus_divisi(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_divisi',$id);
		$cek = $this->db->get('master_divisi');  
		if($cek->num_rows()>0){
			$dt = $cek->row_array();
			$cek = $this->Divisi_model->cekpenilaian($id);
			if($cek>0){
				$this->session->set_flashdata('message', 'Divisi <b>'.$dt['nama_divisi'].'</b> gagal Dihapus');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('divisi'));
			}else{
				$this->db->where('id_divisi',$id);
				$delete = $this->db->delete('master_divisi'); 
				if($delete){
					$this->session->set_flashdata('message', 'Divisi <b>'.$dt['nama_divisi'].'</b> berhasil Dihapus');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('divisi'));
				}else{
					$this->session->set_flashdata('message', 'Divisi <b>'.$dt['nama_divisi'].'</b> gagal Dihapus');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('divisi'));
				}
			}
			
		}else{
			$this->session->set_flashdata('message', 'Divisi gagal Dihapus');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('divisi'));
		}
			
	}

	function save_divisi(){
		$kode_divisi = $this->input->post('kode_divisi');
		$nama_divisi = $this->input->post('nama_divisi'); 

		if($kode_divisi=='' || $nama_divisi==''){
			$this->session->set_flashdata('message', 'Kode Divisi atau Nama Divisi tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('divisi/add_divisi'));
		}else{
			$dataSimpan = array(
				'kode_divisi'=>$kode_divisi,
				'nama_divisi'=>$nama_divisi, 
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 

			$cek = $this->Divisi_model->cek_divisi($kode_divisi,$nama_divisi);
			if($cek>0){
				$this->session->set_flashdata('message', 'Divisi <b>'.$nama_divisi.'</b> sudah tersedia');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('divisi/add_divisi')); 
			}else{
				$insert = $this->db->insert('master_divisi',$dataSimpan);
				if($insert){
					$this->session->set_flashdata('message', 'Divisi <b>'.$nama_divisi.'</b> berhasil Ditambahkan');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('divisi'));
				}else{
					$this->session->set_flashdata('message', 'Divisi <b>'.$nama_divisi.'</b> gagal Ditambahkan');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('divisi/add_divisi'));
				} 
			} 
		}
		
	}
	function update_divisi(){
		$kode_divisi = $this->input->post('kode_divisi');
		$nama_divisi = $this->input->post('nama_divisi'); 
		$id = $this->encrypt->decode($this->input->post('id_divisi'));

		if($nama_divisi=='' || $kode_divisi==''){
			$this->session->set_flashdata('message', 'Kode Divisi atau Nama Divisi tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('divisi/add_divisi'));
		}else{
			$dataSimpan = array(
				'kode_divisi'=>$kode_divisi,
				'nama_divisi'=>$nama_divisi,
				'dibuat_oleh'=>$this->session->userdata('id_pengguna') 
			); 
			$cek = $this->Divisi_model->cek_divisiupdate($kode_divisi,$nama_divisi,$id);
			if($cek>0){
				$this->session->set_flashdata('message', 'Divisi <b>'.$nama_divisi.'</b> gagal diUpdate');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('divisi/edit_divisi/'.$this->input->post('id_divisi')));
			}else{
				$this->db->where('id_divisi',$id);
				$update = $this->db->update('master_divisi',$dataSimpan);
				if($update){
					$this->session->set_flashdata('message', 'Divisi <b>'.$nama_divisi.'</b> berhasil diUpdate');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('divisi'));
				}else{
					$this->session->set_flashdata('message', 'Divisi <b>'.$nama_divisi.'</b> gagal diUpdate');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('divisi/edit_divisi/'.$this->input->post('id_divisi')));
				}
			}
			
		}
		
	}
}
