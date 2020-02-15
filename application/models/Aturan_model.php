<?php

class Aturan_model extends CI_Model {  
    function get_aturan_list($limit, $start){ 
        $this->db->join('master_kriteria','master_aturan.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $query = $this->db->get('master_aturan', $limit, $start);
        return $query;
    } 

    function get_count_aturan_list($q){ 
        $this->db->join('master_kriteria','master_aturan.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $this->db->group_start();
        $this->db->or_like('kode_aturan', $q); 
        $this->db->or_like('hasil', $q); 
        $this->db->or_like('nama_kriteria', $q); 
        $this->db->group_end();
        $query = $this->db->get('master_aturan');
        return $query->num_rows();
    } 
    
    function get_aturan_list_search($limit, $start,$q){
        $this->db->join('master_kriteria','master_aturan.id_kriteria = master_kriteria.id_kriteria','inner'); 
    	$this->db->group_start();
        $this->db->or_like('kode_aturan', $q); 
        $this->db->or_like('hasil', $q); 
        $this->db->or_like('nama_kriteria', $q);  
        $this->db->group_end();
        $query = $this->db->get('master_aturan', $limit, $start);
        return $query;
    } 
    function cek_aturan($kode,$id_kriteria){
        $this->db->join('master_kriteria','master_aturan.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $this->db->group_start();
        $this->db->where('kode_aturan', $kode); 
        $this->db->where('master_aturan.id_kriteria', $id_kriteria);  
        $this->db->group_end();
        $query = $this->db->get('master_aturan');
        return $query->num_rows(); 
    }
    function cek_aturanupdate($kode,$id_kriteria,$id){
        $this->db->join('master_kriteria','master_aturan.id_kriteria = master_kriteria.id_kriteria','inner'); 
        $this->db->group_start();
        $this->db->where('kode_aturan', $kode); 
        $this->db->where('master_aturan.id_kriteria', $id_kriteria);  
        $this->db->group_end();
        $this->db->where_not_in('id_aturan', $id);
        $query = $this->db->get('master_aturan');
        return $query->num_rows(); 
    }
}