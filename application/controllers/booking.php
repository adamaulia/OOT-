<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Booking extends CI_Controller{

public function __construct(){

		parent::__construct();
		//$this->load->helper('url');
		$this->load->helper(array('form','url'));
		$this->load->library('input');
		//$this->load->view('template/index');
		$this->load->model('customer_model');
	}

public function addBooking(){
	$this->load->model('customer_model');

	$data['nama']= $this->input->post('name');
	$data['no_identitas']=$this->input->post('ktp');
	$data['alamat']=$this->input->post('alamat');
	$data['hp']=$this->input->post('phone');
	//echo $data['nama'];
	//echo $data['hp'];
	$data['email']=$this->input->post('email');
	$data['jumlah']=$this->input->post('jumlah');
	$data['date_in']=$this->input->post('datein');
	$data['date_out']=$this->input->post('dateout');
	//echo $data['nama'] ;
	
	$data['biaya']=$this->hitung();
	$this->customer_model->insert_booking($data);
	redirect(site_url('login'));
	//echo "<div class='alert alert-info'> Successfully Booked </div>";
	//redirect(site_url('login/index'));

}

public function cekOpen(){
	$this->load->view('template/CekBooking');
	$this->load->model('customer_model');
}


public function cek_booking(){

	$data=$this->input->post('kode');
	// echo $data;
	// echo "tes booking";
	$this->load->model('customer_model');
	$booking=$this->customer_model->select_by_id($data);


	// echo $booking['nama'];
	// echo $booking['hp'];
	// echo "tes output ";
	// echo "";


	// 	foreach ($booking as $key) {
	// 	echo $key['nama']. " nama ";
	// 	echo $key['hp']. " hp";
	// 	echo $key['no_identitas']. " identitas ";
	// }

	$this->load->view('template/CekBooking',array('Booking' =>$booking ));

	// redirect(site_url('template/CekBooking'));


}

public function hitung(){
	$jum=$this->input->post('jumlah');
	$SumJumlah = $jum * 75000;
	$selimut=$this->input->post('selimut');
	$SumSelimut = $selimut * 15000;
	// if (($data == 1 ) or ($data == 2) or( $data == 3) )  {
	// 	return $hasil = $data * 75000;
	// }

	return $SumJumlah + $SumSelimut ;

}


public function do_upload(){


	// $this->load->helper('form');

	//    $config['upload_path']   =   './imgUpload/';
 // 	   $config['allowed_types'] =   'gif|jpg|jpeg|png'; 
 // 	   $config['max_size']      =   '5000';
 // 	   $config['max_width']     =   '4000';
 // 	   $config['max_height']    =   '3000';
 
 //       $this->load->library('upload',$config);
	   

 //       if( ! $this->upload->do_upload())

 //       {

 //       	   $error = array('error' => $this->upload->display_errors());
 //           $this->load->view('template/successUpload', $error);

 //       }
 //       else

 //       {

 //       	$data = array('upload_data'=> $this->upload->data());

 //       	$this->load->view('template/successUpload', array('Data' =>$data));



 //       }

		$type = explode('.', $_FILES["pic"]["name"]);
		$type = $type[count($type)-1];
		$url = "./imgUpload/".$_FILES["pic"]["name"];
		if(in_array($type, array("jpg","jpeg","gif","png")))
			if(is_uploaded_file($_FILES["pic"]["tmp_name"]))
				if(move_uploaded_file($_FILES["pic"]["tmp_name"],$url));

				return $url;
			return "";


	}


public function panduan(){
	header("Content-disposition: attachment; filename=panduan.pdf");
	header("Content-type: application/pdf");
	readfile("panduan.pdf");
}


public function save(){
	$this->load->model('customer_model');
	$id = $_POST['id'];
	echo "hasil id model ".$id;
	$url=$this->do_upload();
	echo "url = " .$url;
	$data['gambar']=$url;
	$this->customer_model->update_booking($id,$data);
	//$this->load->view('template/index');
	redirect(site_url('login'));
}



	}

?>