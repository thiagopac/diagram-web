<?
  // #INCLUDES
  require_once ('../lib/config.php');
  require_once('../models/Study.php');
  require_once('../models/BaseTheory.php');
  require_once('../models/Variation.php');
  require_once('../models/Line.php');
  require_once('../models/Acquisition.php');
  require_once('../models/StudyProgressTheory.php');

  if (empty($_REQUEST['s'])){
    header('Location: ./');
    exit;
  }

  // CONTROLE SESSAO
  fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  #BUSCAR TODAS AS VARIÁVEIS GET
  $paramStudy = $_REQUEST['s'];

  $study = new Study();
  $study = $study->getStudyWithID($paramStudy);

  $userOwnsStudy = $study->checkIfUserHasStudy($userID, $study->id);

  //se é um estudo que o usuário autor está acessando, ele terá acesso total
  if ($study->authorID == $userID) {
    $userIsAuthorStudy = true;
  }

  if ($userOwnsStudy == false && $userIsAuthorStudy == false) {
    header('Location: ./');
    exit;
  }

  $baseTheory = new BaseTheory();
  $study->baseTheory = $baseTheory->getBaseTheoryForStudy($study->id);

  $variation = new Variation();
  $study->variations = $variation->getAllVariationsForStudy($study->id);

  $studyProgressTheory = new StudyProgressTheory();
  $progress = $studyProgressTheory->getTotalProgressStudyProgressTheoryForUserAndStudy($userID, $study->id);

  //controlar o que irá aparecer de item de menu de estudo
  $showHistory = $study->baseTheory->theoryHistory->text != '' ? true : false;
  $showGameStyle = $study->baseTheory->theoryGameStyle->text != '' ? true : false;
  $showMainGrandMasters = $study->baseTheory->theoryMainGrandMasters->text != '' ? true : false;
  $showVariations = count($study->variations) > 0 ? true : false;
  $showBibliography = $study->baseTheory->theoryBibliography->text != '' ? true : false;

  require_once('../imports/header.php');
  require_once('../imports/opening_styles.php');
