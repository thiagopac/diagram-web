<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/InterfaceLanguage.php');
   require_once('../models/Eco.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ('openings-builder');
   include('../imports/header.php');

   $interfaceLanguage = new InterfaceLanguage();
   $arrInterfaceLanguages = $interfaceLanguage->getAllInterfaceLanguages();

   $eco = new Eco();
   $arrEcos = $eco->getALlEcos();

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
           <a href="#">Openings</a>
           <i class="fa fa-angle-right"></i>
        </li>
         <li>
            <a href="./list.php">Builder</a>
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

         <form method="post" id="formCreateStudy" class="form-horizontal" action="./action/create-study.php">
            <div class="form-body">

              <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                You have some form errors. Please check below.
              </div>
              <div class="alert alert-success display-hide">
                <button class="close" data-close="alert"></button>
                Your form validation is successful!
              </div>

               <div class="form-group">
                  <label class="col-md-3 control-label">Language</label>
                  <div class="col-md-6">
                     <select class="form-control select2me" name="interfaceLanguage">
                        <option value="">Select...</option>

                        <?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

                          <option value="<?=$interfaceLanguage->id?>">[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>

                        <?php endforeach; ?>

                     </select>
                     <span class="help-block">
                     Select the language of this material. You can submit studies only in the supported languages. </span>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label">Name</label>
                  <div class="col-md-6">
                     <input type="text" class="form-control" placeholder="E.g: Caro-Kann for beginners" maxlength="50" name="name">
                     <span class="help-block">
                     Use a small name for your study.</span>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label">Side</label>
                  <div class="col-md-6">
                     <select class="form-control" name="side">
                        <option value="">Choose the side</option>
                        <option value="W">White</option>
                        <option value="B">Black</option>
                     </select>
                     <span class="help-block">
                     Both sides are <strong>NOT</strong> supported at this moment. </span>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label">ECO Opening</label>
                  <div class="col-md-6">
                     <select class="form-control select2me" name="eco">
                        <option value="">Select...</option>
                        <?php foreach ($arrEcos as $key => $eco): ?>

                          <option value="<?=$eco->id?>">[<?=$eco->code?>] - <?=$eco->name?> (<?=$eco->line?>)</option>

                        <?php endforeach; ?>
                     </select>
                     <span class="help-block">
                     If you don't know what is the ECO code, please consider read <a href="https://en.wikipedia.org/wiki/List_of_chess_openings">this</a>.</span>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label">About this <strong>STUDY</strong></label>
                  <div class="col-md-6">
                     <textarea name="about" id="about" maxlength="250" class="form-control" rows="6" placeholder="E.g: This study consists of the preparation of the most popular lines of the Caro-Kann defense. The lines prepared here are able to match the position quickly, guaranteeing a solid position, a very balanced half game, giving the black player the chance to reach the final with good advantages. All lines of this study were taken from Play the Caro-Kann, by International Master Jovanka Houska."></textarea>
                     <span class="help-block">
                       <div id="countAbout" class="pull-right"></div>
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

   $('#about').on("keydown",function(event) {
     var l = $(this).val().length;
     var left = 250 - l;
     $('#countAbout').html('<span class="label label-success">'+ left + ' / 250' +'</span>');
     $('#countAbout').show();

   });

   var FormValidation = function () {

   var handleValidation = function() {

           var form1 = $('#formCreateStudy');
           var error1 = $('.alert-danger', form1);
           var success1 = $('.alert-success', form1);

           form1.validate({
               errorElement: 'span', //default input error message container
               errorClass: 'help-block help-block-error', // default input error message class
               focusInvalid: false, // do not focus the last invalid input
               ignore: "",  // validate all fields including form hidden input
               rules: {
                   name: {
                       minlength: 5,
                       required: true
                   },
                   side: {
                       required: true
                   },
                   eco: {
                       required: true
                   },
                   about: {
                       required: true,
                       minlength: 20,
                       maxlength: 250
                   },
                   interfaceLanguage: {
                       required: true
                   }
               },

               invalidHandler: function (event, validator) { //display error alert on form submit
                   success1.hide();
                   error1.show();
                   Metronic.scrollTo(error1, -200);
               },

               highlight: function (element) { // hightlight error inputs
                   $(element)
                       .closest('.form-group').addClass('has-error'); // set error class to the control group
               },

               unhighlight: function (element) { // revert the change done by hightlight
                   $(element)
                       .closest('.form-group').removeClass('has-error'); // set error class to the control group
               },

               success: function (label) {
                   label
                       .closest('.form-group').removeClass('has-error'); // set success class to the control group
               },

               submitHandler: function (form) {
                   success1.show();
                   error1.hide();
               }
           });

         }

         handleValidation();

      }();

   });
</script>
</body>
</html>
