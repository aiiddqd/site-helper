<?php

namespace SiteHelper\AdminBarSimplification {

    const SETTING_KEY = 'admin_bar_simplification';
    const SETTING_TITLE = 'Admin Bar Simplification';

    add_action('admin_init', __NAMESPACE__ . '\\add_setting');

    add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\frontend');
    add_action('admin_bar_menu', __NAMESPACE__ . '\clear_titles', 999);



    function add_setting(){

        add_settings_field(
            $id = SETTING_KEY,
            $title = SETTING_TITLE,
            $callback = function () {
                $value = \SiteHelper\Config\get()[SETTING_KEY] ?? null;
                $name = sprintf('%s[%s]', \SiteHelper\Config\OPTION_KEY, SETTING_KEY);
                printf('<input type="checkbox" name="%s" value="1" %s />', $name, checked(1, $value, false));
            }
            ,
            \SiteHelper\Config\OPTION_PAGE
        );

    }

    function is_enable()
    {
        return \SiteHelper\Config\get()[SETTING_KEY] ?? false;
    }

    function frontend()
    {
        if (!is_enable()) {
            return;
        }

        if (!is_user_logged_in()) {
            return;
        }

        $file_path = '/style.css';
        $file_path_abs = __DIR__ . $file_path;
        $file_url = plugins_url($file_path, __FILE__);
        wp_enqueue_style('app-admin-bar', $file_url, [], filemtime($file_path_abs));

    }


    function clear_titles(\WP_Admin_Bar $wp_admin_bar)
    {
        if (!is_enable()) {
            return;
        }

        $clear_titles = array(
            'site-name',
            'customize',
            'my-sites',
            'edit',
            // 'google-site-kit',
            // 'new-content',
        );

        $nodes = $wp_admin_bar->get_nodes();
        foreach ($nodes as $key => $node) {


            if (in_array($node->id, $clear_titles)) {
                // use the same node's properties
                $args = $node;

                // make the node title a blank string
                $args->title = '';

                // update the Toolbar node
                $wp_admin_bar->add_node($args);
            }

        }

    }
}