<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();

                }
    
                        
    function detail(){
        $result = $this->db->get('setting');
        $data = array();
        if($result->result()){
            $data = $result->row();
        }
        return $data;
    }
    
    function update(){
        
        $ubah = array(
            'ppn' => $this->input->post('ppn')
        );
        
        $this->db->update('setting', $ubah);
        $jum_ubah = $this->db->affected_rows();
        
        if($jum_ubah == 1){
            return TRUE;
        }
        
        return TRUE;
    }
  
    
    
    function restore_db()
    {
        
        $data = array();
       if(isset($_FILES['filesql']) && $_FILES['filesql']['size'] > 0){
           
           $upload_path = 'assets/temp/';
        
            if(!file_exists("./".$upload_path)){
                if (!mkdir('./'.$upload_path, 0777, true)) {
                        die('Failed to create folders...');
                    }
            }
            
            
            $config = array(
            'upload_path' => './'.$upload_path,
            'allowed_types' => 'sql',
            'file_name' => 'filesql',
            'file_ext_tolower' => TRUE,
            'overwrite' => TRUE,
            'max_size' => 2000,     
            'max_filename' => 0,
            'remove_spaces' => TRUE
        );
        $error = '';
        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('filesql'))
        {
            $hasil = $this->upload->display_errors();
            $status = FALSE;
            $error = $hasil;
        }
        else
        {
                $hasil = $this->upload->data();
                $status = TRUE;
        }
        $data = array(
            'path' => $upload_path.$this->upload->data('file_name'),
            'status' => $status,
            'error' => $error

        );
        
      
       }
      if($data['status']){
            $isi_file = file_get_contents($data['path']);
            $string_query = rtrim( $isi_file, '\n;' );
            $array_query = explode(';', $string_query);

            foreach($array_query as $query)
            {
                if(strlen($query) > 10){
                     $this->db->query($query);
                  }  
            }
      }
      
      return $data;
    }
                
}