<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_kw2 extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('print2_model', 'print');
                    $this->load->library('session');

                }
        
         function p_kuitansi($id){
             $this->print->p_kuitansi($id);
         }
}