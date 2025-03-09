<?php

namespace SiteHelper;

Commander::init();

class Commander
{

    static string $urlSearch;

    public static function init()
    {
        add_action('plugins_loaded', function(){
            self::$urlSearch = rest_url('wp/v2/search/');
        });
        add_shortcode('commander', [__CLASS__, 'shortcode']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'add_base_js_from_cdn']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'add_base_css_from_cdn']);

        add_action('wp_footer', [__CLASS__, 'add_templates_to_footer']);
    }


    public static function add_templates_to_footer()
    {
        // $onfocus = include_once __DIR__ . '/template-on-focus.php';
        echo apply_filters('commander/on-focus', include_once __DIR__ . '/template-on-focus.php');

    }

    public static function shortcode()
    {

        ob_start();
        ?>
        <div id="autocomplete"></div>

        <script>
            document.addEventListener("DOMContentLoaded", function (event) {
                const { autocomplete, getAlgoliaResults } = window['@algolia/autocomplete-js'];

                const predefinedItems = [
                    {
                        name: 'Консультация',
                        url: 'https://wpcraft.ru/ask/',
                    },
                    {
                        name: 'Контакты',
                        url: 'https://wpcraft.ru/contacts/',
                    },
                    {
                        name: 'Услуги',
                        url: 'https://wpcraft.ru/services/',
                    }
                ];
                autocomplete({
                    container: '#autocomplete',
                    openOnFocus: true,
                    autoFocus: true,
                    placeholder: 'Найдется всё',
                    getSources({ query }) {
                        return [
                            {
                                sourceId: 'posts',
                                getItems({ query }) {

                                    if (!query) {
                                        // return predefinedItems;
                                    }

                                    const url = new URL("<?= self::$urlSearch ?>");
                                    url.searchParams.set('search', query);

                                    return fetch(url.toString())
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log(data);
                                            return data.map(item => ({
                                                name: item.title,
                                                url: item.url,
                                            }));
                                        });
                                },
                                getItemUrl({ item }) {
                                    return item.url;
                                },

                                templates: {
                                    item({ item, components, html }) {
                                        return html`
                                            <a href="${item.url}">${item.name}</a>
                                        `;
                                    },
                                },
                            },
                        ];
                    },
                    render({ elements, render, html }, root) {
                        const { posts } = elements;
                        console.log(elements);
                        const content = getOnFocusBlock();
                        render(
                            html`<div class="aa-PanelLayout aa-Panel--scrollable">${content}</div>`,
                            root
                        );
                    },

                });

            });

            function getOnFocusBlock() {
                const content = document.querySelector('#commander-on-focus').innerHTML ?? '';
                // const content = document.querySelector('#commander-on-focus');
                // const content = document.querySelector('#commander-on-focus').textContent ?? '';
                console.log(content);
                return content;
                // console.log(wp.template == undefined);
                // if(!wp){
                //     return '';
                // }
                // return wp.template('commander-on-focus');
                // return wp.template('commander-on-focus');
            }

        </script>
        <?php
        return ob_get_clean();
    }


    public static function add_base_js_from_cdn()
    {
        if (!self::if_has_shortcode()) {
            return;
        }

        $url = 'https://cdn.jsdelivr.net/npm/@algolia/autocomplete-js';
        $args = [
            'strategy' => 'async'
        ];
        wp_enqueue_script('autocomplete-js', $url, [], false, $args);
    }

    public static function add_base_css_from_cdn()
    {
        if (!self::if_has_shortcode()) {
            return;
        }

        $url = 'https://cdn.jsdelivr.net/npm/@algolia/autocomplete-theme-classic@1.18.1/dist/theme.min.css';
        wp_enqueue_style('autocomplete-css', $url, [], false);
    }

    public static function if_has_shortcode()
    {
        if (has_shortcode(get_the_content(), 'commander')) {
            return true;
        }
        return false;
    }


}