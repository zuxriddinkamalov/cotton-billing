<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in() || !$this->data['is_super_admin'])
            redirect(base_url(), 'refresh');
    }

    public function index()
    {
        
    }
    public function users_list(){
        $this->data['users'] = $this->ion_auth->users()->result();
    	foreach ($this->data['users'] as $k => $user)
    	{
    		$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
    	}
        $this->lang->load('auth');
        $this->data['content'] = 'CRM/authorized/pages/profile/users_list';
        $this->load->view('CRM/authorized/container', $this->data);
    }
}