<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lb_model extends CI_Model {
    
    var $table = 'pembelian';
    var $column = array('no_pembelian','tanggal_permintaan','batas_pembayaran','nama_toko', 'total', 'pembayaran','total','pp.created_by', 'pp.updated_by', 'pp.updated_date'); //set column field database for order and search
    var $order = array('no_pembelian' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query($tipe, $awal, $akhir)
    {
        
        $this->db->from($this->table." pp");
        if($tipe == "A"){
            $this->db->where('gudang', 'A');
        }else{
            $this->db->where('gudang', 'B');
        }
        
        $this->db->join('supplier c', 'pp.id_supplier = c.id_supplier', 'left');
        $this->db->where('pp.tanggal_permintaan >=', $awal);
        $this->db->where('pp.tanggal_permintaan <=', $akhir);
        $this->db->order_by('no_pembelian', 'DESC');
      
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
        $this->db->from($this->table." pp");
        if($tipe == "A"){
            $this->db->where('gudang', 'A');
        }else{
            $this->db->where('gudang', 'B');
        }
        
        $this->db->join('supplier c', 'pp.id_supplier = c.id_supplier', 'left');
        $this->db->where('pp.tanggal_permintaan >=', $awal);
        $this->db->where('pp.tanggal_permintaan <=', $akhir);
        $this->db->order_by('no_pembelian', 'DESC');
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

        $query = $this->db->select('DISTINCT(LEFT(`tanggal_permintaan`, 4)) as tahun');
        $query = $this->db->get('pembelian');
        $list = array();
        if($query->result()){
            foreach ($query->result() as $tahun) {
                $list[$tahun->tahun] = $tahun->tahun;
            }
        } 

        return $list;
      
    }
    
 
    
    function total_table_beli($tipe, $awal, $akhir){
        $this->db->select('FORMAT(COALESCE(SUM(`total`),0),0,"de_DE") as tt, '
                . 'FORMAT(COALESCE(SUM(`pembayaran`),0),0,"de_DE") as tp, '
                . 'FORMAT(COALESCE(SUM(`sisa`),0),0,"de_DE") as ts');
        
        $this->db->where('tanggal_permintaan >=', $awal);
        $this->db->where('tanggal_permintaan <=', $akhir);
        if($tipe == "A"){
           $this->db->where('gudang','A');
        }else{
           $this->db->where('gudang','B');
        }
        $result = $this->db->get('pembelian');
        $data = $result->row();
        
        return $data;
    }
    
}