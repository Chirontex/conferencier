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

        $this->shortcodeInit();
        
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

            $start_time = (int)$event->evcal_srow + $lag;
            $end_time = (int)$event->evcal_erow + $lag;

            date_default_timezone_set('UTC');

            $now = time();

            if ($now > $end_time) return '';

            if ($now > $start_time && $now < $end_time) return $content;

            if ($now < $start_time) {

                ob_start();

?>
<div id="conferencier-block-<?= $atts['event'] ?>" style="margin: 0px; display: none;">
<?= $content ?>
</div>
<?php

                return ob_get_clean();

            }

        });

        return $this;

    }

}
