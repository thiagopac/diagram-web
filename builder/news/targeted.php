<?
   // #INCLUDES
   require_once ('../lib/config.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ('news-targeted');
   include('../imports/header.php');
   ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">

	 <? include('../imports/alert.php'); ?>

	 <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            <?= $t->{'Targeted News'}; ?> <small></small>
         </h3>
      </div>
   </div>
   <div class="page-bar">
      <ul class="page-breadcrumb">
         <li>
            <i class="fa fa-home"></i>
            <a href="#"><?= $t->{'News'}; ?></a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="targeted.php"><?= $t->{'Targeted News'}; ?></a>
         </li>
      </ul>
   </div>
	 <!-- END PAGE TITLE & BREADCRUMB-->

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
