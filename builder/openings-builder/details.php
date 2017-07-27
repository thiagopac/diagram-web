<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/User.php');
   require_once('../models/Currency.php');
   require_once('../models/Price.php');
   require_once('../models/PaymentSystem.php');
   require_once('../models/InterfaceLanguage.php');

   if (empty($_REQUEST['s'])){
     header('Location: ./');
     exit;
   }

   // CONTROLE SESSAO
   fnInicia_Sessao ('openings');

   $userID = $_SESSION['USER']['ID'];

   #BUSCAR TODAS AS VARIÁVEIS GET
   $paramStudy = $_REQUEST['s'];

   Study::$showDeleted = false;
   $study = new Study();
   $study = $study->getStudyWithID($paramStudy);

    $user = new User();
    $study->author = $user->getUserWithId($study->authorID);

   if ($study->author->id != $userID){
     header('Location: ./');
     exit;
   }

   if ($study->deleted == true){
     header('Location: ./');
     exit;
   }

   $interfaceLanguage = new InterfaceLanguage();
   $arrInterfaceLanguages = $interfaceLanguage->getAllInterfaceLanguages();

   $study->interfaceLanguage = $interfaceLanguage->getInterfaceLanguageWithID($study->interfaceLanguageID);

   $currency = new Currency();
   $arrCurrencies = $currency->getAllCurrencies();

   $price = new Price();
   $arrPrices = $price->getAllPrices();

   $paymentSystem = new PaymentSystem();
   $arrPaymentSystems = $paymentSystem->getAllPaymentSystems();

   $monetization = new Monetization();
   $study->monetization = $monetization->getMonetizationForStudy($study->id);

   if ($study->monetization->price->value != 0.00) {
     $study->currencyAndPrice = $study->monetization->currency->symbol.' '.$study->monetization->price->value;
   }else{
     $study->currencyAndPrice = $t->{'FREE'};
   }

   $variarion = new Variation();
   $arrVariations = $variarion->getAllVariationsForStudy($study->id);

   $variationsCount = count($arrVariations);

   foreach ($arrVariations as $key => $variation) {
   	foreach ($variation->lines as $key => $line) {
   		$linesCount ++;
   	}
   }

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
            <?=$study->name?><small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
           <i class="fa fa-home"></i>
           <a href="#"><?= $t->{'Openings'}; ?></a>
           <i class="fa fa-angle-right"></i>
        </li>
         <li>
            <a href="./list.php"><?= $t->{'Builder'}; ?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="details.php?s=<?=$study->id?>"><?=$study->name?></a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->

   <!-- BEGIN PAGE TITLE AND DESCRIPTION -->
   <!-- END BEGIN PAGE TITLE AND DESCRIPTION -->
   <div class="row profile">
      <div class="col-md-12">
         <!--BEGIN TABS-->
         <div class="row">
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-9 profile-info" style="text-align:justify;">
                     <p>
                       <?=$study->aboutStudy?>
                     </p>
                     <ul class="list-inline">
                        <li>
                           <i class="fa fa-calendar"></i> <?=$study->dateCreated?>
                        </li>
                        <li>
                           <i class="fa fa-briefcase"></i> <?=$study->author->fullName?>
                        </li>
                        <li>
                           <i class="fa fa-list-ol"></i> <?=$variationsCount ?> Var. | <?=$linesCount ?> <?= $t->{'Lines'}; ?>
                        </li>
                        <li>
                           <i class="fa fa-usd"></i> <?=$study->currencyAndPrice?>
                        </li>
                     </ul>
                  </div>
                  <!--end col-md-8-->
                  <div class="col-md-3">
                     <div class="portlet sale-summary">
                        <div class="portlet-title">
                           <div class="caption">
                              <?= $t->{'Statistics'}; ?>
                           </div>
                        </div>
                        <div class="portlet-body">
                          <small><?= $t->{'This study does not have statistical data yet.'}; ?></small>
                        </div>
                     </div>
                  </div>
                  <!--end col-md-4-->
               </div>

               <a href="theory.php?s=<?=$study->id?>" style="margin-top:10px;" class="btn btn-lg blue-hoki col-md-2 col-xs-12"><i class="fa fa-graduation-cap"></i> <?= $t->{'Edit THEORY'}; ?></a>
               <a href="practice.php?s=<?=$study->id?>" style="margin-top:10px;" class="btn btn-lg red-sunglo col-md-2 col-xs-12"><i class="fa fa-bolt"></i> <?= $t->{'Edit PRACTICE'}; ?></a>
               <a href="#modalEditInfo" style="margin-top:10px;" class="btn btn-lg btn-warning col-md-2 col-xs-12" data-toggle="modal"><i class="fa fa-file-text-o"></i> <?= $t->{'Edit INFO'}; ?></a>
               <a href="#modalEditPayment" style="margin-top:10px;" class="btn btn-lg btn-success col-md-2 col-xs-12" data-toggle="modal"><i class="fa fa-dollar"></i> <?= $t->{'Edit PAYMENT'}; ?></a>
               <!--end row-->
               <div id="modalEditInfo" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
                 <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                     <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                         <h4 class="modal-title"><?= $t->{'Editing Info'}; ?> - <strong><?=$study->name?></strong></h4>
                     </div>
                     <div class="modal-body">
                       <div class="portlet-body form">
                          <!-- BEGIN FORM-->
                          <form id="formStudy" class="form-horizontal">
                            <input type="hidden" name="studyID" id="studyID" value="<?=$study->id?>">
                             <div class="form-body">
                                <div class="form-group">
                                   <label class="col-md-3 control-label"><?= $t->{'Language'}; ?></label>
                                   <div class="col-md-6">
                                      <select class="form-control select2me" id="interfaceLanguageID" name="interfaceLanguageID">
                                         <option value="">Select...</option>
                                         <?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

                                           <?php $selected = ($interfaceLanguage->id == $study->interfaceLanguage->id) ? "selected" : null ;?>

                                           <option value="<?=$interfaceLanguage->id?>" <?=$selected?>>[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>
                                         <?php endforeach; ?>
                                      </select>
                                      <span class="help-block">
                                      <?= $t->{'Select the language of this material. You can submit studies only in the supported languages.'}; ?> </span>
                                   </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-md-3 control-label"><?= $t->{'Name'}; ?></label>
                                   <div class="col-md-6">
                                      <input type="text" class="form-control" value="<?=$study->name?>" maxlength="50" name="name" id="name">
                                      <span class="help-block">
                                      <?= $t->{'Use a small name for your study'}; ?>.</span>
                                   </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-md-3 control-label"><?= $t->{'Side'}; ?></label>
                                   <div class="col-md-6">
                                      <select class="form-control" name="side" id="side">
                                        <?php $selectedW = ($study->side == "W") ? "selected" : null;?>
                                        <?php $selectedB = ($study->side == "B") ? "selected" : null;?>
                                         <option value=""><?= $t->{'Choose the side'}; ?></option>
                                         <option value="W" <?=$selectedW?>><?= $t->{'White'}; ?></option>
                                         <option value="B" <?=$selectedB?>><?= $t->{'Black'}; ?></option>
                                      </select>
                                      <span class="help-block">
                                      <?= $t->{'Both sides are <strong>NOT</strong> supported at this moment.'}; ?></span>
                                   </div>
                                </div>

                                <div class="form-group">
                                   <label class="col-md-3 control-label"><?= $t->{'About this <strong>STUDY</strong>'}; ?></label>
                                   <div class="col-md-6">
                                      <textarea id="about" name="about" class="form-control" rows="6"><?=$study->aboutStudy?></textarea>
                                      <span class="help-block">
                                      <?= $t->{'Describe the main details of your <strong>STUDY</strong>.'}; ?></span>
                                   </div>
                                </div>
                                <div class="row">
                                   <!-- <span class="badge badge-roundless badge-danger">NOTE</span>
                                   <small>By clicking on <strong>SAVE</strong> below, your study will be marked as EDITED for publishing revision.</small> -->
                                </div>
                             </div>
                       </div>
                     </div>
                     <div class="modal-footer">
                       <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
                       <button type="submit" class="btn btn-primary" id="btnSaveStudy" title="Save"><i class="fa fa-floppy-o"></i></button>
                     </div>
                   </form>
                   <!-- END FORM-->
                   </div>
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
                       <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
                       <button type="button" class="btn btn-primary" title="Save"><i class="fa fa-floppy-o"></i></button>
                     </div>
                   </div>
                 </div>
               </div>
            </div>
         </div>
         <!--END TABS-->
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

  $(document).ready(function () {
    if(sessionStorage.getItem("Success")){
        toastr.success(sessionStorage.getItem("Success"));
        sessionStorage.clear();
    }

    if(sessionStorage.getItem("Warning")){
        toastr.warning(sessionStorage.getItem("Warning"));
        sessionStorage.clear();
    }

    if(sessionStorage.getItem("Info")){
        toastr.info(sessionStorage.getItem("Info"));
        sessionStorage.clear();
    }

    if(sessionStorage.getItem("Error")){
        toastr.error(sessionStorage.getItem("Error"));
        sessionStorage.clear();
    }

  });

  var FormValidation = function () {

		var handleValidation = function() {

						var form1 = $('#formStudy');

						form1.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block help-block-error', // default input error message class
								focusInvalid: true, // do not focus the last invalid input
								ignore: "",  // validate all fields including form hidden input
								rules: {
										interfaceLanguageID: {
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
                      url: './action/details-info.php',
                      type: 'POST',
                      data: {studyID: $("#studyID").val(),
                            interfaceLanguageID: $("#interfaceLanguageID").val(),
                            name: $("#name").val(),
                            side: $("#side").val(),
                            about: $("#about").val()},
                      success: function (result) {
                        var response = JSON.parse(result);

                        if(response["status"] == "success"){
                          //mostrar toaster após reload
                          sessionStorage.setItem("Success","<?= $t->{'Saved changes!'}; ?>");
                          location.reload();
                        }else if(response["status"] == "error"){
                          toastr.warning('<?= $t->{'Error. Please, try again later.'}; ?>');
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
</body>
</html>
