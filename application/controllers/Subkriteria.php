<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subkriteria extends CI_Controller {
	public function __construct(){    
	  parent::__construct(); 
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      } 
	  $this->load->model(array('Subkriteria_model'));
      $this->load->library('pagination');
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/subkriteria/add_subkriteria';
		$data['modul'] = 'Master';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_subkriteria"=>$search_text));
	    }else{
	      if($this->session->userdata('search_subkriteria') != NULL){
	        $search_text = $this->session->userdata('search_subkriteria');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_subkriteria"=>$search_text));
	    }

        $config['base_url'] = site_url('subkriteria/index');   
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        if($search_text==""){
        	$config['total_rows'] = $this->db->count_all('master_subkriteria'); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['subkriteria'] = $this->Subkriteria_model->get_subkriteria_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Subkriteria_model->get_count_subkriteria_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['subkriteria'] = $this->Subkriteria_model->get_subkriteria_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $this->template->load('template_wp','subkriteria/subkriteria_view', $data);
	} 

	function add_subkriteria(){
		$data['action'] = base_url().'index.php/subkriteria/save_subkriteria';
		$data['res']	= array();
		$data['modul'] = 'Master';
		$data['kriteria'] = $this->db->get('master_kriteria')->result_array();
		$this->template->load('template_wp','subkriteria/subkriteria_add', $data);
	}

	function edit_subkriteria(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/subkriteria/update_subkriteria'; 
		$this->db->where('id_subkriteria',$id);
		$data['id']		=  $this->uri->segment(3);
		$data['res']	= $this->db->get('master_subkriteria')->row_array();
		$data['modul'] = 'Master';
		$data['kriteria'] = $this->db->get('master_kriteria')->result_array();
		$this->db->where('id_subkriteria',$id);
		$kd = $this->db->get('master_subkriteriadetail');
		$data['kriteria_detail'] = $kd->result_array();
		$data['kriteria_detailnums'] = $kd->num_rows();
		$this->template->load('template_wp','subkriteria/subkriteria_edit', $data);
	}

	function view_subkriteria(){ 
	 	$id =  $this->encrypt->decode($this->uri->segment(3));
		$data['action'] = base_url().'index.php/subkriteria/update_subkriteria'; 
		$this->db->where('id_subkriteria',$id);
		$data['id']		=  $this->uri->segment(3);
		$data['res']	= $this->db->get('master_subkriteria')->row_array();
		$data['modul'] = 'Master';
		$data['kriteria'] = $this->db->get('master_kriteria')->result_array();
		$this->db->where('id_subkriteria',$id);
		$kd = $this->db->get('master_subkriteriadetail');
		$data['kriteria_detail'] = $kd->result_array();
		$data['kriteria_detailnums'] = $kd->num_rows();
		$this->template->load('template_wp','subkriteria/subkriteria_viewd', $data);
	}

	function hapus_subkriteria(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$this->db->where('id_subkriteria',$id);
		$cek = $this->db->get('master_subkriteria');  
		if($cek->num_rows()>0){
			$dt = $cek->row_array();
			$cek2 = $this->Subkriteria_model->cekpenilaian($id);
			if($cek2>0){
				$this->session->set_flashdata('message', 'Subkriteria <b>'.$dt['keterangan'].'</b> berhasil Dihapus');
				$this->session->set_flashdata('info', '1');
  				redirect(site_url('subkriteria'));
			}else{
				$this->db->where('id_subkriteria',$id);
				$delete = $this->db->delete('master_subkriteria'); 
				if($delete){
					$this->session->set_flashdata('message', 'Subkriteria <b>'.$dt['keterangan'].'</b> berhasil Dihapus');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('subkriteria'));
				}else{
					$this->session->set_flashdata('message', 'Subkriteria gagal Dihapus');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('subkriteria'));
				}
			} 
		}else{
			$this->session->set_flashdata('message', 'Subkriteria gagal Dihapus');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('subkriteria'));
		}
			
	}

	function save_subkriteria(){
		$kode_subkriteria = $this->input->post('kode_subkriteria');
		$keterangan = $this->input->post('keterangan'); 
		$id_kriteria = $this->input->post('id_kriteria'); 
		$tipe_subkriteria = $this->input->post('tipe_subkriteria');  

		if($kode_subkriteria=='' || $id_kriteria==''){
			$this->session->set_flashdata('message', 'Kode Subkriteria atau Nama Kriteria tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('subkriteria/add_subkriteria'));
		}else{
			$dataSimpan = array(
				'kode_subkriteria'=>$kode_subkriteria,
				'keterangan'=>$keterangan, 
				'id_kriteria'=>$id_kriteria,
				'tipe_subkriteria'=>$tipe_subkriteria, 
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 

			$cek = $this->Subkriteria_model->cek_subkriteria($kode_subkriteria,$id_kriteria);
			if($cek>0){
				$this->session->set_flashdata('message', 'Subkriteria <b>'.$keterangan.'</b> sudah tersedia');
				$this->session->set_flashdata('info', '2');
	  			redirect(site_url('subkriteria/add_subkriteria')); 
			}else{
				$insert = $this->db->insert('master_subkriteria',$dataSimpan);
				$id_subkriteria = $this->db->insert_id();
				if($insert){
					$arr_pem = array(); 
			        foreach($this->input->post('nilai_awal') as $k=>$v){ 
			        	$arr_pem['nilai_awal'][$k] = $v;
			        }
			        foreach($this->input->post('nilai_akhir') as $k=>$v){ 
			        	$arr_pem['nilai_akhir'][$k] = $v;
			        }
			        foreach($this->input->post('nilai_aktual') as $k=>$v){ 
			        	$arr_pem['nilai_aktual'][$k] = $v;
			        }  
			        $nn=0;
			        foreach($this->input->post('keteranganp') as $k=>$v){ 
			            $pemdet = array();
			            $pemdet['id_subkriteria'] 		= $id_subkriteria;  
			            $pemdet['keterangan'] 			= $v;   
			            $pemdet['nilai_aktual']    		= $arr_pem['nilai_aktual'][$k];
			            $pemdet['nilai_awal']   		= $arr_pem['nilai_awal'][$k];
			            $pemdet['nilai_akhir']  		= $arr_pem['nilai_akhir'][$k];
			            $pemdet['dibuat_oleh']          = $this->session->userdata('id_pengguna');
			            $pemdet['urutan_penilaian']		= $nn++;
			            $this->db->insert('master_subkriteriadetail', $pemdet);  
			        }    
					$this->session->set_flashdata('message', 'Subkriteria <b>'.$keterangan.'</b> berhasil Ditambahkan');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('subkriteria'));
				}else{
					$this->session->set_flashdata('message', 'Subkriteria <b>'.$keterangan.'</b> gagal Ditambahkan');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('subkriteria/add_subkriteria'));
				} 
			} 
		}
		
	}
	function update_subkriteria(){
		$kode_subkriteria = $this->input->post('kode_subkriteria');
		$keterangan = $this->input->post('keterangan'); 
		$id_kriteria = $this->input->post('id_kriteria'); 
		$tipe_subkriteria = $this->input->post('tipe_subkriteria');  
		$id = $this->encrypt->decode($this->input->post('id_subkriteria'));

		if($id_kriteria=='' || $kode_subkriteria==''){
			$this->session->set_flashdata('message', 'Kode Subkriteria atau Nama Kriteria tidak terisi');
			$this->session->set_flashdata('info', '2');
  			redirect(site_url('subkriteria/add_subkriteria'));
		}else{
			$dataSimpan = array(
				'kode_subkriteria'=>$kode_subkriteria,
				'keterangan'=>$keterangan,
				'id_kriteria'=>$id_kriteria,
				'tipe_subkriteria'=>$tipe_subkriteria, 
				'dibuat_oleh'=>$this->session->userdata('id_pengguna') 
			); 
			$cek = $this->Subkriteria_model->cek_subkriteriaupdate($kode_subkriteria,$id_kriteria,$id);
			$cek2 = $this->Subkriteria_model->cekpenilaian($id);
			if($cek>0 || $cek2){
				$this->session->set_flashdata('message', 'Subkriteria <b>'.$keterangan.'</b> gagal diUpdate');
				$this->session->set_flashdata('info', '2');
  				redirect(site_url('subkriteria/edit_subkriteria/'.$this->input->post('id_subkriteria')));
			}else{
				$this->db->where('id_subkriteria',$id);
				$update = $this->db->update('master_subkriteria',$dataSimpan);
				if($update){
					
					$arr_pem = array();
					foreach($this->input->post('nilai_awal') as $k=>$v){ 
			        	$arr_pem['nilai_awal'][$k] = $v;
			        }
			        foreach($this->input->post('nilai_akhir') as $k=>$v){ 
			        	$arr_pem['nilai_akhir'][$k] = $v;
			        }
			        foreach($this->input->post('nilai_aktual') as $k=>$v){ 
			        	$arr_pem['nilai_aktual'][$k] = $v;
			        } 
			        foreach($this->input->post('keteranganp') as $k=>$v){ 
			        	$arr_pem['keteranganp'][$k] = $v;
			        }

			        $arrdelete = array();
			        foreach($this->input->post('id_subkriteriadetail') as $k=>$v){  
			        	if($v!="" || !empty($v)){
			        		array_push($arrdelete, $v);
			        	}
			        }   
			        
			        $this->db->where_not_in('id_subkriteriadetail',$arrdelete);
			        $this->db->where('id_subkriteria',$id); 
			        $this->db->delete('master_subkriteriadetail'); 

			        $nn=0;
			        foreach($this->input->post('id_subkriteriadetail') as $k=>$v){ 
			        	$pemdet = array();
			            $pemdet['id_subkriteria'] 		= $id;  
			            $pemdet['keterangan'] 			= $arr_pem['keteranganp'][$k];   
			            $pemdet['nilai_aktual']    		= $arr_pem['nilai_aktual'][$k];
			            $pemdet['nilai_awal']   		= $arr_pem['nilai_awal'][$k];
			            $pemdet['nilai_akhir']  		= $arr_pem['nilai_akhir'][$k];
			            $pemdet['dibuat_oleh']          = $this->session->userdata('id_pengguna');
			            $pemdet['urutan_penilaian']		= $nn++;
			        	if($v=="" || empty($v)){ 
				            $this->db->insert('master_subkriteriadetail', $pemdet); 
			        	}else{
			        		$this->db->where('id_subkriteriadetail',$v);
			        		$this->db->update('master_subkriteriadetail', $pemdet); 
			        	} 
			        }    

					$this->session->set_flashdata('message', 'Subkriteria <b>'.$keterangan.'</b> berhasil diUpdate');
					$this->session->set_flashdata('info', '1');
	  				redirect(site_url('subkriteria'));
				}else{
					$this->session->set_flashdata('message', 'Subkriteria <b>'.$keterangan.'</b> gagal diUpdate');
					$this->session->set_flashdata('info', '2');
	  				redirect(site_url('subkriteria/edit_subkriteria/'.$this->input->post('id_subkriteria')));
				}
			}
			
		}
		
	}
}
