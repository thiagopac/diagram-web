<?
##INCLUDES
	require_once('../lib/config.php');
	require_once('../models/StudyAdministration.php');
	require_once('../models/Study.php');

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-inbox');

	include('../imports/header.php');

#INPUTS
	$MSG = addslashes($_REQUEST['MSG']);

#INICIO LOGICA

	$userID = $_SESSION['USER']['ID'];

	StudyAdministration::$showDeleted = false;
	StudyAdministration::$orderBy = " ORDER BY OSADM.DIN DESC";

	$studyAdministration = new StudyAdministration();
	$arrStudyAdministrations = $studyAdministration->getAllStudyAdministrationsForAuthor($userID);

	$study= new Study();
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">

			<? include('../imports/alert.php'); ?>

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					<?= $t->{'Inbox'}; ?> <small></small>
					</h3>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<div class="page-bar">
				 <ul class="page-breadcrumb">
					 <li>
					 	 <i class="fa fa-home"></i>
					 	 <a href="#"><?= $t->{'Moderation'}; ?></a>
					 	 <i class="fa fa-angle-right"></i>
					 </li>
						<li>
							 <a href="./inbox.php"><?= $t->{'Inbox'}; ?></a>
						</li>
				 </ul>
			</div>
			<!-- END PAGE HEADER-->

<!-- BEGIN SAMPLE TABLE PORTLET-->
<p><label> <?= $t->{'Here you will receive all administrative messages about your studies. Updates, news, suggestions and warnings for corrections will be concentrated here.'}; ?></label><p>
					<div class="portlet gren">

						<div class="portlet-body">
							<div class="table-responsive">
								<? if (strlen($MSG) > 0 ) { ?>
								<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
								<? } ?>

								<table class="table table-hover" id="table_administrators">
								<thead>
								<tr>
									<th>
										<?= $t->{'Study'}; ?>
									</th>
									<th>
										<?= $t->{'Date'}; ?>
									</th>
									<th>
										<?= $t->{'Message'}; ?>
									</th>
								</tr>
								</thead>
								<tbody>
								<?
								foreach($arrStudyAdministrations as $KEY => $studyAdministration) { ?>

									<?php $studyAdministration->study = $study->getStudyWithID($studyAdministration->studyID); ?>
									<tr class="<? $read = $studyAdministration->read == '0' ? "info" : ""; echo $read; ?>">
										<td>
											 <a href="message.php?m=<?=$studyAdministration->id?>">
 													<?=$studyAdministration->study->name?>
 										 	</a>
										</td>
										<td>
											<a href="message.php?m=<?=$studyAdministration->id?>">
													<?=fnDateDBtoVisual($studyAdministration->dateCreated)?>
										 	</a>
										</td>
										<td>
											<a href="message.php?m=<?=$studyAdministration->id?>">
													<?=substr($studyAdministration->message, 0, 100)."..." ?>
										 	</a>
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
	<!-- END CONTENT -->

<? include('../imports/footer.php'); ?>
<? include('../imports/metronic_core.php'); ?>
<script>
jQuery(document).ready(function() {
// initiate layout and plugins
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	QuickSidebar.init() // init quick sidebar
	// ComponentsFormTools.init();

	var table = $('#table_administrators');

	// begin first table
	table.dataTable({

			// Internationalisation. For more info refer to http://datatables.net/manual/i18n
			"language": {
					"aria": {
							"sortAscending": ": activate to sort column ascending",
							"sortDescending": ": activate to sort column descending"
					},
					"emptyTable": "<?= $t->{'No data available in table'}; ?>",
					"info": "<?= $t->{'Showing'}; ?> _START_ <?= $t->{'to'}; ?> _END_ <?= $t->{'of'}; ?> _TOTAL_ <?= $t->{'entries'}; ?>",
					"infoEmpty": "<?= $t->{'No entries found'}; ?>",
					"infoFiltered": "(filtered1 from _MAX_ total entries)",
					"lengthMenu": "Show _MENU_ entries",
					"search": "<?= $t->{'Search'}; ?>:",
					"zeroRecords": "<?= $t->{'No matching records found'}; ?>"
			},

			// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
			// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
			// So when dropdowns used the scrollable div should be removed.
			// "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

			"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

			"columns": [{
					"orderable": true
			}, {
					"orderable": true
			}, {
					"orderable": false
			}],
			"lengthMenu": [
					[20, 50, 100, -1],
					[20, 50, 100, "All"] // change per page values here
			],
			// set the initial value
			"pageLength": 20,
			"pagingType": "bootstrap_full_number",
			"language": {
					"search": "<?= $t->{'Search'}; ?>: ",
					"lengthMenu": "  _MENU_ <?= $t->{'records'}; ?>",
					"paginate": {
							"previous":"<?= $t->{'Prev'}; ?>",
							"next": "<?= $t->{'Next'}; ?>",
							"last": "<?= $t->{'Last'}; ?>",
							"first": "<?= $t->{'First'}; ?>"
					}
			},
			"columnDefs": [{  // set default column settings
					'orderable': false,
					'targets': [0]
			}, {
					"searchable": true,
					"targets": [0]
			}],
			"order": [
					[1, "asc"]
			] // set first column as a default sort by asc
	});

});
 </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
