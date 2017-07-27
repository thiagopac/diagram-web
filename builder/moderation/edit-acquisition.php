<?
##INCLUDES
	require_once('../lib/config.php');
	require_once('../models/Acquisition.php');
	require_once('../models/Study.php');
	require_once('../models/User.php');

	if (empty($_REQUEST['a'])){
		header('Location: ./');
		exit;
	}

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-acquisitions');

#INPUTS
	$MSG = addslashes($_REQUEST['msg']);
	$paramAcquisition  = (int)$_REQUEST['a'];

	Acquisition::$showDeleted = true;
	$acquisition = new Acquisition();
	$acquisition = $acquisition->getAcquisitionWithID($paramAcquisition);

	$user = new User();
	$user->getUserWithId($acquisition->userID);

	$arrUser = $user->getAllUsers();

	$study = new Study();
	$study->getStudyWithID($acquisition->studyID);

	$arrStudies = $study->getAllStudies();

	include('../imports/header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">

			<? include('../imports/alert.php'); ?>

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					<?= $t->{'Edit Acquisition'}; ?> <small></small>
					</h3>

					<!-- END PAGE TITLE & BREADCRUMB-->
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
							 <a href="./acquisitions.php"><?= $t->{'Acquisitions'}; ?></a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							 <a href="edit-acquisition.php?a=<?=$acquisition->id?>"><?= $t->{'Edit Acquisition'}; ?></a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet gren">
						<div class="portlet-title">
							<div class="caption"><?= $t->{'Acquisition Details'}; ?></div>
							</div>

						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form method="post" class="form-horizontal" id="formAcquisition">
								<input type="hidden" name="id" id="id" value="<?=$acquisition->id?>" />
								<div class="form-body">
									<? if ($MSG != '') { ?>
									<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
									<? } ?>
									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'User'}; ?></span>
										</label>
										<div class="col-md-5">
											 <select class="form-control select2me" id="user" name="user">
													<option value=""><?= $t->{'Select...'}; ?></option>
													<?php foreach ($arrUser as $key => $user): ?>

														<?php $selected = ($acquisition->userID == $user->id) ? "selected" : null ;?>

														<option value="<?=$user->id?>" <?=$selected?>>[ #<?=$user->id?> ] - <?=$user->fullName?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Study'}; ?></span>
										</label>
										<div class="col-md-5">
											 <select class="form-control select2me" id="studyID" name="studyID">
													<option value=""><?= $t->{'Select...'}; ?></option>
													<?php foreach ($arrStudies as $key => $study): ?>

														<?php $selected = ($study->id == $acquisition->studyID) ? "selected" : null ;?>

														<option value="<?=$study->id?>" <?=$selected?>>[ #<?=$study->id?> ] - <?=$study->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Date'}; ?></span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input disabled type="text" class="form-control" name="date" aria-required="true" aria-invalid="true" value="<?=$acquisition->dateCreated?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Approved'}; ?></span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<select class="form-control" id="active" name="active">
													<?php $selectedInactive = ($acquisition->active == "0") ? "selected" : null;?>
													<?php $selectedActive = ($acquisition->active == "1") ? "selected" : null;?>
													 <option value="0" <?=$selectedInactive?>><?= $t->{'NO'}; ?></option>
													 <option value="1" <?=$selectedActive?>><?= $t->{'YES'}; ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Deleted'}; ?></span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<select class="form-control" id="deleted" name="deleted">
													<?php $selectedInactive = ($acquisition->deleted == "0") ? "selected" : null;?>
													<?php $selectedActive = ($acquisition->deleted == "1") ? "selected" : null;?>
													 <option value="0" <?=$selectedInactive?>><?= $t->{'NO'}; ?></option>
													 <option value="1" <?=$selectedActive?>><?= $t->{'YES'}; ?></option>
												</select>
											</div>
										</div>
									</div>

								<div class="modal-footer">
									<button type="button" onclick="history.go(-1)" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
									<button type="submit" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
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
	Layout.init(); // init current layout

	var FormValidation = function () {

		var handleValidation = function() {

						var form1 = $('#formAcquisition');

						form1.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block help-block-error', // default input error message class
								focusInvalid: true, // do not focus the last invalid input
								ignore: "",  // validate all fields including form hidden input
								rules: {
										user: {
												required: true
										},
										studyID: {
												required: true
										},
										active: {
												required: true
										},
										deleted: {
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
											url: './action/edit-acquisition.php',
											type: 'POST',
											data: {id: $("#id").val(),
														user: $("#user").val(),
														studyID: $("#studyID").val(),
														active: $("#active").val(),
														deleted: $("#deleted").val()},
											success: function (result) {

												var response = JSON.parse(result);

												if(response["status"] == "success"){
													toastr.success('<?= $t->{'Saved changes!'}; ?>');
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
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
