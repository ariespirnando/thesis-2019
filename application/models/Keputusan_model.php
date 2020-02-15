<?php

class Keputusan_model extends CI_Model {  
    function get_keputusan_list($limit, $start){ 
        $this->db->where('status_seleksi','Sudah diproses');
        $query = $this->db->get('seleksi', $limit, $start);
        return $query;
    } 

    function get_count_keputusan_list($q){ 
        $this->db->group_start();
        $this->db->or_like('keterangan', $q); 
        $this->db->or_like('tahun_penilaian', $q);  
        $this->db->or_like('status_keputusan', $q);   
        $this->db->group_end();
        $this->db->where('status_seleksi','Sudah diproses');
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('seleksi');
        return $query->num_rows();
    } 
    
    function get_keputusan_list_search($limit, $start,$q){
    	$this->db->group_start();
        $this->db->or_like('keterangan', $q); 
        $this->db->or_like('tahun_penilaian', $q);  
        $this->db->or_like('status_keputusan', $q);   
        $this->db->group_end();
        $this->db->where('status_seleksi','Sudah diproses');
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('seleksi', $limit, $start);
        return $query;
    } 
   
}