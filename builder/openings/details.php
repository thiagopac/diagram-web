<?
  // #INCLUDES
  require_once ('../lib/config.php');
  require_once('../models/Study.php');
  require_once('../models/User.php');
  require_once('../models/Monetization.php');
  require_once('../models/Variation.php');
  require_once('../models/Line.php');
  require_once('../models/StudyRating.php');
  require_once('../models/StudyProgressTheory.php');
  require_once('../models/Statistics.php');

  // CONTROLE SESSAO
  fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  #BUSCAR TODAS AS VARIÁVEIS GET
  $paramStudy = $_REQUEST['s'];


  if (empty($_REQUEST['s'])){
    header('Location: ./');
    exit;
  }

  Study::$showDeleted = true;
  $study = new Study();
  $study = $study->getStudyWithID($paramStudy);

  $user = new User();
  $author = $user->getUserWithID($study->authorID);

  $study->author = $author;

  $monetization = new Monetization();
  $study->monetization = $monetization->getMonetizationForStudy($study->id);

  $variarion = new Variation();
  $arrVariations = $variarion->getAllVariationsForStudy($study->id);

  $variationsCount = count($arrVariations);

  foreach ($arrVariations as $key => $variation) {
  	foreach ($variation->lines as $key => $line) {
  		$linesCount ++;
  	}
  }

  if ($study->deleted == true){
    header('Location: ./');
    exit;
  }

  if ($study->monetization->price->value != 0.00) {
    $study->currencyAndPrice = $study->monetization->currency->symbol.' '.$study->monetization->price->value;
  }else{
    $study->currencyAndPrice = $t->{'FREE'};;
  }

  $studyRating = new StudyRating();
  $studyRating = $studyRating->getStudyRatingForStudyAndUser($paramStudy, $userID);
  $studyRatingCount = $studyRating->getCountStudyRatingForStudy($paramStudy);

  $userHasNotRated = $studyRating->id == NULL ? true : false;

  $studyProgressTheory = new StudyProgressTheory();
  $progress = $studyProgressTheory->getTotalProgressStudyProgressTheoryForUserAndStudy($userID, $paramStudy);

  $statistics = new Statistics();
  $totalPracticeSessions = $statistics->getTotalOfPracticeSessionsForStudyAndUser($paramStudy, $userID);
  $totalPracticePerfects = $statistics->getTotalOfPracticePerfectsForStudyAndUser($paramStudy, $userID);
  $totalLinesPracticed = $statistics->getTotalProgressStudyProgressPracticeForUserAndStudy($userID, $paramStudy);

  // var_dump($study);
  require_once('../imports/header.php');
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
          <a href="#"><?= $t->{'Openings'}; ?></a>
          <i class="fa fa-angle-right"></i>
       </li>
       <li>
         <a href="./list.php"><?= $t->{'Study'}; ?></a>
         <i class="fa fa-angle-right"></i>
       </li>
       <li>
         <a href="details.php?s=<?=$study->id?>"><?=$study->name?></a>
       </li>
     </ul>
     <div class="page-toolbar">
       <div class="btn-group pull-right">
         <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
         <?= $t->{'Actions'}; ?> <i class="fa fa-angle-down"></i>
         </button>
         <ul class="dropdown-menu pull-right" role="menu">
           <li>
             <a id="restartTheoryStats" href="#"><?= $t->{'Restart theoretical statistics'}; ?></a>
           </li>
           <li>
             <a id="restartPracticeStats" href="#"><?= $t->{'Restart practical statistics'}; ?></a>
           </li>
           <li class="divider">
           </li>
           <li>
             <a href="list.php"><?= $t->{'Back to start'}; ?></a>
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
                 <div class="number opening" data-percent="<?=$progress?>" style="width:200px;padding-top:60px;padding-bottom:130px;display:inline-block;">
                   <h1><?=$progress?><small>%</small></h1>
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
                   <i class="fa fa-briefcase"></i> <?=$study->author->fullName?>
                 </li>
                 <li>
                   <i class="fa fa-list-ol"></i> <?=$variationsCount ?> Var. | <?=$linesCount ?> <?= $t->{'Lines'}; ?>
                 </li>
                 <li>
                   <i class="fa fa-usd"></i> <?=$study->currencyAndPrice?>
                 </li>
               </ul>

               <?php
                    $userOwnsStudy = $study->checkIfUserHasStudy($userID, $study->id);
                    $readOnly = 'true';

                    //se é um estudo que o usuário autor está acessando, ele terá acesso total
                    if ($study->authorID == $userID) {
                      $userIsAuthorStudy = true;
                      $userHasNotRated = false;
                    }

                    if ($userOwnsStudy == true) {
                      $readOnly = 'false';
                    }else{
                      $readOnly = 'true';
                      $userHasNotRated = false;
                    }

                ?>
                <p><small><i>(<?=$studyRatingCount ?> <?=$studyRatingCount == 1 ? $t->{'review'} : $t->{'reviews'} ;?>)</i></small></p>
               <form>
                 <p>
                   <input type="hidden" id="studyID" value="<?=$study->id?>">
                   <input type="hidden" id="userID" value="<?=$userID?>">
                   <input id="ratingStars" name="ratingStars" class="rating" data-size="sm" data-min="0" data-max="5" data-step="0.5" value="<?=$studyRating->rating?>" data-readonly="<?=$readOnly?>" data-show-clear="false" data-show-caption="<?=$userHasNotRated?>">
                 </p>
              </form>
              <br/>
                <?php if ($userOwnsStudy == true || $userIsAuthorStudy == true): ?>


                    <a href="theory.php?s=<?=$study->id?>" class="btn btn-lg blue-hoki col-md-4 col-xs-5"><i class="fa fa-graduation-cap"></i> <?= $t->{'THEORY'}; ?> </a>
                    <a href="practice.php?s=<?=$study->id?>" class="btn btn-lg red-sunglo col-md-4 col-xs-5"><i class="fa fa-bolt"></i> <?= $t->{'PRACTICE'}; ?> </a>
                  <!-- <a href="#modalPurchase" class="btn btn-lg btn-success" title="Donate" data-toggle="modal"><i class="fa fa-usd"></i> DONATE </a> -->
               <?php else: ?>
                  <a href="#modalPurchase" class="btn btn-lg btn-success col-md-4 col-xs-12" title="Buy" data-toggle="modal"><i class="fa fa-usd"></i> <?= $t->{'BUY'}; ?> </a>
               <?php endif; ?>
               <br/><br/><br/>
             </div>

             <!--end col-md-8-->
             <div class="col-md-4">
               <div class="portlet sale-summary">
                 <div class="portlet-title">
                   <div class="caption">
                      <?= $t->{'Statistics'}; ?>
                   </div>
                 </div>
                 <div class="portlet-body">
                   <ul class="list-unstyled">
                     <li>
                       <span class="sale-info">
                       <?= $t->{'TOTAL PRACTICE SESSIONS'}; ?> <i class="fa fa-img-up"></i>
                       </span>
                       <span class="sale-num">
                       <?=$totalPracticeSessions;?>  </span>
                     </li>
                     <li>
                       <span class="sale-info">
                       <?= $t->{'PRACTICE PERFECT LINES'}; ?> <i class="fa fa-img-up"></i>
                       </span>
                       <span class="sale-num">
                       <?=$totalPracticePerfects;?>  </span>
                     </li>
                     <li>
                       <span class="sale-info">
                       <?= $t->{'TOTAL LINES PRACTICED'}; ?>  <i class="fa fa-img-down"></i>
                       </span>
                       <span class="sale-num">
                       <?=$totalLinesPracticed?>% </span>
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

