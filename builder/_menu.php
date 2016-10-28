	<!-- BEGIN SIDEBAR -->
  <?
		$GLOBALS['rootpath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));

    // echo $rootpath;
	?>
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper hidden-xs">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search" action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<!--div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div-->
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<? if (fnVerifica_Grant('dashboard')) { ?>
				<li class="last <? if ($MENU_ATIVO == 'dashboard') echo 'active'; ?>">
					<a href="<?=$rootpath?>/dashboard/">
					<i class="icon-home"></i>
					<span class="title">Resumo</span>
					<span class="selected"></span>
					</a>
				</li>
				<? } ?>
				<? if (fnVerifica_Grant('administrators')) { ?>
				<li class="last <? if ($MENU_ATIVO == 'administrators') echo 'active'; ?>">
					<a href="<?=$rootpath?>/administrators/">
					<i class="icon-user"></i>
					<span class="title">Administradores</span>
					<span class="selected"></span>
					</a>
				</li>
				<? } ?>
				<? if (fnVerifica_Grant('audit')) { ?>
				<li class="last <? if ($MENU_ATIVO == 'audit') echo 'active'; ?>">
					<a href="<?=$rootpath?>/audit/">
					<i class="icon-briefcase"></i>
					<span class="title">Auditoria</span>
					<span class="selected"></span>
					</a>
				</li>
				<? } ?>
				<? if (fnVerifica_Grant('settings')) { ?>
				<li class="last <? if ($MENU_ATIVO == 'settings') echo 'active'; ?>">
					<a href="<?=$rootpath?>/settings/">
					<i class="fa fa-cogs"></i>
					<span class="title">Configurações</span>
					<span class="selected"></span>
					</a>
				</li>
				<? } ?>
				<? if ((fnVerifica_Grant('buildpgn')) || (fnVerifica_Grant('buildfen')) || (fnVerifica_Grant('listboards'))){ ?>
				<li class="last <? if (in_array($MENU_ATIVO,array('buildpgn','buildfen','listboards'))) echo 'active'; ?>">
				<a href="javascript:;">
						<i class="fa fa-files-o"></i>
						<span class="title">Boards</span>
						<span class="arrow"></span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<!-- BEGIN REPORT OPTION -->
							<? if (fnVerifica_Grant('listboards')) { ?>
							<li class="<? if ($MENU_ATIVO == 'listboards') echo 'active'; ?>">
								<a href="<?=$rootpath?>/boards/list.php"><i class="fa fa-angle-right"></i>List boards</a>
							</li>
							<? } ?>
							<? if (fnVerifica_Grant('buildpgn')) { ?>
							<li class="<? if ($MENU_ATIVO == 'buildpgn') echo 'active'; ?>">
								<a href="<?=$rootpath?>/boards/buildpgn.php"><i class="fa fa-angle-right"></i>Build PGN</a>
							</li>
							<? } ?>
							<? if (fnVerifica_Grant('buildfen')) { ?>
							<li class="<? if ($MENU_ATIVO == 'buildfen') echo 'active'; ?>">
								<a href="<?=$rootpath?>/boards/buildfen.php"><i class="fa fa-angle-right"></i>Build FEN</a>
							</li>
							<? } ?>
						<!-- END REPORT OPTION -->
						</ul>
					</li>
				<? } ?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
