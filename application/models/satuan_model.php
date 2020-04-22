<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class satuan_model extends CI_Model {
    
    var $table = 'satuan';
    var $column = array('id_satuan','nama_satuan'); //set column field database for order and search
    var $order = array('id_satuan' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query()
        {
         
        $this->db->from($this->table);
       // $this->db->where('satuan', "supplier");
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
       // $this->db->where('satuan', "supplier");
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
    
    function daftar_satuan() {
        
        //$this->db->where('satuan',"supplier");
        $query = $this->db->get('satuan');
        $list = array();
        $list[''] = "--Pilih Satuan--";
        if($query->result()){
            foreach ($query->result() as $satuan) {
                $list[$satuan->id_satuan] = $satuan->nama_satuan;
            }
        } 

        return $list;
      
    }
    
     function add(){
         
        $inserted = $this->db->insert('satuan', array(
            'nama_satuan' => $this->input->post('satuan'),
            
        ));       

        return $inserted;
    }
    
    function detail($id){
        $this->db->where('id_satuan', $id);
        $result = $this->db->get('satuan');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function update(){
        
        $ubah = array(
            'nama_satuan' => $this->input->post('satuan'),
        );
        
        $this->db->where('id_satuan', $this->input->post('username2'));
        $this->db->update('satuan', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
            
    function delete($id){
        
        $this->db->delete('satuan', array('id_satuan' => $id));
        $jum_hapus = $this->db->affected_rows();
        
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
}