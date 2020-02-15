<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
        parent::__construct();  
    }  
	public function index()
	{
		$this->session->sess_destroy();  
		$data = array();
		$data['modul'] = 'Login';
		$data['action'] = base_url().'index.php/Login/cek'; 
		$this->template->load('template_wp','login/login', $data);
	}
	 
	function cek(){   
		if( null !== ($this->input->post('pass')) && 
			null !== ($this->input->post('user'))){  
			$user = $this->input->post('user');
			$pass = $this->input->post('pass'); 
			$this->db->where('username',$user);
			$this->db->where('password',md5($pass));
			//$this->db->where('password',$pass);
			$cek = $this->db->get('pengguna');
			if($cek->num_rows()>0){
				$dts = $cek->row_array();
				$data = array(
			      'id_pengguna'   => $dts['id_pengguna'],
			      'nama_pengguna'   => $dts['nama_pengguna'],
			      'id_divisi' 		=> $dts['id_divisi'],
			      'rule'      		=> $dts['rule']
			    ); 
	            $this->session->set_userdata($data);  
				redirect('Home');
			}else{
				$this->session->set_flashdata('message', 'Username atau Password Tidak ditemukan'); 
				redirect('Login');
			} 
		}else{
			$this->session->set_flashdata('message', 'Data belum diiisi !!'); 
			redirect('Login');
		} 
	}

	public function logout(){
		$this->session->sess_destroy();  
	    redirect('Login');
    }
 
 
}
