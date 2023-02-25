<?php

namespace SiteHelper\JQMigrate {

    const SETTING_KEY = 'jqmigrate_disable';
    const SETTING_TITLE = 'JQMigrate disable';

    add_action('wp_default_scripts', function ($scripts) {
        if (is_active()) {
            if (!empty($scripts->registered['jquery'])) {
                $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
            }
        }
    });

    add_action('admin_init', __NAMESPACE__ . '\\add_setting', 22);

    function is_active()
    {
        $value = \SiteHelper\Config\get()[SETTING_KEY] ?? null;
        if ($value) {
            return true;
        }
        return false;
    }

    function add_setting()
    {
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
}