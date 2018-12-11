<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('posts_model', 'posts');
        $this->load->library(array('phpexcel', 'm_pdf'));
        if (!$this->ion_auth->logged_in()) {
            $this->data['content'] = 'CRM/login-page';
            $this->load->view('CRM/container', $this->data);
        } else {
            $this->data['content'] = 'CRM/authorized/pages/index';
            $this->load->view('CRM/authorized/container', $this->data);
        }
    }

    public function index()
    {
       
    }
}