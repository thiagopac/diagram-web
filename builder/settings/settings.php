<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once ('../models/InterfaceLanguage.php');
   require_once ('../models/Theme.php');
   require_once ('../models/User.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ('settings-appearance');
   include('../imports/header.php');

   $userID = $_SESSION['USER']['ID'];

   $user = new User();
   $user = $user->getUserWithId($userID);

   $interfaceLanguage = new InterfaceLanguage();
   $arrInterfaceLanguages = $interfaceLanguage->getAllInterfaceLanguages();

   $theme = new Theme();
   $arrThemes = $theme->getAllThemes();
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">

	 <? include('../imports/alert.php'); ?>

	 <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            <?= $t->{'Settings'}; ?> <small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="#"><?= $t->{'Settings'}; ?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="./settings.php"><?= $t->{'Appearance'}; ?></a>
         </li>
      </ul>
   </div>
	 <!-- END PAGE TITLE & BREADCRUMB-->

   <div class="row">
   				<div class="col-md-12">

            <!-- BEGIN FORM-->
            <form method="post" action="./action/settings.php" class="form-horizontal">

            <!-- BEGIN Portlet PORTLET-->
   					<div class="portlet">
   						<div class="portlet-title">
   							<div class="caption">
   								<?= $t->{'General'}; ?>
   							</div>
   							<div class="tools">
   								<a href="javascript:;" class="collapse" data-original-title="" title="">
   								</a>
   							</div>
   						</div>
   						<div class="portlet-body">
                <div class="portlet-body form">
                      <div class="form-body">
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?= $t->{'Site language'}; ?></label>
                            <div class="col-md-5">
                              <select class="form-control select2me" id="interfaceLanguage" name="interfaceLanguage">
                                 <option value=""><?= $t->{'Select...'}; ?></option>

                                 <?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

                                   <?php $selected = $interfaceLanguage->id == $user->interfaceLanguageID ? "selected" : "" ; ?>

                                   <option <?=$selected?> value="<?=$interfaceLanguage->id?>">[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>

                                 <?php endforeach; ?>

                              </select>
                            </div>
                         </div>
                      </div>
                </div>
   						</div>
   					</div>
   					<!-- END Portlet PORTLET-->

            <!-- BEGIN Portlet PORTLET-->
   					<div class="portlet">
   						<div class="portlet-title">
   							<div class="caption">
   								<?= $t->{'Layout'}; ?>
   							</div>
   							<div class="tools">
   								<a href="javascript:;" class="collapse" data-original-title="" title="">
   								</a>
   							</div>
   						</div>
   						<div class="portlet-body">
                   <div class="form-body">
                      <div class="form-group">
                         <label class="col-md-3 control-label"><?= $t->{'Theme'}; ?></label>
                         <div class="col-md-5">
                           <select class="form-control select2me" id="theme" name="theme">
                              <option value=""><?= $t->{'Select...'}; ?></option>

                              <?php foreach ($arrThemes as $key => $theme): ?>

                                <?php $selected = $theme->id == $user->themeID ? "selected" : "" ; ?>

                                <option <?=$selected?> value="<?=$theme->id?>"><?=$theme->name?></option>

                              <?php endforeach; ?>

                           </select>
                         </div>
                      </div>
                   </div>
                <br/><br/><br/>
   						</div>
   					</div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
              <button type="button" id="btnSaveSettings" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
            </div>
   					<!-- END Portlet PORTLET-->
          </form>
          <!-- END FORM-->

   				</div>

   			</div>

<!-- END CONTENT -->
</div>
<? include('../imports/footer.php'); ?>
<? include('../imports/metronic_core.php'); ?>
<script>
jQuery(document).ready(function() {
  // initiate layout and plugins
  Metronic.init(); // init metronic core components
  Layout.init(); // init current layou

  $(document).ready(function () {
    if(sessionStorage.getItem("Success")){
        toastr.success(sessionStorage.getItem("Success"));
        sessionStorage.clear();
    }

    if(sessionStorage.getItem("Warning")){
        toastr.warning(sessionStorage.getItem("Warning"));
        sessionStorage.clear();
    }

    if(sessionStorage.getItem("Info")){
        toastr.info(sessionStorage.getItem("Info"));
        sessionStorage.clear();
    }

    if(sessionStorage.getItem("Error")){
        toastr.error(sessionStorage.getItem("Error"));
        sessionStorage.clear();
    }

  });

  $(document).ready(function () {
        $("#btnSaveSettings").click(function () {
            $.ajax({
                url: './action/settings.php',
                type: 'POST',
                data: {interfaceLanguage: $("#interfaceLanguage").val(),
                      theme: $("#theme").val()},
                success: function (result) {
                  var response = JSON.parse(result);

                  if(response["status"] == "success"){
                    sessionStorage.setItem("Success","<?= $t->{'Saved changes!'}; ?>");
                    location.reload();
                  }else if(response["status"] == "error"){
                    toastr.warning('<?= $t->{'Error. Please, try again later.'}; ?>');
                  }
                }, error: function (result) {
                    toastr.error('<?= $t->{'Error. Please, try again later.'}; ?>');
                }
            });
        });
    });

});
</script>
</body>
</html>
