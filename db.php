<?php
/**
 * @package User Role Management
 * @author  SAFRA - Web Solutions
 * @license
 * @copyright 2020 SAFRA Web
 */
if ( ! defined( 'ABSPATH' ) ) {
    // exit; // Exit if accessed directly
}

define('URM_OPTION_COLUMN', 'config_urm_meli');
define('URM_OPTION_LIST', 'config_urm_list');

class DB_URM_Manager
{
  public function __construct() {
    if(!DB_URM_Manager::urmGetOption()) {
      $configOptions = [ 'urm-time' => 30 , 'urm-read' => false ];
      add_option(URM_OPTION_COLUMN,serialize($configOptions));
    }
    $this->option = DB_URM_Manager::urmGetOption();
  }
  /*
  * Get a COLUMN from wp_option table from Db
  */
  public function urmGetOption() {
    $option = get_option(URM_OPTION_COLUMN);

    if(!$option) return false;

    return (array)unserialize($option);
  }

  public function urmNextOption() {
    $option = unserialize(get_option(URM_OPTION_LIST));
    // var_dump($option);
    if(!$option) return false;

    $next = array_shift($option);
    // var_dump($next);
    update_option(URM_OPTION_LIST,serialize($option));
// exit;
    return $next;
  }

  public function urmUpdateOptionList($option) {
    update_option(URM_OPTION_LIST,serialize($option));
  }

  public function urmGetSettingsOptionsForm()
  {
    if(isset($_POST['urm-time'])) $this->config_urm_meli['urm-time'] = (int)$_POST['urm-time'];
  }

  public function urmUpdateOption($urlPage, $index, $value)
  {
    global $is_IIS;

    $config_urm_meliOption = $this->urmGetOption();

      if( !$this->option['urm-read'] ) $config_urm_meliOption['urm-read'] = true;
      $config_urm_meliOption[$index] = $value;

      $option = serialize($config_urm_meliOption);


    $updateOption = update_option(URM_OPTION_COLUMN,$option);

    if($updateOption) {
    $status = 100;

    $location = $urlPage.'&settings-updated' ;
    wp_redirect($location);
  } else {
    $location = $urlPage ;
    wp_redirect($location);
  }
  }
}

?>
