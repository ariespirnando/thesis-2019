<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aturan extends CI_Controller {
	public function __construct(){    
	  parent::__construct(); 
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      } 
	  $this->load->model(array('Aturan_model'));
      $this->load->library('pagination');
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/aturan/add_aturan';
		$data['modul'] = 'Master';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_aturan"=>$search_text));
	    }else{
	      if($this->session->userdata('search_aturan') != NULL){
	        $search_text = $this->session->userdata('search_aturan');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_aturan"=>$search_text));
	    }

        $config['base_url'] = site_url('aturan/index');   
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        if($search_text==""){
        	$config['total_rows'] = $this->db->count_all('master_aturan'); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['aturan'] = $this->Aturan_model->get_aturan_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Aturan_model->get_count_aturan_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['aturan'] = $this->Aturan_model->get_aturan_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $data['aturancostume'] = $this->db->get('master_aturancustume')->result_array();
        $this->template->load('template_wp','aturan/aturan_view', $data);
	} 

	function add_aturan(){
		$data['action'] = base_url().'index.php/aturan/save_aturan';
		$data['res']	= array();
		$data['modul'] = 'Master';
		$data['kriteria'] = $this->db->get('master_kriteria')->result_array();
		$data['subkriteria'] = $this->db->get('master_subkriteria')->result_array();
		$this->template->load('template_wp','aturan/aturan_add', $data);
	}

	function edit_aturan(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/aturan/update_aturan'; 
		$this->db->where('id_aturan',$id);
		$data['id']		=  $this->uri->segment(3);
		$data['res']	= $this->db->get('master_aturan')->row_array();
		$data['modul'] = 'Master';
		$data['kriteria'] = $this->db->get('master_kriteria')->result_array();
		$data['subkriteria'] = $this->db->get('master_subkriteria')->result_array();

		$this->db->where('id_aturan',$id);
		$datr = $this->db->get('master_aturandetail'); 
		$data['aturandetail']=$datr->result_array();
		$data['aturandetailnum']=$datr->num_rows(); 
		$this->template->load('template_wp','aturan/aturan_edit', $data);
	}

	
	function view_aturan(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/aturan/update_aturan'; 
		$this->db->where('id_aturan',$id);
		$data['id']		=  $this->uri->segment(3);
		$data['res']	= $this->db->get('master_aturan')->row_array();
		$data['modul'] = 'Master';
		$data['kriteria'] = $this->db->get('master_kriteria')->result_array();
		$data['subkriteria'] = $this->db->get('master_subkriteria')->result_array();

		$this->db->where('id_aturan',$id);
		$datr = $this->db->get('master_aturandetail'); 
		$data['aturandetail']=$datr->result_array();
		$data['aturandetailnum']=$datr->num_rows(); 
		$this->template->load('template_wp','aturan/aturan_viewd', $data);
	}
	function hapus_aturan(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_aturan',$id);
		$cek = $this->db->get('master_aturan');  
		if($cek->num_rows()>0){
			$dt = $cek->row_array();
			$this->db->where('id_aturan',$id);
			$delete = $this->db->delete('master_aturan'); 
			if($delete){
				$this->db->where('id_aturan',$id);
				$delete = $this->db->delete('master_aturandetail'); 
				$this->session->set_flashdata('message', 'Aturan <b>'.$dt['kode_aturan'].'</b> berhasil Dihapus');
				$this->session->set_flashdata('info', '1');
  				redirect(site_url('aturan'));
			}else{
				$this->session->set_flashdata('message', 'Aturan gagal Dihapus');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('aturan'));
			}
		}else{
			$this->session->set_flashdata('message', 'Aturan gagal Dihapus');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('aturan'));
		}
			
	}

	function save_aturan(){
		$kode_aturan = $this->input->post('kode_aturan'); 
		$id_kriteria = $this->input->post('id_kriteria');
		$hasil  = $this->input->post('hasil');

		if($kode_aturan=='' || $id_kriteria==''){
			$this->session->set_flashdata('message', 'Kode Aturan atau Nama Kriteria tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('aturan/add_aturan'));
		}else{
			$dataSimpan = array(
				'kode_aturan'=>$kode_aturan, 
				'id_kriteria'=>$id_kriteria,
				'hasil'=>$hasil,
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 
			$kodesub = ''; 
			$cekdup  = '';
			$vv		 = '';
			foreach($this->input->post('id_subkriteria') as $k=>$v){  
	        	if($v==$vv){
	        		$this->db->where('id_subkriteria',$v);
	        		$dt = $this->db->get('master_subkriteria')->row_array();
	        		$cekdup = str_replace($dt['kode_subkriteria'].',', '', $cekdup);
	        		$cekdup .= $dt['kode_subkriteria'].',';
	        	}

	        	$this->db->where('id_subkriteria',$v);
	        	$this->db->where('id_kriteria',$id_kriteria);
	        	$cek = $this->db->get('master_subkriteria')->num_rows();
	        	if($cek>0){}else{
	        		$this->db->where('id_subkriteria',$v);
	        		$dt = $this->db->get('master_subkriteria')->row_array();
	        		$kodesub = str_replace($dt['kode_subkriteria'].',', '', $kodesub);
	        		$kodesub .= $dt['kode_subkriteria'].',';
	        	} 
	        	$vv=$v; 
	        } 

	        if($kodesub!=''){
	        	$this->session->set_flashdata('message', 'Kode Subkriteria <b>'.substr($kodesub,0,-1).'</b> Tidak ditemukan');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('aturan/add_aturan'));
	        }else if($cekdup!=''){
	        	$this->session->set_flashdata('message', 'Kode Subkriteria <b>'.substr($cekdup,0,-1).'</b> Tidak boleh duplikasi');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('aturan/add_aturan'));
	        }else{ 

				$cek = $this->Aturan_model->cek_aturan($kode_aturan,$id_kriteria);
				if($cek>0){
					$this->session->set_flashdata('message', 'Aturan <b>'.$kode_aturan.'</b> sudah tersedia');
					$this->session->set_flashdata('info', '2');
		  			redirect(site_url('aturan/add_aturan')); 
				}else{
					$insert = $this->db->insert('master_aturan',$dataSimpan);
					$id_aturan = $this->db->insert_id();
					if($insert){ 
						$arr_pem = array();
						foreach($this->input->post('nilai') as $k=>$v){ 
				        	$arr_pem['nilai'][$k] = $v;
				        }
				        foreach($this->input->post('kondisi') as $k=>$v){ 
				        	$arr_pem['kondisi'][$k] = $v;
				        }  
				        foreach($this->input->post('id_subkriteria') as $k=>$v){ 
				            $pemdet = array();
				            $pemdet['id_aturan'] 			= $id_aturan;  
				            $pemdet['id_subkriteria'] 		= $v;   
				            $pemdet['nilai']    		    = $arr_pem['nilai'][$k];
				            $pemdet['kondisi']   			= $arr_pem['kondisi'][$k]; 
				            $pemdet['dibuat_oleh']          = $this->session->userdata('id_pengguna'); 
				            $this->db->insert('master_aturandetail', $pemdet);  
				        }    

						$this->session->set_flashdata('message', 'Aturan <b>'.$kode_aturan.'</b> berhasil Ditambahkan');
						$this->session->set_flashdata('info', '1');
		  				redirect(site_url('aturan'));
					}else{
						$this->session->set_flashdata('message', 'Aturan <b>'.$kode_aturan.'</b> gagal Ditambahkan');
						$this->session->set_flashdata('info', '2');
		  				redirect(site_url('aturan/add_aturan'));
					} 
				} 
			}
		}
		
	}
	function update_aturan(){
		$kode_aturan = $this->input->post('kode_aturan'); 
		$id_kriteria = $this->input->post('id_kriteria');  
		$id = $this->encrypt->decode($this->input->post('id_aturan'));
		$hasil  = $this->input->post('hasil');

		if($id_kriteria=='' || $kode_aturan==''){
			$this->session->set_flashdata('message', 'Kode Aturan atau Nama Kriteria tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('aturan/add_aturan'));
		}else{
			$dataSimpan = array(
				'kode_aturan'=>$kode_aturan, 
				'id_kriteria'=>$id_kriteria,
				'hasil'=>$hasil,
				'dibuat_oleh'=>$this->session->userdata('id_pengguna') 
			); 

			$kodesub = ''; 
			$cekdup  = '';
			$vv		 = '';
			foreach($this->input->post('id_subkriteria') as $k=>$v){  
	        	if($v==$vv){
	        		$this->db->where('id_subkriteria',$v);
	        		$dt = $this->db->get('master_subkriteria')->row_array();
	        		$cekdup = str_replace($dt['kode_subkriteria'].',', '', $cekdup);
	        		$cekdup .= $dt['kode_subkriteria'].',';
	        	}

	        	$this->db->where('id_subkriteria',$v);
	        	$this->db->where('id_kriteria',$id_kriteria);
	        	$cek = $this->db->get('master_subkriteria')->num_rows();
	        	if($cek>0){}else{
	        		$this->db->where('id_subkriteria',$v);
	        		$dt = $this->db->get('master_subkriteria')->row_array();
	        		$kodesub = str_replace($dt['kode_subkriteria'].',', '', $kodesub);
	        		$kodesub .= $dt['kode_subkriteria'].',';
	        	} 
	        	$vv=$v; 
	        } 

	        if($kodesub!=''){
	        	$this->session->set_flashdata('message', 'Kode Subkriteria <b>'.substr($kodesub,0,-1).'</b> Tidak ditemukan');
				$this->session->set_flashdata('info', '2');
				redirect(site_url('aturan/edit_aturan/'.$this->input->post('id_aturan')));
	        }else if($cekdup!=''){
	        	$this->session->set_flashdata('message', 'Kode Subkriteria <b>'.substr($cekdup,0,-1).'</b> Tidak boleh duplikasi');
				$this->session->set_flashdata('info', '2');
				redirect(site_url('aturan/edit_aturan/'.$this->input->post('id_aturan')));
	        }else{ 
				$cek = $this->Aturan_model->cek_aturanupdate($kode_aturan,$id_kriteria,$id);
				if($cek>0){
					$this->session->set_flashdata('message', 'Aturan <b>'.$kode_aturan.'</b> gagal diUpdate');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('aturan/edit_aturan/'.$this->input->post('id_aturan')));
				}else{
					$this->db->where('id_aturan',$id);
					$update = $this->db->update('master_aturan',$dataSimpan);
					if($update){
						$arr_pem = array();
						foreach($this->input->post('nilai') as $k=>$v){ 
				        	$arr_pem['nilai'][$k] = $v;
				        }
				        foreach($this->input->post('kondisi') as $k=>$v){ 
				        	$arr_pem['kondisi'][$k] = $v;
				        }  
				        $this->db->where('id_aturan',$id);
			        	$this->db->delete('master_aturandetail');
				        foreach($this->input->post('id_subkriteria') as $k=>$v){ 
				            $pemdet = array();
				            $pemdet['id_aturan'] 			= $id;  
				            $pemdet['id_subkriteria'] 		= $v;   
				            $pemdet['nilai']    		    = $arr_pem['nilai'][$k];
				            $pemdet['kondisi']   			= $arr_pem['kondisi'][$k]; 
				            $pemdet['dibuat_oleh']          = $this->session->userdata('id_pengguna'); 
				            $this->db->insert('master_aturandetail', $pemdet);  
				        } 
						$this->session->set_flashdata('message', 'Aturan <b>'.$kode_aturan.'</b> berhasil diUpdate');
						$this->session->set_flashdata('info', '1');
		  				redirect(site_url('aturan'));
					}else{
						$this->session->set_flashdata('message', 'Aturan <b>'.$kode_aturan.'</b> gagal diUpdate');
						$this->session->set_flashdata('info', '2');
		  				redirect(site_url('aturan/edit_aturan/'.$this->input->post('id_aturan')));
					}
				}
			}
			
		}
		
	}
}
