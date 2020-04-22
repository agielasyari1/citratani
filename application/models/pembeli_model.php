<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pembeli_model extends CI_Model {
    
    var $table = 'customer';
    var $column = array('id_customer','nama_toko','nama','alamat', 'no_telp','tipe'); //set column field database for order and search
    var $order = array('id_customer' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query()
        {
         
        $this->db->from($this->table);
       // $this->db->where('kategori', "supplier");
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
       // $this->db->where('kategori', "supplier");
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
    
    function daftar_pembeli($term) {
        
        $this->db->like('nama_toko',$term);
        $query = $this->db->get('customer');
        $list = array();
        if($query->result()){
            foreach ($query->result() as $pembeli) {
                $list[] = $pembeli->id_customer.'- '.$pembeli->nama_toko;
            }
        }else{
             $list[] = "Tidak ditemukan...";
        } 

        return $list;
      
    }
    
     function add(){
         
        $inserted = $this->db->insert('customer', array(
            'nama_toko' => $this->input->post('nama_toko'),
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
            'tipe' => $this->input->post('tipe'),
           'created_by' => $this->session->userdata('username'),
            'created_date' => date("Y-m-d"),
        ));       

        return $inserted;
    }
    
    function detail($id){
        $this->db->where('id_customer', $id);
        $result = $this->db->get('customer');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function update(){
        
        $ubah = array(
            'nama_toko' => $this->input->post('nama_toko'),
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
            'tipe' => $this->input->post('tipe'),
           'updated_by' => $this->session->userdata('username'),
            'updated_date' => date("Y-m-d"),
        );
        
        $this->db->where('id_customer', $this->input->post('username2'));
        $this->db->update('customer', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
            
    function delete($id){
        
        $this->db->delete('customer', array('id_customer' => $id));
        $jum_hapus = $this->db->affected_rows();
        
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
}