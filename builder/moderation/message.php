<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/StudyAdministration.php');
   require_once('../models/Study.php');

   if (empty($_REQUEST['m'])){
     header('Location: ./');
     exit;
 	 }

   // CONTROLE SESSAO
   fnInicia_Sessao ('moderation-inbox');

   #BUSCAR TODAS AS VARIÁVEIS GET
   $paramMessage = $_REQUEST['m'];
   $paramUser = $_SESSION['USER']['ID'];

   StudyAdministration::$showDeleted = false;

   $studyAdministration = new StudyAdministration();
   $studyAdministration = $studyAdministration->getStudyAdministrationWithIDForUser($paramMessage, $paramUser);

   $study = new Study();
  $studyAdministration->study = $study->getStudyWithID($studyAdministration->studyID);

   if ($studyAdministration->id == NULL){
     header('Location: ./');
     exit;
    }

   include('../imports/header.php');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
   <? include('../imports/alert.php'); ?>
   <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            <?= $t->{'Administration Message'}; ?> <small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="#"><?= $t->{'Moderation'}; ?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="inbox.php"><?= $t->{'Inbox'}; ?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="message.php?m=<?=$paramMessage?>"><?= $t->{'Message'}; ?></a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <div class="portlet light">
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form class="form-horizontal">
           <input type="hidden" id="studyAdministrationID" name="studyAdministrationID" value="<?=$paramMessage?>">
            <div class="form-body">
               <div class="form-group">
                  <label class="col-md-3 control-label"><?= $t->{'Study'}; ?></label>
                  <div class="col-md-6">
                     <p class="form-control-static"><?=$studyAdministration->study->name?></p>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label"><?= $t->{'Sent date'}; ?></label>
                  <div class="col-md-6">
                     <p class="form-control-static"><?=$studyAdministration->dateCreated?></p>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label"><?= $t->{'Message'}; ?></label>
                  <div class="col-md-6">
                     <p class="form-control-static"><?=$studyAdministration->message?></p>
                  </div>
               </div>
            </div>
            <div class="form-actions">
               <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                     <button type="button" class="btn default" onclick="window.history.go(-1)"><?= $t->{'Back'}; ?></button>
                  </div>
               </div>
            </div>
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

  var read = <?=$studyAdministration->read  ?>

  if (read == 0){
    $.ajax({
        url: './action/read-feedback.php',
        type: 'POST',
        data: {studyAdministrationID: $("#studyAdministrationID").val()},
        success: function (result) {
        }
    });
  }

});
</script>
</body>
</html>
