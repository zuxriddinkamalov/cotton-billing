<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('posts_model', 'posts');
        if (!$this->ion_auth->logged_in()) {
            die();
        }
    }

    public function index()
    {
       
    }

    /* ======================================================*/
    /*                      Factory                          */
    /*=======================================================*/
    public function getAllFactories()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $filter = array(
            'name' => @$this->input->post_get('name')
        );
        $data = $this->posts->get_all_data('factory', $offset, $limit, $filter);
        $count = count($this->posts->get_all_data('factory', 0, 100000000, $filter));
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count)));
    }

    public function insertFactory()
    {
        $data = array(
            'name' => $this->input->post_get('name'), 
            'phone' => @$this->input->post_get('phone'), 
            'info' => @$this->input->post_get('info'), 
            'address' => @$this->input->post_get('address')
        );
        $this->posts->insert_data('factory', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function deleteFactory() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('factory', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getFactoryById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('factory', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateFactory()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'name' => $this->input->post_get('name'), 
            'phone' => @$this->input->post_get('phone'), 
            'info' => @$this->input->post_get('info'), 
            'address' => @$this->input->post_get('address')
        );
        $this->posts->update_data('factory', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }
    /* ================================================= */
    /*                        end                        */
    /* ================================================= */

    /* ======================================================*/
    /*                      currency                          */
    /*=======================================================*/
    public function getAllCurrencies()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $data = $this->posts->get_all_data('currency', $offset, $limit);
        $count = count($this->posts->get_all_data('currency'));
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count)));
    }

    public function insertCurrency()
    {
        $data = array(
            'name' => $this->input->post_get('name'), 
            'code' => @$this->input->post_get('code')
        );
        $this->posts->insert_data('currency', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function deleteCurrency() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('currency', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getCurrencyById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('currency', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateCurrency()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'name' => $this->input->post_get('name'), 
            'code' => @$this->input->post_get('code')
        );
        $this->posts->update_data('currency', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }
    /* ================================================= */
    /*                        end                        */
    /* ================================================= */

    /* ======================================================*/
    /*                      Charges types                    */
    /*=======================================================*/
    public function getAllChargesType()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $data = $this->posts->get_all_data('charges_types', $offset, $limit);
        $count = count($this->posts->get_all_data('charges_types'));
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count)));
    }

    public function insertChargesType()
    {
        $data = array(
            'name' => $this->input->post_get('name')
        );
        $this->posts->insert_data('charges_types', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function deleteChargesType() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('charges_types', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getChargesTypeById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('charges_types', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateChargesType()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'name' => $this->input->post_get('name')
        );
        $this->posts->update_data('charges_types', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }
    /* ================================================= */
    /*                        end                        */
    /* ================================================= */

    /* ======================================================*/
    /*                      Dislocation                      */
    /*=======================================================*/
    public function getAllDislocations()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $filter = array(
            'factory_id' => @$this->input->post_get('company'), 
            'start' => @$this->input->post_get('start'), 
            'end' => @$this->input->post_get('end'), 
        );
        $data = $this->posts->get_all_dislocation($offset, $limit, $filter);
        $count = count($this->posts->get_all_dislocation(0, 100000000, $filter));
        $factories = $this->posts->get_all_data('factory');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count, 'factories' => $factories)));
    }

    public function insertDislocation()
    {
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'weight' => $this->input->post_get('weight'), 
            'date' => $this->input->post_get('date'), 
        );
        $result = $this->posts->check_dublicate('dislocation', array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'date' => $this->input->post_get('date')
        ));
        if (!$result) {
            $this->posts->insert_data('dislocation', $data);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => !$result)));
    }

    public function deleteDislocation() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('dislocation', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getDislocationById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('dislocation', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateDislocation()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'weight' => $this->input->post_get('weight'), 
            'date' => $this->input->post_get('date'), 
        );
        $this->posts->update_data('dislocation', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }
    /* ================================================= */
    /*                        end                        */
    /* ================================================= */
    
    /* ======================================================*/
    /*                       Staple                          */
    /*=======================================================*/
    public function getAllStaples()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $filter = array(
            'factory_id' => @$this->input->post_get('company'), 
            'start' => @$this->input->post_get('start'), 
            'end' => @$this->input->post_get('end'), 
            'one_filter' => (@$this->input->post_get('one_filter') == 'true')?true:false, 
        );
        $data = $this->posts->get_all_staples($offset, $limit, $filter);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->before_deb = $this->posts->staple_deb($data[$i]->factory_id, $data[$i]->currency_id, date('Y-m-01'))->value;
            $data[$i]->current_deb = $this->posts->staple_deb($data[$i]->factory_id, $data[$i]->currency_id)->value;
        }
        $count = count($this->posts->get_all_staples(0, 100000000, $filter));
        $factories = $this->posts->get_all_data('factory');
        $currencies = $this->posts->get_all_data('currency');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count, 'factories' => $factories, 'currencies' => $currencies)));
    }

    public function insertStaple() {
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'currency_id' => $this->input->post_get('currency_id'), 
            'weight' => @$this->input->post_get('weight'), 
            'date' => @$this->input->post_get('date'), 
            'summ' => @$this->input->post_get('summ'), 
            'by_bank' => @$this->input->post_get('by_bank'), 
            'by_tax' => @$this->input->post_get('by_tax'), 
            'by_self_counting' => @$this->input->post_get('by_self_counting'), 
        );
        $this->posts->insert_data('staple', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function deleteStaple() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('staple', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getStapleById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('staple', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateStaple()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'weight' => $this->input->post_get('weight'), 
            'date' => $this->input->post_get('date'), 
            'summ' => $this->input->post_get('summ'), 
            'by_bank' => $this->input->post_get('by_bank'), 
            'by_tax' => $this->input->post_get('by_tax'), 
            'by_self_counting' => $this->input->post_get('by_self_counting'), 
            'currency_id' => $this->input->post_get('currency_id'), 
        );
        $this->posts->update_data('staple', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    /* ======================================================*/
    /*                         Corn                          */
    /*=======================================================*/
    public function getAllCorns()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $filter = array(
            'factory_id' => @$this->input->post_get('company'), 
            'start' => @$this->input->post_get('start'), 
            'end' => @$this->input->post_get('end'), 
            'one_filter' => (@$this->input->post_get('one_filter') == 'true')?true:false, 
        );
        $data = $this->posts->get_all_corns($offset, $limit, $filter);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->before_deb = $this->posts->corn_deb($data[$i]->factory_id, $data[$i]->currency_id, date('Y-m-01'))->value;
            $data[$i]->current_deb = $this->posts->corn_deb($data[$i]->factory_id, $data[$i]->currency_id)->value;
            $data[$i]->corn_dislocation = $this->posts->corn_dislocation($data[$i]->factory_id, $data[$i]->date);
        }
        $count = count($this->posts->get_all_corns(0, 100000000, $filter));
        $factories = $this->posts->get_all_data('factory');
        $currencies = $this->posts->get_all_data('currency');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count, 'factories' => $factories, 'currencies' => $currencies)));
    }

    public function insertCorn() {
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'currency_id' => $this->input->post_get('currency_id'), 
            'weight' => @$this->input->post_get('weight'), 
            'date' => @$this->input->post_get('date'), 
            'summ' => @$this->input->post_get('summ'), 
            'by_bank' => @$this->input->post_get('by_bank'), 
            'by_tax' => @$this->input->post_get('by_tax'), 
            'by_self_counting' => @$this->input->post_get('by_self_counting'), 
        );
        $this->posts->insert_data('corn', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function deleteCorn() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('corn', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getCornById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('corn', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateCorn()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'weight' => $this->input->post_get('weight'), 
            'date' => $this->input->post_get('date'), 
            'summ' => $this->input->post_get('summ'), 
            'by_bank' => $this->input->post_get('by_bank'), 
            'by_tax' => $this->input->post_get('by_tax'), 
            'by_self_counting' => $this->input->post_get('by_self_counting'), 
            'currency_id' => $this->input->post_get('currency_id'), 
        );
        $this->posts->update_data('corn', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    /* ======================================================*/
    /*                         Cotton                        */
    /*=======================================================*/
    public function getAllCottons()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $filter = array(
            'factory_id' => @$this->input->post_get('company'), 
            'start' => @$this->input->post_get('start'), 
            'end' => @$this->input->post_get('end'), 
            'one_filter' => (@$this->input->post_get('one_filter') == 'true')?true:false, 
        );
        $data = $this->posts->get_all_cottons($offset, $limit, $filter);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->before_deb = $this->posts->cotton_deb($data[$i]->factory_id, $data[$i]->currency_id, date('Y-m-01'))->value;
            $data[$i]->current_deb = $this->posts->cotton_deb($data[$i]->factory_id, $data[$i]->currency_id)->value;
        }
        $count = count($this->posts->get_all_cottons(0, 100000000, $filter));
        $factories = $this->posts->get_all_data('factory');
        $currencies = $this->posts->get_all_data('currency');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count, 'factories' => $factories, 'currencies' => $currencies)));
    }

    public function insertCotton() {
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'currency_id' => $this->input->post_get('currency_id'), 
            'weight' => @$this->input->post_get('weight'), 
            'date' => @$this->input->post_get('date'), 
            'summ' => @$this->input->post_get('summ'), 
            'by_bank' => @$this->input->post_get('by_bank'), 
            'by_tax' => @$this->input->post_get('by_tax'), 
            'by_self_counting' => @$this->input->post_get('by_self_counting'), 
        );
        $this->posts->insert_data('cotton', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function deleteCotton() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('cotton', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getCottonById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('cotton', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateCotton()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'factory_id' => $this->input->post_get('factory_id'), 
            'weight' => $this->input->post_get('weight'), 
            'date' => $this->input->post_get('date'), 
            'summ' => $this->input->post_get('summ'), 
            'by_bank' => $this->input->post_get('by_bank'), 
            'by_tax' => $this->input->post_get('by_tax'), 
            'by_self_counting' => $this->input->post_get('by_self_counting'), 
            'currency_id' => $this->input->post_get('currency_id'), 
        );
        $this->posts->update_data('cotton', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    /* ======================================================*/
    /*                       Charges                         */
    /*=======================================================*/
    public function getAllCharges()
    {
        $offset = @$this->input->post_get('offset');
        $limit = @$this->input->post_get('limit');
        $filter = array(
            'charges_type_id' => @$this->input->post_get('charges'), 
            'start' => @$this->input->post_get('start'), 
            'end' => @$this->input->post_get('end'), 
            'one_filter' => (@$this->input->post_get('one_filter') == 'true')?true:false, 
        );
        $data = $this->posts->get_all_charges($offset, $limit, $filter);
        $count = count($this->posts->get_all_charges(0, 100000000, $filter));
        $charges_types = $this->posts->get_all_data('charges_types');
        $currencies = $this->posts->get_all_data('currency');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data, 'count' => $count, 'charges_types' => $charges_types, 'currencies' => $currencies)));
    }

    public function insertCharges() {
        $data = array(
            'charges_type_id' => $this->input->post_get('charges_type_id'), 
            'currency_id' => $this->input->post_get('currency_id'), 
            'output_summ' => $this->input->post_get('output_summ'), 
            'date' => $this->input->post_get('date'), 
            'description' => $this->input->post_get('description'), 
        );
        $this->posts->insert_data('charges', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function deleteCharges() {
        $id = $this->input->post_get('id');
        $this->posts->delete_data('charges', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true)));
    }

    public function getChargesById()
    {
        $id = @$this->input->post_get('id');
        $data = $this->posts->get_data_by_id('charges', $id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function updateCharges()
    {
        $id = $this->input->post_get('id');
        $data = array(
            'charges_type_id' => $this->input->post_get('charges_type_id'), 
            'currency_id' => $this->input->post_get('currency_id'), 
            'output_summ' => $this->input->post_get('output_summ'), 
            'date' => $this->input->post_get('date'), 
            'description' => $this->input->post_get('description'), 
        );
        $this->posts->update_data('charges', $id, $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

}