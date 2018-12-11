<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends MY_Controller
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
        $this->load->model('profile_model', 'profile');
        $this->load->library(array('phpexcel', 'm_pdf'));
    }
    public function index($id)
    {
          $this->data['client_id'] = $id;
          $this->data['profile'] = $this->profile->get($id);
          $this->data['page'] = 'clients';
          
        $calc = $this->products->get_products(array('client_id' => $id));
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
       
        
       
       
          
        $this->data['content'] = 'CRM/authorized/profile/index';
        $this->load->view('CRM/authorized/container', $this->data);
    }


    public function profileProduct($id)
    {
        $countSale = countProductUser($id);
        $limit = (int)$this->input->get('pageSize');
        $page = ((int)$this->input->get('pageIndex') - 1) * $limit;

        
            
            
               if ($this->input->get('first_name'))
        {
            $title = $this->input->get('first_name');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'first_name' => $title,
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'first_name' => $title,
                  'client_id' => $id,
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
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'last_name' => $title,
                  'client_id' => $id,
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
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'company' => $title,
                  'client_id' => $id,
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
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'price_per_one' => $title,
                  'client_id' => $id,
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
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'weight' => $title,
                'order' => 'desc',
                  'client_id' => $id,
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
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'total_price' => $title,
                'order' => 'desc',
                  'client_id' => $id,
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
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'paid_sum' => $title,
                  'client_id' => $id,
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
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'trade_receivable' => $title,
                  'client_id' => $id,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count))));
        } elseif ($this->input->get('date'))
        {
            $title = $this->input->get('date');
            $count = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'date' => $title,
                  'client_id' => $id,
                'order' => 'desc'));
            $data = $this->products->get_products(array(
                'orderby' => 'sale_info.id_sale',
                'date' => $title,
                  'client_id' => $id,
                'order' => 'desc',
                'limit' => $limit,
                'offset' => $page));
            $this->output->set_content_type('application/json')->set_output(json_encode(array
                ('data' => $data, 'countSale' => count($count), 'date' => $title)));
        } else
        {
            $data = $this->products->get_products(array(
            'orderby' => 'sale_info.id_sale',
            'order' => 'desc',
            'client_id' => $id,
            'limit' => $limit,
            'offset' => $page));
        $this->output->set_content_type('application/json')->set_output(json_encode(array
            ('data' => $data, 'countSale' => $countSale)));
        }


    }

    public function addProduct($client_id)
    {
        $data = array(
            'price_per_one' => $this->input->post('price_per_one'),
            'weight' => $this->input->post('weight'),
            'paid_sum' => $this->input->post('paid_sum'),
            'date' => date('Y-m-d H:i:s'),
            'product_id' => 1,
            'client_id' => $client_id,
            // 'trade_receivable' => $this->input->post('trade_receivable'),
            );
        // save sale
        $id = $this->products->saveSale($data, false);
    
    }
    
    public function exportExcel($client_id)
    {
        $this->data['sel'] = '';
        $data = $this->products->get_products(array('client_id' => $client_id));
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
         //var_dump($data);
        // var_dump($calc);
    }
    public function exportPDF($client_id)
    {
        $this->data['sel'] = '';
        $this->data['sale'] = $this->products->get_products(array('client_id' => $client_id));
        $html = $this->load->view("CRM/authorized/export/pdf", $this->data, true);
        $title = 'export-pdf-' . date('Y-m-d H:i:s');
        $pdfFilePath = "$title.pdf";
        //load mPDF library
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function importExcel($client_id)
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
                    if (array_key_exists("D", $value))
                    {
                    
                    if (nameProduct('name', trim($value["D"])))
                    {
                    $product['product_id'] = nameProduct('name', trim($value["D"]));
                    } else{
                        $product['product_id'] = 0;
                    }
                    }
                    
                    $product['date'] = date('Y-m-d H:i:s');
                    $product['client_id'] = $client_id;
               
                    if($product['product_id'] !== 0){
                     // save sale
                    $id = $this->products->saveSale($product, false);
                    
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
}
