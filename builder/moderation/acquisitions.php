<?
##INCLUDES
	require_once('../lib/config.php');
	require_once('../models/Acquisition.php');
	require_once('../models/Study.php');
	require_once('../models/User.php');

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-acquisitions');

#INPUTS
	$MSG = addslashes($_REQUEST['MSG']);

#INICIO LOGICA

	$userID = $_SESSION['USER']['ID'];

	Acquisition::$showDeleted = true;

	$acquisition = new Acquisition();
	$arrAcquisition = $acquisition->getAllAcquisitions();

	$study = new Study();
	$user = new User();

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
					Acquisitions <small></small>
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
	             <a href="./acquisitions.php">Acquisitions</a>
	          </li>
	       </ul>
	    </div>
			<!-- END PAGE HEADER-->

<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet gren">


						<div class="portlet-body">
							<div class="table-responsive">
								<? if (strlen($MSG) > 0 ) { ?>
								<div class="alert alert-danger display">
										<button class="close" data-close="alert"></button>
										<?=$MSG?>
									</div>
								<? } ?>

								<table class="table table-striped table-hover" id="table_acquisitions">
								<thead>
								<tr>
									<th>
										 #
									</th>
									<th>
										User
									</th>
									<th>
										 Study
									</th>
									<th>
										Date
									</th>
									<th>
										Approved
									</th>
									<th>
										Deleted
									</th>
									<th>
										 Actions
									</th>
								</tr>
								</thead>
								<tbody>
								<?
								foreach($arrAcquisition as $KEY => $acquisition)
									{
									?>
									<tr>
										<td>
											 <?=$acquisition->id?>
										</td>
										<td>
											 <? $user = $user->getUserWithId($acquisition->userID); echo $user->fullName; ?>
										</td>
										<td>
											<? $study = $study->getStudyWithID($acquisition->studyID); echo $study->name; ?>
										</td>
										<td>
											 <?=$acquisition->dateCreated?>
										</td>
										<td>
											 <?=$acquisition->active == true ? "YES" : "<span style='color:red'><strong>NOT YET</strong></span>"; ?>
										</td>
										<td>
											 <?=$acquisition->deleted == true ? "YES" : "NO"; ?>
										</td>
										<td>
											 <a href="edit-acquisition.php?a=<?=$acquisition->id?>">Edit</a> | <a href="../exec/?e=adm_del&a=<?=$acquisition->id?>" class="confirmation">Remove</a>
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
        });

    $('.confirmation').on('click', function () {
        return confirm('Tem certeza?');
    });

		var table = $('#table_acquisitions');

		// begin first table
		table.dataTable({

				// Internationalisation. For more info refer to http://datatables.net/manual/i18n
				"language": {
						"aria": {
								"sortAscending": ": activate to sort column ascending",
								"sortDescending": ": activate to sort column descending"
						},
						"emptyTable": "No data available in table",
						"info": "Showing _START_ to _END_ of _TOTAL_ entries",
						"infoEmpty": "No entries found",
						"infoFiltered": "(filtered1 from _MAX_ total entries)",
						"lengthMenu": "Show _MENU_ entries",
						"search": "Search:",
						"zeroRecords": "No matching records found"
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
						"orderable": true
				}, {
						"orderable": true
				}, {
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
						"search": "Search: ",
						"lengthMenu": "  _MENU_ records",
						"paginate": {
								"previous":"Prev",
								"next": "Next",
								"last": "Last",
								"first": "First"
						}
				},
				"columnDefs": [{  // set default column settings
						'orderable': false,
						'targets': [0]
				}, {
						"searchable": false,
						"targets": [0]
				}],
				"order": [
						[1, "asc"]
				] // set first column as a default sort by asc
		});

 </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
