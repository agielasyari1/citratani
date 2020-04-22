<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tl_model extends CI_Model {
    
    var $table = 'transaksi_lain';
    var $column = array('id_transaksi','keterangan','tanggal','total'); //set column field database for order and search
    var $order = array('id_transaksi' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query($awal, $akhir)
    {
        $this->db->from($this->table);
        $this->db->where('tanggal >=', $awal);
        $this->db->where('tanggal <=', $akhir);
        $this->db->order_by('tanggal', 'DESC');
      
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
        
    function count_filtered($awal, $akhir)
    {
        $this->_get_datatables_query($awal, $akhir);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($awal, $akhir)
    {
        $this->db->from($this->table);
        $this->db->where('tanggal >=', $awal);
        $this->db->where('tanggal <=', $akhir);
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->count_all_results();
    }
    
    function get_datatables($awal, $akhir)
    {
        $this->_get_datatables_query($awal, $akhir);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function daftar_tahun() {

        $query = $this->db->select('DISTINCT(LEFT(`tanggal`, 4)) as tahun');
        $query = $this->db->get('transaksi_lain');
        $list = array();
        if($query->result()){
            foreach ($query->result() as $tahun) {
                $list[$tahun->tahun] = $tahun->tahun;
            }
        } 

        return $list;
      
    }
    
   
    
    function total_table_jual($awal, $akhir){
        $this->db->select('FORMAT(COALESCE(SUM(`total`),0),0,"de_DE") as ttj');
        $this->db->where('tanggal >=', $awal);
        $this->db->where('tanggal <=', $akhir);
        $result = $this->db->get('transaksi_lain');
        $data = $result->row();
        
        return $data;
    }
    
}