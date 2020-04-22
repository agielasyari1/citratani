<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function  __construct() {
            parent::__construct();
                $this->load->helper('url');
                $this->load->model('login_model', 'login');
                $this->load->library('session');
            }
                
	public function index()
	{
            if($this->session->userdata('logged_in')){
                redirect('dashboard');
            }else{
                $this->load->view('login');
            }
		
	}
        
        public function check_login(){
        
                extract($_POST);
                $data = $this->login->check_login($username, $password);

                if(! $data)
                {
                    $this->session->set_flashdata('login_error', 'TRUE');
                    redirect('login');

                }
                else
                {
                    $this->session->set_userdata(array(
                                                    'logged_in'=> TRUE,
                                                    'username'=> $data['username'],
                                                    'nama'=> $data['nama'],
                                                    'posisi'=> $data['posisi'],
                                                    ));
                    
                       redirect('dashboard');

                }
           
        }
        
        function logout(){
            if($this->session->userdata('logged_in')){
                $this->login->set_login_status($this->session->userdata('username'), 0);
                $this->session->sess_destroy();
                redirect('login');
            }
            
        }
       
}
