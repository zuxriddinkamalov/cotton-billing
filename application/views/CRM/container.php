<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view("CRM/components/header");?>
<body>
    <div id="wrapper">
        <?php $this->load->view($content);?>
    </div>
    <?php $this->load->view("CRM/components/footer");?>
</body>