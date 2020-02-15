<?php

class Seleksi_model extends CI_Model {  
    function get_seleksi_list($limit, $start){ 
        $query = $this->db->get('seleksi', $limit, $start);
        return $query;
    } 

    function get_count_seleksi_list($q){ 
        $this->db->group_start();
        $this->db->or_like('keterangan', $q); 
        $this->db->or_like('tahun_penilaian', $q);  
        $this->db->or_like('status_seleksi', $q);   
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('seleksi');
        return $query->num_rows();
    } 
    
    function get_seleksi_list_search($limit, $start,$q){
    	$this->db->group_start();
        $this->db->or_like('keterangan', $q); 
        $this->db->or_like('tahun_penilaian', $q);  
        $this->db->or_like('status_seleksi', $q);   
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('seleksi', $limit, $start);
        return $query;
    } 
    function cek_seleksi($tahun_penilaian){
        $this->db->where('tahun_penilaian', $tahun_penilaian);  
        $query = $this->db->get('seleksi');
        return $query->num_rows(); 
    }
    function cek_seleksiupdate($tahun_penilaian,$id){
        $this->db->where('tahun_penilaian', $tahun_penilaian); 
        $this->db->where_not_in('id_seleksi', $id);
        $query = $this->db->get('seleksi');
        return $query->num_rows(); 
    }
}