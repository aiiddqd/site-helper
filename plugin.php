<?php
/*
* Plugin Name: SiteHelper
* Description: Site Helper for WordPress - additional options, tools, customizations, optimizations
* Author: uptimizt
* GitHub Plugin URI: https://github.com/uptimizt/aa-helper
* Version: 0.230218
*/

namespace aaHelper;

$files = glob(__DIR__ . '/includes/*.php');
foreach ($files as $file) {
  require_once $file;
}