<?
  require_once ('../models/User.php');
  require_once ('../models/Theme.php');
  require_once ('../internationalization/Translate.php');

  $t = new Translate();

  $userID = $_SESSION['USER']['ID'];
  $user = new User();
  $user = $user->getUserWithId($userID);

  $theme = new Theme();
  $theme = $theme->getThemeWithID($user->themeID);

  $user->theme = $theme;
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<title><?=$TITULO?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />

<? include('../imports/global_mandatory_styles.php'); ?>
<? include('../imports/page_level_styles.php'); ?>
<? include('../imports/theme_styles.php'); ?>

<link rel="shortcut icon" href="../favicon.png" />
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-boxed page-sidebar-closed">
	<!-- BEGIN HEADER -->
	<div class="page-header -i navbar navbar-fixed-top">
		<!-- BEGIN HEADER INNER -->
		<div class="page-header-inner container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="../dashboard/dashboard.php">
					<img src="<?=$absolutepath?>assets/admin/layout/img/<?=$user->theme->file?>_logo.png" alt="logo" class="logo-default" />
				</a>
				<div class="menu-toggler sidebar-toggler">
					<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
				</div>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler responsive-toggler"
				data-toggle="collapse" data-target=".navbar-collapse"> </a>
			<!-- END RESPONSIVE MENU TOGGLER -->
		<? include('../_top.php'); ?>
	</div>
		<!-- END HEADER INNER -->
	</div>
	<!-- END HEADER -->
	<div class="clearfix"></div>
	<!-- BEGIN CONTAINER -->
	<!-- CONTAINER / used with boxed -->
	<div class="container">
		<div class="page-container">
	<? include('../_menu.php'); ?>
