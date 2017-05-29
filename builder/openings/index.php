<?
   // #INCLUDES
   require_once ('../lib/config.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings' );
   include('../imports/header.php');
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
  <a href="details.php">
    <div class="tile selected double bg-grey-cascade">
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
        <div class="name">
          85%
        </div>
        <div class="number">
           <small>Updated: 12:13PM, 22 Jan 17</small>
        </div>
      </div>
    </div>
  </a>
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