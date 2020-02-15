<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){    
	  parent::__construct();  
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      } 
	}
	public function index()
	{  
		$data['modul'] = 'Home';  
		$this->template->load('template_wp','home/home', $data);
	} 
 
	function randomdata(){
		$tahun = 2018;

		$this->db->query('DELETE  FROM penilaian_detail 
			WHERE id_penilaian IN (SELECT id_penilaian FROM penilaian WHERE tahun_penilaian='.$tahun.')');
		$this->db->where('tahun_penilaian',$tahun);
		$this->db->delete('penilaian');

		$data  = $this->db->get('master_divisi')->result_array(); 
		foreach ($data as $d) {
			$dataSimpan = array(
				'id_divisi'=>$d['id_divisi'],
				'tahun_penilaian'=>$tahun, 
				'status'=>'Finish',
				'dibuat_oleh'=>$this->session->userdata('id_pengguna')
			); 
			$this->db->insert('penilaian',$dataSimpan);
		}

		$this->db->where('tahun_penilaian',$tahun);
		$data  = $this->db->get('penilaian')->result_array();

		foreach ($data as $d) {
			$this->db->where('tahun_penilaian',$tahun);
			$kriteria  = $this->db->get('master_kriteria')->result_array(); 
			foreach ($kriteria as $k) {
				$this->db->where('id_kriteria',$k['id_kriteria']);
				$subkriteria  = $this->db->get('master_subkriteria')->result_array(); 
				foreach ($subkriteria as $s) {
					$pemdet = array(); 
					$pemdet['id_penilaian'] = $d['id_penilaian']; 
					$pemdet['id_kriteria'] = $k['id_kriteria']; 
					$pemdet['id_subkriteria'] = $s['id_subkriteria']; 

					$load = $this->db->query('SELECT `id_subkriteriadetail` 
						FROM `master_subkriteriadetail`
						WHERE `id_subkriteria` = '.$s['id_subkriteria'].'
						ORDER BY RAND()
						LIMIT 1')->row_array();

					$pemdet['id_subkriteriadetail'] = $load['id_subkriteriadetail'];
					$this->db->insert('penilaian_detail',$pemdet);
				}
			}
			
		}
		
		echo 'SUCCESS DATA FULL.........................'; 
	}
	
}
