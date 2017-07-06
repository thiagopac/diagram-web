<?
   // #INCLUDES
   require_once ('../lib/config.php');
   require_once('../models/Study.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings-builder' );

   include('../imports/header.php');

   $authorID = $_SESSION['USER']['ID'];

   $study = new Study();
   $arrStudies = $study->getAllStudiesForAuthor($authorID);
   ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            Openings Builder<small></small>
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
         <a href="./list.php">Builder</a>
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
   								Your openings
   							</div>
   							<div class="tools">
   								<a href="javascript:;" class="collapse" data-original-title="" title="">
   								</a>
   								<a href="javascript:;" class="reload" data-original-title="" title="">
   								</a>
   								<a href="" class="fullscreen" data-original-title="" title="">
   								</a>
   							</div>
   						</div>
   						<div class="portlet-body">
                <div class="tiles">

                  <?foreach($arrStudies as $KEY => $study){ ?> <!-- INCÍCIO foreach  -->
                    <!-- INÍCIO VIEW OBJETO ESTUDO -->

                  <a href="details.php?s=<?=$study->id?>">
                    <div class="tile double bg-grey-cascade double">

                      <div class="tile-body">
                        <h4><?=$study->name?></h4><small>By: <?=$study->authorFullName?></small>
                        <p>
                          <!--  rate-->
                          <div style="margin-top:10px;">
                            <input id="input-1" name="input-1" class="rating" data-size="xs" data-min="0" data-max="5" value="4.5" data-readonly="true" data-show-clear="false" data-show-caption="false">
                          </div>
                        </p>
                      </div>
                      <div class="tile-object">
                        <div class="number">
                           <small>Updated: <?=$study->dateUpdated?></small>
                        </div>
                      </div>
                    </div>
                  </a>

                  <!-- FIM VIEW OBJETO ESTUDO -->
                  <?}?> <!-- FIM foreach  -->

                  <?php if (count($arrStudies) < 1): ?>
                    <p class="text-center">You have not created any studies yet.</p>
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
                         <div class="tile double bg-red">
                           <div class="tile-body">
                             <h3>New opening study</h3>

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

   $("#rateYo").rateYo({
      starWidth: "20px",
      normalFill: "#6a6a6a",
      ratedFill: "#ffffff",
      rating: 4.5,
      halfStar: true,
      readOnly: true
    }).on("rateyo.set", function (e, data) {
                console.log("The rating is set to " + data.rating + "!");
    });

   });
</script>
</body>
</html>
