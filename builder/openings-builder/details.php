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
            Caro-Kann<small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="./">Openings Builder</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="details.php">Caro-Kann</a>
         </li>
      </ul>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <? include('../imports/alert.php'); ?>
   <!-- BEGIN PAGE TITLE AND DESCRIPTION -->
   <!-- END BEGIN PAGE TITLE AND DESCRIPTION -->
   <div class="row profile">
      <div class="col-md-12">
         <!--BEGIN TABS-->
         <div class="row">
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-9 profile-info" style="text-align:justify;">
                     <p>
                       A defesa Caro-Kann é uma das mais sólidas respostas ao lance 1.e4 das brancas. Classificada como abertura semi-aberta, a defesa  leva este nome em homenagem o enxadrista britânico Horatio Caro e o austríaco Marcus Kann que analisaram a abertura em 1886.
                     </p>
                     <p>
                        Este estudo consiste na preparação das linhas mais populares da defesa Caro-Kann. As linhas aqui preparadas conseguem igualar a posição rapidamente, garantindo uma posição sólida, um meio jogo bastante equilibrado, dando ao jogador de pretas a possibulidade de chegar ao final com boas vantagens. Todas as linhas deste estudo foram retiradas do livro <em>Play the Caro-Kann</em>, da Mestre Internacional Jovanka Houska.
                     </p>
                     <ul class="list-inline">
                        <li>
                           <i class="fa fa-calendar"></i> 22 Jan 2017
                        </li>
                        <li>
                           <i class="fa fa-briefcase"></i> Jovanka Houska
                        </li>
                        <li>
                           <i class="fa fa-list-ol"></i> 13 Variations & 44 Lines
                        </li>
                        <li>
                           <i class="fa fa-usd"></i>Free
                        </li>
                     </ul>
                  </div>
                  <!--end col-md-8-->
                  <div class="col-md-3">
                     <div class="portlet sale-summary">
                        <div class="portlet-title">
                           <div class="caption">
                              Statistics
                           </div>
                        </div>
                        <div class="portlet-body">
                          <small>This study does not have statistical data yet.</small>
                        </div>
                     </div>
                  </div>
                  <!--end col-md-4-->
               </div>
               <br />
               <a href="theory.php" class="btn btn-lg blue-hoki"><i class="fa fa-graduation-cap"></i> Develop the THEORY</a>
               <a href="practice.php" class="btn btn-lg red-sunglo"><i class="fa fa-bolt"></i> Develop the PRACTICE</a>
               <a href="edit-study.php" class="btn btn-lg btn-success"><i class="fa fa-file-text-o"></i> Edit INFO</a>
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
