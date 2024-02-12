<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Student_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function add_a_student($data) { 
        $data['created'] = $data['modified'] = time();
        $data['user_type'] = $data['status'] = 1;
        $data['created'] = time();
        $this->db->insert('users',$data);
        return $this->db->insert_id();
    }
    
    public function add_education_profile($input) { 
        $this->db->insert('student_education_profile',$input);
        return $this->db->insert_id();
    }

}
