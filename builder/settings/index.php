<?
   // #INCLUDES
   require_once ('../lib/config.php');

   // CONTROLE SESSAO
   include('../imports/header.php');
   ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">

   <div class="row">
     <div class="col-md-12 page-404">
       <div class="number">
          404
       </div>
       <div class="details">
         <h3>Oops! You're lost.</h3>
         <p>
            We can not find the page you're looking for.<br/>
           <a onclick="window.history.go(-1)">
           Return </a>
           to the last page you were.
         </p>
       </div>
     </div>
   </div>

<!-- END CONTENT -->
</div>
<? include('../imports/footer.php'); ?>
</body>
</html>
