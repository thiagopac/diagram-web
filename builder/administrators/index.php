<?
##INCLUDES
	require_once('../lib/config.php');

#CONTROLE SESSAO
	fnInicia_Sessao('administrators');

#INPUTS
	$MSG = addslashes($_REQUEST['MSG']);

#INICIO LOGICA
	$DB = fnDBConn();
	$SQL = "SELECT * FROM USER WHERE ID_TYPE_USER = 1 AND STATUS = 1 ORDER BY FIRSTNAME";
	$RET = fnDB_DO_SELECT_WHILE($DB,$SQL);

	include('../imports/header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">

			<? include('../imports/alert.php'); ?>

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Administrators <small></small>
					</h3>
					<button type="button" class="btn red" style="right: 15px; position: absolute; margin-top: -40px" onClick="parent.location='editar.php?id=-1'">Novo Usuário</button>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->

<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption"></div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>

						<div class="portlet-body">
							<div class="table-responsive">
								<? if (strlen($MSG) > 0 ) { ?>
								<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
								<? } ?>

								<table class="table">
								<thead>
								<tr>
									<th>
										 ID Usuário
									</th>
									<th>
										 Nome
									</th>
									<th>
										 Login
									</th>
									<th>
										 Ações
									</th>
								</tr>
								</thead>
								<tbody>
								<?
								foreach($RET as $KEY => $ROW)
									{
									?>
									<tr>
										<td>
											 <?=$ROW['ID']?>
										</td>
										<td>
											 <?=$ROW['FIRSTNAME']?>
										</td>
										<td>
											 <?=$ROW['LOGIN']?>
										</td>
										<td>
											 <a href="edit.php?id=<?=(int)$ROW['ID']?>">Editar</a> | <a href="../exec/?e=adm_del&id=<?=(int)$ROW['ID']?>" class="confirmation">Apagar</a>
										</td>
									</tr>
									<?
									}
								?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->

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

    $('.confirmation').on('click', function () {
        return confirm('Tem certeza?');
    });

 </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
