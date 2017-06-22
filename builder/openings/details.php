<?
  // #INCLUDES
  require_once ('../lib/config.php');
  require_once('../models/Study.php');

  // CONTROLE SESSAO
  fnInicia_Sessao ( 'openings' );
  require_once('../imports/header.php');

  $_SESSION['s'] = isset($_REQUEST['s']) ? addslashes($_REQUEST['s']) : $_SESSION['s'];
  $userID = $_SESSION['USER']['ID'];

  #BUSCAR TODAS AS VARIÁVEIS GET
  $paramStudy = $_SESSION['s'];

  $study = new Study();
  $study = $study->getStudyWithID($paramStudy);

  if ($study->monetization->price->value != 0.00) {
    $study->currencyAndPrice = $study->currency->symbol.' '.$study->monetization->price->value;
  }else{
    $study->currencyAndPrice = "FREE";
  }

  // var_dump($study);
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
         <a href="./">Openings</a>
         <i class="fa fa-angle-right"></i>
       </li>
       <li>
         <a href="details.php?s=<?=$study->id?>"><?=$study->name?></a>
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
<!-- BEGIN PAGE TITLE AND DESCRIPTION -->

<!-- END BEGIN PAGE TITLE AND DESCRIPTION -->
   <div class="row profile">
     <div class="col-md-12">
       <!--BEGIN TABS-->
       <div class="row">
         <div class="col-md-3">
           <ul class="list-unstyled profile-nav">
             <li>
               <div class="easy-pie-chart">
                 <div class="number opening" data-percent="85" style="width:200px;padding-top:60px;">
                   <h1>85<small>%</small></h1>
                 </div>
               </div>
             </li>
           </ul>
         </div>
         <div class="col-md-9">
           <div class="row">
             <div class="col-md-8 profile-info" style="text-align:justify;">
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
               <span class="badge badge-danger">You have not rated this opening yet</span>
               <p>
                 <div id="rateYo"></div>
               </p>
               <br/>
               <?php

               $userOwnsStudy = $study->checkIfUserHasStudy($userID, $study->id);

               if ($userOwnsStudy == true): ?>
                  <a href="theory.php?s=<?=$study->id?>" class="btn btn-lg blue-hoki"><i class="fa fa-graduation-cap"></i> THEORY</a>
                  <a href="practice.php?s=<?=$study->id?>" class="btn btn-lg red-sunglo"><i class="fa fa-bolt"></i> PRACTICE</a>
               <?php else: ?>
                  <a href="#modalPurchase" class="btn btn-lg btn-success" title="Buy" data-toggle="modal"><i class="fa fa-usd"></i> BUY </a>
               <?php endif; ?>
             </div>

             <div id="modalPurchase" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-md">
                 <div class="modal-content">
                   <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Purchase <?=$study->name?></h4>
                   </div>
                   <div class="modal-body">

                     <ul class="chats">
                     									<li class="in">
                     										<img class="avatar" alt="" src="../../assets/admin/layout/img/avatar1.jpg"/>
                     										<div class="message">
                     											<span class="arrow">
                     											</span>
                     											<label>
                     											<?=$study->authorFullName?> </label>
                     											<span class="body">
                     											<p><?=$study->detailsPayment->text?></span></p>
                     										</div>
                     									</li>
                     								</ul>

                                    <div class="portlet light">
                        							<!-- STAT -->
                        							<div class="row list-separated profile-stat">
                        								<div class="col-md-4 col-sm-4 col-xs-6">
                        									<div class="uppercase profile-stat-title">
                        										 <?=$study->variationsCount?>
                        									</div>
                        									<div class="uppercase profile-stat-text">
                        										 Variations
                        									</div>
                        								</div>
                        								<div class="col-md-4 col-sm-4 col-xs-6">
                        									<div class="uppercase profile-stat-title">
                        										 <?=$study->linesCount?>
                        									</div>
                        									<div class="uppercase profile-stat-text">
                        										 Lines
                        									</div>
                        								</div>
                        								<div class="col-md-4 col-sm-4 col-xs-6">
                        									<div class="uppercase profile-stat-title">
                        										 <?=$study->currencyAndPrice?>
                        									</div>
                        									<div class="uppercase profile-stat-text">
                        										 Investment
                        									</div>
                        								</div>
                        							</div>
                        							<!-- END STAT -->
                        							<div>
                        								<h4 class="profile-desc-title"><?=$study->typePayment?></h4>
                        								<span class="profile-desc-text"> Please make the payment through the url below. </span>
                        								<div class="margin-top-20 profile-desc-link">
                        									<i class="fa fa-usd"></i>
                        									<a href="<?=$study->detailsPayment->url?>" target="_blank"><?=$study->detailsPayment->url?></a>
                        								</div>
                        							</div>
                        						</div>
                                    <span class="label label-danger"><small>Attention</small></span>
                                    <span> <small>After payment confirmation, your purchase will be activated as soon as possible.</small></span>
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
                   </div>
                 </div>
               </div>
             </div>

             <!--end col-md-8-->
             <div class="col-md-4">
               <div class="portlet sale-summary">
                 <div class="portlet-title">
                   <div class="caption">
                      Your progress
                   </div>
                 </div>
                 <div class="portlet-body">
                   <ul class="list-unstyled">
                     <li>
                       <span class="sale-info">
                       NUMBER OF TIMES STUDIED <i class="fa fa-img-up"></i>
                       </span>
                       <span class="sale-num">
                       85  </span>
                     </li>
                     <li>
                       <span class="sale-info">
                       TOTAL OF STUDIED LINES <i class="fa fa-img-up"></i>
                       </span>
                       <span class="sale-num">
                       11  </span>
                     </li>
                     <li>
                       <span class="sale-info">
                       PERFECT PERFORMANCE <i class="fa fa-img-down"></i>
                       </span>
                       <span class="sale-num">
                       31 </span>
                     </li>
                   </ul>
                 </div>
               </div>
             </div>
             <!--end col-md-4-->
           </div>
           <!--end row-->

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

     $('.easy-pie-chart .number.opening').easyPieChart({
         animate: 1000,
         scaleColor: false,
         size: 200,
         lineWidth: 15,
         barColor: '#586e8b',
         onStep: function(from, to, percent) {
				this.el.children[0].innerHTML = Math.round(percent)+"<small>%</small>";
			}
     });

     $("#rateYo").rateYo({
        starWidth: "30px",
        rating: 4.5,
        halfStar: true,
        normalFill: "#d3d3d3"
      }).on("rateyo.set", function (e, data) {
                  console.log("The rating is set to " + data.rating + "!");
      });

   });
</script>
</body>
</html>
