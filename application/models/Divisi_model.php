<?php

class Divisi_model extends CI_Model {  
    function get_divisi_list($limit, $start){ 
        $query = $this->db->get('master_divisi', $limit, $start);
        return $query;
    } 

    function get_count_divisi_list($q){ 
        $this->db->group_start();
        $this->db->or_like('kode_divisi', $q); 
        $this->db->or_like('nama_divisi', $q);  
        $this->db->group_end();
        $query = $this->db->get('master_divisi');
        return $query->num_rows();
    } 
    
    function get_divisi_list_search($limit, $start,$q){
    	$this->db->group_start();
        $this->db->or_like('kode_divisi', $q); 
        $this->db->or_like('nama_divisi', $q);  
        $this->db->group_end();
        $query = $this->db->get('master_divisi', $limit, $start);
        return $query;
    } 
    function cek_divisi($kode,$nama){
        $this->db->group_start();
        $this->db->or_where('kode_divisi', $kode); 
        $this->db->or_where('nama_divisi', $nama);  
        $this->db->group_end();
        $query = $this->db->get('master_divisi');
        return $query->num_rows(); 
    }
    function cek_divisiupdate($kode,$nama,$id){
        $this->db->group_start();
        $this->db->or_where('kode_divisi', $kode); 
        $this->db->or_where('nama_divisi', $nama);  
        $this->db->group_end();
        $this->db->where_not_in('id_divisi', $id);
        $query = $this->db->get('master_divisi');
        return $query->num_rows(); 
    }
    function cekpenilaian($id){
        $cek = $this->db->query('SELECT id_penilaian FROM penilaian WHERE id_penilaian ='.$id);
        return $cek->num_rows();
    }
}