<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lj_model extends CI_Model {
    
    var $table = 'penjualan_partai';
    var $column = array('no_penjualan','pp.created_date','nama_toko','grand_total','pembayaran', 'sisa'); //set column field database for order and search
    var $order = array('no_penjualan' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query($tipe, $awal, $akhir)
    {
        
       if($tipe == "ecer"){
            $this->table = "penjualan_ecer";
            $this->column = NULL;
            $this->column = array('no_penjualan','pp.created_date','nama_pembeli','grand_total','pembayaran', 'sisa');
            $this->order = NULL;
            $this->order = array('no_penjualan' => 'desc');
        }
        $this->db->from($this->table.' pp');
        if($tipe != "ecer"){
             $this->db->join('customer c', 'pp.id_customer = c.id_customer', 'left');
        }
        $this->db->where('pp.created_date >=', $awal);
        $this->db->where('pp.created_date <=', $akhir);
        $this->db->order_by('no_penjualan', 'DESC');
        //if($id != "semua"){
        //}
      
        $i = 0;
     
        foreach ($this->column as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
        
    function count_filtered($tipe, $awal, $akhir)
    {
        $this->_get_datatables_query($tipe, $awal, $akhir);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($tipe, $awal, $akhir)
    {
        
        if($tipe == "ecer"){
            $this->table = "penjualan_ecer";
            $this->column = NULL;
            $this->column = array('no_penjualan','pp.created_date','nama_pembeli','grand_total','pembayaran', 'sisa');
            $this->order = NULL;
            $this->order = array('no_penjualan' => 'desc');
        }
        $this->db->from($this->table.' pp');
        if($tipe != "ecer"){
             $this->db->join('customer c', 'pp.id_customer = c.id_customer', 'left');
        }
        $this->db->where('pp.created_date >=', $awal);
        $this->db->where('pp.created_date <=', $akhir);
        $this->db->order_by('no_penjualan', 'DESC');
        return $this->db->count_all_results();
    }
    
    function get_datatables($tipe, $awal, $akhir)
    {
        $this->_get_datatables_query($tipe, $awal, $akhir);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function daftar_tahun() {

        $query = $this->db->select('DISTINCT(LEFT(`created_date`, 4)) as tahun');
        $query = $this->db->get('penjualan_partai');
        $list = array();
        if($query->result()){
            foreach ($query->result() as $tahun) {
                $list[$tahun->tahun] = $tahun->tahun;
            }
        } 

        return $list;
      
    }
    
 
    
    function total_table_jual($tipe, $awal, $akhir){
//        $this->db->select('FORMAT(COALESCE(SUM(`grand_total`),0),0,"de_DE") as tt, '
//                . 'FORMAT(COALESCE(SUM(`pembayaran`),0),0,"de_DE") as tp, '
//                . 'FORMAT(COALESCE(SUM(`sisa`),0),0,"de_DE") as ts');
        $this->db->select('COALESCE(SUM(`grand_total`),0) as tt, '
                . 'COALESCE(SUM(`pembayaran`),0) as tp, '
                . 'COALESCE(SUM(`sisa`),0) as ts');
        
        $this->db->where('created_date >=', $awal);
        $this->db->where('created_date <=', $akhir);
        $result = $this->db->get('penjualan_ecer')->row();
 
        $this->db->select('COALESCE(SUM(`grand_total`),0) as tt, '
                . 'COALESCE(SUM(`pembayaran`),0) as tp, '
                . 'COALESCE(SUM(`sisa`),0) as ts');
        
        $this->db->where('created_date >=', $awal);
        $this->db->where('created_date <=', $akhir);
        $result2 = $this->db->get('penjualan_partai')->row();
    
        $data = array(
            'tt' => number_format($result->tt + $result2->tt, 0, '.', ','),
            'tp' => number_format($result->tp + $result2->tp, 0, '.', ','),
            'ts' => number_format($result->ts + $result2->ts, 0, '.', ',')
        );
        
        return $data;
    }
    
}