<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');
   require_once('../models/User.php');
   require_once('../models/StudyRating.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings-builder' );

   $authorID = $_SESSION['USER']['ID'];

   Study::$showDeleted = false;
   Study::$orderBy = " ORDER BY DIN_LAST_UPDATE DESC";

   $study = new Study();
   $arrStudies = $study->getAllStudiesForAuthor($authorID);

   $user = new User();

   include('../imports/header.php');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            <?= $t->{'Openings Builder'}; ?><small></small>
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
       </li>
     </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
	 <? include('../imports/alert.php'); ?>

   <div class="row">
   				<div class="col-md-12">
   					<!-- BEGIN Portlet PORTLET-->
   					<div class="portlet">
   						<div class="portlet-title">
   							<div class="caption">
   								<?= $t->{'Your openings'}; ?>
   							</div>
   							<div class="tools">
   								<a href="javascript:;" class="collapse" data-original-title="" title="">
   								</a>
   							</div>
   						</div>
   						<div class="portlet-body">
                <div class="tiles">

                  <?foreach($arrStudies as $KEY => $study){ ?>

                    <?php
                        $studyRating = new StudyRating();
                        $studyRatingAverage = $studyRating->getAverageStudyRatingForStudy($study->id);

                        $study->author = $user->getUserWithId($study->authorID);
                     ?>

                  <a href="details.php?s=<?=$study->id?>">
                    <div class="tile double bg-red-sunglo double">

                      <div class="tile-body">
                        <h4 style="line-height: 16px; !important"><?=$study->name?></h4><small><?= $t->{'By'}; ?>: <?=$study->author->fullName?></small>
                        <p>
                          <!--  rate-->
                          <div style="margin-top:10px;">
                            <input id="input-1" name="input-1" class="rating" data-size="xs" data-min="0" data-max="5" value="<?=$studyRatingAverage?>" data-readonly="true" data-show-clear="false" data-show-caption="false">
                          </div>
                        </p>
                      </div>
                      <div class="tile-object">
                        <div class="number">
                           <small><?= $t->{'Updated'}; ?>: <?=$study->dateUpdated?></small>
                        </div>
                      </div>
                    </div>
                  </a>

                  <!-- FIM VIEW OBJETO ESTUDO -->
                  <?}?> <!-- FIM foreach  -->

                  <?php if (count($arrStudies) < 1): ?>
                    <p class="text-center"><?= $t->{'You have not created any studies yet.'}; ?></p>
                  <?php endif; ?>

                 </div>
   						</div>
   					</div>
   					<!-- END Portlet PORTLET-->
   				</div>

   			</div>

        <div class="row">
        				<div class="col-md-12">
        					<!-- BEGIN Portlet PORTLET-->
        					<div class="portlet">
        						<div class="portlet-title">
        							<div class="caption">

        							</div>
        						</div>
        						<div class="portlet-body">

                     <div class="tiles">
                       <a href="create-study.php">
                         <div class="tile double bg-green-meadow">
                           <div class="tile-body">
                             <h3 style="line-height: 22px; !important"><?= $t->{'New opening study'}; ?></h3>

                           </div>
                           <div class="tile-object">
                             <div class="number">
                                  <div style="opacity:0.2"><i class="fa fa-file-o fa-4x" aria-hidden="true"></i></div>
                             </div>
                           </div>
                         </div>
                       </a>
                      </div>


        						</div>
        					</div>
        					<!-- END Portlet PORTLET-->
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

   });
</script>
</body>
</html>
