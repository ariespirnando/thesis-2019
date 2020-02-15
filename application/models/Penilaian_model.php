<?php

class Penilaian_model extends CI_Model {  

    function get_penilaian_count_wrule(){ 
        $this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner');
        $this->db->where('master_divisi.id_divisi', $this->session->userdata('id_divisi'));
        $this->db->order_by("tahun_penilaian", "desc");
        $this->db->order_by("master_divisi.id_divisi", "desc");
        $query = $this->db->get('penilaian'); 
        return $query->num_rows();
    }

    function get_penilaian_list_wrule($limit, $start){ 
        $this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner');
        $this->db->where('master_divisi.id_divisi', $this->session->userdata('id_divisi'));
        $this->db->order_by("tahun_penilaian", "desc");
        $this->db->order_by("master_divisi.id_divisi", "desc");
        $query = $this->db->get('penilaian', $limit, $start);
        return $query;
    }
    function get_count_penilaian_list_wrule($q){ 
        $this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner'); 
        $this->db->where('master_divisi.id_divisi', $this->session->userdata('id_divisi'));
        $this->db->group_start();
        $this->db->or_like('nama_divisi', $q); 
        $this->db->or_like('tahun_penilaian', $q); 
        $this->db->or_like('status', $q); 
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $this->db->order_by("master_divisi.id_divisi", "desc");
        $query = $this->db->get('penilaian');
        return $query->num_rows();
    } 
    
    function get_penilaian_list_search_wrule($limit, $start,$q){
        $this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner'); 
        $this->db->where('master_divisi.id_divisi', $this->session->userdata('id_divisi'));
        $this->db->group_start();
        $this->db->or_like('nama_divisi', $q); 
        $this->db->or_like('tahun_penilaian', $q); 
        $this->db->or_like('status', $q);  
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $this->db->order_by("master_divisi.id_divisi", "desc");
        $query = $this->db->get('penilaian', $limit, $start);
        return $query;
    } 


    function get_penilaian_list($limit, $start){ 
        $this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner');
        $this->db->order_by("tahun_penilaian", "desc");
        $this->db->order_by("master_divisi.id_divisi", "desc");
        $query = $this->db->get('penilaian', $limit, $start);
        return $query;
    } 

    function get_subkriteria_list($tahun_penilaian){ 
        $this->db->join('master_kriteria','master_subkriteria.id_kriteria = master_kriteria.id_kriteria','inner');
        $this->db->where('tahun_penilaian', $tahun_penilaian);  
        $query = $this->db->get('master_subkriteria');
        return $query;
    } 

    function get_count_penilaian_list($q){ 
        $this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner'); 
        $this->db->group_start();
        $this->db->or_like('nama_divisi', $q); 
        $this->db->or_like('tahun_penilaian', $q); 
        $this->db->or_like('status', $q); 
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $this->db->order_by("master_divisi.id_divisi", "desc");
        $query = $this->db->get('penilaian');
        return $query->num_rows();
    } 
    
    function get_penilaian_list_search($limit, $start,$q){
        $this->db->join('master_divisi','master_divisi.id_divisi = penilaian.id_divisi','inner'); 
    	$this->db->group_start();
        $this->db->or_like('nama_divisi', $q); 
        $this->db->or_like('tahun_penilaian', $q); 
        $this->db->or_like('status', $q);  
        $this->db->group_end();
        $this->db->order_by("tahun_penilaian", "desc");
        $this->db->order_by("master_divisi.id_divisi", "desc");
        $query = $this->db->get('penilaian', $limit, $start);
        return $query;
    } 
    function cek_penilaian($id_divisi,$tahun_penilaian){
        $this->db->group_start();
        $this->db->where('id_divisi', $id_divisi); 
        $this->db->where('tahun_penilaian', $tahun_penilaian);  
        $this->db->group_end();
        $query = $this->db->get('penilaian');
        return $query->num_rows(); 
    }
    function cek_penilaianupdate($id_divisi,$tahun_penilaian,$id){
        $this->db->group_start();
        $this->db->or_where('id_divisi', $id_divisi); 
        $this->db->or_where('tahun_penilaian', $tahun_penilaian);  
        $this->db->group_end();
        $this->db->where_not_in('id_penilaian', $id);
        $query = $this->db->get('penilaian');
        return $query->num_rows(); 
    }
    function cekpenialainkriteria($tahun_penilaian){
        $cek = $this->db->query('SELECT `tahun_penilaian` FROM `master_kriteria` WHERE tahun_penilaian='.$tahun_penilaian);
        return $cek->num_rows();
    }
}