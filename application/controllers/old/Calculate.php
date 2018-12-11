<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Calculate extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
        {
            redirect(base_url());
        }
        ;
        $this->load->model('product_model', 'products');
        $this->load->model('calculate_model', 'calculate');
        $this->load->library(array('phpexcel', 'm_pdf', 'pagination'));
    }
    
      public function view($id = false)
    {
        if(countProductView($id)){
        $this->data['page'] = 'product';
         $this->data['page_tab'] = 'calculate';
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
       
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = TRUE;
        $config['base_url'] = base_url().LANG.'/calculate/view/'.$id.'/?';
        //$config['total_rows'] = $this->posts->get_posts_count_not('news', 9);
        $config['total_rows'] = $this->calculate->get_calculate_count($id);
        $config['per_page'] = 12;        
        $config['full_tag_open'] = '<div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&rarr;';
        $config['next_tag_open'] = '<li class="page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr;';
        $config['prev_tag_open'] = '<li class="page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        
        $this->data['calculate'] = $this->calculate->get_calculate(array('product_id' => $id, 'limit' => $config['per_page'], 'offset' => (int)$this->input->get('page')));
        
        $this->data['pagination'] = $this->pagination->create_links();
        // var_dump($calc);
        $this->data['content'] = 'CRM/authorized/pages/calculate';
        $this->load->view('CRM/authorized/container', $this->data);
        }else{
            redirect(base_url());
        }
    }
    
    
     public function form_calc(){
 $price_product = $this->input->post('price_product');
        $count_product = $this->input->post('count_product');
        $transfer = $this->input->post('transfer');
        $transport = $this->input->post('transport');
        $clearing = $this->input->post('clearing');
        $transfer = $this->input->post('transfer');
        $station = $this->input->post('station');
        $loader = $this->input->post('loader');
        $custom_house = $this->input->post('custom_house');            
        $declarant = $this->input->post('declarant');
        $warehouse = $this->input->post('warehouse');
        $other_expenses = $this->input->post('other_expenses');
        $mortgage = $this->input->post('mortgage');
        
        $total = $price_product + $count_product + $transfer + $transport + $clearing + $transfer + $station + $loader + $custom_house + $declarant + $warehouse + $other_expenses + $mortgage;
        
        $data = array(
            'price_product' => $this->input->post('price_product'),
            'count_product' => $this->input->post('count_product'),
            'transfer' => $this->input->post('transfer'),
            'transport' => $this->input->post('transport'),
            'clearing' => $this->input->post('clearing'),
            'transfer' => $this->input->post('transfer'),
            'station' => $this->input->post('station'),
            'loader' => $this->input->post('loader'),
            'custom_house' => $this->input->post('custom_house'),
            
            'declarant' => $this->input->post('declarant'),
            'warehouse' => $this->input->post('warehouse'),
            'other_expenses' => $this->input->post('other_expenses'),
              'mortgage' => $this->input->post('mortgage'),
              
            'date' => date('Y-m-d H:i:s'),
            'product_id' => $this->input->post('product_id'),
            'total' => $total,
            // 'trade_receivable' => $this->input->post('trade_receivable'),
            );
        // save sale
        $id = $this->calculate->save($data, false);
        
           if($id){
        $this->session->set_flashdata('message', 'Добавлено');
        }else{
            $this->session->set_flashdata('message', 'Ошибка');
        }
        
        redirect($_SERVER['HTTP_REFERER']);
     
     }
     
      public function form_calc_save(){
         
        $price_product = $this->input->post('price_product');
        $count_product = $this->input->post('count_product');
        $transfer = $this->input->post('transfer');
        $transport = $this->input->post('transport');
        $clearing = $this->input->post('clearing');
        $transfer = $this->input->post('transfer');
        $station = $this->input->post('station');
        $loader = $this->input->post('loader');
        $custom_house = $this->input->post('custom_house');            
        $declarant = $this->input->post('declarant');
        $warehouse = $this->input->post('warehouse');
        $other_expenses = $this->input->post('other_expenses');
        $mortgage = $this->input->post('mortgage');
        
        $total = $price_product + $count_product + $transfer + $transport + $clearing + $transfer + $station + $loader + $custom_house + $declarant + $warehouse + $other_expenses + $mortgage;
        
        $product_id = $this->input->post('product_id');
        $data = array(
            'price_product' => $this->input->post('price_product'),
            'count_product' => $this->input->post('count_product'),
            'transfer' => $this->input->post('transfer'),
            'transport' => $this->input->post('transport'),
            'clearing' => $this->input->post('clearing'),
            'transfer' => $this->input->post('transfer'),
            'station' => $this->input->post('station'),
            'loader' => $this->input->post('loader'),
            'custom_house' => $this->input->post('custom_house'),
            
            'declarant' => $this->input->post('declarant'),
            'warehouse' => $this->input->post('warehouse'),
            'other_expenses' => $this->input->post('other_expenses'),
              'mortgage' => $this->input->post('mortgage'),
              'total' => $total,
           // 'date' => date('Y-m-d H:i:s'),
            
            // 'trade_receivable' => $this->input->post('trade_receivable'),
            );
        // save sale
        $this->calculate->save($data, $product_id);
        
           
        $this->session->set_flashdata('message', 'Обновленно');
        
        
        redirect($_SERVER['HTTP_REFERER']);
     
     }
    
}
?>