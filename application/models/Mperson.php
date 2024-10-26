<?php

// Chỉ tương tác cơ sở dữ liệu
// Không sử lý logic trong model

    class Mperson extends CI_Model {
        public function __construct(){
            parent::__construct();
        }

        //truy suất tất cả trong bảng 
        public function get_person(){
            $this->db->select("*");
            $this->db->from("person");
            $query = $this->db->get();
            return $query->result();
        }

        public function get_count(){
            $this->db->select("ID");
            $this->db->from("person");
            $query = $this->db->get();
            return $query->num_rows();
        }

        //truy suất có điểm bắt đầu và kết thúc - pagination
        public function get_8_person($id){
            $limit = 8;
            $start = ($id-1) * $limit;
            
            $this->db->select("*");
            $this->db->from("person");
            $this->db->limit($limit, $start);  
            $query = $this->db->get();
            return $query->result();
        }

        //Thêm person vào bảng
        public function add_person($data){
            $this->db->insert("person", $data);
            return $this->db->insert_id();
        }

        public function edit_person($data){

        }

        //xóa phần tử theo id
        public function delete_person_by_id($id)
        {
            // Kiểm tra 
            if (is_numeric($id) && $id > 0) {
                $this->db->where("id", $id);
                $this->db->delete("person");
                // Trả về số hàng bị ảnh hưởng (nếu xóa thành công sẽ trả về 1)
                return $this->db->affected_rows();
            } else {
                return false;
            }
        }
        
        //Lấy ra bản ghi theo email
        public function get_person_by_email($email){
            $this->db->where("Email", $email);
            $query = $this->db->get("person");
            return $query->num_rows() > 0;
        }

      

    }