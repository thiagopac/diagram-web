<?
##INCLUDES.
	require_once('../lib/config.php');
	require_once('../models/User.php');

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-users');
	include('../imports/header.php');

#INPUTS
	$MSG = addslashes($_REQUEST['msg']);
	$paramUser  = (int)$_REQUEST['u'];

	$user = new User();
	$user = $user->getUserWithId($paramUser);
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">

			<? include('../imports/alert.php'); ?>

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Edit User <small></small>
					</h3>

					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<div class="page-bar">
				 <ul class="page-breadcrumb">
					 <li>
							<i class="fa fa-home"></i>
							<a href="#">Moderation</a>
							<i class="fa fa-angle-right"></i>
					 </li>
						<li>
							 <a href="./users.php">Users</a>
							 <i class="fa fa-angle-right"></i>
						</li>
						<li>
							 <a href="edit-user.php">Edit User</a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet gren">
						<div class="portlet-title">
							<div class="caption">User Details</div>
							</div>

						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form method="post" action="../exec/" id="form_sample_2" class="form-horizontal" novalidate="novalidate">
							<input type="hidden" name="e" id="e" value="adm_edit" />
							<input type="hidden" name="id" id="id" value="<?=$user->id?>" />
								<div class="form-body">
									<? if ($MSG != '') { ?>
									<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
									<? } ?>
									<div class="form-group">
										<label class="control-label col-md-3">Full Name</label>
										<div class="col-md-2">
											<div class="input-icon right">
												<input type="text" class="form-control" name="firstName" aria-required="true" aria-invalid="false" value="<?=$user->firstName?>">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input-icon right">
												<input type="text" class="form-control" name="lastName" aria-required="true" aria-invalid="false" value="<?=$user->lastName?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">Login</span>
										</label>
										<div class="col-md-4">
											<div class="input-icon right">
												<input type="text" class="form-control" name="login" aria-required="true" aria-invalid="true" value="<?=$user->login?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">ELO Fide</span>
										</label>
										<div class="col-md-4">
											<div class="input-icon right">
												<input type="text" class="form-control" name="login" aria-required="true" aria-invalid="true" value="<?=$user->eloFide?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">User status</span>
										</label>
										<div class="col-md-4">
											<div class="input-icon right">
												<select class="form-control" name="select">
													<?php $selectedInactive = ($user->status == "0") ? "selected" : null;?>
													<?php $selectedActive = ($user->status == "1") ? "selected" : null;?>
													 <option value="0" <?=$selectedInactive?>>Inactive</option>
													 <option value="1" <?=$selectedActive?>>Active</option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group last password-strength">
										<label class="control-label col-md-3">Password</label>
										<div class="col-md-4">
											<input type="password" class="form-control" name="password" id="password_strength">
										</div>
										<label for="chkShowPassword" style="margin:5px;">
							                <input type="checkbox" id="chkShowPassword" />
							                Show password
							             </label>
									</div>
								</div>


								<div class="form-actions fluid">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Salvar</button>
										<button type="button" class="btn default" onClick="window.history.go(-1); return false;">Voltar</button>
									</div>
								</div>
							</form>
							<!-- END FORM-->
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
			Layout.init(); // init current layout
			QuickSidebar.init() // init quick sidebar

        });

        $(function () {
            $("#chkShowPassword").bind("click", function () {
                var txtPassword = $("[id*=password_strength]");
                if ($(this).is(":checked")) {
                    txtPassword.after('<input onchange = "PasswordChanged(this);" id = "txt_' + txtPassword.attr("id") + '" class="form-control" name="password" type = "text" value = "' + txtPassword.val() + '" />');
                    txtPassword.hide();
                } else {
                    txtPassword.val(txtPassword.next().val());
                    txtPassword.next().remove();
                    txtPassword.show();
                }
            });
        });
        function PasswordChanged(txt) {
            $(txt).prev().val($(txt).val());
        }
    </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
