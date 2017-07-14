<?
##INCLUDES.
	require_once('../lib/config.php');
	require_once('../models/User.php');
	require_once('../models/Country.php');
	require_once('../models/Language.php');
	require_once('../models/InterfaceLanguage.php');
	require_once('../models/Theme.php');

	if (empty($_REQUEST['u'])){
		header('Location: ./');
		exit;
	}

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-users');
	include('../imports/header.php');

#INPUTS
	$MSG = addslashes($_REQUEST['msg']);
	$paramUser  = (int)$_REQUEST['u'];

	$user = new User();
	$user = $user->getUserWithId($paramUser);

	$country = new Country();
	$arrCountries = $country->getAllCountries();

	$language = new Language();
	$arrLanguages = $language->getAllLanguages();

	$interfaceLanguage = new InterfaceLanguage();
	$arrInterfaceLanguages = $interfaceLanguage->getAllInterfaceLanguages();

	$theme = new Theme();
	$arrThemes = $theme->getAllThemes();

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
					Edit User <small></small>
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
							 <a href="./users.php">Users</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							 <a href="edit-user.php?u=<?=$user->id?>">Edit User</a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet gren">
						<div class="portlet-title">
							<div class="caption">User Details</div>
							</div>

						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form method="post" action="./action/edit-user.php" class="form-horizontal">
							<input type="hidden" name="id" value="<?=$user->id?>" />
								<div class="form-body">

									<div class="form-group">
										<label class="control-label col-md-3">Full Name</label>
										<div class="col-md-2">
											<div class="input-icon right">
												<input type="text" class="form-control" name="firstName" aria-required="true" aria-invalid="false" value="<?=$user->firstName?>">
											</div>
										</div>

										<div class="col-md-3">
											<div class="input-icon right">
												<input type="text" class="form-control" name="lastName" aria-required="true" aria-invalid="false" value="<?=$user->lastName?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Login</span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input type="text" class="form-control" name="login" aria-required="true" aria-invalid="true" value="<?=$user->login?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">ELO Fide</span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input type="text" class="form-control" name="eloFide" aria-required="true" aria-invalid="true" value="<?=$user->eloFide?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Grants</span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input type="text" class="form-control" name="grants" aria-required="true" aria-invalid="true" value="<?=$user->grants?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Birthday</span>
										</label>
										<div class="col-md-3">
											<input class="form-control form-control-inline input-medium date-picker" name="birthday" size="16" type="text" value="<?=fnDateDBtoVisual($user->birthday)?>"/>
											<span class="help-block">
											Month / Day / Year </span>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Country</label>
										<div class="col-md-5">
											 <select class="form-control select2me" name="country">
													<option value="">Select...</option>
													<?php foreach ($arrCountries as $key => $country): ?>

														<?php $selected = ($country->id == $user->countryID) ? "selected" : null ;?>

														<option value="<?=$country->id?>" <?=$selected?>> <?=$country->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Language</label>
										<div class="col-md-5">
											 <select class="form-control select2me" name="language">
													<option value="">Select...</option>
													<?php foreach ($arrLanguages as $key => $language): ?>

														<?php $selected = ($language->id == $user->languageID) ? "selected" : null ;?>

														<option value="<?=$language->id?>" <?=$selected?>>[<?=$language->code?>] - <?=$language->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Theme</label>
										<div class="col-md-5">
											 <select class="form-control select2me" name="theme">
													<option value="">Select...</option>
													<?php foreach ($arrThemes as $key => $theme): ?>

														<?php $selected = ($theme->id == $user->themeID) ? "selected" : null ;?>

														<option value="<?=$theme->id?>" <?=$selected?>><?=$theme->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Interface Language</label>
										<div class="col-md-5">
											 <select class="form-control select2me" name="interfaceLanguage">
													<option value="">Select...</option>
													<?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

														<?php $selected = ($interfaceLanguage->id == $user->interfaceLanguageID) ? "selected" : null ;?>

														<option value="<?=$interfaceLanguage->id?>" <?=$selected?>>[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">User status</span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<select class="form-control" name="status">
													<?php $selectedInactive = ($user->status == "0") ? "selected" : null;?>
													<?php $selectedActive = ($user->status == "1") ? "selected" : null;?>
													 <option value="0" <?=$selectedInactive?>>Inactive</option>
													 <option value="1" <?=$selectedActive?>>Active</option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group last password-strength">
										<label class="control-label col-md-3">Role</label>
										<div class="col-md-5">
											<select class="form-control" name="typeUser">
												<?php $selectedActive = ($user->typeUser == "1") ? "selected" : null;?>
												<?php $selectedInactive = ($user->typeUser == "2") ? "selected" : null;?>
												 <option value="1" <?=$selectedActive?>>Admin</option>
												 <option value="2" <?=$selectedInactive?>>User</option>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">Deleted</span>
									</label>
									<div class="col-md-5">
										<div class="input-icon right">
											<select class="form-control" name="deleted">
												<?php $selectedInactive = ($user->deleted == "0") ? "selected" : null;?>
												<?php $selectedActive = ($user->deleted == "1") ? "selected" : null;?>
												 <option value="0" <?=$selectedInactive?>>NO</option>
												 <option value="1" <?=$selectedActive?>>YES</option>
											</select>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
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
			ComponentsPickers.init();
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
