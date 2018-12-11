<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="OSG">
    <title>Online service group</title>
    <script>
        base_url = '<?=base_url()?>';
        csrf = {
            <?=$this->security->get_csrf_token_name()?>: '<?=$this->security->get_csrf_hash()?>'
        }
    </script>
    <link rel="apple-touch-icon" href="<?=base_url()?>assets/images/brand.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/brand.png">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin-scripts/framework/components/element-ui/index.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/responsive.css?ver=<?=time()?>" />
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?=base_url()?>assets/admin-scripts/libs/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <link type="text/css" href="<?=base_url()?>assets/fonts/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" />
</head>