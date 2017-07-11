<?

	if(!ISSET($_GET['msg'])){
		$MSG = $MSG;
	}else{
		$MSG = $_GET['msg'];
	}

	if(!ISSET($_GET['success'])){
		$SUCCESS = $SUCCESS;
	}else{
		$SUCCESS = $_GET['success'];
	}

	if(!ISSET($_GET['error'])){
		$ERROR = $ERROR;
	}else{
		$ERROR = $_GET['error'];
	}

?>

<?php if ($MSG != ''): ?>

<div class="alert alert-info display fade in">
   <button class="close" data-close="alert" data-dismiss="alert"></button>
   <i class="fa-lg fa fa-info-circle"></i>
   <?=$MSG?>
</div>

<?php endif; ?>


<?php if ($ERROR != ''): ?>

	<div class="alert alert-danger display fade in">
	   <button class="close" data-close="alert" data-dismiss="alert"></button>
	   <i class="fa-lg fa fa-warning"></i>
	   <?=$ERROR?>
	</div>

<?php endif; ?>

<?php if ($SUCCESS != ''): ?>

	<div class="alert alert-success display fade in">
	   <button class="close" data-close="alert" data-dismiss="alert"></button>
	   <i class="fa-lg fa fa-check"></i>
	   <?=$SUCCESS?>
	</div>

<?php endif; ?>