<div id="modalPurchase" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?= $t->{'Purchase'}; ?> <?=$study->name?></h4>
      </div>
      <div class="modal-body">

        <ul class="chats">
                         <li class="in">
                           <!-- <img class="avatar" alt="" src="../../assets/admin/layout/img/avatar1.jpg"/> -->
                           <div class="message">
                             <span class="arrow">
                             </span>
                             <label>
                             <?=$study->author->fullName?> </label>
                             <span class="body">
                             <p><?=$study->monetization->detailsPayment->text?></span></p>
                           </div>
                         </li>
                       </ul>

                       <div class="portlet light">
                         <!-- STAT -->
                         <div class="row list-separated profile-stat">
                           <div class="col-md-4 col-sm-4 col-xs-6">
                             <div class="uppercase profile-stat-title">
                                <?=$variationsCount?>
                             </div>
                             <div class="uppercase profile-stat-text">
                                <?= $t->{'Variations'}; ?>
                             </div>
                           </div>
                           <div class="col-md-4 col-sm-4 col-xs-6">
                             <div class="uppercase profile-stat-title">
                                <?=$linesCount?>
                             </div>
                             <div class="uppercase profile-stat-text">
                                <?= $t->{'Lines'}; ?>
                             </div>
                           </div>
                           <div class="col-md-4 col-sm-4 col-xs-6">
                             <div class="uppercase profile-stat-title">
                                <?=$study->currencyAndPrice?>
                             </div>
                             <div class="uppercase profile-stat-text">
                                <?= $t->{'Investment'}; ?>
                             </div>
                           </div>
                         </div>
                         <!-- END STAT -->
                         <div>
                           <h4 class="profile-desc-title"><?=$study->typePayment?></h4>
                           <span class="profile-desc-text"> <?= $t->{'Please make the payment through the url below.'}; ?> </span>
                           <div class="margin-top-20 profile-desc-link">
                             <i class="fa fa-usd"></i>
                             <a href="<?=$study->monetization->detailsPayment->url?>" target="_blank"><?=$study->monetization->detailsPayment->url?></a>
                           </div>
                         </div>
                       </div>
                       <span class="label label-danger"><small><?= $t->{'Attention'}; ?></small></span>
                       <span> <small><?= $t->{'After payment confirmation, your purchase will be activated as soon as possible'}; ?>.</small></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
      </div>
    </div>
  </div>
