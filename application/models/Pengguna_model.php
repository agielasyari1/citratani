<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model {
    
    var $table = 'user';
    var $column = array('username','nama','alamat', 'no_telp', 'posisi', 'status'); //set column field database for order and search
    var $order = array('username' => 'desc'); // default order 
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
   
    private function _get_datatables_query()
        {
         
        $this->db->from($this->table);
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
    
     function add(){
        $inserted = $this->db->insert('user', array(
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
            'posisi' => $this->input->post('posisi'),
           'created_by' => $this->session->userdata('username'),
            'created_date' => date("Y-m-d"),
        ));       

        return $inserted;
    }
    
    function detail($id){
        $this->db->where('username', $id);
        $result = $this->db->get('user');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function update(){
        
        $ubah = array(
            'username' => $this->input->post('username'),
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
            'posisi' => $this->input->post('posisi'),
           'updated_by' => $this->session->userdata('username'),
            'updated_date' => date("Y-m-d"),
        );
        
        if($this->input->post('password') != "........"){
            $ubah['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }
        
        $this->db->where('username', $this->input->post('username2'));
        $this->db->update('user', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
            
    function delete($id){
        
        $this->db->delete('user', array('username' => $id));
        $jum_hapus = $this->db->affected_rows();
        
        if($jum_hapus == 1){
            return TRUE;
        }
        
        return FALSE;
        
    }
    
    function generateID(){
        
         $seg1 = "CT";
    if($this->input->post('posisi') == 1){
         $seg2 = "ADM";
    }else{
         $seg2 = "EMP";
    }
       
        
       
        
        $this->db->select("MAX(RIGHT(`username`, 4)) as 'maxID'");
        $this->db->like('username', $seg1.'-'.$seg2, 'after');
        $result = $this->db->get('user');
        $code = (int) substr($result->row(0)->maxID, 1, 4);
        $code++; 
        $data = array(
                'username' => $seg1."-".$seg2."-".sprintf("%04s", $code)
            ); 
        
        return $data;
    }
    
    function foto(){
        $this->db->select('photo');
        $this->db->where('username', $this->session->userdata('username'));
        $result = $this->db->get('user');
        $data = array();
        if($result->result()){
            if($result->row(0)->photo == NULL){
                $data['photo'] = "assets/avatar/default.jpg";
            }else{
                $data = $result->row();
            }
        }
        return $data;
    }
    
}