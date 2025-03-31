<?php
	$GLOBALS['theme_dir'] = get_template_directory_uri();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script>
		// fScript sourcecode
		var b=!1,c=document.getElementsByTagName("head")[0]||document.documentElement;function d(){var a=document.querySelectorAll("fscript");[].forEach.call(a,function(a){var b=document.createElement("script");if(b.type="text/javascript",a.hasAttributes())for(var d in a.attributes)a.attributes.hasOwnProperty(d)&&(b[a.attributes[d].name]=a.attributes[d].value||!0);else b.appendChild(document.createTextNode(a.innerHTML));c.insertBefore(b,c.firstChild)})}function e(){b||(b=!0,setTimeout(function(){"requestIdleCallback"in window?requestIdleCallback(d,{timeout:1e3}):d()},1e3))}const a=["scroll","mouseover","keydown","touchmove","touchstart","click"];a.forEach(a=>{window.addEventListener(a,e,{passive:!0,once:!0})})
	</script>
	<?php
		$head_code = get_field('head_code', 'option');
	?>
	<?php echo $head_code ?>
	<style>
		@font-face {
			font-family: 'presicav';
			src: url('https://use.typekit.net/af/462ab8/00000000000000003b9afe26/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff2'),
				url('https://use.typekit.net/af/462ab8/00000000000000003b9afe26/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff'),
				url('https://use.typekit.net/af/462ab8/00000000000000003b9afe26/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('opentype');
			font-display: swap;
			font-style: normal;
			font-weight: 400;
		}
	</style>
	<?php wp_head(); ?>
	<link rel="icon" href="<?php echo $GLOBALS['theme_dir'] . '/src/img/favicons/favicon.ico'; ?>" type="image/x-icon" />
</head>
<body <?php body_class(); ?>>
	<?php get_template_part('/parts/site-top');	?>
	<main>
