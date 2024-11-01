<?php
/**
 * @package User Role Management
 * @author  SAFRA - Web Solutions
 * @license
 * @copyright 2020 SAFRA Web
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_filter( 'cron_schedules', 'add_cron_60_secs' );

function add_cron_60_secs( $schedules ) {
    $schedules['sixty_seconds'] = array(
        'interval' => 60,
        'display'  => esc_html__( 'Every Sixty Seconds' ),
    );

    return $schedules;
}

add_action( 'urm_cron_hook', 'run_urm_cron' );

wp_next_scheduled( 'urm_cron_hook' );

if ( ! wp_next_scheduled( 'urm_cron_hook' ) ) {
    wp_schedule_event( time(), 'sixty_seconds', 'urm_cron_hook' );
}

function run_urm_cron() {
  include_once URM_PLUGIN_PATH.'app.php';
  // Launch plugin
  URM_App::instance();
}

?>
