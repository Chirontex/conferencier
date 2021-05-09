<?php
/**
 * Plugin Name: Conferencier
 * Plugin URI: https://github.com/chirontex/conferencier
 * Description: Добавляет шорткод, скрывающий и открывающий контент мероприятия, созданного с помощью MyEventON.
 * Version: 0.0.4
 * Author: Dmitry Shumilin
 * Author URI: mailto://chirontex@yandex.ru
 * 
 * @package Conferencier
 * @author Dmitry Shumilin (chirontex@yandex.ru)
 * @since 0.0.4
*/
use Magnate\Injectors\EntryPointInjector;
use Conferencier\Main;

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/conferencier-autoload.php';

new Main(
    new EntryPointInjector(
        plugin_dir_path(__FILE__),
        plugin_dir_url(__FILE__)
    )
);
