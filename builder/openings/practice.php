<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/Variation.php');
   require_once('../models/BasePractice.php');
   require_once('../models/PracticeLine.php');
   require_once('../models/StudyProgressPractice.php');

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

   $eco = new Eco();
   $eco = $eco->getEcoForStudy($study->id);
   $study->eco = $eco;

   $study->basePractice = new basePractice($study->id);

   $variation = new Variation();
   $study->variations = $variation->getAllVariationsForStudy($study->id);

   //se é um estudo que o usuário autor está acessando, ele terá acesso total
   if ($study->authorID == $userID && $userIsAuthorStudy == false) {
     $userIsAuthorStudy = true;
   }

   $userOwnsStudy = $study->checkIfUserHasStudy($userID, $study->id);

   if ($userOwnsStudy == false && $userIsAuthorStudy == false) {
     header('Location: ./');
     exit;
   }

   $studyProgressPractice = new StudyProgressPractice();
   $progress = $studyProgressPractice->getTotalProgressStudyProgressPracticeForUserAndStudy($userID, $study->id);

   include('../imports/header.php');
   include('../imports/opening_styles.php');
?>

<script>

  var getVariationAndLineName = function(practiceLineID){
    var variationName;
    var lineName;


  };

  var diagramLines = {};
  var diagramIndexes = {};

  var arrPracticePGNs = [];
  var arrPracticeIndexes = [];

  var arrAllPracticePGNs = [];
  var arrAllPracticeIndexes = [];

  <?php foreach ($study->variations as $variation) : ?>

      <?php foreach ($variation->lines as $line) : ?>

          <?php foreach ($line->practiceLines as $practiceLine) : ?>

            <?php $practiceLine->lineName = $line->name; ?>
            <?php $practiceLine->variationName = $variation->name; ?>

              arrAllPracticePGNs.push('<?php echo $practiceLine->practicePGN ?>');
              arrAllPracticeIndexes.push('<?php echo json_encode($practiceLine); ?>');

              arrPracticePGNs.push('<?php echo $practiceLine->practicePGN ?>');
              arrPracticeIndexes.push('<?php echo json_encode($practiceLine); ?>');

          <?php endforeach; ?>

      <?php endforeach; ?>

      diagramLines['<?=$variation->eco->ecoPracticeLine?>'] = arrPracticePGNs;
      diagramIndexes['<?=$variation->eco->ecoPracticeLine?>'] = arrPracticeIndexes;

      arrPracticePGNs = [];
      arrPracticeIndexes = [];

  <?php endforeach; ?>

//todas as variations serão criadas com uma chave do código ECO do estudo, para um estudo abrangente, ou estudo direcioado que poderá ser criado depois, com cada
//variation sendo chave de suas linhas
  diagramLines['<?=$study->basePractice->studyEcoPracticeLine?>'] = arrAllPracticePGNs;
  diagramIndexes['<?=$study->basePractice->studyEcoPracticeLine?>'] = arrAllPracticeIndexes;

//o treinamento presume que o jogador vai jogar um estudo abrangente, de todas as variantes. Poderá ser iniciado um treinamento por variante, passando o ECO da variante para
//um treinamento direcionado.

  ecoPracticeLine = '<?=$study->basePractice->studyEcoPracticeLine?>';

  // if(getEco != ''){
  //   ecoPracticeLine = getEco;
  // }

  side = '<?=$study->side?>';

