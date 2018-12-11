<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Product extends MY_Controller
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
        $this->load->library(array('phpexcel', 'm_pdf'));
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
            ('data' => $data, 'countSale' => $countSale, 'page' => $page, 'limit' => $limit)));


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

        /*for($i=0; $i<count($data); $i++){
        $data[i]['price_per_one'] = number_format($data[i]['price_per_one'], '', '');
        $data[i]['weight'] = number_format($data[i]['weight'], '', '');
        $data[i]['total_price'] = number_format($data[i]['total_price'], '', '');
        $data[i]['paid_sum'] = number_format($data[i]['paid_sum'], '', '');
        $data[i]['trade_receivable'] = number_format($data[i]['trade_receivable'], '', '');           
        
        }*/

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
    

    public function exportExcel()
    {
        $this->data['sel'] = '';
        $data = $this->products->get_products();
        $objPHPExcel = new PHPExcel();
        $heading = array(
            '№',
            'Имя',
            'Фамилия',
            'Компания',
            'Дата',
            'Цена за 1 кг',
            'Вес кг',
            'Итого Цена',
            'Отдал',
            'Задолженность');
        //$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->getActiveSheet()->setTitle('Export');
        $rowNumberH = 1;
        $colH = 'A';
        foreach ($heading as $h)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
            $colH++;
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $i = 2;
        $i1 = 1;
        foreach ($data as $item)
        {
            // $objPHPExcel->getActiveSheet()->getStyle("F$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $g = $i + 1;
            $objPHPExcel->getActiveSheet()->setCellValue("A$i", $i1);
            $objPHPExcel->getActiveSheet()->setCellValue("B$i", $item['first_name']);
            $objPHPExcel->getActiveSheet()->setCellValue("C$i", $item['last_name']);
            $objPHPExcel->getActiveSheet()->setCellValue("D$i", $item['company']);
            $objPHPExcel->getActiveSheet()->setCellValue("E$i", $item['date']);
            $objPHPExcel->getActiveSheet()->setCellValue("F$i", $item['price_per_one']);
            $objPHPExcel->getActiveSheet()->setCellValue("G$i", $item['weight']);
            $objPHPExcel->getActiveSheet()->setCellValue("H$i", $item['total_price']);
            $objPHPExcel->getActiveSheet()->setCellValue("I$i", $item['paid_sum']);
            $objPHPExcel->getActiveSheet()->setCellValue("J$i", $item['trade_receivable']);
            $objPHPExcel->getActiveSheet()->setCellValue("K$i", $item['name']);
            // $objPHPExcel->getActiveSheet()->setCellValue("F$g", $res3);
            // $objPHPExcel->getActiveSheet()->setCellValue("G$g", $res3);
            $i++;
            $i1++;
        }
        for ($col = 'A'; $col !== 'L'; $col++)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        /* Записываем в файл */
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header('Content-Type: application/vnd.ms-excel');
        //$title = _t(getPosts($post_id, 'title'));
        $title = 'Export-' . date('Y-m-d H:i:s');
        header('Content-Disposition: attachment;filename="' . $title . '.xls"');
        header('Cache-Control: max-age=0');
        // Выводим содержимое файла
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        go_to();
        // var_dump($data);
        // var_dump($calc);
    }
    public function exportPDF()
    {
        $this->data['sel'] = '';
        $this->data['sale'] = $this->products->get_products();
        $html = $this->load->view("CRM/authorized/export/pdf", $this->data, true);
        $title = 'export-pdf-' . date('Y-m-d H:i:s');
        $pdfFilePath = "$title.pdf";
        //load mPDF library
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function importExcel()
    {
        $this->load->library('phpexcel');

        if (@$_FILES['userfile']['size'] > 0)
        {
            $uploaddir = 'uploads/excel/';
            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
            {
                $data['file'] = basename($_FILES['userfile']['name']);

                $objPHPExcel = PHPExcel_IOFactory::load($uploadfile);
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                $arr_data = array();
                $header = array();

                foreach ($cell_collection as $cell)
                {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1)
                    {
                        $header[$row][$column] = $data_value;
                    } else
                    {
                        $arr_data[$row][$column] = $data_value;
                    }
                    /*   if ($row == 1) {
                    $header[$row][$column] = $data_value;
                    }  elseif ($row == 2) {
                    $header[$row][$column] = $data_value;
                    }else {
                    $arr_data[$row][$column] = $data_value;
                    }*/
                }
                //send the data in an array format
                $this->data['header'] = $header;
                $this->data['values'] = $arr_data;


                foreach ($this->data['values'] as $value)
                {
                    if (array_key_exists("A", $value))
                    {
                        $user['first_name'] = $value["A"];
                    }
                    if (array_key_exists("B", $value))
                    {

                        $user['last_name'] = $value["B"];
                    }
                    if (array_key_exists("C", $value))
                    {
                        $user['company'] = $value["C"];
                    }
                    if (array_key_exists("D", $value))
                    {
                        $product['price_per_one'] = $value["D"];
                    }
                    if (array_key_exists("E", $value))
                    {
                        $product['weight'] = $value["E"];
                    }
                    if (array_key_exists("F", $value))
                    {
                        $product['paid_sum'] = $value["F"];
                    }
                    
                    if (array_key_exists("G", $value))
                    {
                         if (nameProduct('name', trim($value["G"])))
        {
                    $product['product_id'] = nameProduct('name', trim($value["G"]));
                    } else{
                        $product['product_id'] = 0;
                    }
                    }
                    
                    $product['date'] = date('Y-m-d H:i:s');
                    
                   


                    // save sale
                    if($product['product_id'] !== 0){
                    $id = $this->products->saveSale($product, false);
                    
                    
                    if (nameClients('first_name', trim($value["A"])) and nameClients('company', trim
                        ($value["C"])))
                    {
                        $client_id = nameClients('first_name', trim($value["A"]));
                    } else
                    {
                        $client_id = $this->products->saveClients($user, false);
                    }

                    $data2 = array('client_id' => $client_id);

                    $this->products->saveSale($data2, $id);
                    }
                }


                $count = count($this->data['values']);
                $this->session->set_flashdata('success', 'Добавлено ' . $count . '');
                @unlink($uploaddir . basename($_FILES['userfile']['name']));
                go_to();

            } else
            {
                $data['pic'] = "";
                $this->session->set_flashdata('error', 'Ошибка');
                go_to();
            }
        } else
        {
            echo "Что то пошло не так";
        }

    }
    
    /* Для просмотра товара (профиль) */
    
        public function exportViewExcel($product_id)
    {
        $this->data['sel'] = '';
        $data = $this->products->get_products(array('product_id' => $product_id));
        $objPHPExcel = new PHPExcel();
        $heading = array(
            '№',
            'Имя',
            'Фамилия',
            'Компания',
            'Дата',
            'Цена за 1 кг',
            'Вес кг',
            'Итого Цена',
            'Отдал',
            'Задолженность',
            'Товар');
        //$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->getActiveSheet()->setTitle('Export');
        $rowNumberH = 1;
        $colH = 'A';
        foreach ($heading as $h)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($colH . $rowNumberH, $h);
            $colH++;
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $i = 2;
        $i1 = 1;
        foreach ($data as $item)
        {
            // $objPHPExcel->getActiveSheet()->getStyle("F$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $g = $i + 1;
            $objPHPExcel->getActiveSheet()->setCellValue("A$i", $i1);
            $objPHPExcel->getActiveSheet()->setCellValue("B$i", $item['first_name']);
            $objPHPExcel->getActiveSheet()->setCellValue("C$i", $item['last_name']);
            $objPHPExcel->getActiveSheet()->setCellValue("D$i", $item['company']);
            $objPHPExcel->getActiveSheet()->setCellValue("E$i", $item['date']);
            $objPHPExcel->getActiveSheet()->setCellValue("F$i", $item['price_per_one']);
            $objPHPExcel->getActiveSheet()->setCellValue("G$i", $item['weight']);
            $objPHPExcel->getActiveSheet()->setCellValue("H$i", $item['total_price']);
            $objPHPExcel->getActiveSheet()->setCellValue("I$i", $item['paid_sum']);
            $objPHPExcel->getActiveSheet()->setCellValue("J$i", $item['trade_receivable']);
            $objPHPExcel->getActiveSheet()->setCellValue("K$i", $item['name']);
            // $objPHPExcel->getActiveSheet()->setCellValue("F$g", $res3);
            // $objPHPExcel->getActiveSheet()->setCellValue("G$g", $res3);
            $i++;
            $i1++;
        }
        for ($col = 'A'; $col !== 'L'; $col++)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        /* Записываем в файл */
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header('Content-Type: application/vnd.ms-excel');
        //$title = _t(getPosts($post_id, 'title'));
        $title = 'Export-' . date('Y-m-d H:i:s');
        header('Content-Disposition: attachment;filename="' . $title . '.xls"');
        header('Cache-Control: max-age=0');
        // Выводим содержимое файла
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        go_to();
         //var_dump($data);
        // var_dump($calc);
    }
    public function exportViewPDF($product_id)
    {
        $this->data['sel'] = '';
        $this->data['sale'] = $this->products->get_products(array('product_id' => $product_id));
        $html = $this->load->view("CRM/authorized/export/pdf", $this->data, true);
        $title = 'export-pdf-' . date('Y-m-d H:i:s');
        $pdfFilePath = "$title.pdf";
        //load mPDF library
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function importViewExcel($product_id)
    {
        $this->load->library('phpexcel');

        if (@$_FILES['userfile']['size'] > 0)
        {
            $uploaddir = 'uploads/excel/';
            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
            {
                $data['file'] = basename($_FILES['userfile']['name']);

                $objPHPExcel = PHPExcel_IOFactory::load($uploadfile);
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                $arr_data = array();
                $header = array();

                foreach ($cell_collection as $cell)
                {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1)
                    {
                        $header[$row][$column] = $data_value;
                    } else
                    {
                        $arr_data[$row][$column] = $data_value;
                    }
                    /*   if ($row == 1) {
                    $header[$row][$column] = $data_value;
                    }  elseif ($row == 2) {
                    $header[$row][$column] = $data_value;
                    }else {
                    $arr_data[$row][$column] = $data_value;
                    }*/
                }
                //send the data in an array format
                $this->data['header'] = $header;
                $this->data['values'] = $arr_data;


                foreach ($this->data['values'] as $value)
                {
              
                    if (array_key_exists("A", $value))
                    {
                        $product['price_per_one'] = $value["A"];
                    }
                    if (array_key_exists("B", $value))
                    {
                        $product['weight'] = $value["B"];
                    }
                    if (array_key_exists("C", $value))
                    {
                        $product['paid_sum'] = $value["C"];
                    }
                    $product['date'] = date('Y-m-d H:i:s');
                    $product['product_id'] = $product_id;
                    $product['client_id'] = $client_id;


                    // save sale
                    $id = $this->products->saveSale($product, false);
                
                    
                }


                $count = count($this->data['values']);
                $this->session->set_flashdata('success', 'Добавлено ' . $count . '');
                @unlink($uploaddir . basename($_FILES['userfile']['name']));
                go_to();

            } else
            {
                $data['pic'] = "";
                $this->session->set_flashdata('error', 'Ошибка');
                go_to();
            }
        } else
        {
            echo "Что то пошло не так";
        }

    }
}
