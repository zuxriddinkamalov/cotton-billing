<div class="container">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="title-block"><?=lang('edit_profile')?></h3>
    </div>
    <div class="content-body">
      <div class="row">
        <div class="col-xs-12">
          <div class="card-block">
            <form action="<?=base_url(LANG.'/admin/edit-profile')?>" enctype="multipart/form-data" method="post" class="steps-validation wizard-circle">

              <fieldset>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="firstName1">Ism: <span class="danger">*</span></label>
                      <input name="first_name" value="<?=$user->first_name?>" type="text" class="form-control required" id="firstName1" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lastName1">Familiya: <span class="danger">*</span></label>
                      <input name="last_name" value="<?=$user->last_name?>" type="text" class="form-control required" id="lastName1" >
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="sex1">Jinsi: </label>
                      <select class="custom-select form-control" id="sex1" name="sex">
                        <option <?=($user->sex=='Erkak'?"selected":"")?> value="Erkak">Erkak</option>
                        <option <?=($user->sex=='Ayol'?"selected":"")?> value="Ayol">Ayol</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="location1">Viloyat:</label>
                      <select class="custom-select form-control" id="location1" name="city">
                        <option name="city" value="">Viloyatni tanlang</option>
                        <?php foreach($cities as $city){?>
                          <option name="city" <?=($city->name==$user->city?"selected":"")?> value="<?=$city->name?>"><?=$city->name?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phoneNumber1">Telefon raqam:</label>
                      <input name="phone" value="<?=$user->phone?>" type="tel" class="form-control" id="phoneNumber1" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date1">Tug'ilgan yili:</label>
                      <input name="born" value="<?=str_replace(':', '-', date("Y:d:m",strtotime($user->born)))?>" type="date" class="form-control" id="date1" >
                    </div>
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="proposalTitle1">Foydalanuvchi logini: <span class="danger">*</span></label>
                      <input value="<?=$user->username?>" name="username" type="text" class="form-control required" id="proposalTitle1" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="emailAddress1">Email adres: <span class="danger">*</span></label>
                      <input value="<?=$user->email?>" name="email" type="email" class="form-control required" id="emailAddress1" >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">Eski parol:</label>
                      <input type="password" class="form-control password" name="old_password" id="password" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">Yangi parol:</label>
                      <input type="password" name="new_password" class="form-control password" id="password1" >
                      <div class="show-password"><i class="fa fa-eye" aria-hidden="true"></i></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php if($user->image_file){?>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Foydalanuvchi rasmi:</label>
                        <div>
                          <img class="avatar-edit" src="<?=$user_image?>" alt="" />
                          <a href="<?=base_url("admin/delete-photo")?>"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;O'chirish</a>
                        </div>
                      </div>
                    </div>
                  <?php }?>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="image">Foydalanuvchi rasmi:</label>
                      <input name="userfile" type="file" class="form-control" id="image-file" >
                    </div>
                  </div>
                </div>
              </fieldset>
              <input type="submit" class="btn btn-primary text-right" value="<?=lang('save')?>" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>