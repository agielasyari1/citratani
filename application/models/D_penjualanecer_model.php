<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class D_penjualanecer_model extends CI_Model {
    
    var $table = 'd_penjualan_ecer';
    var $column = array('id','nama_barang','qty','harga_satuan','harga_total'); //set column field database for order and search
    var $order = array('id' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query($no_penjualan)
        {
         
        $this->db->from($this->table." dpp, barang b");
        $this->db->where("dpp.id_barang= b.id_barang");
        $this->db->where("no_penjualan", $no_penjualan);
       
 
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
        
    function count_filtered($no_penjualan)
    {
        $this->_get_datatables_query($no_penjualan);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($no_penjualan)
    {
        $this->db->from($this->table." dpp, barang b");
        $this->db->where("dpp.id_barang= b.id_barang");
        $this->db->where("no_penjualan", $no_penjualan);
        return $this->db->count_all_results();
    }
    
    function get_datatables($no_penjualan)
    {
        $this->_get_datatables_query($no_penjualan);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    
    function add(){
        $str = explode("-", $this->input->post('id_barang'));
        
        $this->db->where('no_penjualan',$this->input->post('no_penjualan'));
        $this->db->where('id_barang',$str[0]);
        $result = $this->db->get('d_penjualan_ecer');
        if($result->num_rows() > 0){
            $this->db->set('qty', 'qty+'.$this->input->post('qty'), FALSE);
            $this->db->set('harga_total', 'harga_total+'.$this->input->post('total'), FALSE);
            $this->db->where('no_penjualan', $this->input->post('no_penjualan'));
            $this->db->where('id_barang', $str[0]);
            $this->db->update('d_penjualan_ecer');
            $inserted = true;
        }else{
             $inserted = $this->db->insert('d_penjualan_ecer', array(
                'no_penjualan' => $this->input->post('no_penjualan'),
                'id_barang' => $str[0],
                'qty' => $this->input->post('qty'),
                'harga_satuan' => $this->input->post('harga_satuan'),
                'harga_total' => $this->input->post('total'),

            ));
        }
       
        return $inserted;
    }
    
    
    function detail($id){
        $this->db->select('no_penjualan, d.id_barang, nama_barang, harga_total, harga_satuan, qty, gudang');
        $this->db->where('d.id', $id);
        $this->db->where('d.id_barang = b.id_barang');
        $result = $this->db->get('d_penjualan_ecer d, barang b');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function update(){
        $str = explode("-", $this->input->post('id_barang'));
        $ubah = array(
            'id_barang' => $str[0],
            'qty' => $this->input->post('qty'),
            'harga_satuan' => $this->input->post('harga_satuan'),
            'harga_total' => $this->input->post('total'),
        );
        
        $this->db->where('id', $this->input->post('username2'));
        $this->db->update('d_penjualan_ecer', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
       
    function delete($id){
        
        $this->db->delete('d_penjualan_ecer', array('id' => $id));
        $jum_hapus = $this->db->affected_rows();
        
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
    function batal($id){
        
        $this->db->delete('d_penjualan_ecer', array('no_penjualan' => $id));
        $jum_hapus = $this->db->affected_rows();
        
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
    
}