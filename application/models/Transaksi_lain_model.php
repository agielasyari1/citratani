<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_lain_model extends CI_Model {
    
    var $table = 'transaksi_lain';
    var $column = array('id_transaksi','keterangan','total', 'tanggal'); //set column field database for order and search
    var $order = array('id_transaksi' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query()
        {
         
        $this->db->from($this->table);
        if($this->session->userdata('posisi') != 1){
            $this->db->where('tanggal', date("Y-m-d"));
        }
 
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
        
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        if($this->session->userdata('posisi') != 1){
            $this->db->where('tanggal', date("Y-m-d"));
        }
        return $this->db->count_all_results();
    }
    
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function generateNO(){
        
        $seg1 = "TL";
        $seg2 = date("Ymd");
        
        $this->db->select("MAX(RIGHT(`id_transaksi`, 4)) as 'maxID'");
        $this->db->like('id_transaksi', $seg1.'-'.$seg2, 'after');
        $result = $this->db->get('transaksi_lain');
        $code = (int) substr($result->row(0)->maxID, 1, 4);
        $code++; 
        $data = array(
                'no_penjualan' => $seg1."-".$seg2."-".sprintf("%04s", $code)
            ); 
        
        return $data;
    }
    
    
    
    function add(){
        
        $inserted = $this->db->insert('transaksi_lain', array(
            'id_transaksi' => $this->input->post('no_penjualan'),
            'keterangan' => $this->input->post('keterangan'),
            'total' => $this->input->post('total'),
            'tanggal' => date("Y-m-d")
        )); 
        
        return $inserted;
    }
    
    function detail($id){
        $this->db->where('id_transaksi', $id);
        $result = $this->db->get('transaksi_lain');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function update(){
        
        $ubah = array(
            'keterangan' => $this->input->post('keterangan'),
            'total' => $this->input->post('total'),
        );
        
        $this->db->where('id_transaksi', $this->input->post('username2'));
        $this->db->update('transaksi_lain', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
       
    function delete($id){
        
        $this->db->delete('transaksi_lain', array('id_transaksi' => $id));
        $jum_hapus = $this->db->affected_rows();
        
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
}