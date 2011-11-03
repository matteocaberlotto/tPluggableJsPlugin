<?php

class tPluggableJsPluginConfiguration extends sfPluginConfiguration {

    /**
     * @see sfPluginConfiguration
     */
    public function initialize() {
        $this->dispatcher->connect('response.filter_content', array('tPluggableJsPluginConfiguration', 'filter_content_listener'));
    }

    /**
     * Listens to the response.filter_content event.
     *
     * @param  sfEvent $event   The sfEvent instance
     * @param  string  $content The response content
     *
     * @return string  The filtered response content
     */
    public static function filter_content_listener(sfEvent $event, $content) {

        preg_match("/(\<body[^\>]*\>)/", $content, $m);

        if (count($m)) {

            /**
             * The following condition makes symfony
             * properly raise application level errors.
             */
            if (function_exists('get_partial')) {
                $head_partial = get_partial('pluggableHtml/head');

                if (sfConfig::get('app_pluggable_js_plugin_head_append', false))
                {
                    $head_partial .= get_partial(sfConfig::get('app_pluggable_js_plugin_head_append'));
                }

                $content = preg_replace("/\<body[^\>]*\>/", $m[1] . $head_partial, $content);

                $bottom_partial = get_partial('pluggableHtml/bottom');

                if (sfConfig::get('app_pluggable_js_plugin_bottom_append', false))
                {
                    $bottom_partial .= get_partial(sfConfig::get('app_pluggable_js_plugin_bottom_append'));
                }

                $content = str_replace("</body>", $bottom_partial . "</body>", $content);
            }
        }

        return $content;
    }

}