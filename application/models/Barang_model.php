<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {
    
    var $table = 'barang';
    var $column = array('id_barang', 'nama_barang', 'stok', 'hrg_beli','hrg_jual_eceran','hrg_jual_grosir', 'gudang', 'nama_kategori','nama_satuan'); //set column field database for order and search
    var $order = array('id_barang' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query()
        {
         
        $this->db->from($this->table." b,kategori k, satuan r");
        $this->db->where("b.id_kategori=k.id_kategori");
        $this->db->where("b.id_satuan=r.id_satuan");
        
        //$this->db->order_by('id_jenjang', 'DESC');
 
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
    
    function daftar_barang($term) {
        $this->db->like('nama_barang',$term, 'both');
        $this->db->where('gudang',"Gudang A");
        $this->db->where('stok > 0');
        $query = $this->db->get('barang');
        $list = array();
        
        if($query->result()){
            foreach ($query->result() as $barang) {
                $list[] = $barang->id_barang.'- '.$barang->nama_barang;
            }
        }else{
            $list[] = "Tidak ditemukan...";
        } 

        return $list;
      
    }
    function daftar_barangB($term) {
        $this->db->like('nama_barang',$term, 'both');
        $this->db->where('gudang',"Gudang B");
        $this->db->where('stok > 0');
        $query = $this->db->get('barang');
        $list = array();
        
        if($query->result()){
            foreach ($query->result() as $barang) {
                $list[] = $barang->id_barang.'- '.$barang->nama_barang;
            }
        }else{
            $list[] = "Tidak ditemukan...";
        } 

        return $list;
      
    }
    function daftar_barang2($term) {
        $this->db->like('nama_barang',$term, 'both');
        $this->db->where('gudang',"Gudang A");
        $query = $this->db->get('barang');
        $list = array();
        
        if($query->result()){
            foreach ($query->result() as $barang) {
                $list[] = $barang->id_barang.'- '.$barang->nama_barang;
            }
        }else{
            $list[] = "Tidak ditemukan...";
        } 

        return $list;
      
    }
    function daftar_barangB2($term) {
        $this->db->like('nama_barang',$term, 'both');
        $this->db->where('gudang',"Gudang B");
        $query = $this->db->get('barang');
        $list = array();
        
        if($query->result()){
            foreach ($query->result() as $barang) {
                $list[] = $barang->id_barang.'- '.$barang->nama_barang;
            }
        }else{
            $list[] = "Tidak ditemukan...";
        } 

        return $list;
      
    }
     function add(){
        $inserted = $this->db->insert('barang', array(
            'nama_barang' => $this->input->post('nama_barang'),
            'stok' => $this->input->post('stok'),
            'id_satuan' => $this->input->post('satuan'),
            'hrg_beli' => $this->input->post('harga_beli'),
            'hrg_jual_eceran' => $this->input->post('harga_jual_eceran'),
            'hrg_jual_grosir' => $this->input->post('harga_jual_grosir'),
            'gudang' => $this->input->post('gudang'),
            'id_kategori' => $this->input->post('kategori'),
            'created_by' => $this->session->userdata('username'),
            'created_date' => date("Y-m-d"),
        ));       

        return $inserted;
    }
    
    function detail($id){
        $this->db->where('id_barang', $id);
        $result = $this->db->get('barang');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function update(){
        
        $ubah = array(
            'nama_barang' => $this->input->post('nama_barang'),
            'stok' => $this->input->post('stok'),
            'id_satuan' => $this->input->post('satuan'),
            'hrg_beli' => $this->input->post('harga_beli'),
            'hrg_jual_eceran' => $this->input->post('harga_jual_eceran'),
            'hrg_jual_grosir' => $this->input->post('harga_jual_grosir'),
            'gudang' => $this->input->post('gudang'),
            'id_kategori' => $this->input->post('kategori'),
            'updated_by' => $this->session->userdata('username'),
            'updated_date' => date("Y-m-d"),
        );
        
        $this->db->where('id_barang', $this->input->post('username2'));
        $this->db->update('barang', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
            
    function delete($id){
        
        $this->db->delete('barang', array('id_barang' => $id));
        $jum_hapus = $this->db->affected_rows();
        
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
    function get_harga_grosir($id){
        $this->db->select('hrg_jual_grosir as harga_grosir');
        $this->db->where('id_barang', $id);
        $result = $this->db->get('barang');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    function get_harga_ecer($id){
        $this->db->select('hrg_jual_eceran as harga_ecer');
        $this->db->where('id_barang', $id);
        $result = $this->db->get('barang');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    function get_gudang_barang($id){
        $this->db->select('gudang');
        $this->db->where('id_barang', $id);
        $result = $this->db->get('barang');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
}