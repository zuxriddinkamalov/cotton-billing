<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Api extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model', 'products');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-CSRF-TOKEN");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, QWERTY");
    }
    
    /* Menu product */
    public function index()
    {
        $this->data['page'] = 'product';
       
        $this->data['countSale'] = $this->products->countProduct();
        $this->data['content'] = 'CRM/authorized/pages/products';
        $this->load->view('CRM/authorized/container', $this->data);
    }
    
    public function getProduct()
    {
        $countSale = $this->products->countProduct();
        $limit = (int)$this->input->get('pageSize');
        $page = ((int)$this->input->get('pageIndex') - 1) * $limit;
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        if ($this->input->get('name'))
        {
            $title = $this->input->get('name');
            $count = $this->products->getProducts(array(
                'orderby' => 'product.id_product',
                'name' => $title,
                'order' => 'desc'));
            $data = $this->products->getProducts(array(
                'orderby' => 'product.id_product',
                'name' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        }elseif($this->input->get('id_product')){
            $title = $this->input->get('id_product');
            $count = $this->products->getProducts(array(
                'orderby' => 'product.id_product',
                'id_product' => $title,
                'order' => 'desc'));
            $data = $this->products->getProducts(array(
                'orderby' => 'product.id_product',
                'id_product' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        }else
        {
            $data = $this->products->getProducts(array(
                'orderby' => 'product.id_product',
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => $countSale)));
        }

    }
        
    public function updateProduct()
    {
        $id = $this->input->post('id_product');
        $data = array(
            'name' => $this->input->post('name'),           
        );        
        $this->products->saveProduct($data, $id);
       
    }
    public function addProduct()
    {
         $name = trim($this->input->post('name'));
         if (!nameProduct('name', $name))
        {
        $data = array(
            'name' => $this->input->post('name'),           
        );
        // save sale
        $id = $this->products->saveProduct($data, false);
        }
      
    }
     public function deleteProduct()
    {
        $id = $this->input->post('id_product');
        $this->products->deleteProduct($id);
        $this->output->set_content_type('application/json');
        $this->output->set_output( json_encode(array('id_product'=>$id) ));
    }
    
     public function view($id)
    {
        $this->data['page'] = 'product';
          $this->data['id_product'] = $id;
          $this->data['countSale'] = countProductView($id);
          
          $this->data['product'] = $this->products->get($id);
          
            $calc = $this->products->get_products(array('product_id' => $id));
       if($calc){
            $res = '';
            $res2 = '';
            $i1 = 0; foreach($calc as $item){
           $res1[$i1] = $item['total_price'];
           $res2 = $res1[$i1] + $res2;
           $res3 = $res2;
            $i1++;}
            
            $this->data['total_price'] = $res3;
            
             $res = '';
            $res2 = '';
            $i1 = 0; foreach($calc as $item){
           $res1[$i1] = $item['paid_sum'];
           $res2 = $res1[$i1] + $res2;
           $res3 = $res2;
            $i1++;}
            
            $this->data['paid_sum'] = $res3;
            
             $res = '';
            $res2 = '';
            $i1 = 0; foreach($calc as $item){
           $res1[$i1] = $item['trade_receivable'];
           $res2 = $res1[$i1] + $res2;
           $res3 = $res2;
            $i1++;}
            
            $this->data['trade_receivable'] = $res3;
       }
         // var_dump($calc);
           $this->data['content'] = 'CRM/authorized/pages/products_view';
        $this->load->view('CRM/authorized/container', $this->data);
    }
    
    public function viewProduct($id)
    {
        $countSale = countProductView($id);
        $limit = (int)$this->input->get('pageSize');
        $page = ((int)$this->input->get('pageIndex') - 1) * $limit;

        $data = $this->products->get_products(array(
            'orderby' => 'sale_info.id_sale',
            'order' => 'desc',
            'product_id' => $id,
            'limit' => $limit,
            'offset' => $page));
        $this->output->set_content_type('application/json')->set_output(json_encode(array
            ('data' => $data, 'countSale' => $countSale, 'page' => $page, 'limit' => $limit, 'method' => $_SERVER['REQUEST_METHOD'])));
    }
    public function addViewProduct($id_product)
    {
        $data = array(
            'price_per_one' => $this->input->post('price_per_one'),
            'weight' => $this->input->post('weight'),
            'paid_sum' => $this->input->post('paid_sum'),
            'date' => date('Y-m-d H:i:s'),
            'product_id' => $id_product,
            // 'trade_receivable' => $this->input->post('trade_receivable'),
            );
        // save sale
        $id = $this->products->saveSale($data, false);
        // edit user
        //$client_id = $this->input->post('client_id');
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
                );
            $client_id = $this->products->saveClients($data1, false);
        }
        $data2 = array('client_id' => $client_id);
        $this->products->saveSale($data2, $id);
    }
    
    /*end menu product */
    
    public function get_products()
    {
        $countSale = $this->products->countSale();
        $limit = (int)$this->input->get('pageSize');
        $page = ((int)$this->input->get('pageIndex') - 1) * $limit;

        if ($this->input->get('first_name'))
        {
            $title = $this->input->get('first_name');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'first_name' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'first_name' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('last_name'))
        {
            $title = $this->input->get('last_name');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'last_name' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'last_name' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('company'))
        {
            $title = $this->input->get('company');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'company' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'company' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('price_per_one'))
        {
            $title = $this->input->get('price_per_one');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'price_per_one' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'price_per_one' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('weight'))
        {
            $title = $this->input->get('weight');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'weight' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'weight' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('total_price'))
        {
            $title = $this->input->get('total_price');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'total_price' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'total_price' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('paid_sum'))
        {
            $title = $this->input->get('paid_sum');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'paid_sum' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'paid_sum' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('trade_receivable'))
        {
            $title = $this->input->get('trade_receivable');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'trade_receivable' => $title,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'trade_receivable' => $title,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } else
        {
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => $countSale, 'offset' => $page, 'limit' => $limit)));
        }


    }
    
       

  
    public function update_products()
    {
        $id = $this->input->post('id_sale');
        $data = array(
            'price_per_one' => $this->input->post('price_per_one'),
            'weight' => $this->input->post('weight'),
            'paid_sum' => $this->input->post('paid_sum'),
            //'trade_receivable' => $this->input->post('trade_receivable'),
            );
        // save sale
        $this->products->saveSale($data, $id);
        // edit user
        $client_id = $this->input->post('client_id');
        $data1 = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            );
        $this->products->saveClients($data1, $client_id);
    }
    public function add()
    {
        $data = array(
            'price_per_one' => $this->input->post('price_per_one'),
            'weight' => $this->input->post('weight'),
            'paid_sum' => $this->input->post('paid_sum'),
            'date' => date('Y-m-d H:i:s'),
            'product_id' => 1,
            // 'trade_receivable' => $this->input->post('trade_receivable'),
            );
        // save sale
        $id = $this->products->saveSale($data, false);
        // edit user
        //$client_id = $this->input->post('client_id');
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
                );
            $client_id = $this->products->saveClients($data1, false);
        }
        $data2 = array('client_id' => $client_id);
        $this->products->saveSale($data2, $id);
    }
    public function delete()
    {
        $id = $this->input->post('client_id');
        $this->products->delete($id);
        $this->output->set_content_type('application/json');
        $this->output->set_output( json_encode(array('client_id'=>$id) ));
    }
    public function sale()
    {
        $this->data['page'] = 'sale';
        $this->data['data_info'] = $this->products->get_products();
        $this->data['countSale'] = $this->products->countSale();
        $this->data['content'] = 'CRM/authorized/pages/sale';
        $this->load->view('CRM/authorized/container', $this->data);
    }
    
}
