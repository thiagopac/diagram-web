<?
##INCLUDES.
	require_once('../lib/config.php');
	require_once('../models/Study.php');
	require_once('../models/Currency.php');
	require_once('../models/Price.php');
	require_once('../models/PaymentSystem.php');
	require_once('../models/InterfaceLanguage.php');

	if (empty($_REQUEST['s'])){
		header('Location: ./');
		exit;
	}

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-openings');

	include('../imports/header.php');

#INPUTS
	$MSG = addslashes($_REQUEST['msg']);

	#BUSCAR TODAS AS VARIÁVEIS GET
	$paramStudy = $_REQUEST['s'];

	Study::$showDeleted = true;
	$study = new Study();
	$study = $study->getStudyWithID($paramStudy);

	if ($study->monetization->price->value != 0.00) {
		$study->currencyAndPrice = $study->monetization->currency->symbol.' '.$study->monetization->price->value;
	}else{
		$study->currencyAndPrice = $t->{'FREE'};;
	}

	$interfaceLanguage = new InterfaceLanguage();
	$arrInterfaceLanguages = $interfaceLanguage->getAllInterfaceLanguages();

	$currency = new Currency();
	$arrCurrencies = $currency->getAllCurrencies();

	$price = new Price();
	$arrPrices = $price->getAllPrices();

	$paymentSystem = new PaymentSystem();
	$arrPaymentSystems = $paymentSystem->getAllPaymentSystems();
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
					<?= $t->{'Edit Opening'}; ?> <small></small>
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
							 <a href="./openings.php"><?= $t->{'Openings'}; ?></a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							 <a href="edit-opening.php?s=<?=$study->id?>"><?= $t->{'Edit Opening'}; ?></a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet gren">
						<div class="portlet-title">
							<div class="caption"><?= $t->{'Master Data'}; ?></div>
							</div>

						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form id="formStudy" class="form-horizontal">

							<input type="hidden" id="id" name="id" value="<?=$study->id?>" />
								<div class="form-body">

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Name'}; ?></label>
										<div class="col-md-6">
											<div class="input-icon right">
												<input type="text" class="form-control" id="name" name="name" value="<?=$study->name?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Language'}; ?></label>
										<div class="col-md-6">
											 <select class="form-control select2me" id="interfaceLanguage" name="interfaceLanguage">
													<option value=""><?= $t->{'Select...'}; ?></option>
													<?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

														<?php $selected = ($interfaceLanguage->id == $study->interfaceLanguageID) ? "selected" : null ;?>

														<option value="<?=$interfaceLanguage->id?>" <?=$selected?>>[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'About this <strong>STUDY</strong>'}; ?></span>
										</label>
										<div class="col-md-6">
											<div class="input-icon right">
												<textarea id="about" name="about" class="form-control" rows="4"><?=$study->aboutStudy?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Side'}; ?></span>
										</label>
										<div class="col-md-6">
											 <select class="form-control" id="side" name="side">
												 <?php $selectedW = ($study->side == "W") ? "selected" : null;?>
												 <?php $selectedB = ($study->side == "B") ? "selected" : null;?>
													<option value="W" <?=$selectedW?>><?= $t->{'White'}; ?></option>
													<option value="B" <?=$selectedB?>><?= $t->{'Black'}; ?></option>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"><?= $t->{'Status'}; ?></label>
										<div class="col-md-6">
											<select class="form-control" id="active" name="active">
												<?php $inactive = ($study->active == "0") ? "selected" : null;?>
												<?php $active = ($study->active == "1") ? "selected" : null;?>
												 <option value="0" <?=$inactive?>><?= $t->{'Inactive'}; ?></option>
												 <option value="1" <?=$active?>><?= $t->{'Active'}; ?></option>
											</select>
										</div>
									</div>

									<div class="form-group last">
										<label class="control-label col-md-3"><?= $t->{'Deleted'}; ?></label>
										<div class="col-md-6">
											<select class="form-control" id="deleted" name="deleted">
												<?php $notDeleted = ($study->deleted == "0") ? "selected" : null;?>
												<?php $deleted = ($study->deleted == "1") ? "selected" : null;?>
												 <option value="0" <?=$notDeleted?>><?= $t->{'NO'}; ?></option>
												 <option value="1" <?=$deleted?>><?= $t->{'YES'}; ?></option>
											</select>
										</div>
									</div>

								</div>

								<div class="modal-footer">
									<button type="button" onclick="history.go(-1)" class="btn btn-danger" title="Cancel"><i class="fa fa-close"></i></button>
									<button type="submit" id="btnSaveStudy" class="btn btn-primary" title="Save"><i class="fa fa-floppy-o"></i></button>
								</div>
							</form>
							<!-- END FORM-->

							<br />
							<center>
								<a href="theory.php?s=<?=$study->id?>" class="btn btn-lg blue-hoki"><i class="fa fa-graduation-cap"></i> <?= $t->{'Edit THEORY'}; ?></a>
								<a href="practice.php?s=<?=$study->id?>" class="btn btn-lg red-sunglo"><i class="fa fa-bolt"></i> <?= $t->{'Edit PRACTICE'}; ?></a>
								<a href="#modalEditPayment" class="btn btn-lg btn-success" data-toggle="modal"><i class="fa fa-file-text-o"></i> <?= $t->{'Edit PAYMENT'}; ?></a>
						  </center>
						</div>
					</div>

					<div id="modalEditPayment" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title"><?= $t->{'Editing Payment'}; ?> - <strong><?=$study->name?></strong></h4>
								</div>
								<div class="modal-body">
									<div class="portlet-body form">
										 <!-- BEGIN FORM-->
										 <form action="details.php" class="form-horizontal">
												<div class="form-body">
													 <div class="form-group">
															<label class="col-md-3 control-label"><?= $t->{'Currency'}; ?></label>
															<div class="col-md-6">
																 <select class="form-control select2me" name="currency">
																		<option value=""><?= $t->{'Select...'}; ?></option>
																		<?php foreach ($arrCurrencies as $key => $currency): ?>

																			<?php $selected = ($currency->id == $study->monetization->currency->id) ? "selected" : null ;?>

																			<option value="<?=$currency->id?>" <?=$selected?>>[<?=$currency->code?>] - <?=$currency->name?></option>
																		<?php endforeach; ?>
																 </select>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label"><?= $t->{'Price'}; ?></label>
															<div class="col-md-6">
																 <select class="form-control select2me" name="options2">
																		<option value=""><?= $t->{'Select...'}; ?></option>
																		<?php foreach ($arrPrices as $key => $price): ?>

																			<?php $selected = ($price->id == $study->monetization->price->id) ? "selected" : null ;?>

																			<option value="<?=$price->id?>" <?=$selected?>><?=$price->value?></option>
																		<?php endforeach; ?>
																 </select>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label"><?= $t->{'Payment System'}; ?></label>
															<div class="col-md-6">
																 <select class="form-control select2me" name="options2">
																		<option value=""><?= $t->{'Select...'}; ?></option>
																		<?php foreach ($arrPaymentSystems as $key => $paymentSystem): ?>

																			 <?php $selected = ($paymentSystem->id == $study->monetization->detailsPayment->paymentSystem->id) ? "selected" : null ;?>

																			<option value="<?=$paymentSystem->id?>" <?=$selected?>><?=$paymentSystem->desc?></option>
																		<?php endforeach; ?>
																 </select>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label"><?= $t->{'Payment URL'}; ?></label>
															<div class="col-md-6">
																 <input type="text" class="form-control" value="<?=$study->monetization->detailsPayment->url?>" maxlength="50" name="defaultconfig" id="text_name" placeholder="E.g: https://pag.ae/seuCodigo (Using PagSeguro)">
																 <span class="help-block">
																 <?= $t->{'Put the direct link to the item payment.'}; ?></span>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label"><?= $t->{'Payment message to users'}; ?></label>
															<div class="col-md-6">
																 <textarea id="textarea_opening" maxlength="250" class="form-control" rows="6"><?=$study->monetization->detailsPayment->text?></textarea>
																 <span class="help-block">
																 <?= $t->{'Thank your students, encourage them to collaborate to maintain the excellent level of excellence in the quality of this material.'}; ?></span>
															</div>
													 </div>
													 <div class="row">
															<span class="badge badge-roundless badge-danger"><?= $t->{'NOTE'}; ?></span>
															<small><?= $t->{'By clicking on <strong>SAVE</strong> below, your study will be marked as EDITED for publishing revision.'}; ?></small>
													 </div>
												</div>
										 </form>
										 <!-- END FORM-->
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" onclick="history.go(-1)" class="btn btn-danger" title="Cancel"><i class="fa fa-close"></i></button>
									<button type="button" class="btn btn-primary" title="Save"><i class="fa fa-floppy-o"></i></button>
								</div>
							</div>
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

						var form1 = $('#formStudy');

						form1.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block help-block-error', // default input error message class
								focusInvalid: true, // do not focus the last invalid input
								ignore: "",  // validate all fields including form hidden input
								rules: {
										interfaceLanguage: {
												required: true
										},
										name: {
												required: true
										},
										side: {
												required: true
										},
										about: {
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
												url: './action/edit-opening.php',
												type: 'POST',
												data: {id: $("#id").val(),
															interfaceLanguage: $("#interfaceLanguage").val(),
															name: $("#name").val(),
															side: $("#side").val(),
															about: $("#about").val(),
															active: $("#active").val(),
															deleted: $("#deleted").val()},
												success: function (result) {

													var response = JSON.parse(result);

													if(response["status"] == "success"){
														toastr.success('<?= $t->{'Saved changes!'}; ?>');
													}else{
														toastr.error('<?= $t->{'Error. Please, try again later.'}; ?>');
													}
												}, error: function (result) {
														toastr.error('<?= $t->{'Error. Please, try again later.'}; ?>');
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
