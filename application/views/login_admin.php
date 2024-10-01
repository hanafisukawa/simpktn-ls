<?php
	$currency = 'Rp';
?>

<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Login | STAR PINS</title>
		<meta charset="utf-8" />
		<meta name="description" content="STAR - PINS.CO.ID" />
		<meta name="keywords" content="STAR - PINS.CO.ID" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="STAR - PINS.CO.ID" />
		<meta property="og:url" content="vms.pins.co.id" />
		<meta property="og:site_name" content="vms.pins.co.id" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.png" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
		
		<style>body { background-image: url('<?php echo base_url(); ?>themes/ortyd/assets/media/auth/bg6.jpg'); } [data-bs-theme="dark"] body { background-image: url('<?php echo base_url(); ?>themes/ortyd/assets/media/auth/bg6.jpg'); }</style>

		
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/jquery/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/bootstrap-notify/bootstrap-notify.min.js"></script> 
		
		<script src="https://www.google.com/recaptcha/enterprise.js?render=<?php echo $site_key; ?>"></script>
		
		<script src='https://www.google.com/recaptcha/api.js'></script>
		
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
			<?php require_once($template_contents.'.php'); ?>
		<!--end::Main-->
		<!--begin::Javascript-->
		<script>var hostUrl = "<?php echo base_url(); ?>themes/ortyd/assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>