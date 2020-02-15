<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	public function __construct(){    
	  parent::__construct();  
	  if(!$this->session->userdata('id_pengguna')){   
        redirect('Login');
      } 
	  $this->load->model(array('Laporan_model')); 
      $this->load->library(array('pagination','pdf'));
	}
	
	public function index(){ 
		$data['add']   = base_url().'index.php/laporan/add_laporan';
		$data['modul'] = 'Laporan';  
		$search_text = "";
	    if($this->input->post('submit') != NULL ){
	      $search_text = $this->input->post('search');
	      $this->session->set_userdata(array("search_laporan"=>$search_text));
	    }else{
	      if($this->session->userdata('search_laporan') != NULL){
	        $search_text = $this->session->userdata('search_laporan');
	      }
	    }

	    if($this->input->post('reset') != NULL ){
	      $search_text = '';
	      $this->session->set_userdata(array("search_laporan"=>$search_text));
	    }

        $config['base_url'] = site_url('laporan/index');   
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
        	$data['seleksi'] = $this->Laporan_model->get_laporan_list($config["per_page"], $data['page'])->result_array(); 
        }else{
        	$config['total_rows'] = $this->Laporan_model->get_count_laporan_list($search_text); 
        	$choice = $config["total_rows"] / $config["per_page"];
	        $config["num_links"] = floor($choice); 
	        $this->pagination->initialize($config);
	        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
	        $data['pagination'] = $this->pagination->create_links();
	        $data['search'] = $search_text;
        	$data['seleksi'] = $this->Laporan_model->get_laporan_list_search($config["per_page"], $data['page'],$search_text)->result_array(); 
        }  
        $this->template->load('template_wp','laporan/laporan_view', $data);
	} 

	function print_laporan(){
		$id =  $this->encrypt->decode($this->uri->segment(3));
		$tipe =  $this->input->post('tipe');
		$this->db->where('id_seleksi',$id);
		$query = $this->db->get('seleksi');
		$dt = $query->row_array();

		$this->db->join('master_divisi','master_divisi.id_divisi = seleksi_hasil.id_divisi','inner');
		$this->db->where('id_seleksi',$id);
		$query = $this->db->get('seleksi_hasil');
		$total_awal = $query->num_rows();
		$data_awal = $query->result_array();
		//print_r($this->db->last_query());
		 
		
		$pdf = new FPDF('p','mm','A5'); 
		$pdf->setMargins(5,4,5); 

		$pdf->AddPage(); 
 		//Ini Header 
 		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,10,'Laporan Seleksi Penilaian Kinerja Divisi Tahun '.$dt['tahun_penilaian']);   
		$pdf->SetLineWidth(1);
		$pdf->Line(6,15,143,15); 
		$pdf->Cell(10,15,'',0,1);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(80,7,'Jumlah divisi yang dilakukan proses Seleksi',0,0);
		$pdf->Cell(5,7,':',0,0); 
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(5,7,$total_awal,0,0);


		$pdf->Cell(10,8,'',0,1);
		 
		$pdf->SetFont('Arial','B',8);
		$pdf->SetLineWidth(0);
		$pdf->Cell(35,6,'Kode Divisi',1,0);
		$pdf->Cell(103,6,'Nama Divisi',1,1); 
		$pdf->SetFont('Arial','',8);

		$numdl = 0;
		$numtdl = 0;
		foreach ($data_awal as $d) {
		 	$pdf->Cell(35,6,$d['kode_divisi'],1,0);
			$pdf->Cell(103,6,substr($d['nama_divisi'], 0, 35),1,1);
			if($d['hasil']=='Dilanjutkan') {
				$numdl++;
			}else{
				$numtdl++;
			}
		 } 

		$pdf->AddPage(); 
 		//Ini Header 
 		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,10,'Laporan Seleksi Penilaian Kinerja Divisi Tahun '.$dt['tahun_penilaian']);   
		$pdf->SetLineWidth(1);
		$pdf->Line(6,15,143,15); 
		$pdf->Cell(10,15,'',0,1);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(80,7,'Jumlah divisi yang tidak masuk kriteria penilaian',0,0);
		$pdf->Cell(5,7,':',0,0);  
		$pdf->Cell(5,7,$numtdl,0,1);
		$pdf->Cell(80,7,'Jumlah divisi yang  masuk kriteria penilaian',0,0);
		$pdf->Cell(5,7,':',0,0); 
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(5,7,$numdl,0,1); 
		$pdf->Cell(10,2,'',0,1);
		 
		$pdf->SetFont('Arial','B',8);
		$pdf->SetLineWidth(0);
		$pdf->Cell(35,6,'Kode Divisi',1,0);
		$pdf->Cell(68,6,'Nama Divisi',1,0);
		$pdf->Cell(35,6,'Status',1,1); 
		$pdf->SetFont('Arial','',8);

		$numdl = 0;
		$numtdl = 0;

		$this->db->join('master_divisi','master_divisi.id_divisi = seleksi_hasil.id_divisi','inner');
		$this->db->where('id_seleksi',$id);
		$this->db->order_by("hasil", "asc");
		$query = $this->db->get('seleksi_hasil');
		$data_awal = $query->result_array();

		foreach ($data_awal as $d) { 
		 	$pdf->Cell(35,6,$d['kode_divisi'],1,0);
			$pdf->Cell(68,6,substr($d['nama_divisi'], 0, 35),1,0);
			$pdf->Cell(35,6,$d['hasil'],1,1); 
		} 

		$pdf->AddPage(); 
 		//Ini Header 
 		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,10,'Laporan Seleksi Penilaian Kinerja Divisi Tahun '.$dt['tahun_penilaian']);   
		$pdf->SetLineWidth(1);
		$pdf->Line(6,15,143,15); 
		$pdf->Cell(10,15,'',0,1);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(80,7,'Hasil perangkingan divisi yang dilakukan',0,1); 
		$pdf->Cell(10,2,'',0,1);
		 
		$pdf->SetFont('Arial','B',8);
		$pdf->SetLineWidth(0);
		$pdf->Cell(35,6,'Kode Divisi',1,0);
		$pdf->Cell(68,6,'Nama Divisi',1,0);
		$pdf->Cell(20,6,'Nilai',1,0);
		$pdf->Cell(15,6,'Peringkat',1,1); 
		$pdf->SetFont('Arial','',8);

		$numdl = 0;
		$numtdl = 0;

		$this->db->join('master_divisi','master_divisi.id_divisi = seleksi_hasil.id_divisi','inner');
		$this->db->where('id_seleksi',$id);
		$this->db->where('hasil','Dilanjutkan');
		$this->db->order_by("peringkat", "asc");
		$query = $this->db->get('seleksi_hasil');
		$data_awal = $query->result_array();

		foreach ($data_awal as $d) {
		 	$pdf->Cell(35,6,$d['kode_divisi'],1,0);
			$pdf->Cell(68,6,substr($d['nama_divisi'], 0, 35),1,0);
			$pdf->Cell(20,6,$d['prefrensi'],1,0);
			$pdf->Cell(15,6,$d['peringkat'],1,1); 
		} 
 		
 		$pdf->AddPage(); 
 		//Ini Header 
 		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,10,'Laporan Seleksi Penilaian Kinerja Divisi Tahun '.$dt['tahun_penilaian']);   
		$pdf->SetLineWidth(1);
		$pdf->Line(6,15,143,15); 
		$pdf->Cell(10,15,'',0,1);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(80,7,'Keputusan penilaian yang diambil oleh Direksi dan Manajemen',0,1); 
		$pdf->Cell(10,2,'',0,1);
		 
		$pdf->SetFont('Arial','B',8);
		$pdf->SetLineWidth(0);
		$pdf->Cell(35,6,'Kode Divisi',1,0);
		$pdf->Cell(68,6,'Nama Divisi',1,0);
		$pdf->Cell(20,6,'Nilai',1,0);
		$pdf->Cell(15,6,'Peringkat',1,1); 
		$pdf->SetFont('Arial','',8);

		$numdl = 0;
		$numtdl = 0;

		$this->db->join('master_divisi','master_divisi.id_divisi = seleksi_hasil.id_divisi','inner');
		$this->db->where('id_seleksi',$id);
		$this->db->where('ikeputusan','1');
		$this->db->where('hasil','Dilanjutkan');
		$this->db->order_by("peringkat", "asc");
		$query = $this->db->get('seleksi_hasil');
		$data_awal = $query->result_array();

		foreach ($data_awal as $d) {
		 	$pdf->Cell(35,6,$d['kode_divisi'],1,0);
			$pdf->Cell(68,6,substr($d['nama_divisi'], 0, 35),1,0);
			$pdf->Cell(20,6,$d['prefrensi'],1,0);
			$pdf->Cell(15,6,$d['peringkat'],1,1); 
		} 

 

		$pdf->Output('D','HASIL_SELEKSI_PENILIAN_TAHUN_'.$dt['tahun_penilaian'].'.pdf');
	}
 
}
