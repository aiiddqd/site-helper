<?php
/*
* Plugin Name: @ Helper
* Description: Helper for WordPress - additional options, tools, customizations
* Author: uptimizt
* GitHub Plugin URI: https://github.com/uptimizt/aa-helper
* Version: 0.230218
*/

namespace aaHelper;

$files = glob(__DIR__ . '/includes/*.php');
foreach ($files as $file) {
  require_once $file;
}