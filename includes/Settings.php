<?php 

namespace aaHelper\Config {
    
    const OPTION_KEY = 'aahelper_config';
    const OPTION_PAGE = 'aahelper-settings';

    add_action('admin_init', function(){
        register_setting( OPTION_PAGE, OPTION_KEY );
    });



    function get(){
        return get_option(OPTION_KEY, []);
    }

    add_action('admin_menu', function () {

        add_options_page(
            'Helper',
            'Helper',
            'manage_options',
            OPTION_PAGE,
            function () {
                ?>
                <form method="POST" action="options.php">

                    <h1>Helper</h1>
                    <?php 
                    settings_fields(OPTION_PAGE);
                    do_settings_sections(OPTION_PAGE);
                    submit_button();
                    ?>
                </form>
                <?php 
            }
        );

        add_settings_section( 'default', '', '', OPTION_PAGE );

    });


}