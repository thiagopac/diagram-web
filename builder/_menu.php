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
			<ul class="page-sidebar-menu page-sidebar-menu-closed" data-auto-scroll="true" data-slide-speed="200">
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
					<a href="<?=$rootpath?>/dashboard/dashboard.php">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					</a>
				</li>
				<? } ?>
        <? if (fnVerifica_Grant('news')) { ?>
				<li class="last <? if (($MENU_ATIVO == 'news-general') || ($MENU_ATIVO == 'news-targeted')) echo 'active'; ?>">
					<a href="<?=$rootpath?>/news/">
					<i class="icon-book-open"></i>
					<span class="title">News</span>
					<span class="selected"></span>
					</a>
          <ul class="sub-menu">
            <? if (fnVerifica_Grant('news-targeted')) { ?>
            <li class="<? if ($MENU_ATIVO == 'news-targeted') echo 'active'; ?>">
              <a href="<?=$rootpath?>/news/targeted.php"><i class="fa fa-angle-right"></i>Targeted News</a>
            </li>
            <? } ?>
            <? if (fnVerifica_Grant('news-general')) { ?>
            <li class="<? if ($MENU_ATIVO == 'news-general') echo 'active'; ?>">
              <a href="<?=$rootpath?>/news/general.php"><i class="fa fa-angle-right"></i>General News</a>
            </li>
            <? } ?>
          </ul>
				</li>
				<? } ?>
				<? if (fnVerifica_Grant('moderation')) { ?>
				<li class="last <? if ($MENU_ATIVO == 'moderation') echo 'active'; ?>">
        <li class="last <? if (($MENU_ATIVO == 'moderation') || ($MENU_ATIVO == 'moderation-users') || ($MENU_ATIVO == 'moderation-openings')  || ($MENU_ATIVO == 'moderation-inbox') || ($MENU_ATIVO == 'moderation-feedback') || ($MENU_ATIVO == 'moderation-acquisitions')) echo 'active'; ?>">
					<a href="<?=$rootpath?>/moderation/">
					<i class="icon-lock-open"></i>
					<span class="title">Moderation</span>
					<span class="selected"></span>
					</a>
          <ul class="sub-menu">
            <? if (fnVerifica_Grant('moderation-users')) { ?>
            <li class="<? if ($MENU_ATIVO == 'moderation-users') echo 'active'; ?>">
              <a href="<?=$rootpath?>/moderation/users.php"><i class="fa fa-angle-right"></i>Users</a>
            </li>
            <? } ?>
            <? if (fnVerifica_Grant('moderation-openings')) { ?>
            <li class="<? if ($MENU_ATIVO == 'moderation-openings') echo 'active'; ?>">
              <a href="<?=$rootpath?>/moderation/openings.php"><i class="fa fa-angle-right"></i>Openings</a>
            </li>
            <? } ?>
            <? if (fnVerifica_Grant('moderation-inbox')) { ?>
            <li class="<? if ($MENU_ATIVO == 'moderation-inbox') echo 'active'; ?>">
              <a href="<?=$rootpath?>/moderation/inbox.php"><i class="fa fa-angle-right"></i>Inbox</a>
            </li>
            <? } ?>
            <? if (fnVerifica_Grant('moderation-feedback')) { ?>
            <li class="<? if ($MENU_ATIVO == 'moderation-feedback') echo 'active'; ?>">
              <a href="<?=$rootpath?>/moderation/feedback.php"><i class="fa fa-angle-right"></i>Feedback</a>
            </li>
            <? } ?>
            <? if (fnVerifica_Grant('moderation-acquisitions')) { ?>
            <li class="<? if ($MENU_ATIVO == 'moderation-acquisitions') echo 'active'; ?>">
              <a href="<?=$rootpath?>/moderation/acquisitions.php"><i class="fa fa-angle-right"></i>Acquisitions</a>
            </li>
            <? } ?>
          </ul>
				</li>
				<? } ?>
				<? if (fnVerifica_Grant('audit')) { ?>
				<li class="last <? if ($MENU_ATIVO == 'audit') echo 'active'; ?>">
					<a href="<?=$rootpath?>/audit/list.php">
					<i class="icon-briefcase"></i>
					<span class="title">Audit</span>
					<span class="selected"></span>
					</a>
				</li>
				<? } ?>
				<? if (fnVerifica_Grant('settings')) { ?>
				<li class="last <? if ($MENU_ATIVO == 'settings') echo 'active'; ?>">
					<a href="<?=$rootpath?>/settings/settings.php">
					<i class="icon-settings"></i>
					<span class="title">Settings</span>
					<span class="selected"></span>
					</a>
				</li>
				<? } ?>
        <? if (fnVerifica_Grant('openings')) { ?>
				<li class="last <? if (($MENU_ATIVO == 'openings') || ($MENU_ATIVO == 'openings-builder')) echo 'active'; ?>">
					<a href="<?=$rootpath?>/openings/">
					<i class="icon-book-open"></i>
					<span class="title">Openings</span>
					<span class="selected"></span>
					</a>
          <ul class="sub-menu">
            <? if (fnVerifica_Grant('openings')) { ?>
            <li class="<? if ($MENU_ATIVO == 'openings') echo 'active'; ?>">
              <a href="<?=$rootpath?>/openings/list.php"><i class="fa fa-angle-right"></i>Study</a>
            </li>
            <? } ?>
            <? if (fnVerifica_Grant('openings-builder')) { ?>
            <li class="<? if ($MENU_ATIVO == 'openings-builder') echo 'active'; ?>">
              <a href="<?=$rootpath?>/openings-builder/list.php"><i class="fa fa-angle-right"></i>Builder</a>
            </li>
            <? } ?>
          </ul>
				</li>
				<? } ?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