</script>
   <div class="page-content-wrapper">
   <div class="page-content">
     <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <div class="row">
         <div class="col-md-12">
            <h3 class="page-title">
               Practice <small> Memorization session</small>
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
               <div class="todo-sidebar">
                  <div class="portlet light">
                     <div class="portlet-title">
                        <div class="caption">
                           <span class="caption-subject font-green-sharp bold uppercase">TRAINING </span>
                           <span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to view project list</span>
                        </div>
                        <div class="actions">
                           <div class="btn-group">
                              <a class="btn green-haze btn-circle btn-sm todo-projects-config" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                              <i class="icon-settings"></i> &nbsp; <i class="fa fa-angle-down"></i>
                              </a>
                              <ul class="dropdown-menu pull-right">
                                 <li>
                                    <a href="details.php?s=<?=$study->id?>">
                                    <i class="i"></i> Finish training </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="portlet-body todo-project-list-content">
                        <div class="todo-project-list">
                           <ul class="nav nav-pills nav-stacked">
                              <li>
                                 <a href="javascript:;">
                                 <span class="badge" id="badge-linhas-perfeitas"> 0 </span> Perfect lines </a>
                              </li>
                              <li>
                                 <a href="javascript:;">
                                 <span class="badge" id="badge-dicas-recebidas"> 0 </span> Received tips </a>
                              </li>
                              <li>
                                 <a href="javascript:;">
                                 <span class="badge" id="badge-erros"> 0 </span> Errors </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="portlet-title">
                       <div class="caption">
                          <span class="caption-subject font-green-sharp bold uppercase">VARIATION </span>
                          <span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to view project list</span>
                       </div>
                   </div>
                   <div class="portlet-body">
                     <div class="form-group">
                         <select class="form-control select2me" name="practiceVariation" id="practiceVariation">
                           <option value="<?=$study->eco->ecoPracticeLine?>" <?php echo $getEco == $study->eco->ecoPracticeLine || $getEco == null ? 'selected' : ''; ?>>All</option>
                            <?php foreach ($study->variations as $key => $variation): ?>
                              <option value="<?=$variation->eco->ecoPracticeLine?>" <?=$selected?> <?php echo $getEco == $variation->eco->ecoPracticeLine ? 'selected' : ''; ?>><?=$variation->name?></option>
                            <?php endforeach; ?>
                         </select>
                     </div>
                   </div>
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
                           <span class="caption-helper">OPENING:</span> &nbsp;<span class="caption-subject font-green-sharp bold uppercase"><?=$study->eco->name?></span><br />
                           <span class="caption-helper">VARIATION:</span> &nbsp;<span class="caption-subject font-blue-madison bold uppercase" id="variationName"></span><br />
                           <span class="caption-helper">LINE:</span> &nbsp;<span class="caption-subject font-red-pink bold uppercase" id="lineName"></span>
                        </div>
                        <div class="actions right">
                           <a href="javascript:;" class="btn blue" id="btnnew"><i class="fa fa-refresh"></i> Restart</a>
                           <a href="javascript:;" class="btn green" id="btnflip"><i class="fa fa-retweet"></i> Flip</a>
                           <a href="javascript:;" class="btn red" id="btnundo"><i class="fa fa-undo"></i> Undo</a>
                           <a href="javascript:;" class="btn yellow" id="btnhint"><i class="fa fa-lightbulb-o"></i> Tip</a>
                        </div>
                     </div>
                     <!-- end PROJECT HEAD -->
                     <div class="portlet-body">
                       <div class="row">
                         <ul class="feeds">
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-success">
																					<i class="fa fa-exchange"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 <span id="opening"></span>
																				</div>
																			</div>
																		</div>
																	</div>
															</ul>
                              <!-- <div id="engineStatus">Status: </div> -->
                       </div>
                        <div class="row">
                           <div id="boardWrap" style="margin-left: auto; margin-right: auto;">
                              <div id="board" style="width: 100%; margin-left: auto; margin-right: auto"></div>
                           </div>

                        </div>
                     </div>

                     <input type="hidden" id="studyID" value="<?=$study->id?>" name="studyID" />
                     <input type="hidden" id="practiceLineID" value="VOU COLOCAR" name="practiceLineID" />
                     <input type="hidden" id="userID" value="<?=$userID?>" name="userID" />

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
<link rel="stylesheet" href="../../assets/admin/custom/css/chessy.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/admin/custom/scripts/chessboard-0.3.0.js"></script>
<script src="../../assets/admin/custom/scripts/chessy.js"></script>
<script src="opening_names.js"></script>
<script src="../../assets/admin/custom/scripts/jquery.ui.touch-punch.min.js"></script>
<script src="openingController.js"></script>
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

  $('#practiceVariation').on('change', function (evt) {
    // console.log($('#practiceVariation').select2('val'));
    ecoPracticeLine = $('#practiceVariation').select2('val');
    // console.log(ecoPracticeLine);
    // window.location.href = "practice.php?eco="+ecoPracticeLine;
  });

  UIAlertDialogApi.init();

});
</script>
