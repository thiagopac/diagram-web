<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/StudyAdministration.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'administration-management');
   include('../imports/header.php');

   $_SESSION['m'] = isset($_REQUEST['m']) ? addslashes($_REQUEST['m']) : $_SESSION['m'];

   #BUSCAR TODAS AS VARIÁVEIS GET
   $paramMessage = $_SESSION['m'];
   $paramUser = $_SESSION['USER']['ID'];

   $studyAdministration = new StudyAdministration();
   $studyAdministration = $studyAdministration->getStudyAdministrationWithIDForUser($paramMessage, $paramUser);

   ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
   <? include('../imports/alert.php'); ?>
   <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            Administration Message <small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="#">Administration</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="index.php">Inbox</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="message.php?m=<?=$paramMessage?>">Message</a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <div class="portlet light">
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="details.php" class="form-horizontal">
            <div class="form-body">
               <div class="form-group">
                  <label class="col-md-3 control-label">Study</label>
                  <div class="col-md-6">
                     <p class="form-control-static"><?=$studyAdministration->study->name?></p>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">Sent date</label>
                  <div class="col-md-6">
                     <p class="form-control-static"><?=$studyAdministration->dateCreated?></p>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">Message</label>
                  <div class="col-md-6">
                     <p class="form-control-static"><?=$studyAdministration->message?></p>
                  </div>
               </div>
            </div>
            <div class="form-actions">
               <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                     <button type="button" class="btn default" onclick="window.history.go(-1)">Back</button>
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


   var ComponentsFormTools = function () {

       var handleBootstrapMaxlength = function() {
           $('#text_name').maxlength({
               limitReachedClass: "label label-danger",
           })

           $('#textarea_opening').maxlength({
               limitReachedClass: "label label-danger",
               alwaysShow: true,
               placement: 'bottom-right'

           });

           $('#textarea_study').maxlength({
               limitReachedClass: "label label-danger",
               alwaysShow: true,
               placement: 'bottom-right'
           });

           $('#maxlength_placement').maxlength({
               limitReachedClass: "label label-danger",
               alwaysShow: true,
               placement: Metronic.isRTL() ? 'top-right' : 'top-left'
           });
       }

       handleBootstrapMaxlength();

   }();


   });
</script>
</body>
</html>
