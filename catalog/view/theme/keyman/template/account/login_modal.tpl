<div class="modal fade" id="modal-in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-in">
    <div class="modal-content">
      <div class="modal-header">
          <div class="h2 text-center ttu custom_h3"><span>Вход</span></div>
      </div>
      <div class="modal-body">
        <div id="modal_auth_message" style="dn"></div>
        <div class="text-center custom_h4">Войти через социальную сеть</div>
                    <div class="social-icons">
                       <?php echo $ulogin_form_marker; ?>
                   </div>
        
        <div class="text-center linecenter custom_h4"><span>Или</span></div>
        
        <div class="modal-in-form">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="modal_login_form">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="E-mail" name="email" value="<?php echo $email; ?>" id="input-email" >
                </div>
                <div class="form-group posrel">
                  <input type="text" class="form-control" placeholder="Пароль" name="password" value="<?php echo $password; ?>" id="input-password">
                  <a href="<?php echo $forgotten; ?>" class="remindme" rel="nofollow">Забыли пароль?</a>
                </div>
                 <div class="row form-group">
                <div class="col-xs-6"><button type="submit" id="modal_login_submit" class="btn btn-block  btn-default btn-primary pull-left">Войти</button></div>
                <div class="col-xs-6"><a href="<?php echo $register; ?>" class="btn btn-block btn-default pull-right" rel="nofollow">Регистрация</a></div>
                <div class="clearfix"></div>
            </div>
            </form>
        </div>
      </div>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->