<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualanpartai_model extends CI_Model {
    
    var $table = 'penjualan_partai';
    var $column = array('no_penjualan','pp.created_date','nama_toko','grand_total','pembayaran', 'sisa', 'pp.created_by', 'pp.updated_by', 'pp.updated_date'); //set column field database for order and search
    var $order = array('no_penjualan' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query()
        {
         
        $this->db->select('no_penjualan, pp.created_date,nama_toko, grand_total, pembayaran, sisa, pp.created_by, pp.updated_by, pp.updated_date');
        $this->db->from($this->table." pp");
        $this->db->join('customer c', 'pp.id_customer = c.id_customer', 'left');
        if($this->session->userdata('posisi') != 1){
            $this->db->where('pp.created_date', date("Y-m-d"));
        }
        
        $this->db->order_by('no_penjualan', 'DESC');
 
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
        $this->db->from($this->table." pp, customer c");
        $this->db->where("pp.id_customer = c.id_customer");
        if($this->session->userdata('posisi') != 1){
            $this->db->where('pp.created_date', date("Y-m-d"));
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
    
    function add($no_penjualan){
        
        $inserted = $this->db->insert('penjualan_partai', array(
            'no_penjualan' => $no_penjualan,
            'proses' => 0,
            'created_by' => $this->session->userdata('username'),
            'created_date' => date("Y-m-d")
        ));
        
        return $inserted;
    }
    
    function cek_ada($no_penjualan){
        $this->db->where('no_penjualan',$no_penjualan);
        if($this->db->count_all_results('penjualan_partai') == 1){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    
    function generateNO(){
        
        $seg1 = "PJP";
        $seg2 = date("Ymd");
        
        $this->db->select("MAX(RIGHT(`no_penjualan`, 4)) as 'maxID'");
        $this->db->where("proses",1);
        $this->db->like('no_penjualan', $seg1.'-'.$seg2, 'after');
        $result = $this->db->get('penjualan_partai');
        $code = (int) substr($result->row(0)->maxID, 1, 4);
        $code++; 
        $data = $seg1."-".$seg2."-".sprintf("%04s", $code);
        
        return $data;
    }
    
   
    
    function detail($id){
        
        $this->db->select('id_customer');
        $this->db->where('no_penjualan', $id);
        $temp = $this->db->get('penjualan_partai')->row();
        
        if($temp->id_customer != ""){
            $this->db->where('no_penjualan', $id);
            $this->db->where('p.id_customer = c.id_customer');
            $result = $this->db->get('penjualan_partai p, customer c');
        }else{
            $this->db->where('no_penjualan', $id);
            $result = $this->db->get('penjualan_partai');
        }
        
        
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function get_total_jual($id){
        $this->db->select('total');
        $this->db->where('no_penjualan', $id);
        $result = $this->db->get('penjualan_partai');
        $data = array();
        if($result->result()){
            $data['total'] = "Rp. ".number_format($result->row(0)->total, 2, ',', '.');
        }
        return $data;
    }
    
    function update(){
        
        $str = explode("-", $this->input->post('id_customer'));
        
        $ubah = array(
            'id_customer' => $str[0],
            'pembayaran' => $this->input->post('ppembayaran'),
            'total' => $this->input->post('ptotal'),
            'grand_total' => $this->input->post('gtotal'),
            'ppn' => $this->input->post('ppn'),
            'sisa' => $this->input->post('psisa'),
            'proses' => 1,
            'updated_by' => $this->session->userdata('username'),
            'updated_date' => date("Y-m-d")
        );
        
        $this->db->where('no_penjualan', $this->input->post('pno_penjualan'));
        $this->db->update('penjualan_partai', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
       
    function delete($id){
        
        $this->db->select('proses');
        $this->db->where('no_penjualan', $id);
        $result = $this->db->get('penjualan_partai')->row();
        if($result->proses == 0){
            $this->db->select('id');
            $this->db->where('no_penjualan', $id);
            $result2 = $this->db->get('d_penjualan_partai');
            if($result2->num_rows() > 0){
                foreach ($result2->result() as $item){
                    $this->db->delete('d_penjualan_partai', array('id' => $item->id));
                }
            }
            
        }
        $this->db->delete('penjualan_partai', array('no_penjualan' => $id));
        $jum_hapus = $this->db->affected_rows();
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
}