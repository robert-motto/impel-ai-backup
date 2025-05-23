<?php
	$GLOBALS['theme_dir'] = get_template_directory_uri();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php
	$url_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	echo esc_attr(empty($url_path) ? 'homepage-slug' : $url_path . '-slug');
?>">
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
			font-family: 'KHTeka';
			src: url('<?php echo $GLOBALS['theme_dir']; ?>/src/fonts/KHTeka/regular/KHTeka-Regular.woff2') format('woff2'),
				url('<?php echo $GLOBALS['theme_dir']; ?>/src/fonts/KHTeka/regular/KHTeka-Regular.woff') format('woff'),
				url('<?php echo $GLOBALS['theme_dir']; ?>/src/fonts/KHTeka/regular/KHTeka-Regular.otf') format('opentype');
			font-display: swap;
			font-style: normal;
			font-weight: 400;
		}
		@font-face {
			font-family: 'KHTeka';
			src: url('<?php echo $GLOBALS['theme_dir']; ?>/src/fonts/KHTeka/medium/KHTeka-Medium.woff2') format('woff2'),
				url('<?php echo $GLOBALS['theme_dir']; ?>/src/fonts/KHTeka/medium/KHTeka-Medium.woff') format('woff'),
				url('<?php echo $GLOBALS['theme_dir']; ?>/src/fonts/KHTeka/medium/KHTeka-Medium.otf') format('opentype');
			font-display: swap;
			font-style: normal;
			font-weight: 500;
		}
	</style>
	<?php wp_head(); ?>
	<link rel="icon" href="<?php echo $GLOBALS['theme_dir'] . '/src/img/favicons/favicon.ico'; ?>" type="image/x-icon" />
	<script>
		window.markerConfig = {
			project: '68303939c5a548b4e04d1c17',
			source: 'snippet'
		};

		! function(e, r, a) {
			if (!e.__Marker) {
				e.__Marker = {};
				var t = [],
					n = {
						__cs: t
					};
				["show", "hide", "isVisible", "capture", "cancelCapture", "unload", "reload", "isExtensionInstalled", "setReporter", "clearReporter", "setCustomData", "on", "off"].forEach(function(e) {
					n[e] = function() {
						var r = Array.prototype.slice.call(arguments);
						r.unshift(e), t.push(r)
					}
				}), e.Marker = n;
				var s = r.createElement("script");
				s.async = 1, s.src = "https://edge.marker.io/latest/shim.js";
				var i = r.getElementsByTagName("script")[0];
				i.parentNode.insertBefore(s, i)
			}
		}(window, document);
	</script>
</head>
<body <?php body_class(); ?>>
	<?php get_template_part('/parts/site-top');	?>
	<main>