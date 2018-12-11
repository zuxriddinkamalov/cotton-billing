<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Country extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
        {
            redirect(base_url());
        }
        ;
        $this->load->model('country_model', 'country');
      //  $this->load->library(array('phpexcel', 'm_pdf'));
    }
    
  
    public function index()
    {
         $this->data['page'] = 'country';
       
        $this->data['countSale'] = $this->country->countCountry();
        $this->data['content'] = 'CRM/authorized/pages/country';
        $this->load->view('CRM/authorized/container', $this->data);
    }
    
    
        public function getCountry()
    {
        $countSale = $this->country->countCountry();
        $limit = (int)$this->input->get('pageSize');
        $page = ((int)$this->input->get('pageIndex') - 1) * $limit;

        if ($this->input->get('factory_name'))
        {
            $title = $this->input->get('factory_name');
            $count = $this->country->getCountry(array(
                'orderby' => 'factory.id_factory',
                'factory_name' => $title,
                'order' => 'desc'));
            $data = $this->country->getCountry(array(
                'orderby' => 'factory.id_factory',
                'factory_name' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        }elseif($this->input->get('country_id')){
             $title = $this->input->get('country_id');
            if($title == -1){
                    
                
                $data = $this->country->getCountry(array(
                'orderby' => 'factory.id_factory',
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => $countSale)));
            }else{
                        $count = $this->country->getCountry(array(
                'orderby' => 'factory.id_factory',
                'id_factory' => $title,
                'order' => 'desc'));
            $data = $this->country->getCountry(array(
                'orderby' => 'factory.id_factory',
                'country_id' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
            }
           

        }else
        {
            $data = $this->country->getCountry(array(
                'orderby' => 'factory.id_factory',
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => $countSale)));
        }

    }
    
     public function getAllCountry(){
        $data = $this->country->getAllCountry();
        array_unshift($data, array('name' => 'Все', 'id' => -1));
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
    }
    
    public function getFactory(){
        $data = $this->country->getFactory();
        array_unshift($data, array('name' => 'Все', 'id' => -1));
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $data)));
    }
    
    public function updateFactory()
    {
        $id = $this->input->post('id_factory');
        $data = array(
            'factory_name' => $this->input->post('factory_name'), 
            'country_id' => $this->input->post('country_id'),
                      
        );        
        $this->country->saveFactory($data, $id);
       
    }
    
      public function addFactory()
    {
         $name = trim($this->input->post('factory_name'));
         if (!nameFactory('factory_name', $name))
        {
        $data = array(
            'factory_name' => $this->input->post('factory_name'),
            'country_id' => $this->input->post('country_id'),              
        );
        // save sale
        $id = $this->country->saveFactory($data, false);
        }
      
    }
    
    public function delete()
    {
        $id = $this->input->post('id_factory');
        $this->country->delete($id);
        $this->output->set_content_type('application/json');
        $this->output->set_output( json_encode(array('id_factory'=>$id) ));
    }
    
   
}
