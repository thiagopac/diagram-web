<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/PracticeLine.php');
   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings' );
   include('../imports/header.php');
   include('../imports/opening_styles.php');

   $_SESSION['s'] = isset($_REQUEST['s']) ? addslashes($_REQUEST['s']) : $_SESSION['s'];
   $userID = $_SESSION['USER']['ID'];

   #BUSCAR TODAS AS VARIÁVEIS GET
   $paramStudy = $_SESSION['s'];

   $study = new Study();
   $study = $study->getStudyWithID($paramStudy);

?>

<script>

  var diagramLines = {};
  var arrPracticePGNs = [];
  <?php foreach ($study->basePractice->practicePGNs as $practicePGN) : ?>
  arrPracticePGNs.push('<?php echo $practicePGN ?>');
  <?php endforeach; ?>

  //O ECO NÃO PODERÁ SER NO STUDY.. PRECISARÁ PASSAR PARA OU A LINE OU VARIATION...
  ecoPracticeLine = '<?=$study->basePractice->ecoPracticeLine?>';

  side = '<?=$study->side?>';

  diagramLines['<?=$study->basePractice->ecoPracticeLine?>'] = arrPracticePGNs;

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
						<a href="./">Openings</a>
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
      <div class="row">
         <div class="col-md-12">
            <!-- BEGIN TODO SIDEBAR -->
            <div class="todo-ui">
               <div class="todo-sidebar">
                  <div class="portlet light">
                     <div class="portlet-title">
                        <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
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
                                    <a href="javascript:;">
                                    <i class="i"></i> Report an issue </a>
                                 </li>
                                 <li>
                                    <a href="javascript:;">
                                    Author's news <span class="badge badge-danger">
                                    4 </span>
                                    </a>
                                 </li>
                                 <li class="divider">
                                 </li>
                                 <li>
                                    <a href="javascript:;">
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
<script src="books.js"></script>
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

  UIAlertDialogApi.init();

});
</script>
