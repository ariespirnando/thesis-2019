<?php

class Subkriteria_model extends CI_Model {  
    function get_subkriteria_list($limit, $start){ 
        $this->db->join('master_kriteria','master_subkriteria.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('master_subkriteria', $limit, $start);
        return $query;
    } 

    function get_count_subkriteria_list($q){ 
        $this->db->join('master_kriteria','master_subkriteria.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $this->db->group_start();
        $this->db->or_like('kode_subkriteria', $q); 
        $this->db->or_like('keterangan', $q); 
        $this->db->or_like('nama_kriteria', $q); 
        $this->db->or_like('tahun_penilaian', $q);
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('master_subkriteria');
        return $query->num_rows();
    } 
    
    function get_subkriteria_list_search($limit, $start,$q){
        $this->db->join('master_kriteria','master_subkriteria.id_kriteria = master_kriteria.id_kriteria','inner'); 
    	$this->db->group_start();
        $this->db->or_like('kode_subkriteria', $q); 
        $this->db->or_like('keterangan', $q); 
        $this->db->or_like('nama_kriteria', $q);  
        $this->db->or_like('tahun_penilaian', $q);
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('master_subkriteria', $limit, $start);
        return $query;
    } 
    function cek_subkriteria($kode,$id_kriteria){
        $this->db->join('master_kriteria','master_subkriteria.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $this->db->group_start();
        $this->db->where('kode_subkriteria', $kode); 
        $this->db->where('master_subkriteria.id_kriteria', $id_kriteria);  
        $this->db->group_end();
        $query = $this->db->get('master_subkriteria');
        return $query->num_rows(); 
    }
    function cek_subkriteriaupdate($kode,$id_kriteria,$id){
        $this->db->join('master_kriteria','master_subkriteria.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $this->db->group_start();
        $this->db->where('kode_subkriteria', $kode); 
        $this->db->where('master_subkriteria.id_kriteria', $id_kriteria);  
        $this->db->group_end();
        $this->db->where_not_in('id_subkriteria', $id);
        $query = $this->db->get('master_subkriteria');
        return $query->num_rows(); 
    }

    function cekpenilaian($id_subkriteria){
        $cek = $this->db->query('SELECT id_subkriteria FROM `penilaian_detail` WHERE id_subkriteria ='.$id_subkriteria);
        return $cek->num_rows();
    }
}