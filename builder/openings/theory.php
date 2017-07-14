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
  fnInicia_Sessao ( 'openings' );

  $userID = $_SESSION['USER']['ID'];

  #BUSCAR TODAS AS VARIÁVEIS GET
  $paramStudy = $_REQUEST['s'];

  $study = new Study();
  $study = $study->getStudyWithID($paramStudy);

  $userOwnsStudy = $study->checkIfUserHasStudy($userID, $study->id);

  if ($userOwnsStudy == false) {
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
            Theory<small></small>
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
            <a href="./list.php">Study</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="details.php?s=<?=$study->id?>"><?=$study->name?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="#">Theory</a>
         </li>
      </ul>
      <div class="page-toolbar">
         <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
            Actions <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
               <li>
                  <a href="#">Restart stats</a>
               </li>
               <li>
                  <a href="#">Tell a friend</a>
               </li>
               <li class="divider">
               </li>
               <li>
                  <a href="#">Back to start</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <? include('../imports/alert.php'); ?>
   <div class="progress">
      <div class="progress-bar blue-hoki" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%">
         <span style="color: <? $color = $progress < 5 ? "black" : "white"; echo $color; ?>">
         <?=$progress?>% Complete </span>
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
                        <span class="caption-subject font-green-sharp bold uppercase">LEARNING </span>
                     </div>
                     <div class="actions">
                        <div class="btn-group">
                           <a class="btn green-haze btn-circle btn-sm todo-projects-config" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                           <i class="icon-settings"></i> &nbsp; <i class="fa fa-angle-down"></i>
                           </a>
                           <ul class="dropdown-menu pull-right">
                              <li>
                                 <a href="javascript:;">
                                 <i class="i"></i> Relatar um erro </a>
                              </li>
                              <li>
                                 <a href="javascript:;">
                                 Novidades do autor <span class="badge badge-danger">
                                 4 </span>
                                 </a>
                              </li>
                              <li class="divider">
                              </li>
                              <li>
                                 <a href="javascript:;">
                                 <i class="i"></i> Finalizar treinamento </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <!--  BEGIN MENU APRENDIZADO -->
                  <div class="row">
                     <ul class="ver-inline-menu tabbable margin-bottom-10">

                      <?php if ($showHistory == true): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_1">
                           <i class="fa fa-birthday-cake"></i> History </a>
                           <span class="after">
                           </span>
                        </li>
                      <?php endif; ?>

                      <?php if ($showGameStyle == true): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_2">
                           <i class="fa fa-puzzle-piece"></i> Game Style </a>
                        </li>
                      <?php endif; ?>

                      <?php if ($showMainGrandMasters): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_3">
                           <i class="fa fa-users"></i> Main Grandmasters </a>
                        </li>
                      <?php endif; ?>

                      <?php if ($showVariations): ?>
                        <li class="active">
                           <a data-toggle="tab" href="#tab_4">
                           <i class="fa fa-bars"></i> Variations </a>
                        </li>
                      <?php endif; ?>

                      <?php if ($showBibliography): ?>
                        <li>
                           <a data-toggle="tab" href="#tab_5">
                           <i class="fa fa-graduation-cap"></i> Bibliography </a>
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
                        <span class="caption-helper">OPENING:</span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase"><?=$study->eco->name?></span>
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
                                          <span class="caption-subject bold uppercase"> History</span>
                                       </div>
                                       <!-- <div class="actions">
                                          <div class="btn-group">
                                             <div class="md-checkbox">
                                                <input type="checkbox" id="checkbox-history" class="md-check" >
                                                <label for="checkbox-history">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                Mark as learned </label>
                                             </div>
                                          </div>
                                       </div> -->
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
                                          <span class="caption-subject bold uppercase"> Game Style</span>
                                       </div>
                                       <!-- <div class="actions">
                                          <div class="btn-group">
                                             <div class="md-checkbox">
                                                <input type="checkbox" id="checkbox-game-style" class="md-check" >
                                                <label for="checkbox-game-style">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                Mark as learned </label>
                                             </div>
                                          </div>
                                       </div> -->
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
                                          <span class="caption-subject bold uppercase"> Main Grandmasters</span>
                                       </div>
                                       <!-- <div class="actions">
                                          <div class="btn-group">
                                             <div class="md-checkbox">
                                                <input type="checkbox" id="checkbox-main-players" class="md-check" >
                                                <label for="checkbox-main-players">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                Mark as learned </label>
                                             </div>
                                          </div>
                                       </div> -->
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
                                          <span class="caption-subject bold uppercase"> VARIATIONS</span>
                                       </div>
                                       <div class="actions">
                                          <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                                          </a>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div class="row">
                                          <ul class="nav nav-tabs">
                                             <?
                                                $flag = "active";
                                                foreach ($study->variations as $key => $variation) {
                                                  if (count($variation->lines) > 1) {
                                                    $href = "javascript:;";
                                                    $dataToggle = "dropdown";
                                                    $class = "dropdown-toggle";
                                                    $angleDown = "<i class=\"fa fa-angle-down\"></i>";
                                                  }else{
                                                    $line = $variation->lines[0];
                                                    $href = "#tab_".$variation->id."_".$line->id;
                                                    $dataToggle = "tab";
                                                    $class = "";
                                                    $angleDown = "";
                                                  }?>
                                             <li class="dropdown <?=$flag?>">
                                                <a href="<?=$href?>" class="<?=$class?>" data-toggle="<?=$dataToggle?>">
                                                <?=$variation->name?> <?=$angleDown?></a>
                                                <ul class="dropdown-menu" role="menu">
                                                   <?php foreach ($variation->lines as $key => $line):
                                                      $href = "#tab_".$variation->id."_".$line->id;
                                                      ?>
                                                   <li>
                                                      <a href="<?=$href?>" tabindex="-1" data-toggle="tab">
                                                      <?=$line->name?></a>
                                                   </li>
                                                   <?php endforeach; ?>
                                                </ul>
                                             </li>
                                             <? $flag = "" ?>
                                             <?} ?>
                                          </ul>
                                          <div class="tab-content">
                                             <?$flag = "active";
                                             foreach ($study->variations as $key => $variation) {
                                                foreach ($variation->lines as $key => $line) {
                                                    $tab = "tab_".$line->idVariation."_".$line->id; ?>
                                             <div class="tab-pane <?=$flag?>" id="<?=$tab?>">
                                                <div class="portlet light">

                                                  <?php if (strlen($variation->text)>0): ?>
                                                  <div class="portlet">
                                                  						<div class="portlet-title">
                                                  							<div class="caption">
                                                  								<?=$variation->name?>
                                                  							</div>
                                                  							<div class="tools">
                                                  								<a href="javascript:;" class="collapse" data-original-title="" title="">
                                                  								</a>
                                                  								<a href="javascript:;" class="remove" data-original-title="" title="">
                                                  								</a>
                                                  							</div>
                                                  						</div>
                                                  						<div class="portlet-body">
                                                  							 <?=$variation->text?>
                                                  						</div>
                                                  					</div>
                                                  <?php endif; ?>

                                                   <div class="portlet-title">
                                                      <div class="caption">
                                                         <span class="caption-subject uppercase"> <?=$line->name?></span>
                                                      </div>
                                                      <div class="actions">
                                                         <div class="btn-group">
                                                            <div class="md-checkbox">
                                                               <input type="checkbox" id="checkbox-variante-classica" class="md-check" >
                                                               <label for="checkbox-variante-classica">
                                                               <span></span>
                                                               <span class="check"></span>
                                                               <span class="box"></span>
                                                               Mark as learned </label>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="portlet-body">
                                                      <iframe name='iframe1' id="iframe1" onload="resizeIframe(this)" src="../board/pgnviewer.php?pgn=<?=$line->pgn?>" scrolling="yes" frameborder="0" border="0" cellspacing="0"
                                                         style="border-style: none;width: 100%; height: 480px;"></iframe>
                                                         <?php if (strlen($line->text)>0): ?>
                                                           <blockquote><h5><?=$line->text?></h5></blockquote>
                                                         <?php endif; ?>
                                                   </div>
                                                </div>
                                             </div>
                                             <? $flag = "fade" ?>
                                              <?} ?>
                                             <?} ?>
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
                                          <span class="caption-subject bold uppercase"> Bibliography</span>
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
                  <div class="modal fade" id="finishedLine" tabindex="-1" role="basic" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h4 class="modal-title">Title</h4>
                           </div>
                           <div class="modal-body">
                              Body
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn default" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="lineinexistent" tabindex="-1" role="basic" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h4 class="modal-title">Title</h4>
                           </div>
                           <div class="modal-body">
                              Body
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn default" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <audio id="soundMove" src="../../assets/admin/custom/sounds/move.wav" type="audio/wav"></audio>
                  <audio id="soundTake" src="../../assets/admin/custom/sounds/take.wav" type="audio/wav"></audio>
                  <audio id="soundCheck" src="../../assets/admin/custom/sounds/check.wav" type="audio/wav"></audio>
                  <audio id="soundSuccess" src="../../assets/admin/custom/sounds/success.wav" type="audio/wav"></audio>
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

   });
</script>
