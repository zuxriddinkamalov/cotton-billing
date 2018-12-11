<?php

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('public');
        $this->load->model('admin_model', 'admin');
        $this->load->library('ion_auth');
        
        if ($this->ion_auth->logged_in()) {
            $user = $this->admin->get_active_user();
            $user = $user[0];
            $this->data['user'] = $user;
            $this->data['user_group'] = $this->ion_auth->get_users_groups($user->id)->result();
            $this->data['is_super_admin'] = false;
            foreach($this->data['user_group'] as $item){
                if($item->name=='superadmin'){
                    $this->data['is_super_admin'] = true;
                    break;
                }
            }
            $this->data['user_image'] = base_url(($user->image_file!='')?('uploads/admin/users/'.$user->image_file):(($user->sex=='1')?'uploads/admin/users/default/male.jpg':'uploads/admin/users/default/female.jpg'));
        }

    }


}