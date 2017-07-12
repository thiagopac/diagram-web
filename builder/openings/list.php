<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/Acquisition.php');
   require_once('../models/StudyRating.php');
   require_once('../models/StudyProgressTheory.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings' );

   #BUSCAR TODAS AS VARIÁVEIS GET
   	$MSG = addslashes($_REQUEST['MSG']);

    $userID = $_SESSION['USER']['ID'];

    Study::$showDeleted = false;
    $study = new Study();
    $arrStudies = $study->getAllActiveStudies();

    $studyProgressTheory = new StudyProgressTheory();

    // var_dump($arrStudies);
    require_once('../imports/header.php');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            Openings<small></small>
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
       </li>
     </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
	 <? include('../imports/alert.php'); ?>

<div class="tiles">


  <?foreach($arrStudies as $KEY => $study){ ?> <!-- INCÍCIO foreach  -->
        <?php
              $userOwnsStudy = $study->checkIfUserHasStudy($userID, $study->id);

              $color = "";

              $selected = "";

              if ($userOwnsStudy == true) {
                $color = "bg-red-sunglo";
                $selected = "selected";
              }else{
                $color = "bg-grey-cascade";
              }

                $studyRating = new StudyRating();
                $studyRating = $studyRating->getAverageStudyRatingForStudy($study->id);

                $progress = $studyProgressTheory->getTotalProgressStudyProgressTheoryForUserAndStudy($userID, $study->id);

                $strProgress = $userOwnsStudy == true ? $progress."%" : "";

         ?>

  <!-- INÍCIO VIEW OBJETO ESTUDO -->
  <a href="details.php?s=<?=$study->id?>">
    <div class="tile double <?=$selected?> <?=$color?>">

<!-- só mostrar o V se o usuário já adquiriu o estudo -->
      <?php if ($userOwnsStudy == true): ?>
        <div class="corner">
        </div>
        <div class="check">
        </div>
      <?php endif; ?>

      <div class="tile-body">
        <h4><?=$study->name?></h4><small>By: <?=$study->authorFullName?></small>
           <!--  rate-->
           <div style="margin-top:10px;">
             <input id="input-1" name="input-1" class="rating" data-size="xs" data-min="0" data-max="5" value="<?=$studyRating->rating?>" data-readonly="true" data-show-clear="false" data-show-caption="false">
           </div>
      </div>
      <div class="tile-object">
        <div class="name">
          <?=$strProgress?>
        </div>
        <div class="number">
           <small>Updated: <?=$study->dateUpdated?></small>
        </div>
      </div>
    </div>
  </a>

  <!-- FIM VIEW OBJETO ESTUDO -->

  <?}?> <!-- FIM foreach  -->

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

  // $('#input-1').rating({displayOnly: true, step: 0.5});

});
</script>
</body>
</html>
