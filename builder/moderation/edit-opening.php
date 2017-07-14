<?
##INCLUDES.
	require_once('../lib/config.php');
	require_once('../models/Study.php');
	require_once('../models/Currency.php');
	require_once('../models/Price.php');
	require_once('../models/PaymentSystem.php');
	require_once('../models/InterfaceLanguage.php');
	require_once('../models/Eco.php');

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
		$study->currencyAndPrice = "FREE";
	}

	$interfaceLanguage = new InterfaceLanguage();
	$arrInterfaceLanguages = $interfaceLanguage->getAllInterfaceLanguages();

	$eco = new Eco();
	$arrEcos = $eco->getALlEcos();

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
					Edit Opening <small></small>
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
							 <a href="./openings.php">Openings</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							 <a href="edit-opening.php?s=<?=$study->id?>">Edit Opening</a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet gren">
						<div class="portlet-title">
							<div class="caption">Master Data</div>
							<div class="tools">
									<a href="" class="collapse" data-original-title="" title=""></a>
								</div>
							</div>

						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form method="post" action="./action/edit-opening.php" class="form-horizontal" novalidate="novalidate">
							<input type="hidden" name="id" value="<?=$study->id?>" />
								<div class="form-body">
									<? if ($MSG != '') { ?>
									<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
									<? } ?>
									<div class="form-group">
										<label class="control-label col-md-3">Name</label>
										<div class="col-md-6">
											<div class="input-icon right">
												<input type="text" class="form-control" name="name" aria-required="true" aria-invalid="false" value="<?=$study->name?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">Language</label>
										<div class="col-md-6">
											 <select class="form-control select2me" name="interfaceLanguage">
													<option value="">Select...</option>
													<?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

														<?php $selected = ($interfaceLanguage->id == $study->interfaceLanguageID) ? "selected" : null ;?>

														<option value="<?=$interfaceLanguage->id?>" <?=$selected?>>[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">About this <strong>STUDY</strong></span>
										</label>
										<div class="col-md-6">
											<div class="input-icon right">
												<textarea name="about" maxlength="250" class="form-control" rows="4"><?=$study->aboutStudy?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">Side</span>
										</label>
										<div class="col-md-6">
											 <select class="form-control" name="side">
												 <?php $selectedW = ($study->side == "W") ? "selected" : null;?>
												 <?php $selectedB = ($study->side == "B") ? "selected" : null;?>
													<option value="W" <?=$selectedW?>>White</option>
													<option value="B" <?=$selectedB?>>Black</option>
											 </select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">ECO Opening</span>
										</label>
										<div class="col-md-6">
											 <select class="form-control select2me" name="eco">
													<option value="">Select...</option>
													<?php foreach ($arrEcos as $key => $eco): ?>

														<?php $selected = ($eco->id == $study->ecoID) ? "selected" : null ;?>

														<option value="<?=$eco->id?>" <?=$selected?>>[<?=$eco->code?>] - <?=$eco->name?> (<?=$eco->line?>)</option>
													<?php endforeach; ?>
											 </select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">Status</label>
										<div class="col-md-6">
											<select class="form-control" name="active">
												<?php $inactive = ($study->active == "0") ? "selected" : null;?>
												<?php $active = ($study->active == "1") ? "selected" : null;?>
												 <option value="0" <?=$inactive?>>Inactive</option>
												 <option value="1" <?=$active?>>Active</option>
											</select>
										</div>
									</div>

									<div class="form-group last">
										<label class="control-label col-md-3">Deleted</label>
										<div class="col-md-6">
											<select class="form-control" name="deleted">
												<?php $notDeleted = ($study->deleted == "0") ? "selected" : null;?>
												<?php $deleted = ($study->deleted == "1") ? "selected" : null;?>
												 <option value="0" <?=$notDeleted?>>NO</option>
												 <option value="1" <?=$deleted?>>YES</option>
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

							<br />
							<center>
								<a href="theory.php?s=<?=$study->id?>" class="btn btn-lg blue-hoki"><i class="fa fa-graduation-cap"></i> Edit THEORY</a>
								<a href="practice.php?s=<?=$study->id?>" class="btn btn-lg red-sunglo"><i class="fa fa-bolt"></i> Edit PRACTICE</a>
								<a href="#modalEditPayment" class="btn btn-lg btn-success" data-toggle="modal"><i class="fa fa-file-text-o"></i> Edit PAYMENT</a>
						  </center>
						</div>
					</div>

					<div id="modalEditPayment" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Editing Payment - <strong><?=$study->name?></strong></h4>
								</div>
								<div class="modal-body">
									<div class="portlet-body form">
										 <!-- BEGIN FORM-->
										 <form action="details.php" class="form-horizontal">
												<div class="form-body">
													 <div class="form-group">
															<label class="col-md-3 control-label">Currency</label>
															<div class="col-md-6">
																 <select class="form-control select2me" name="currency">
																		<option value="">Select...</option>
																		<?php foreach ($arrCurrencies as $key => $currency): ?>

																			<?php $selected = ($currency->id == $study->monetization->currency->id) ? "selected" : null ;?>

																			<option value="<?=$currency->id?>" <?=$selected?>>[<?=$currency->code?>] - <?=$currency->name?></option>
																		<?php endforeach; ?>
																 </select>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label">Price</label>
															<div class="col-md-6">
																 <select class="form-control select2me" name="options2">
																		<option value="">Select...</option>
																		<?php foreach ($arrPrices as $key => $price): ?>

																			<?php $selected = ($price->id == $study->monetization->price->id) ? "selected" : null ;?>

																			<option value="<?=$price->id?>" <?=$selected?>><?=$price->value?></option>
																		<?php endforeach; ?>
																 </select>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label">Payment System</label>
															<div class="col-md-6">
																 <select class="form-control select2me" name="options2">
																		<option value="">Select...</option>
																		<?php foreach ($arrPaymentSystems as $key => $paymentSystem): ?>

																			 <?php $selected = ($paymentSystem->id == $study->monetization->detailsPayment->paymentSystem->id) ? "selected" : null ;?>

																			<option value="<?=$paymentSystem->id?>" <?=$selected?>><?=$paymentSystem->desc?></option>
																		<?php endforeach; ?>
																 </select>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label">Payment URL</label>
															<div class="col-md-6">
																 <input type="text" class="form-control" value="<?=$study->monetization->detailsPayment->url?>" maxlength="50" name="defaultconfig" id="text_name" placeholder="E.g: https://pag.ae/seuCodigo (Using PagSeguro)">
																 <span class="help-block">
																 Put the direct link to the item payment.</span>
															</div>
													 </div>
													 <div class="form-group">
															<label class="col-md-3 control-label">Payment message to users</label>
															<div class="col-md-6">
																 <textarea id="textarea_opening" maxlength="250" class="form-control" rows="6"><?=$study->monetization->detailsPayment->text?></textarea>
																 <span class="help-block">
																 Thank your students, encourage them to collaborate to maintain the excellent level of excellence in the quality of this material.</span>
															</div>
													 </div>
													 <div class="row">
															<span class="badge badge-roundless badge-danger">NOTE</span>
															<small>By clicking on <strong>SAVE</strong> below, your study will be marked as EDITED for publishing revision.</small>
													 </div>
												</div>
										 </form>
										 <!-- END FORM-->
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
									<button type="button" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
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
			QuickSidebar.init() // init quick sidebar

        });


    </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
