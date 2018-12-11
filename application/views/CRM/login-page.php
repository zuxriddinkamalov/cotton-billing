<div class="login-register">
    <div class="login-box card">
        <div class="card-block">
            <form class="form-horizontal form-material" id="loginform" method="post" action="admin/login">
                <h3 class="box-title m-b-20"><?=lang('sign_in')?></h3>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" autocomplete="off" type="text" required="" placeholder="<?=lang('username')?>" name="identity">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" autocomplete="off" type="password" required="" placeholder="<?=lang('password')?>" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox-primary pull-left p-t-0">
                            <input id="checkbox-signup" type="checkbox" name="remember">
                            <label for="checkbox-signup"> <?=lang('remember_me')?> </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"><?=lang('login')?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>