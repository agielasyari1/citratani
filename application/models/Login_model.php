<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
    
                
                
    function check_login($username, $password)
    {
        			
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username',$username);

        $result = $this->db->get();
        if($result->num_rows() == 1){
            if(password_verify($password, $result->row(0)->password)){
               $data['username'] = $result->row(0)->username;
               $data['nama'] = $result->row(0)->nama;
               $data['posisi'] = $result->row(0)->posisi;
               $this->set_login_status($username, 1);
               return $data;
            }
        }
        
        else
        {
            return false;
        }
    }
    
    function set_login_status($username, $status){
        $this->db->set('status', $status, FALSE);
        $this->db->where('username',$username);
        $this->db->update('user');
    }
    
    
    
    
}