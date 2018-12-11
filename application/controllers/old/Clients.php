<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Clients extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
        {
            redirect(base_url());
        }
        ;
        $this->load->model('clients_model', 'clients');
        $this->load->library(array('phpexcel', 'm_pdf'));
    }
    public function index()
    {
        $this->data['page'] = 'clients';
        $this->data['data_info'] = $this->clients->get_clients();
        $this->data['countSale'] = $this->clients->countClients();
        $this->data['content'] = 'CRM/authorized/pages/clients';
        $this->load->view('CRM/authorized/container', $this->data);
    }
    public function getClients()
    {
        $countSale = $this->clients->countClients();
        $limit = (int)$this->input->get('pageSize');
        $page = ((int)$this->input->get('pageIndex') - 1) * $limit;
              
        if ($this->input->get('first_name'))
        {
            $title = $this->input->get('first_name');
            $count = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'first_name' => $title,
                'order' => 'desc'));
            $data = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'first_name' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('last_name'))
        {
            $title = $this->input->get('last_name');
            $count = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'last_name' => $title,
                'order' => 'desc'));
            $data = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'last_name' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('company'))
        {
            $title = $this->input->get('company');
            $count = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'company' => $title,
                'order' => 'desc'));
            $data = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'company' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('adress'))
        {
            $title = $this->input->get('adress');
            $count = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'adress' => $title,
                'order' => 'desc'));
            $data = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'adress' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('email'))
        {
            $title = $this->input->get('email');
            $count = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'email' => $title,
                'order' => 'desc'));
            $data = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'email' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('phone'))
        {
            $title = $this->input->get('phone');
            $count = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'phone' => $title,
                'order' => 'desc'));
            $data = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'phone' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        }else
        {
            $data = $this->clients->get_clients(array(
                'orderby' => 'clients.id_client',
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => $countSale)));
        }


    }
  
    public function update_clients()
    {
        
        // edit user
        $client_id = $this->input->post('id_client');
        $data1 = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            'email' => $this->input->post('email'),
                'adress' => $this->input->post('adress'),
                'phone' => $this->input->post('phone'),
            );
        $this->clients->saveClients($data1, $client_id);
    }
    public function addClients()
    {
        
        $first_name = trim($this->input->post('first_name'));
        $company = trim($this->input->post('company'));
        if (nameClients('first_name', $first_name) and nameClients('company', $company))
        {
            $client_id = nameClients('first_name', $first_name);
        } else
        {
            $data1 = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'email' => $this->input->post('email'),
                'adress' => $this->input->post('adress'),
                'phone' => $this->input->post('phone'),
                );
            $client_id = $this->clients->saveClients($data1, false);
        }
       
    }
    public function delete()
    {
        $id = $this->input->post('client_id');
        $this->clients->delete($id);
        $this->output->set_content_type('application/json');
        $this->output->set_output( json_encode(array('client_id'=>$id) ));
    }
    



    
}
