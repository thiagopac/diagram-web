<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings' );
   include('../imports/header.php');
   include('../imports/opening_styles.php');

   $_SESSION['s'] = isset($_REQUEST['s']) ? addslashes($_REQUEST['s']) : $_SESSION['s'];

   #BUSCAR TODAS AS VARIÁVEIS GET
   $paramStudy = $_SESSION['s'];

   $study = new Study();
   $study = $study->getStudyWithID($paramStudy);

   $variarion = new Variation();
   $arrVariations = $variarion->getAllVariationsForStudy($paramStudy);
?>

<style type="text/css">

.lineLink:hover {
  text-decoration: none;
  color: deepskyblue;
  cursor: pointer;
}

.practiceLineLink:hover {
  text-decoration: none;
  color: deepskyblue;
  cursor: pointer;
}

</style>

<script>
   function resizeIframe(obj) {
     //faz um iframe aparecer inteiro, de acordo com o height do conteúdo que será apresentado
    // obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
   }
</script>
<div class="page-content-wrapper">
<div class="page-content">
   <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            Practice<small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="./">Openings Builder</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="details.php?s=<?=$study->id?>"><?=$study->name?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="#">Practice</a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <? include('../imports/alert.php'); ?>
   <div class="row">
      <div class="col-md-12">
         <!-- BEGIN TODO SIDEBAR -->
         <div class="todo-ui">
            <!-- BEGIN TODO CONTENT -->
            <div class="todo-content">
               <div class="portlet light">
                  <!-- PROJECT HEAD -->
                  <div class="portlet-title">
                     <div class="caption">
                        <i class="icon-bar-chart font-green-sharp hide"></i>
                        <span class="caption-helper">OPENING:</span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase"><?=$study->eco->name?></span>
                     </div>
                  </div>
                  <!-- end PROJECT HEAD -->
                  <div class="portlet-body">
                     <div class="row">
                        <div class="col-md-12">
                          <div class="portlet light">
                             <div class="portlet-title">
                                <div class="caption">
                                   <span class="caption-subject bold uppercase"> Variations</span>
                                </div>
                             </div>
                             <div class="portlet-body">
                               <?php if ($study->variationsCount < 1): ?>
                                <small>This study does not have any line yet.</small>
                              <?php else: ?>
                                <div class="portlet-body">
                    							<div class="panel-group accordion" id="accordion3">

<!--  -->
<?php foreach ($arrVariations as $key => $variation): ?>
                                    <div class="panel panel-default">
                    									<div class="panel-heading">
                    										<h4 class="panel-title">
                                          <?php $countLines = count($variation->lines); ?>
                    										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_<?=$variation->id?>">
                    										   <?=$variation->name ?> <i> <small style="color:lightgray">- <? echo $countLines; echo $countLines != 1 ? " Lines" : " Line"; ?></small></i>
                                        </a>
                    										</h4>
                    									</div>
                    									<div id="collapse_<?=$variation->id?>" class="panel-collapse collapse">
                    										<div class="panel-body">
       <!--  -->
       <?php foreach ($variation->lines as $key => $line): ?>
                              <ul class="" style="list-style-type: none !important;">
                                          <li class="lineLink">
                                            <?php $countPracticeLines = count($line->practiceLines); $color = $countPracticeLines > 0 ? "" : "color:red"; ?>
                                            <h4 href="modalEditLinePractice.php?s=<?=$study->id?>&l=<?=$line->id?>&pl=" data-target="#modalEditLinePractice" data-toggle="modal">
									                             <span style="<?=$color?>">&#8627; <?=$line->name ?></span> <i> <small style="color:lightgray">- <? echo $countPracticeLines; echo $countPracticeLines != 1 ? " Practice Lines" : " Practice Line"; ?></small></i> <i class="fa fa-plus-square pull-right"></i>
                                             </h4>
							                            </li>
                                          <!--  -->
                                          <?php foreach ($line->practiceLines as $key => $practiceLine): ?>
                                        <ul class="" style="list-style-type: none !important;">
                                            <li class="practiceLineLink">
                                              <h5 href="modalEditLinePractice.php?s=<?=$study->id?>&l=<?=$line->id?>&pl=<?=$practiceLine->id?>" data-target="#modalEditLinePractice" data-toggle="modal">
  									                             &#8627; <?=$practiceLine->pgn ?> <i class="fa fa-edit pull-right"></i>
                                               </h5>
  							                            </li>
                                        </ul>
                                          <?php endforeach; ?>
                                          <!--  -->
                                          </ul>
       <?php endforeach; ?>
       <!--  -->
                    										</div>
                    									</div>
                    								</div>
<?php endforeach; ?>
<!--  -->
                  							 </div>
                    						</div>
                                <span class="badge badge-roundless badge-danger">NOTE</span>
                                <small>Click on any of the above Variations to expand and create a <strong>Practice Line</strong>. <strong>Lines</strong> that do not have any <strong>Practice Line</strong> will be marked in <strong><font color="red">red</font></strong>.</small>
                              <?php endif; ?>
                             </div>
                          </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- END TODO CONTENT -->
   </div>
</div>
<div id="modalEditLinePractice" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
<? include('../imports/footer.php'); ?>
<? include('../imports/metronic_core.php'); ?>
<script src="../../assets/admin/custom/scripts/chess.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="../../assets/admin/custom/scripts/chessboard-0.3.0.js"></script>
</body>
</html>
<script>
   jQuery(document).ready(function() {
     // initiate layout and plugins
     Metronic.init(); // init metronic core components
     Layout.init(); // init current layou
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

     UIAlertDialogApi.init();

   });
</script>
