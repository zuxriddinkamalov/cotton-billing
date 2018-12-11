<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_active_user()
    {
        $userId = $this->ion_auth->get_user_id();
        $this->db->select('users.*')->where('id', $userId);
        return $this->db->get('users')->result();
    }

    public function get_cities(){
        return $this->db->get('cities')->result();
    }

    public function delete_user_photo(){
        $id_user = $this->ion_auth->get_user_id();
        $file_name = $this->get_active_user()[0]->image_file;
        $this->db->set('image_file', '');
        $this->db->where('id', $id_user);
        $this->db->update('users');
        @unlink('./uploads/admin/users/'.$file_name);
    }

    public function edit_user_data($args){
        $id_user = $this->ion_auth->get_user_id();
        $this->db->set('first_name', $args['first_name']);
        $this->db->set('last_name', $args['last_name']);
        $this->db->set('phone', $args['phone']);
        $this->db->set('city', $args['city']);
        $this->db->set('born', $args['born']);
        $this->db->set('sex', $args['sex']);
        $this->db->set('username', $args['username']);
        $this->db->set('email', $args['email']);
        if  (isset($args['image_file'])){
            $this->delete_user_photo();
            $this->db->set('image_file', $args['image_file']);
        }
        $this->db->where('id', $id_user);
        $this->db->update('users');
    }

}