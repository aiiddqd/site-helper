<?php
/*
* Plugin Name: @ SiteHelper
* Description: Site Helper for WordPress - additional options, tools, customizations, optimizations
* Author: uptimizt
* GitHub Plugin URI: https://github.com/uptimizt/aa-site-helper
* Version: 0.230218
*/

namespace SiteHelper;

$files = glob(__DIR__ . '/includes/*.php');
foreach ($files as $file) {
  require_once $file;
}

$files = glob(__DIR__ . '/includes/*/config.php');
foreach ($files as $file) {
  require_once $file;
}
