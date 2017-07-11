<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'moderation-feedback');
   include('../imports/header.php');

   $study = new Study();
   $arrStudies = $study->getAllStudies();

   ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
   <? include('../imports/alert.php'); ?>
   <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            Feedback <small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="#">Moderation</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="feedback.php">Feedback</a>
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
                     <select class="form-control select2me" name="options2">
                        <option value="">Select...</option>

                        <?php foreach ($arrStudies as $key => $study): ?>

                          <option value="<?=$study->id?>">[<?=$study->author->fullName?>] - <?=$study->name?></option>

                        <?php endforeach; ?>

                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">Message</label>
                  <div class="col-md-6">
                     <textarea id="textarea_message" maxlength="250" class="form-control" rows="6"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
              <button type="button" class="btn btn-success" title="Send" data-dismiss="modal"><i class="fa fa-envelope-o"></i></button>
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
