<?
##INCLUDES
	require_once('../lib/config.php');
	require_once('../models/User.php');

#CONTROLE SESSAO
	fnInicia_Sessao('moderation-users');

#INPUTS
	$MSG = addslashes($_REQUEST['MSG']);

#INICIO LOGICA

	$userID = $_SESSION['USER']['ID'];

	User::$showDeleted = true;
	$user = new User();
	$arrUsers = $user->getAllUsers();

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
					<?= $t->{'Users'}; ?> <small></small>
					</h3>
					<a type="button" class="btn red" style="right: 15px; position: absolute; margin-top: -40px" href="new-user.php"><?= $t->{'New User'}; ?></a>
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
							 <a href="./users.php"><?= $t->{'Users'}; ?></a>
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

								<table class="table table-striped table-hover" id="table_users">
								<thead>
								<tr>
									<th>
										 #
									</th>
									<th>
										 <?= $t->{'Login'}; ?>
									</th>
									<th>
										<?= $t->{'Full Name'}; ?>
									</th>
									<th>
										<?= $t->{'Role'}; ?>
									</th>
									<th>
										<?= $t->{'Deleted'}; ?>
									</th>
									<th>
										 <?= $t->{'Actions'}; ?>
									</th>
								</tr>
								</thead>
								<tbody>
								<?
								foreach($arrUsers as $KEY => $user)
									{
									?>
									<tr>
										<td>
											 <?=$user->id?>
										</td>
										<td>
											<?=$user->login?>
										</td>
										<td>
											 <?=$user->fullName?>
										</td>
										<td>
											 <?=$strType = $user->typeUser == 1 ? $t->{'Admin'} : $t->{'User'} ;?>
										</td>
										<td>
											 <?=$strDeleted = $user->deleted == 1 ? $t->{'YES'} : $t->{'NO'} ;?>
										</td>
										<td>
											 <a href="edit-user.php?u=<?=$user->id?>"><?= $t->{'Edit'}; ?></a> | <a id="<?=$user->id?>" class="deleteUser"><?= $t->{'Delete'}; ?></a>
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

	$(document).ready(function () {
		if(sessionStorage.getItem("Success")){
				toastr.success(sessionStorage.getItem("Success"));
				sessionStorage.clear();
		}

		if(sessionStorage.getItem("Warning")){
				toastr.warning(sessionStorage.getItem("Warning"));
				sessionStorage.clear();
		}

		if(sessionStorage.getItem("Info")){
				toastr.info(sessionStorage.getItem("Info"));
				sessionStorage.clear();
		}

		if(sessionStorage.getItem("Error")){
				toastr.error(sessionStorage.getItem("Error"));
				sessionStorage.clear();
		}

	});

	$(document).ready(function () {
		$(".deleteUser").click(function () {

			var buttonTapped = $(this);

			bootbox.dialog({
					message: "<?= $t->{'Are you sure?'}; ?>",
					title: "<?= $t->{'Attention'}; ?>",
					buttons: {
						main: {
							label: "<?= $t->{'YES'}; ?>",
							className: "green",
							callback: function() {

								$.ajax({
										url: './action/del-user.php',
										type: 'POST',
										data: {user: buttonTapped.attr('id')},
										success: function (result) {
											var response = JSON.parse(result);

											if(response["status"] == "success"){
												//mostrar toaster após reload
												sessionStorage.setItem("Success","<?= $t->{'Saved changes!'}; ?>");
												location.reload();
											}else if(response["status"] == "error"){
												toastr.warning('<?= $t->{'Error. Please, try again later.'}; ?>');
											}
										}, error: function (result) {
												toastr.error('<?= $t->{'Error. Please, try again later.'}; ?>');
										}
								});

							}
						},
						danger: {
							label: "<?= $t->{'NO'}; ?>",
							className: "red",
							callback: function() {

							}
						}
					}
			});

		});
	});

	var table = $('#table_users');

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
					"szeroRecords": "<?= $t->{'No matching records found'}; ?>"
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
					"searchable": false,
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
