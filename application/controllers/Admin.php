<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    if (!$this->ion_auth->logged_in())
      redirect(base_url(), 'refresh');
  }

  public function index()
  {

  }
  public function edit_profile()
  {
    if($this->input->post()) {
      $identity = $this->session->userdata('identity');
      if($this->input->post('old_password')&&$this->input->post('new_password'))
        $change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));
      else
        $change = true;
      if ($change)
      {
        $args['first_name']= $this->input->post('first_name');
        $args['last_name']= $this->input->post('last_name');
        $args['phone']= $this->input->post('phone');
        $args['city']= $this->input->post('city');
        $args['born']= $this->input->post('born');
        $args['sex']= $this->input->post('sex');
        $args['username']= $this->input->post('username');
        $args['email']= $this->input->post('email');

        $config['upload_path']      = './uploads/admin/users/';
        $config['allowed_types']    = 'gif|jpg|png';
        $config['encrypt_name']    = TRUE;
        $config['max_size']       = 100;
        $config['max_width']      = 1024;
        $config['max_height']       = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
          $error = $this->upload->display_errors();
        }
        else
        {
          $args['image_file']= $this->upload->data('file_name'); ;
        }
        $this->admin->edit_user_data($args);
      }
      redirect($_SERVER['HTTP_REFERER']);

    }
    $this->data['cities'] = $this->admin->get_cities();
    $this->data['content'] = 'CRM/authorized/pages/profile/edit_profile';
    $this->load->view('CRM/authorized/container', $this->data);
  }
  public function delete_user_photo(){
    $this->admin->delete_user_photo();
    redirect($_SERVER["HTTP_REFERER"]);
  }
}