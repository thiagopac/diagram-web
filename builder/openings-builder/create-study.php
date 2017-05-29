<?
   // #INCLUDES
   require_once ('../lib/config.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings-builder' );
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
            Create new study <small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="./">Openings Builder</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="create-study.php">Create study</a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <div class="portlet light">
      <div class="portlet-title">
         <div class="caption">
            <i class="fa fa-bars font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase">NEW STUDY</span>
            <span class="caption-helper">All fields are required</span>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="details.php" class="form-horizontal">
            <div class="form-body">
               <div class="form-group">
                  <label class="col-md-3 control-label">Language</label>
                  <div class="col-md-6">
                     <select class="form-control select2me" name="options2">
                        <option value="">Select...</option>
                        <option value="Option 1">Option 1</option>
                        <option value="Option 2">Option 2</option>
                        <option value="Option 3">Option 3</option>
                        <option value="Option 4">Option 4</option>
                     </select>
                     <span class="help-block">
                     Select the language of this material. You can submit studies only in the supported languages. </span>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">Name</label>
                  <div class="col-md-6">
                     <input type="text" class="form-control" placeholder="E.g: Caro-Kann for beginners" maxlength="50" name="defaultconfig" id="text_name">
                     <span class="help-block">
                     Use a small name for your study.</span>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">Side</label>
                  <div class="col-md-6">
                     <select class="form-control" name="select">
                        <option value="">Choose the side</option>
                        <option value="Category 1">White</option>
                        <option value="Category 2">Black</option>
                     </select>
                     <span class="help-block">
                     Both sides are <strong>NOT</strong> supported at this moment. </span>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">ECO Opening</label>
                  <div class="col-md-6">
                     <select class="form-control select2me" name="options2">
                        <option value="">Select...</option>
                        <option value="Option 1">Option 1</option>
                        <option value="Option 2">Option 2</option>
                        <option value="Option 3">Option 3</option>
                        <option value="Option 4">Option 4</option>
                     </select>
                     <span class="help-block">
                     If you don't know what is the ECO code, please consider read <a href="https://en.wikipedia.org/wiki/List_of_chess_openings">this</a>.</span>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">About the <strong>OPENING</strong></label>
                  <div class="col-md-6">
                     <textarea id="textarea_opening" maxlength="250" class="form-control" rows="6" placeholder="E.g: The Caro–Kann is a common defense against the King's Pawn Opening and is classified as a Semi-Open Game like the Sicilian Defence and French Defence, although it is thought to be more solid and less dynamic than either of those openings. It often leads to good endgames for Black, who has the better pawn structure."></textarea>
                     <span class="help-block">
                     Describe the main details of the <strong>OPENING</strong> of this study. </span>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">About this <strong>STUDY</strong></label>
                  <div class="col-md-6">
                     <textarea id="textarea_study" maxlength="250" class="form-control" rows="6" placeholder="E.g: This study consists of the preparation of the most popular lines of the Caro-Kann defense. The lines prepared here are able to match the position quickly, guaranteeing a solid position, a very balanced half game, giving the black player the chance to reach the final with good advantages. All lines of this study were taken from Play the Caro-Kann, by International Master Jovanka Houska."></textarea>
                     <span class="help-block">
                     Describe the main details of your <strong>STUDY</strong>. </span>
                  </div>
               </div>
               <div class="row">
                  <span class="badge badge-roundless badge-danger">NOTE</span>
                  <small>By clicking on <strong>CREATE</strong> below, you can start the basis of your study, with theory and practice. Just proceed if you are sure that you have completed this step.</small>
               </div>
            </div>
            <div class="form-actions">
               <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                     <button type="submit" class="btn green">Create</button>
                     <button type="button" class="btn default">Cancel</button>
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
