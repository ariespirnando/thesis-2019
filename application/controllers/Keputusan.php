<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keputusan extends CI_Controller {
	public function __construct(){    
	  parent::__construct();  
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      } 
	  $this->load->model(array('Keputusan_model'));
      $this->load->library('pagination');
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/keputusan/add_keputusan';
		$data['modul'] = 'Transaksi';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_keputusan"=>$search_text));
	    }else{
	      if($this->session->userdata('search_keputusan') != NULL){
	        $search_text = $this->session->userdata('search_keputusan');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_keputusan"=>$search_text));
	    }

        $config['base_url'] = site_url('keputusan/index');   
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
        	$data['seleksi'] = $this->Keputusan_model->get_keputusan_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Keputusan_model->get_count_keputusan_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['seleksi'] = $this->Keputusan_model->get_keputusan_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $this->template->load('template_wp','keputusan/keputusan_view', $data);
	} 

	function edit_keputusan(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$tipe =  $this->input->post('tipe');
		$this->db->where('id_seleksi',$id);
		$dt = $this->db->get('seleksi')->row_array();
		$data['action'] = base_url().'index.php/keputusan/save_keputusan'; 
		$data['res'] = $dt; 
		$data['modul'] = 'Transaksi';  
		$data['preferensi_seleksi']=$this->db->query('SELECT sh.id_seleksi_hasil, sh.ikeputusan,sh.`id_divisi`,md.`nama_divisi`, md.`kode_divisi`, sh.`peringkat`, sh.`prefrensi`
			FROM seleksi_hasil sh JOIN master_divisi md ON md.`id_divisi` = sh.`id_divisi`
			WHERE sh.`id_seleksi` = '.$id.' AND hasil = "Dilanjutkan" ORDER BY sh.`peringkat`')->result_array();
		$this->template->load('template_wp','keputusan/keputusan_edit', $data);
	}

	function save_keputusan(){
		$id_seleksi = $this->input->post('id_seleksi');
		$tahun_penilaian = $this->input->post('tahun_penilaian');
		$n=0;
		if($this->input->post('submit') != NULL){
			$n=1;
			$this->db->set('status_keputusan','Selesai');
			$this->db->where('id_seleksi',$id_seleksi);
			$this->db->where('tahun_penilaian',$tahun_penilaian);
			$this->db->update('seleksi');
		} 
		$this->db->set('ikeputusan','0');
		$this->db->where('id_seleksi',$id_seleksi);
        $this->db->update('seleksi_hasil');
		
		foreach($this->input->post('id_seleksi_hasil') as $k=>$v){ 
			$this->db->set('ikeputusan','1');
			$this->db->where('id_seleksi_hasil',$v);
			$this->db->where('id_seleksi',$id_seleksi);
        	$this->db->update('seleksi_hasil');
        } 
        if($n==1){
        	$this->session->set_flashdata('message', 'Keputusan Tahun <b>'.$tahun_penilaian.'</b> status diubah menjadi <b>Selesai</b>');
			$this->session->set_flashdata('info', '1');
			redirect(site_url('keputusan'));
        }else{
        	$this->session->set_flashdata('message', 'Keputusan Tahun <b>'.$tahun_penilaian.'</b> berhasil dipilih ');
			$this->session->set_flashdata('info', '1');
			redirect(site_url('keputusan/edit_keputusan/'.$this->encrypt->encode($id_seleksi)));
        } 
	} 
	function viewd_keputusan(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$tipe =  $this->input->post('tipe');
		$this->db->where('id_seleksi',$id);
		$dt = $this->db->get('seleksi')->row_array();
		$data['action'] = base_url().'index.php/keputusan/save_keputusan'; 
		$data['res'] = $dt; 
		$data['modul'] = 'Transaksi';  
		$data['preferensi_seleksi']=$this->db->query('SELECT sh.id_seleksi_hasil, sh.ikeputusan,sh.`id_divisi`,md.`nama_divisi`, md.`kode_divisi`, sh.`peringkat`, sh.`prefrensi`
			FROM seleksi_hasil sh JOIN master_divisi md ON md.`id_divisi` = sh.`id_divisi`
			WHERE sh.`id_seleksi` = '.$id.' AND hasil = "Dilanjutkan" ORDER BY sh.ikeputusan DESC, sh.`peringkat` ASC')->result_array();
		$this->template->load('template_wp','keputusan/keputusan_viewd', $data);
	}
}
