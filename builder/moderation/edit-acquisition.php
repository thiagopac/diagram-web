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
	$study->getBasicDataStudyWithID($acquisition->studyID);

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
					Edit Acquisition <small></small>
					</h3>

					<!-- END PAGE TITLE & BREADCRUMB-->
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
							 <a href="./acquisitions.php">Acquisitions</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							 <a href="edit-acquisition.php?a=<?=$acquisition->id?>">Edit Acquisition</a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet gren">
						<div class="portlet-title">
							<div class="caption">Acquisition Details</div>
							</div>

						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form method="post" action="../exec/" id="form_sample_2" class="form-horizontal" novalidate="novalidate">
							<input type="hidden" name="e" id="e" value="adm_edit" />
							<input type="hidden" name="id" id="id" value="<?=$user->id?>" />
								<div class="form-body">
									<? if ($MSG != '') { ?>
									<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
									<? } ?>
									<div class="form-group">
										<label class="control-label col-md-3">User</span>
										</label>
										<div class="col-md-5">
											 <select class="form-control select2me" name="language">
													<option value="">Select...</option>
													<?php foreach ($arrUser as $key => $user): ?>

														<?php $selected = ($acquisition->userID == $user->id) ? "selected" : null ;?>

														<option value="<?=$user->id?>" <?=$selected?>>[ #<?=$user->id?> ] - <?=$user->fullName?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Study</span>
										</label>
										<div class="col-md-5">
											 <select class="form-control select2me" name="language">
													<option value="">Select...</option>
													<?php foreach ($arrStudies as $key => $study): ?>

														<?php $selected = ($study->id == $acquisition->studyID) ? "selected" : null ;?>

														<option value="<?=$study->id?>" <?=$selected?>>[ #<?=$study->id?> ] - <?=$study->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Date</span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input disabled type="text" class="form-control" name="login" aria-required="true" aria-invalid="true" value="<?=$acquisition->dateCreated?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Approved</span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<select class="form-control" name="select">
													<?php $selectedInactive = ($acquisition->active == "0") ? "selected" : null;?>
													<?php $selectedActive = ($acquisition->active == "1") ? "selected" : null;?>
													 <option value="0" <?=$selectedInactive?>>NO</option>
													 <option value="1" <?=$selectedActive?>>YES</option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Deleted</span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<select class="form-control" name="select">
													<?php $selectedInactive = ($acquisition->deleted == "0") ? "selected" : null;?>
													<?php $selectedActive = ($acquisition->deleted == "1") ? "selected" : null;?>
													 <option value="0" <?=$selectedInactive?>>NO</option>
													 <option value="1" <?=$selectedActive?>>YES</option>
												</select>
											</div>
										</div>
									</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
									<button type="button" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
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
			QuickSidebar.init() // init quick sidebar

        });

        $(function () {
            $("#chkShowPassword").bind("click", function () {
                var txtPassword = $("[id*=password_strength]");
                if ($(this).is(":checked")) {
                    txtPassword.after('<input onchange = "PasswordChanged(this);" id = "txt_' + txtPassword.attr("id") + '" class="form-control" name="password" type = "text" value = "' + txtPassword.val() + '" />');
                    txtPassword.hide();
                } else {
                    txtPassword.val(txtPassword.next().val());
                    txtPassword.next().remove();
                    txtPassword.show();
                }
            });
        });
        function PasswordChanged(txt) {
            $(txt).prev().val($(txt).val());
        }
    </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
