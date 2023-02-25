<?php
/*
 * Plugin Name: @ SiteHelper
 * Description: Site Helper for WordPress - additional options, tools, customizations, optimizations
 * Author: uptimizt
 * GitHub Plugin URI: https://github.com/uptimizt/site-helper
 * Version: 0.230225
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

/**
 * add Settings link to plugins list
 */
add_filter(
  'plugin_action_links_' . plugin_basename(__FILE__),
  function ($links) {
    if (!current_user_can('manage_options')) {
      return $links;
    }

    return array_merge(
      $links,
      array(
        sprintf(
          '<a href="%s">%s</a>',
          add_query_arg(
            array(
              'page' => \SiteHelper\Config\OPTION_PAGE,
            ),
            admin_url('options-general.php')
          ),
          esc_attr__('Settings', 'antispam-bee')
        ),
      )
    );

  }
);