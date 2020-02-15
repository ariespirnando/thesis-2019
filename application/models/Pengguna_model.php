<?php

class Pengguna_model extends CI_Model {  
    function get_pengguna_list($limit, $start){ 
        $this->db->join('master_divisi','master_divisi.id_divisi = pengguna.id_divisi','inner'); 
        $query = $this->db->get('pengguna', $limit, $start);
        return $query;
    } 

    function get_count_pengguna_list($q){ 
        $this->db->join('master_divisi','master_divisi.id_divisi = pengguna.id_divisi','inner'); 
        $this->db->group_start();
        $this->db->or_like('username', $q); 
        $this->db->or_like('nama_pengguna', $q); 
        $this->db->or_like('nama_divisi', $q); 
        $this->db->group_end();
        $query = $this->db->get('pengguna');
        return $query->num_rows();
    } 
    
    function get_pengguna_list_search($limit, $start,$q){
        $this->db->join('master_divisi','master_divisi.id_divisi = pengguna.id_divisi','inner'); 
    	$this->db->group_start();
        $this->db->or_like('username', $q); 
        $this->db->or_like('nama_pengguna', $q);  
        $this->db->or_like('nama_divisi', $q); 
        $this->db->group_end();
        $query = $this->db->get('pengguna', $limit, $start);
        return $query;
    } 
    function cek_pengguna($username){  
        $this->db->where('username', $username);  
        $query = $this->db->get('pengguna');
        return $query->num_rows(); 
    }
    function cek_penggunaupdate($username,$id){
        $this->db->join('master_divisi','master_divisi.id_divisi = pengguna.id_divisi','inner');  
        $this->db->where('username', $username);  
        $this->db->where_not_in('id_pengguna', $id);
        $query = $this->db->get('pengguna');
        return $query->num_rows(); 
    } 
}