?>

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
            <?= $t->{'Theory'}; ?><small></small>
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
            <a href="./list.php"><?= $t->{'Study'}; ?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="details.php?s=<?=$study->id?>"><?=$study->name?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="#"><?= $t->{'Theory'}; ?></a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <? include('../imports/alert.php'); ?>
   <div class="progress">
      <div class="progress-bar blue-hoki" id="progressBar" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%">
         <span id="progressCount" style="color: <? $color = $progress < 5 ? "black" : "white"; echo $color; ?>">
         <?=$progress?>% <?= $t->{'Complete'}; ?> </span>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <!-- BEGIN TODO SIDEBAR -->
         <div class="todo-ui">
            <div class="todo-sidebar">
               <div class="portlet light">
                  <div class="portlet-title">
                     <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                        <span class="caption-subject font-green-sharp bold uppercase"><?= $t->{'LEARNING'}; ?> </span>
                     </div>
                     <div class="actions">
                        <div class="btn-group">
                           <a class="btn green-haze btn-circle btn-sm todo-projects-config" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                           <i class="icon-settings"></i> &nbsp; <i class="fa fa-angle-down"></i>
                           </a>
                           <ul class="dropdown-menu pull-right">
                              <!-- <li>
                                 <a class="openModalErrorReport" data-studyid="<?=$study->id?>"  data-userid="<?=$userID?>" >
                                 <i class="i"></i> Report an error </a>
                              </li> -->
                              <!-- <li>
                                 <a href="javascript:;">
                                 Novidades do autor <span class="badge badge-danger">
                                 4 </span>
                                 </a>
                              </li> -->
                              <!-- <li class="divider">
                              </li> -->
                              <li>
                                 <a href="details.php?s=<?=$study->id?>">
                                 <i class="i"></i> <?= $t->{'Finish training'}; ?> </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <!-- <div id="modalErrorReport" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h4 class="modal-title" id="lineNameTitle">Report an error</h4>
                        </div>
                        <div class="modal-body form">
                          <form class="form-horizontal form-row-seperated">

                            <input type="hidden" id="studyID" name="studyID" />

                            <div class="form-group last">
                              <div class="col-sm-12">

                                  <div class="portlet-body">

                                  </div>
                            </div>
                        </div>
                          <div class="modal-footer">

                            <button type="button" id="btnCloseModalErrorReport" class="btn btn-danger" title="Close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

               </div> -->
                  <!--  BEGIN MENU APRENDIZADO -->
                  <div class="row">
                     <ul class="ver-inline-menu tabbable margin-bottom-10">

                      <?php if ($showHistory == true): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_1">
                           <i class="fa fa-birthday-cake"></i> <?= $t->{'History'}; ?> </a>
                           <span class="after">
                           </span>
                        </li>
                      <?php endif; ?>

                      <?php if ($showGameStyle == true): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_2">
                           <i class="fa fa-puzzle-piece"></i> <?= $t->{'Game Style'}; ?> </a>
                        </li>
                      <?php endif; ?>

                      <?php if ($showMainGrandMasters): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_3">
                           <i class="fa fa-users"></i> <?= $t->{'Main Grandmasters'}; ?> </a>
                        </li>
                      <?php endif; ?>

                      <?php if ($showVariations): ?>
                        <li class="active">
                           <a data-toggle="tab" href="#tab_4">
                           <i class="fa fa-bars"></i> <?= $t->{'Variations'}; ?> </a>
                        </li>
                      <?php endif; ?>

                      <?php if ($showBibliography): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_5">
                           <i class="fa fa-graduation-cap"></i> <?= $t->{'Bibliography'}; ?> </a>
                        </li>
                      <?php endif; ?>

                     </ul>
                  </div>
                  <!--  FIM MENU APRENDIZADO -->
               </div>
            </div>
            <!-- END TODO SIDEBAR -->
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
                           <div class="tab-content">
                              <div id="tab_1" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> <?= $t->{'History'}; ?></span>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div>
                                          <p>
                                             <?=$study->baseTheory->theoryHistory->text?>
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="tab_2" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> <?= $t->{'Game Style'}; ?></span>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div>
                                          <p>
                                             <?=$study->baseTheory->theoryGameStyle->text?>
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="tab_3" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> <?= $t->{'Main Grandmasters'}; ?></span>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div>
                                          <p>
                                             <?=$study->baseTheory->theoryMainGrandMasters->text?>
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                            <?php if ($showVariations == true): ?>
                              <div id="tab_4" class="tab-pane active">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> <?= $t->{'VARIATIONS'}; ?></span>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div class="row">
                                        <div class="col-md-12">
                                          <div class="panel-group accordion" id="accordion">

                                    <?php foreach ($study->variations as $key => $variation): ?>

                                        <?php if (count($variation->lines) < 1) continue; ?>

                                                <div class="panel panel-default">
                                									<div class="panel-heading">
                                										<h4 class="panel-title">
                                                      <?php $countLines = count($variation->lines); ?>
                                										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_<?=$variation->id?>">
                                										   <?=$variation->name ?> <i> <small style="color:lightgray">- <? echo $countLines; echo $countLines != 1 ? " Lines" : " Line"; ?></small></i>
                                                    </a>
                                										</h4>
                                									</div>
                                									<div id="collapse_<?=$variation->id?>" class="panel-collapse collapse in">
                                										<div class="panel-body">
                                                   <!--  -->
                                          <?php foreach ($variation->lines as $key => $line): ?>

                                            <ul class="" style="list-style-type: none !important;">
                                              <li class="lineLink">
                                                <?php
                                                  $studyProgressTheory = new StudyProgressTheory();
                                                  $studyProgressTheory = $studyProgressTheory->getStudyProgressTheoryForUserStudyAndLine($userID, $study->id, $line->id);
                                                  $iconChecked = $studyProgressTheory->learned == "1" ? "fa fa-check-square-o" : "fa fa-square-o";
                                                  $colorChecked = $studyProgressTheory->learned == "1" ? "color:limegreen" : "color:lightgray";
                                                  $checked = $studyProgressTheory->learned == "1" ? true : false;

                                                  $cleanPgn = preg_replace("~(?:(\()|(\[)|(\{))(?(1)(?>[^()]++|(?R))*\))(?(2)(?>[^][]++|(?R))*\])(?(3)(?>[^{}]++|(?R))*\})~","",$line->pgn); //retirando parêntesis

                                                ?>
                                                <h4 style="cursor: pointer" class="openModalLine" id="<?=$line->variationID."_".$line->id?>" data-toggle="modal" data-studyid="<?=$study->id?>" data-varid="<?=$line->variationID?>" data-varname="<?=$variation->name?>" data-vartext="<?=$variation->text?>" data-lineid="<?=$line->id?>"
                                                  data-linetext="<?=$line->text?>" data-linename="<?=$line->name?>" data-progress="<?=$checked?>" data-pgn="<?=$line->pgn?>">

    									                             <span>&#8627; <?=$line->name ?></span> <i style="<?=$colorChecked?>" class="<?=$iconChecked?> pull-right"></i><span style="color:lightgray; font-weight:lighter" class="small light pull-right">(<?= $t->{'Updated'}; ?>: <?=fnDateDBtoVisual($line->dateCreated)?>)</span>
                                                 </h4>
    							                            </li>
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
                                       </div>
                                    </div>
                                 </div>

                                 <div id="modalLine" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
                                   <div class="modal-dialog modal-lg">
                                     <div class="modal-content">

                                       <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                         <h4 class="modal-title" id="lineNameTitle"><?= $t->{'Opening Line'}; ?></h4>
                                       </div>
                                       <div class="modal-body form">
                                         <form class="form-horizontal form-row-seperated">

                                           <input type="hidden" id="studyID" name="studyID" />
                                           <input type="hidden" id="lineID" name="lineID" />


                                           <div class="form-group last">
                                             <div class="col-sm-12">


                                                 <div class="panel-group accordion" id="accordion">
                                                                <div class="panel panel-default">
                                                                  <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_variation" aria-expanded="false">
                                                                    <?= $t->{'About'}; ?> <span id="variationName"></span> </a>
                                                                    </h4>
                                                                  </div>
                                                                  <div id="collapse_variation" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                                    <div class="panel-body">
                                                                      <p>
                                                                         <span id="variationText"></span>
                                                                      </p>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                  <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_line" aria-expanded="false">
                                                                    <?= $t->{'About'}; ?> <span id="lineName"></span> </a>
                                                                    </h4>
                                                                  </div>
                                                                  <div id="collapse_line" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                                    <div class="panel-body" style="overflow-y:auto;">
                                                                      <p>
                                                                         <span id="lineText"></span>
                                                                      </p>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>

                                                 <div class="portlet-body">
                                                   <iframe name="iframeLine" id="iframeLine" onload="resizeIframe(this)" src="" scrolling="yes"
                                                     frameborder="0" border="0" cellspacing="0"
                                                     style="border-style: none;width: 100%; height: 420px;"></iframe>
                                                 </div>


                                           </div>
                                       </div>
                                         <div class="modal-footer">

                                           <div class="btn-group pull-left">
                                             <div class="md-checkbox">
                                                <input type="checkbox" id="" class="md-check checkbox-learned" >
                                                <label id="labelCheckbox" for="">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <?= $t->{'Mark as learned'}; ?> </label>
                                             </div>
                                          </div>

                                           <button type="button" id="btnCloseModalLine" class="btn btn-danger" title="Close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                         </div>
                                       </form>
                                     </div>
                                   </div>
                                 </div>

                              </div>
                            </div>

                          <?php endif; ?>
                              <div id="tab_5" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> <?= $t->{'Bibliography'}; ?></span>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <p>
                                          <?=$study->baseTheory->theoryBibliography->text?>
                                       </p>
                                    </div>
                                 </div>
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
     var progress;

     $(function(){
         $(".openModalLine").click(function(){
             $('#studyID').val($(this).data('studyid'));
             $('#variationName').html($(this).data('varname'));
             $('#variationText').html($(this).data('vartext'));
             $('#lineID').val($(this).data('lineid'));
             $('#lineNameTitle').html($(this).data('linename'));
             $('#lineName').html($(this).data('linename'));
             $('#lineText').html($(this).data('linetext'));
             $('#linePGN').val($(this).data('pgn'));
             $('#studyProgressID').val($(this).data('studyProgressID'));
             $('.checkbox-learned').prop("checked", $(this).data('progress'));
             $('.checkbox-learned').attr("id", $(this).data('lineid'));
             $('#labelCheckbox').attr("for", $(this).data('lineid'));

             if ($(this).data('pgn') != null) {
               $('#iframeLine').attr("src", "../board/pgnviewer.php?pgn=" + $(this).data('pgn'));
             }else{
               $('#iframeLine').attr("src", "../board/pgnviewer.php");
             }

             $("#modalLine").modal("show");
         });
     });

     $(function(){
         $(".openModalErrorReport").click(function(){
             $('#studyID').val($(this).data('studyid'));
             $('#userID').html($(this).data('userid'));

             $("#modalErrorReport").modal("show");
         });
     });

     $(function(){
         $('.checkbox-learned').on('change',function(){
           var id = $(this).attr('id');
           var isChecked = $(this).attr('checked') == "checked" ? 1 : 0;
           $.ajax({
               url: './action/theory-learned.php',
               type: 'POST',
               data: {studyID: $("#studyID").val(),
                     lineID: id,
                     learned: isChecked },
               success: function (result) {
                 var response = JSON.parse(result);

                 if(response["status"] == "success"){
                   progress = response["progress"];
                  // console.log(response);
                   toastr.success('<?= $t->{'Saved changes!'}; ?>');
                 }else if(response["status"] == "error"){
                   toastr.warning('<?= $t->{'Error. Please, try again later.'}; ?>');
                 }
               }, error: function (result) {
                   toastr.error('<?= $t->{'Error. Please, try again later.'}; ?>');
               }
           });
        });
      });

      $(function(){
          $("#btnCloseModalLine").click(function(){
            location.reload();
            //
            // $("#progressBar").attr("aria-valuenow", progress);
            // $("#progressBar").attr("style", "width: " + progress + "%");
            // $("#progressCount").html(progress + "% Complete");

          });
      });

   });
</script>
