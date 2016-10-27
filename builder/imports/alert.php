<?

if(!ISSET($_GET['msg'])){
	$MSG = $MSG;
}else{
	$MSG = $_GET['msg'];
}

 if ($MSG != '') { ?>
<div class="alert alert-danger display">
   <button class="close" data-close="alert"></button>
   <i class="fa-lg fa fa-warning"></i>
   <?=$MSG?>
</div>
<? } ?>
