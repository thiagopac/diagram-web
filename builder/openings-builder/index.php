<?
   // #INCLUDES
   require_once ('../lib/config.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings-builder' );
   include('../imports/header.php');
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
         <a href="./">Openings Builder</a>
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
                  <a href="details.php">
                    <div class="tile double bg-grey-cascade">
                      <div class="corner">
                      </div>
                      <div class="check">
                      </div>
                      <div class="tile-body">
                        <h3>Caro-Kann</h3><small>By: Jovanka Houska</small>
                        <p>
                           <div id="rateYo"></div>
                        </p>
                      </div>
                      <div class="tile-object">
                        <div class="number">
                           <small>Updated: 12:13PM, 22 Jan 17</small>
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
