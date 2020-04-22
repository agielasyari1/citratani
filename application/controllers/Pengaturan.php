<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
    
    
    function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('pengaturan_model', 'pengaturan');
                    $this->load->library('session');

                }
    
    public function index()
	{
            if($this->session->userdata('logged_in') && $this->session->userdata('posisi') == 1){
                $this->load->view('header');
		$this->load->view('pengaturan');
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}            
          
    function view(){
        
            $detail = $this->pengaturan->detail();
            echo json_encode($detail);
        
    }
    
    function update(){
        $status = $this->pengaturan->update();
        echo json_encode(array('status' => $status));
    }
    
    function backup_db(){
        $this->load->dbutil();

        $prefs = array(     
                'tables'     => array('barang', 'customer', 'kategori', 'satuan', 'setting', 'supplier', 'user'),
                'format'      => 'text',             
                'filename'    => 'ct-tani.sql'
              );


        $backup = $this->dbutil->backup($prefs); 

        $db_name = 'ct-tani-'. date("Y-m-d-H-i-s") .'.sql';
        $save = $result->dir.$db_name;
        $this->load->helper('download');
        force_download($db_name, $backup);
    }
    
    function restore_db(){
        $status = $this->pengaturan->restore_db();
        echo json_encode($status);
    }
    
    
    
}