</div>
<? include('../imports/footer.php'); ?>
<? include('../imports/metronic_core.php'); ?>
<script>
jQuery(document).ready(function() {
  // initiate layout and plugins
  Metronic.init(); // init metronic core components
  Layout.init(); // init current layout

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

  $(function(){
      $('#ratingStars').on('change',function(){
        var rating = $(this).val();
        console.log(rating);
        $.ajax({
            url: './action/details-rate.php',
            type: 'POST',
            data: {studyID: $("#studyID").val(),
                  rating: rating,
                  userID: $("#userID").val()},
            success: function (result) {
              var response = JSON.parse(result);

              if(response["status"] == "success"){
                progress = response["progress"];
               // console.log(response);
                toastr.success('<?= $t->{'Your rating has been saved!'}; ?>');
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
         $("#restartTheoryStats").click(function () {
           bootbox.dialog({
               message: "<?= $t->{'Are you sure you want to restart statistics? You will not be able to reverse this action!'}; ?>",
               title: "<?= $t->{'Restart theoretical stats'}; ?>",
               buttons: {
                 main: {
                   label: "<?= $t->{'YES'}; ?>",
                   className: "green",
                   callback: function() {

                     $.ajax({
                         url: './action/details-restart-theory-stats.php',
                         type: 'POST',
                         data: {studyID: $("#studyID").val(),
                               userID: $("#userID").val()},
                         success: function (result) {
                           var response = JSON.parse(result);

                           if(response["status"] == "success"){
                             //mostrar toaster após reload
                             sessionStorage.setItem("Success","<?= $t->{'Your theoretical statistics were restarted!'}; ?>");
                             location.reload();
                           }else if(response["status"] == "error"){
                             toastr.warning('<?= $t->{'Error. Please, try again later.'}; ?>');
                           }
                         }, error: function (result) {
                             toastr.error('<?= $t->{'Error. Please, try again later.'}; ?>');
                         }
                     });

                   }
                 },
                 danger: {
                   label: "<?= $t->{'NO'}; ?>",
                   className: "red",
                   callback: function() {

                   }
                 }
               }
           });

         });
     });

     $(document).ready(function () {
           $("#restartPracticeStats").click(function () {
             bootbox.dialog({
                 message: "<?= $t->{'Are you sure you want to restart statistics? You will not be able to reverse this action!'}; ?>",
                 title: "<?= $t->{'Restart practical stats'}; ?>",
                 buttons: {
                   main: {
                     label: "<?= $t->{'YES'}; ?>",
                     className: "green",
                     callback: function() {

                       $.ajax({
                           url: './action/details-restart-practice-stats.php',
                           type: 'POST',
                           data: {studyID: $("#studyID").val(),
                                 userID: $("#userID").val()},
                           success: function (result) {
                             var response = JSON.parse(result);

                             if(response["status"] == "success"){
                               //mostrar toaster após reload
                               sessionStorage.setItem("Success","<?= $t->{'Your practical statistics were restarted!'}; ?>");
                               location.reload();
                             }else if(response["status"] == "error"){
                               toastr.warning('<?= $t->{'Error. Please, try again later.'}; ?>');
                             }
                           }, error: function (result) {
                               toastr.error('<?= $t->{'Error. Please, try again later.'}; ?>');
                           }
                       });

                     }
                   },
                   danger: {
                     label: "<?= $t->{'NO'}; ?>",
                     className: "red",
                     callback: function() {

                     }
                   }
                 }
             });

           });
       });

});
</script>
</body>
</html>
