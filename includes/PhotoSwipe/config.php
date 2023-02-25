<?php 

namespace SiteHelper\PhotoSwipe {
 
    const SETTING_KEY = 'photoswipe';
    const SETTING_TITLE = 'PhotoSwipe for images and gallery';
    const VERSION = '5.3.6';

    add_action('admin_init', __NAMESPACE__ . '\\add_setting');
    add_action('wp_footer', __NAMESPACE__ . '\\add_js_module');
    add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\add_css');

    
    function add_css(){
        if(!is_enable()){
            return;
        }
        $url = plugins_url('dist/photoswipe.css', __FILE__);
        wp_enqueue_style( SETTING_KEY, $url, [], VERSION, 'all' );
    }

    function add_js_module(){
        if(!is_enable()){
            return;
        }

        $photoswipe_lightbox = plugins_url('dist/photoswipe-lightbox.esm.js', __FILE__);
        $photoswipe = plugins_url('dist/photoswipe.esm.js', __FILE__);
        ?>
        <script type="module" id="SiteKitPhotoSwipe">
            import PhotoSwipeLightbox from '<?= $photoswipe_lightbox; ?>'
            const lightbox = new PhotoSwipeLightbox({
            gallery: '.wp-block-image',
            children: 'a',
            pswpModule: () => import('<?= $photoswipe ?>')
            });
            lightbox.init();
        </script>
        <?php 
    }
    
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


}