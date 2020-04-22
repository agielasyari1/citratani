<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class R_Pembeliana extends CI_Controller {

	function  __construct() {
                parent::__construct();
                    $this->load->helper('url');
                    $this->load->model('D_Pembeliana_M', 'pembelian');
                    $this->load->model('pengaturan_model', 'pengaturan');
                    $this->load->library('session');

                }
        
	public function view_detail($id_pembelian)
	{
            
            if($this->session->userdata('logged_in')){
                $ppn = $this->pengaturan->detail();
                $data['ppn'] = $ppn->ppn;
                $data['id_pembelian'] = $id_pembelian;
                if($this->session->userdata('posisi') == 1){
                    $this->load->view('header');
                }else{
                    $this->load->view('header_pegawai');
                }
		$this->load->view('r_pembeliana', $data);
		$this->load->view('footer');
            }else{
                redirect('login');
            }
		
	}
        
        function view($no_pembelian){
            $list = $this->pembelian->get_datatables($no_pembelian);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $pembelian) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $pembelian->nama_barang;
                $row[] = number_format($pembelian->qty, 1, ',', '.');
                $row[] = number_format($pembelian->harga_satuan, 0, ',', '.');
                $row[] = number_format($pembelian->harga_total, 0, ',', '.');
                
                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->pembelian->count_all($no_pembelian),
                            "recordsFiltered" => $this->pembelian->count_filtered($no_pembelian),
                            "data" => $data,
                    );
            echo json_encode($output);
        }
        
      
}
