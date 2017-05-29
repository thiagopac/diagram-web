<?
##INCLUDES.
	require_once('../lib/config.php');

#CONTROLE SESSAO
	fnInicia_Sessao('administrators');

#INPUTS
	$MSG = addslashes($_REQUEST['msg']);
	$ID  = (int)$_REQUEST['id'];

#INICIO LOGICA
	$DB = fnDBConn();

	if ($ID == -1)
		{
		$GRANTS = '|';
		foreach($MENU_GRANT as $ROW)
			$GRANTS .= $ROW[0].'|';

		$SQL = "INSERT INTO USER (ID_TYPE_USER, LOGIN, PASSWORD, FIRSTNAME, LASTNAME, GRANTS, STATUS, DIN) VALUES (1, NULL, NULL, NULL, '{$GRANTS}', 0, NOW())";
		$RET = fnDB_DO_EXEC($DB,$SQL);
		$ID = (int)$RET[1];
		if ($ID == 0)
			die('Falha geral. ID nao foi criado');
		}

	$SQL = "SELECT * FROM USUARIO WHERE ID = $ID";
	$RET = fnDB_DO_SELECT($DB,$SQL);

	include('../imports/header.php');
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
					Dados do usário <small></small>
					</h3>

					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->

					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption"></div>
							<div class="tools">
								 <a href="javascript:;" class="collapse">
								 </a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form method="post" action="../exec/" id="form_sample_2" class="form-horizontal" novalidate="novalidate">
							<input type="hidden" name="e" id="e" value="adm_edit" />
							<input type="hidden" name="id" id="id" value="<?=$ID?>" />
								<div class="form-body">
									<? if ($MSG != '') { ?>
									<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
									<? } ?>
									<div class="form-group">
										<label class="control-label col-md-3">Nome</label>
										<div class="col-md-4">
											<div class="input-icon right">
												<input type="text" class="form-control" name="nome" aria-required="true" aria-invalid="false" value="<?=$RET['NOME']?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">Login</span>
										</label>
										<div class="col-md-4">
											<div class="input-icon right">
												<input type="text" class="form-control" name="login" aria-required="true" aria-invalid="true" value="<?=$RET['LOGIN']?>">
											</div>
										</div>
									</div>

									<div class="form-group last password-strength">
										<label class="control-label col-md-3">Senha</label>
										<div class="col-md-4">
											<input type="password" class="form-control" name="password" id="password_strength">
										</div>
										<label for="chkShowPassword" style="margin:5px;">
							                <input type="checkbox" id="chkShowPassword" />
							                Mostrar senha
							             </label>
									</div>
								</div>



								<div class="form-actions fluid">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Salvar</button>
										<button type="button" class="btn default" onClick="parent.location='index.php';">Voltar</button>
									</div>
								</div>
							</form>
							<!-- END FORM-->
						</div>
					</div>
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
           ComponentsFormTools.init();
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
