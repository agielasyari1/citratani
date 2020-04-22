<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_lain extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('transaksi_lain_model', 't_lain');
                    $this->load->model('pengaturan_model', 'pengaturan');
                    $this->load->library('session');

                }
                
	public function index()
	{
            if($this->session->userdata('logged_in')){
                $data = $this->pengaturan->detail();
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
		$this->load->view('transaksi_lain', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function view(){
            $list = $this->t_lain->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $transaksi) {
                $no++;
                $row = array();
                $row[] = $transaksi->id_transaksi;
                $row[] = $transaksi->tanggal;
                $row[] = $transaksi->keterangan;
                $row[] = number_format($transaksi->total, 0, ',', '.');
                $row[] = '<button type="button" id="edit" onclick="change('."'".$transaksi->id_transaksi."'".')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></button> '
                        . '<button type="button" id="delete" onclick="del('."'".$transaksi->id_transaksi."'".')"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->t_lain->count_all(),
                            "recordsFiltered" => $this->t_lain->count_filtered(),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
        function generateNO(){
             $detail = $this->t_lain->generateNo();
             echo json_encode($detail);
        }
        
       
        
        function add(){
             $inserted = $this->t_lain->add();
             echo json_encode(array('status' => $inserted));
        }
        
        function detail($id){
            $detail = $this->t_lain->detail($id);
            echo json_encode($detail);
        }
        
        function update(){
             $status = $this->t_lain->update();
             echo json_encode(array('status' => $status));
        }
        
        function delete($id){
                    
            $status = $this->t_lain->delete($id);
            echo json_encode(array('status' => $status));
        }
}
