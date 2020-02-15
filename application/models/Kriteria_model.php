<?php

class Kriteria_model extends CI_Model {  
    function get_kriteria_list($limit, $start){ 
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('master_kriteria', $limit, $start);
        return $query;
    } 

    function get_count_kriteria_list($q){ 
        $this->db->group_start();
        $this->db->or_like('kode_kriteria', $q); 
        $this->db->or_like('nama_kriteria', $q);  
        $this->db->or_like('tipe_kriteria', $q);
        $this->db->or_like('tahun_penilaian', $q); 
        $this->db->or_like('bobot', $q);  
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('master_kriteria');
        return $query->num_rows();
    } 
    
    function get_kriteria_list_search($limit, $start,$q){
    	$this->db->group_start();
        $this->db->or_like('kode_kriteria', $q); 
        $this->db->or_like('nama_kriteria', $q);  
        $this->db->or_like('tipe_kriteria', $q); 
        $this->db->or_like('tahun_penilaian', $q); 
        $this->db->or_like('bobot', $q);  
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $query = $this->db->get('master_kriteria', $limit, $start);
        return $query;
    } 
    function cek_kriteria($kode,$tahun_penilaian){
        $this->db->group_start();
        $this->db->or_where('kode_kriteria', $kode);  
        $this->db->or_where('tahun_penilaian', $tahun_penilaian);  
        $this->db->group_end(); 
        $query = $this->db->get('master_kriteria');
        return $query->num_rows(); 
    }
    function cek_kriteriaupdate($kode,$tahun_penilaian,$id){
        $this->db->group_start();
        $this->db->or_where('kode_kriteria', $kode); 
        $this->db->or_where('tahun_penilaian', $tahun_penilaian);   
        $this->db->group_end();
        $this->db->where_not_in('id_kriteria', $id);
        $query = $this->db->get('master_kriteria');
        return $query->num_rows(); 
    }
    function cekpenilaian($tahun_penilaian){
        $cek = $this->db->query('SELECT tahun_penilaian FROM `penilaian` WHERE tahun_penilaian = '.$tahun_penilaian);
        return $cek->num_rows();
    }
}