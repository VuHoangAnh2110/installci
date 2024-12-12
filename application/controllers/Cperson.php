<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cperson extends CI_Controller {
	public function __construct() {
		    parent::__construct();  

	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		// $this->load->model("Mperson");
		// $data["list"] = $this->Mperson->get_person();
		// $this->load->view('test1/test1', $data);

		$this->pagi(1);		
	}

//Phân trang với số lượng 8 bản ghi 
	public function pagi($page = 1){
		$this->load->model("Mperson");
		$count1 = $this->Mperson->get_count();
		$limit = 8;
		$paginate = ceil($count1/$limit);
		$data["paginate"] = $paginate;
		$data["list"] = $this->Mperson->get_8_person($page);

		$data1["data"] = $data;
		$this->load->view("layout/VLayout", $data1);
	}

//Thêm dữ liệu vào database
	public function add(){
		$this->load->model("Mperson");
		$name = $this->input->post("name", TRUE);
		$email = $this->input->post("email", TRUE);
		$birth = $this->input->post("birth", TRUE);
		$sex = $this->input->post("sex", TRUE);

		// Kiểm tra lỗi
		if (empty($name) || empty($email) || empty($birth) || empty($sex) || $this->Mperson->get_person_by_email($email)) {
				$errors = [];
			if (empty($name)) {
				$errors['name'] = 'Không để trống';
			}
			if (empty($email)) {
				$errors['email'] = 'Không để trống';
			}
			if (empty($birth)) {
				$errors['birth'] = 'Không để trống';
			}
			if (empty($sex)) {
				$errors['sex'] = 'Không để trống';
			}
			if ($this->Mperson->get_person_by_email($email)) {
				$errors['email'] = 'Đã tồn tại email';
			}
			// 	
			echo json_encode(['errors' => $errors]);
        } else {
			$sexNumber = 0;
            // Chuyển đổi giới tính thành số
			switch ($sex) {
                case "Nam": $sexNumber = 1;
                case "Nữ": $sexNumber = 2;
                case "Khác": $sexNumber = 3;
                default: $sexNumber = 0;
            };

            // Chuẩn bị dữ liệu
            $data = array(
                'Name' => $name,
                'BirthDay' => $birth,
                'Sex' => $sexNumber,
                'Email' => $email
            );

			if($this->Mperson->add_person($data)) {
			  	// 
				$count1 = $this->Mperson->get_count();
				$limit = 8;
				$paginate = ceil($count1/$limit);
				echo json_encode([
					'success' => 'Success!',
					'paginate' => $paginate
				]);
			
			} else {
				// 
				echo json_encode(['error' => 'Fail!']);
			}
			
		}
	}


}

   