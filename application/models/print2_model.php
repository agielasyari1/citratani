<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print2_model extends CI_Model {
    
    function  __construct() {
                parent::__construct();
                    $this->load->database();
                     $this->load->library('fpdf');

                }
    
     function p_kuitansi($id){
         
            $pdf = new FPDF('P','mm','A5');
            
            $this->db->select("COUNT(*) as jumlah");
            $this->db->where("no_penjualan", $id);
            $query = $this->db->get("d_penjualan_partai")->row();
            
            if($query->jumlah <= 14){
                $this->set_header($pdf, $id);
                $this->set_content($pdf, $id);
                //$this->set_footer($pdf, $id);
            }else{
                $loop = ceil($query->jumlah / 14);
                
                for($i = 0; $i < $loop; $i++){
                    $this->set_header($pdf, $id, $i);
                    $this->set_content($pdf, $id, $i*14, 14, $i);
                    //$this->set_footer($pdf, $id);
                }

            }
            
            //$content = $pdf->Output('./assets/doc.pdf','F');
            $pdf->Output($id, 'I');
        }
        
        function set_header($pdf, $id, $lembar=0){
            $pdf->setMargins(5,5,5);
            $pdf->SetAutoPageBreak(TRUE, 5);
            $pdf->AddPage();
            $pdf->Rect(5, 6, 200, 14, 'D');
            $pdf->SetFont('Times','B',9);
            $pdf->Cell(60,7,'Sumber Tani Makmur',0,0,'L');
            $pdf->Cell(80,7,'',0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(60,7,'Nomor',0,0,'C');
            $pdf->Ln(4); 
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(60,7,'Jl. Raya Telang No. 16 Kamal - Madura',0,0,'L');
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(80,7,'TANDA TERIMA BARANG',0,0,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(60,7,$id,0,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(80,7,'Telp. (031) - 3013720',0,0,'L');
            
            $pdf->Ln(7);
            $pdf->SetFont('Times','',9);
            $pdf->Cell(20,5,'Tanggal','LTR',0,'C');
            $pdf->Cell(20,5,'Tipe','LTR',0,'C');
            $pdf->Cell(20,5,'Lembar ke-','LTR',0,'C');
            $pdf->Cell(60,5,'Nama Pelanggan','LTR',0,'C');
            $pdf->Cell(80,5,'Alamat','LTR',0,'C');
            $pdf->Ln(4); 
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(20,5,date("d/m/Y"),'LRB',0,'C');
            $pdf->Cell(20,5,'Cash/Transfer','LRB',0,'C');
            $pdf->Cell(20,5,$lembar+1,'LRB',0,'C');
            $pdf->Cell(60,5,$this->get_nama_pembeli($id)['nama'],'LRB',0,'C');
            $pdf->Cell(80,5,$this->get_nama_pembeli($id)['alamat'],'LRB',0,'C');
            
        }
        
        function set_content($pdf, $id, $offset="", $limit="", $page=""){
            
            $pdf->Ln(6);
            $pdf->SetFont('Times','',9);
            $pdf->Cell(10,5,'No','LTR',0,'C');
            $pdf->Cell(80,5,'Nama Barang','LTR',0,'C');
            $pdf->Cell(40,5,'Qty','LTR',0,'C');
            $pdf->Cell(35,5,'Harga Satuan','LTR',0,'C');
            $pdf->Cell(35,5,'Jumlah','LTR',0,'C');
            $pdf->Ln(4); 
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(10,5,'','LRB',0,'C');
            $pdf->Cell(80,5,'','LRB',0,'C');
            $pdf->Cell(20,5,'Box/Ktk/Bata','LTRB',0,'C');
            $pdf->Cell(20,5,'Pcs','LTRB',0,'C');
            $pdf->Cell(35,5,'(Rp)','LRB',0,'C');
            $pdf->Cell(35,5,'(Rp)','LRB',0,'C');
            $pdf->Ln(7); 
            $i = 0;
            $this->db->where("no_penjualan", $id);
            $this->db->where("dpp.id_barang = b.id_barang");
            if($limit != ""){
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            $query = $this->db->get("d_penjualan_partai dpp, barang b");
            $total = 0;
            $prev_total = 0;
            if($query){
                if($page != ""){
                    $prev_total = $this->get_prev_total($id, $page);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(10,5,"",0,0,'C');
                    $pdf->Cell(80,5,"Jumlah Sebelumnya",0,0,'L');
                    $pdf->Cell(20,5,'',0,0,'C');
                    $pdf->Cell(20,5,'',0,0,'R');
                    $pdf->Cell(35,5,'',0,0,'R');
                    $pdf->Cell(35,5, number_format($prev_total,0,'.',','),0,0,'R');
                    $pdf->Ln(5);
                }
                foreach ($query->result() as  $item){
                    $i++;
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(10,5,$i,0,0,'C');
                    $pdf->Cell(80,5,$item->nama_barang,0,0,'L');
                    $pdf->Cell(20,5,'',0,0,'C');
                    $pdf->Cell(20,5,number_format($item->qty,0,'.',','),0,0,'C');
                    $pdf->Cell(35,5,  sprintf("%15s",  number_format($item->harga_satuan,0,'.',',')),0,0,'R');
                    $pdf->Cell(35,5,  sprintf("%15s",  number_format($item->harga_total,0,'.',',')),0,0,'R');
                    $pdf->Ln(5);
                    $total += $item->harga_total;
                }
                $this->set_footer($pdf, $id, $total+$prev_total);
            }
        }
                
        function set_footer($pdf, $id, $total){
            $this->db->select('ppn');
            $result = $this->db->get('setting')->row();
            $pdf->SetY(-30);
            //$pdf->Ln(7); 
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(10,5,'Sales :','TB',0,'L');
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(60,5,  $this->get_sales($id),'TB',0,'L');
            $pdf->Cell(50,5,'Meta. '.  date("d/m/Y H:i:s"),'TB',0,'C');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(35,5,'Total + '.$result->ppn.'% PPN','TB',0,'R');
            $pdf->Cell(10,5,'','TB',0,'R');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(35,5,  sprintf("%15s",  number_format($total + ($total * $result->ppn /100),0,'.',',')),'TB',0,'R');
            $pdf->Ln(6); 
            $pdf->Cell(25,5,'','RTLB',0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,'Perhatian',0,0,'L');
            $pdf->SetFont('Arial','',8);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,'Ditermia Oleh',0,0,'C');
            $pdf->Cell(40,5,'Disetujui Oleh',0,0,'C');
            $pdf->Cell(40,5,'Diserahkan Oleh',0,0,'C');
            $pdf->Ln(4); 
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(70,5,'1. Pembayara dengan cara Cheque Buyer baru dianggap sah/',0,0,'L');
            $pdf->SetFont('Arial','',8);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Ln(2); 
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(70,5,'    lunas bila telah dilakukan.',0,0,'L');
            $pdf->SetFont('Arial','',8);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Ln(2); 
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(70,5,'2. Barang yang telah diterima tdak dapat ditukar atau',0,0,'L');
            $pdf->SetFont('Arial','',8);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Cell(40,5,'',0,0,'C');
            $pdf->Ln(2); 
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(70,5,'    dikembalikan kecuali dengan perjanjian.',0,0,'L');
            $pdf->SetFont('Arial','',8);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(5,5,'',0,0,'C');
            $pdf->Cell(30,5,'','B',0,'C');
            $pdf->Cell(5,5,'',0,0,'C');
            $pdf->Cell(5,5,'',0,0,'C');
            $pdf->Cell(30,5,'','B',0,'C');
            $pdf->Cell(5,5,'',0,0,'C');
            $pdf->Cell(5,5,'',0,0,'C');
            $pdf->Cell(30,5,'','B',0,'C');
            $pdf->Cell(5,5,'',0,0,'C');
            
        }            
    
        function get_nama_pembeli($id){
            
            $this->db->where('no_penjualan', $id);
            $result = $this->db->get('penjualan_partai');
            $this->db->where('id_customer', $result->row(0)->id_customer);
            $result2 = $this->db->get('customer');
            $data = array();
            $data['nama'] = "";
            $data['alamat'] = "";
            if($result2->result()){
                $data['nama'] = $result2->row(0)->nama;
                $data['alamat'] = $result2->row(0)->alamat;
            }
            
            return $data;
        }
        function get_prev_total($id, $i){
            
            
            $my_query = "SELECT COALESCE(SUM(harga_total),0) as total FROM ("
                    . "SELECT harga_total FROM d_penjualan_partai WHERE no_penjualan ='".$id."' LIMIT ".$i*14 
                    . ")as temp";
            $result = $this->db->query($my_query)->row();
            return $result->total;
        }
        function get_sales($id){
            $this->db->where('no_penjualan', $id);
            $result = $this->db->get('penjualan_partai');
            $this->db->where('username', $result->row(0)->created_by);
            $result2 = $this->db->get('user');
            return $result2->row(0)->nama;
        }
        
}