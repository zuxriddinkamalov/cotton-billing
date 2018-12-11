<div class="container">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse" aria-expanded="false">
            <span class="sr-only"><?=lang('toggle')?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=base_url()?>"><p style="float: left;">Paxtasanoat</p></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img width="25" class="user-avatar" src="<?=$user_image?>" alt="avatar" /><span class="user-name"><?=($user->first_name.' '.$user->last_name)?></span> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?=base_url(LANG.'/admin/edit-profile')?>" class="dropdown-item"><i class="ft-user"></i> <?=lang('edit_profile')?></a></li>
                <!--<?php if($is_super_admin){?><li><a href="<?=base_url(LANG.'/admin/users-list')?>"><?=lang('users')?></a></li><?}?>-->
                <li role="separator" class="divider"></li>
                <li><a href="<?=base_url('admin/logout')?>"><?=lang('logout')?></a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
</div>