<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/User.php');

   if (empty($_REQUEST['s'])){
     header('Location: ./');
     exit;
   }

   // CONTROLE SESSAO
   fnInicia_Sessao ('openings-builder');

   $userID = $_SESSION['USER']['ID'];

   #BUSCAR TODAS AS VARIÁVEIS GET
   $paramStudy = $_REQUEST['s'];

   $study = new Study();
   $study = $study->getStudyWithID($paramStudy);

   $user = new User();
   $study->author = $user->getUserWithId($study->authorID);

   if ($study->author->id != $userID){
     header('Location: ./');
     exit;
   }

   Variation::$showLineDeleted = false;
   Variation::$showPracticeLineDeleted = false;

   $variarion = new Variation();
   $arrVariations = $variarion->getAllVariationsForStudy($paramStudy);

   include('../imports/header.php');
   include('../imports/opening_styles.php');
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
            <?= $t->{'Practice'}; ?><small></small>
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
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="#"><?= $t->{'Practice'}; ?></a>
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
                          <span class="caption-helper"><?= $t->{'STUDY'}; ?>:</span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase"><?=$study->name?></span>
                     </div>
                  </div>
                  <!-- end PROJECT HEAD -->
                  <div class="portlet-body">
                     <div class="row">
                        <div class="col-md-12">
                          <div class="portlet light">
                             <div class="portlet-title">
                                <div class="caption">
                                   <span class="caption-subject bold uppercase"> <?= $t->{'Variations'}; ?></span>
                                </div>
                             </div>
                             <div class="portlet-body">
                               <?php if (count($arrVariations) < 1): ?>
                                <small><?= $t->{'This study does not have any line yet.'}; ?></small>
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
                    										   <?=$variation->name ?> <i> <small style="color:lightgray">- <? echo $countLines; echo " "; echo $strLines != 1 ? $t->{'Lines'} : $t->{'Line'}; ?></small></i>
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
                                            <h4 class="openModalLinePractice" data-toggle="modal" data-lineid="<?=$line->id?>">
									                             <span style="<?=$color?>">&#8627; <?=$line->name ?></span> <i> <small style="color:lightgray">- <? echo $countPracticeLines; echo " "; echo $strPracticeLines != 1 ? $t->{'Practice Lines'} : $t->{'Practice Line'}; ?></small></i> <i class="fa fa-plus-square pull-right"></i>
                                             </h4>
							                            </li>
                                  <?php

                                      $printSuggestion = true;

                                      //retira os parêntesis de sublinhas e chaves de comentários dos PGNs
                                      $cleanPgn = preg_replace("~(?:(\()|(\[)|(\{))(?(1)(?>[^()]++|(?R))*\))(?(2)(?>[^][]++|(?R))*\])(?(3)(?>[^{}]++|(?R))*\})~","",$line->pgn);
                                      $cleanPgn = preg_replace("/\s\s+/", " ", $cleanPgn); //retirar espaços duplos que podem ter ficado no PGN
                                  ?>
                                  <!--  -->
                                  <?php foreach ($line->practiceLines as $key => $practiceLine): ?>
                                        <ul class="" style="list-style-type: none !important;">
                                            <li class="practiceLineLink">
                                              <h5 class="openModalLinePractice" data-toggle="modal" data-lineid="<?=$line->id?>" data-practicelineid="<?=$practiceLine->id?>" data-practicelinepgn="<?=$practiceLine->pgn?>">
  									                             &#8627; <?=$practiceLine->pgn ?> <i class="fa fa-edit pull-right"></i>
                                               </h5>
  							                            </li>
                                        </ul>

                                        <?php $strLine = $practiceLine->pgn; $strPgn = $cleanPgn;?>
                                        <?php similar_text($strLine, $strPgn, $percent); // se a similaridade do PGN da linha teória com a de alguma linha já incluída for maior do que 95%, não sugerir a linha teórica com PGN limpo ?>

                                        <?php if ($percent > 95): ?>
                                          <?php $printSuggestion = false;  ?>
                                        <?php endif; ?>

                                  <?php endforeach; ?>
                                  <!--  -->

                                  <!-- SUGGESTED PRACTICE LINE BASED IN THEORY LINE -->

                                  <?php if ($printSuggestion == true): ?>

                                      <ul class="" style="list-style-type: none !important;">
                                          <li class="practiceLineLink">
                                            <h5 class="openModalLinePractice" style="color: darkgray" data-toggle="modal" data-lineid="<?=$line->id?>" data-practicelinepgn="<?=$cleanPgn?>">
                                               &#8627; <?=$cleanPgn ?> <small><i style="color: darkgray"><?= $t->{'(Suggested based on theoretical line)'}; ?></i></small> <i class="fa fa-edit pull-right"></i>
                                             </h5>
                                          </li>
                                      </ul>
                                  <?php endif; ?>
                                  <!-- END SUGGESTED PRACTICE LINE -->


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
                                <span class="badge badge-roundless badge-danger"><?= $t->{'NOTE'}; ?></span>
                                <small><?= $t->{"Click on any of the above Variations to expand and create a <strong>Practice Line</strong>. <strong>Lines</strong> that do not have any <strong>Practice Line</strong> will be marked in <strong><font color='red'>red</font></strong>."}; ?></small>
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
<div id="modalLinePractice" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><span id="modalTitle"></span></h4>
      </div>
      <div class="modal-body form">
        <form class="form-horizontal form-row-seperated">
          <input type="hidden" id="lineID" name="lineID" value="" />
          <input type="hidden" id="practiceLineID" name="practiceLineID" value="" />
          <!-- <input type="hidden" id="practiceLinePGN" name="practiceLinePGN" value="" /> -->
          <div class="form-group">
            <div class="col-md-12">
              <div class="portlet-body">
                <iframe name="iframePracticeLine" id="iframePracticeLine" onload="resizeIframe(this)" scrolling="yes"
                  frameborder="0" border="0" cellspacing="0"
                  style="border-style: none;width: 100%; height: 400px;"></iframe>
              </div>
              <span class="badge badge-roundless badge-danger"><?= $t->{'NOTE'}; ?></span>
              <small><?= $t->{"To use an external PGN, paste it into the text field, then click the <i class='fa fa-pencil-square-o'></i> button."}; ?></small>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
        <button type="button" class="btn btn purple" id="btnDeletePracticeLine" title="Delete" data-dismiss="modal"><i class="fa fa-trash-o"></i></button>
        <button type="button" class="btn btn-primary" id="btnSavePracticeLine" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
      </div>

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

     $(function(){
         $(".openModalLinePractice").click(function(){
             $('#lineID').val($(this).data('lineid'));
             $('#practiceLineID').val($(this).data('practicelineid'));
            //  $('#practiceLinePGN').val($(this).data('practicelinepgn'));

             if($(this).data('practicelineid') != null){
               $('#modalTitle').html("<?= $t->{'Edit Practice Line'}; ?>");
               $('#btnDeletePracticeLine').show();
             }else{
               $('#modalTitle').html("<?= $t->{'Add new Practice Line'}; ?>");
               $('#btnDeletePracticeLine').hide();
             }

             if ($(this).data('practicelinepgn') != null) {
               $('#iframePracticeLine').attr("src", "../board/practiceeditor.php?pgn=" + $(this).data('practicelinepgn'));
               console.log("aqui");
             }else{
               $('#iframePracticeLine').attr("src", "../board/practiceeditor.php");
             }

             $("#modalLinePractice").modal("show");
         });
     });

     $(document).ready(function () {
           $("#btnSavePracticeLine").click(function () {
               $.ajax({
                   url: './action/practice-edit-practice-line.php',
                   type: 'POST',
                   data: {lineID: $("#lineID").val(),
                         practiceLineID: $("#practiceLineID").val(),
                         practiceLinePGN: $("#iframePracticeLine").contents().find("#pgn").val()},
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
           });
       });

       $(document).ready(function () {
             $("#btnDeletePracticeLine").click(function () {
                 $.ajax({
                     url: './action/practice-delete-practice-line.php',
                     type: 'POST',
                     data: {practiceLineID: $("#practiceLineID").val()},
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
             });
         });

   });
</script>
