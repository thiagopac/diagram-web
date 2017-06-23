<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/Acquisition.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings' );

   require_once('../imports/header.php');

   #BUSCAR TODAS AS VARIÁVEIS GET
   	$MSG = addslashes($_REQUEST['MSG']);

    $userID = $_SESSION['USER']['ID'];

    $study = new Study();
    $arrStudies = $study->getAllStudies();

    // var_dump($arrStudies);
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
         <a href="./">Openings</a>
       </li>
     </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
	 <? include('../imports/alert.php'); ?>

<div class="tiles">


  <?foreach($arrStudies as $KEY => $study){ ?> <!-- INCÍCIO foreach  -->
    <?php
          $acquisition = new Acquisition();
          $acquisition = $acquisition->getAcquisitionForUserAndStudy($userID, $study->id);

          $userHasStudy = $acquisition->idStudy;

          $color = "";

          $selected = "";

          if ($userHasStudy) {
            $color = "bg-red-sunglo";
            $selected = "selected";
          }else{
            $color = "bg-grey-cascade";
          }
     ?>

  <!-- INÍCIO VIEW OBJETO ESTUDO -->
  <a href="details.php?s=<?=$study->id?>">
    <div class="tile double <?=$selected?> <?=$color?>">

<!-- só mostrar o V se o usuário já adquiriu o estudo -->
      <?php if ($userHasStudy): ?>
        <div class="corner">
        </div>
        <div class="check">
        </div>
      <?php endif; ?>

      <div class="tile-body">
        <h4><?=$study->name?></h4><small>By: <?=$study->authorFullName?></small>
           <!--  rate-->
           <div style="margin-top:10px;">
             <input id="input-1" name="input-1" class="rating" data-size="xs" data-min="0" data-max="5" value="4.5" data-readonly="true" data-show-clear="false" data-show-caption="false">
           </div>
      </div>
      <div class="tile-object">
        <div class="name">
          85%
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
