<?
##INCLUDES.
	require_once('../lib/config.php');
	require_once('../models/User.php');
	require_once('../models/Country.php');
	require_once('../models/Language.php');
	require_once('../models/InterfaceLanguage.php');
	require_once('../models/Theme.php');

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-users');
	include('../imports/header.php');

#INPUTS
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

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					<?= $t->{'New User'}; ?> <small></small>
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
							 <a href="./users.php"><?= $t->{'Users'}; ?></a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							 <a href="edit-user.php?u=<?=$user->id?>"><?= $t->{'New User'}; ?></a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet gren">
						<div class="portlet-title">
							<div class="caption"><?= $t->{'User Details'}; ?></div>
							</div>

						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form id="formUser" class="form-horizontal">
							<input type="hidden" id="id" name="id" value="<?=$user->id?>" />
								<div class="form-body">

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Full Name'}; ?></label>
										<div class="col-md-2">
											<div class="input-icon right">
												<input type="text" class="form-control" id="firstName" name="firstName" aria-required="true" aria-invalid="false" value="">
											</div>
										</div>

										<div class="col-md-3">
											<div class="input-icon right">
												<input type="text" class="form-control" id="lastName" name="lastName" aria-required="true" aria-invalid="false" value="">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Login'}; ?></span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input type="text" class="form-control" id="login" name="login" aria-required="true" aria-invalid="true" value="">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'ELO Fide'}; ?></span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input type="text" class="form-control" id="eloFide" name="eloFide" aria-required="true" aria-invalid="true" value="">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Grants'}; ?></span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<input type="text" class="form-control" id="grants" name="grants" aria-required="true" aria-invalid="true" value="">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Birthday'}; ?></span>
										</label>
										<div class="col-md-3">
											<input class="form-control form-control-inline input-medium date-picker" id="birthday" name="birthday" size="16" type="text" value=""/>
											<span class="help-block">
											<?= $t->{'Month / Day / Year'}; ?> </span>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Country'}; ?></label>
										<div class="col-md-5">
											 <select class="form-control select2me" id="country" name="country">
													<option value=""><?= $t->{'Select...'}; ?></option>
													<?php foreach ($arrCountries as $key => $country): ?>

														<option value="<?=$country->id?>"> <?=$country->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Language'}; ?></label>
										<div class="col-md-5">
											 <select class="form-control select2me" id="language" name="language">
													<option value=""><?= $t->{'Select...'}; ?></option>
													<?php foreach ($arrLanguages as $key => $language): ?>

														<option value="<?=$language->id?>">[<?=$language->code?>] - <?=$language->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Theme'}; ?></label>
										<div class="col-md-5">
											 <select class="form-control select2me" id="theme" name="theme">
													<option value=""><?= $t->{'Select...'}; ?></option>
													<?php foreach ($arrThemes as $key => $theme): ?>

														<option value="<?=$theme->id?>"><?=$theme->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Interface Language'}; ?></label>
										<div class="col-md-5">
											 <select class="form-control select2me" id="interfaceLanguage" name="interfaceLanguage">
													<option value=""><?= $t->{'Select...'}; ?></option>
													<?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

														<option value="<?=$interfaceLanguage->id?>">[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'User status'}; ?></span>
										</label>
										<div class="col-md-5">
											<div class="input-icon right">
												<select class="form-control" id="status" name="status">
													 <option value="0"><?= $t->{'Inactive'}; ?></option>
													 <option value="1"><?= $t->{'Active'}; ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Role'}; ?></label>
										<div class="col-md-5">
											<select class="form-control" id="typeUser" name="typeUser">
												 <option value="1"><?= $t->{'Admin'}; ?></option>
												 <option value="2"><?= $t->{'User'}; ?></option>
											</select>
										</div>
									</div>

									<div class="form-group last">
										<label class="control-label col-md-3"><?= $t->{'Deleted'}; ?></span>
										</label>
										<div class="col-md-5">
												<select class="form-control" id="deleted" name="deleted">
													 <option value="0"><?= $t->{'NO'}; ?></option>
													 <option value="1"><?= $t->{'YES'}; ?></option>
												</select>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" onclick="history.go(-1)" class="btn btn-danger" title="Cancel"><i class="fa fa-close"></i></button>
									<button type="submit" class="btn btn-primary" title="Save"><i class="fa fa-floppy-o"></i></button>
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
	ComponentsPickers.init();
	UIToastr.init();

	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": "toast-top-right",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

	var FormValidation = function () {

		var handleValidation = function() {

						var form1 = $('#formUser');

						form1.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block help-block-error', // default input error message class
								focusInvalid: true, // do not focus the last invalid input
								ignore: "",  // validate all fields including form hidden input
								rules: {
										firstName: {
												required: true
										},
										lastName: {
												required: true
										},
										login: {
												required: true
										},
										grants: {
												required: true
										},
										birthday: {
												required: true
										},
										country: {
												required: true
										},
										language: {
												required: true
										},
										theme: {
												required: true
										},
										interfaceLanguage: {
												required: true
										},
										status: {
												required: true
										},
										typeUser: {
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
											url: './action/new-user.php',
											type: 'POST',
											data: {id: $("#id").val(),
														firstName: $("#firstName").val(),
														lastName: $("#lastName").val(),
														login: $("#login").val(),
														eloFide: $("#eloFide").val(),
														grants: $("#grants").val(),
														birthday: $("#birthday").val(),
														country: $("#country").val(),
														language: $("#language").val(),
														theme: $("#theme").val(),
														interfaceLanguage: $("#interfaceLanguage").val(),
														status: $("#status").val(),
														typeUser: $("#typeUser").val(),
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
