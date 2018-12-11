<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view("CRM/authorized/components/header");?>
<body>
    <div id="wrapper">
        <?php $this->load->view('CRM/authorized/components/navbar_top');?>
        <div v-cloak id="app">
            <div class="content container">
               <?php $this->load->view($content);?>
            </div>
        </div>
        <?php $this->load->view("CRM/authorized/pages/templates");?>
        <?php $this->load->view("CRM/authorized/components/footer");?>
    </div>
</body>