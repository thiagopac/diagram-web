<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/Currency.php');
   require_once('../models/Price.php');
   require_once('../models/PaymentSystem.php');
   require_once('../models/InterfaceLanguage.php');
   require_once('../models/Eco.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings' );
   include('../imports/header.php');

   $_SESSION['s'] = isset($_REQUEST['s']) ? addslashes($_REQUEST['s']) : $_SESSION['s'];

   #BUSCAR TODAS AS VARIÁVEIS GET
   $paramStudy = $_SESSION['s'];

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

  // var_dump($study);
  //  var_dump($arrInterfaceLanguages);
  //  var_dump($arrEcos);
  //  var_dump($arrCurrencies);
  //  var_dump($arrPrices);
  //  var_dump($arrPaymentSystems);
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
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
           <a href="#">Openings</a>
           <i class="fa fa-angle-right"></i>
        </li>
         <li>
            <a href="./list.php">Builder</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="details.php"><?=$study->name?></a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <? include('../imports/alert.php'); ?>
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
                           <i class="fa fa-briefcase"></i> <?=$study->authorFullName?>
                        </li>
                        <li>
                           <i class="fa fa-list-ol"></i> <?=$study->variationsCount ?> Var. | <?=$study->linesCount ?> Lines
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
                              Statistics
                           </div>
                        </div>
                        <div class="portlet-body">
                          <small>This study does not have statistical data yet.</small>
                        </div>
                     </div>
                  </div>
                  <!--end col-md-4-->
               </div>
               <br />
               <a href="theory.php?s=<?=$study->id?>" class="btn btn-lg blue-hoki"><i class="fa fa-graduation-cap"></i> Edit THEORY</a>
               <a href="practice.php?s=<?=$study->id?>" class="btn btn-lg red-sunglo"><i class="fa fa-bolt"></i> Edit PRACTICE</a>
               <a href="#modalEditInfo" class="btn btn-lg btn-warning" data-toggle="modal"><i class="fa fa-file-text-o"></i> Edit INFO</a>
               <a href="#modalEditPayment" class="btn btn-lg btn-success" data-toggle="modal"><i class="fa fa-dollar"></i> Edit PAYMENT</a>
               <!--end row-->
               <div id="modalEditInfo" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
                 <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                     <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                         <h4 class="modal-title">Editing Info - <strong><?=$study->name?></strong></h4>
                     </div>
                     <div class="modal-body">
                       <div class="portlet-body form">
                          <!-- BEGIN FORM-->
                          <form action="details.php" class="form-horizontal">
                             <div class="form-body">
                                <div class="form-group">
                                   <label class="col-md-3 control-label">Language</label>
                                   <div class="col-md-6">
                                      <select class="form-control select2me" name="options2">
                                         <option value="">Select...</option>
                                         <?php foreach ($arrInterfaceLanguages as $key => $interfaceLanguage): ?>

                                           <?php $selected = ($interfaceLanguage->id == $study->interfaceLanguage->id) ? "selected" : null ;?>

                                           <option value="<?=$interfaceLanguage->id?>" <?=$selected?>>[<?=$interfaceLanguage->code?>] - <?=$interfaceLanguage->name?></option>
                                         <?php endforeach; ?>
                                      </select>
                                      <span class="help-block">
                                      Select the language of this material. You can submit studies only in the supported languages. </span>
                                   </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-md-3 control-label">Name</label>
                                   <div class="col-md-6">
                                      <input type="text" class="form-control" value="<?=$study->name?>" maxlength="50" name="defaultconfig" id="text_name">
                                      <span class="help-block">
                                      Use a small name for your study.</span>
                                   </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-md-3 control-label">Side</label>
                                   <div class="col-md-6">
                                      <select class="form-control" name="select">
                                        <?php $selectedW = ($study->side == "W") ? "selected" : null;?>
                                        <?php $selectedB = ($study->side == "B") ? "selected" : null;?>
                                         <option value="">Choose the side</option>
                                         <option value="W" <?=$selectedW?>>White</option>
                                         <option value="B" <?=$selectedB?>>Black</option>
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
                                         <?php foreach ($arrEcos as $key => $eco): ?>

                                           <?php $selected = ($eco->id == $study->eco->id) ? "selected" : null ;?>

                                           <option value="<?=$eco->id?>" <?=$selected?>>[<?=$eco->code?>] - <?=$eco->name?> (<?=$eco->line?>)</option>
                                         <?php endforeach; ?>
                                      </select>
                                      <span class="help-block">
                                      If you don't know what is the ECO code, please consider read <a href="https://en.wikipedia.org/wiki/List_of_chess_openings">this</a>.</span>
                                   </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-md-3 control-label">About this <strong>STUDY</strong></label>
                                   <div class="col-md-6">
                                      <textarea id="textarea_study" maxlength="250" class="form-control" rows="6"><?=$study->aboutStudy?></textarea>
                                      <span class="help-block">
                                      Describe the main details of your <strong>STUDY</strong>. </span>
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

   });
</script>
</body>
</html>
