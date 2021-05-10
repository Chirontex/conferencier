<?php
/**
 * @package Conferencier
 * @author Dmitry Shumilin (chirontex@yandex.ru)
 */
namespace Conferencier;

use Magnate\EntryPoint;

/**
 * Main entry point.
 * @since 0.0.2
 */
class Main extends EntryPoint
{

    /**
     * @since 0.0.3
     */
    protected function init() : self
    {

        $this
            ->scriptAdd()
            ->shortcodeInit();
        
        return $this;

    }

    /**
     * Initialize shortcode.
     * @since 0.0.3
     * 
     * @return $this
     */
    protected function shortcodeInit() : self
    {

        add_shortcode('backstage', function($atts, $content) {

            $atts = shortcode_atts(
                [
                    'event' => ''
                ],
                $atts
            );

            $event = get_post((int)$atts['event']);

            if (empty($event)) return $content;

            if ($event->post_type !== 'ajde_events') return $content;

            $lag = 3600;

            $start_time = (int)$event->evcal_srow;
            $end_time = (int)$event->evcal_erow;

            date_default_timezone_set('UTC');

            $start_time = date("Y-m-d H:i:s", $start_time);
            $end_time = date("Y-m-d H:i:s", $end_time);

            date_default_timezone_set($event->_evo_tz);

            $start_time = strtotime($start_time) - $lag;
            $end_time = strtotime($end_time) + $lag;

            $now = time();

            if ($now > $end_time) return '';

            if ($now > $start_time && $now < $end_time) return $content;

            if ($now < $start_time) {

                ob_start();

?>
<div id="conferencier-block-<?= $atts['event'] ?>" style="margin: 0px auto; display: none;">
<?= $content ?>
</div>
<script>
ConferencierClient.delay('conferencier-block-<?= $atts['event'] ?>', <?= ($start_time - $now) * 1000 ?>);
</script>
<?php

                return ob_get_clean();

            }

        });

        return $this;

    }

    /**
     * Add front-end script.
     * @since 0.0.4
     * 
     * @return $this
     */
    protected function scriptAdd() : self
    {

        add_action('wp_enqueue_scripts', function() {

            wp_enqueue_script(
                'conferencier-client',
                $this->url.'assets/js/conferencier-client.js',
                [],
                '0.0.3'
            );

        });

        return $this;

    }

}
