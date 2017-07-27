<?
// #INCLUDES
require_once ('../lib/config.php');
require_once('../models/Study.php');
require_once('../models/User.php');

// CONTROLE SESSAO
fnInicia_Sessao ('moderation-feedback');
include('../imports/header.php');

$study = new Study();
$arrStudies = $study->getAllStudies();

$author = new User();

?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
   <? include('../imports/alert.php'); ?>
   <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            <?= $t->{'Feedback'}; ?> <small></small>
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
            <a href="feedback.php"><?= $t->{'Feedback'}; ?></a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <div class="portlet light">
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form id="formFeedback" class="form-horizontal">
            <div class="form-body">
               <div class="form-group">
                  <label class="col-md-3 control-label"><?= $t->{'Author / Study'}; ?></label>
                  <div class="col-md-6">
                     <select class="form-control select2me" id="studyID" name="studyID">
                        <option value=""><?= $t->{'Select...'}; ?></option>

                        <?php foreach ($arrStudies as $key => $study): ?>

                          <?php $study->author = $author->getUserWithId($study->authorID); ?>

                          <option value="<?=$study->id?>">[<?=$study->author->fullName?>] - <?=$study->name?></option>

                        <?php endforeach; ?>

                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-3 control-label"><?= $t->{'Message'}; ?></label>
                  <div class="col-md-6">
                     <textarea id="message" name="message" class="form-control" rows="6"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
              <button type="submit" class="btn btn-success" title="Send" data-dismiss="modal"><i class="fa fa-envelope-o"></i></button>
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

   var FormValidation = function () {

 		var handleValidation = function() {

 						var form1 = $('#formFeedback');

 						form1.validate({
 								errorElement: 'span', //default input error message container
 								errorClass: 'help-block help-block-error', // default input error message class
 								focusInvalid: true, // do not focus the last invalid input
 								ignore: "",  // validate all fields including form hidden input
 								rules: {
 										studyID: {
 												required: true
 										},
 										message: {
 												required: true
 										}
 								},

 								invalidHandler: function (event, validator) { //display error alert on form submit
 										toastr.error("<?= $t->{'You have some form errors. Please check below.'}; ?>");
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

 									$.ajax({
 											url: './action/new-feedback.php',
 											type: 'POST',
 											data: {studyID: $("#studyID").val(),
 														message: $("#message").val()},
 											success: function (result) {

 												var response = JSON.parse(result);

 												if(response["status"] == "success"){
 													toastr.success('<?= $t->{'Message sent!'}; ?>');
 												}else if(response["status"] == "error"){
 													toastr.warning('<?= $t->{'Error. Please, try again later.'}; ?>');
 												}
 											}
 									});

 								}
 						});
 					}
 				handleValidation();
 		 }();

});
</script>
</body>
</html>
