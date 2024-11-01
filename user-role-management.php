<?php
/**
* @package User Role Management
* @version 2.0.1
*/
/**
  * Plugin Name:       User Role Management
  * Description:       Este plugin cria roles para os usuários de acordo com os produtos virtuais existentes na loja (woocommerce). Ao obter uma venda, o plugin verifica qual ou quais, o(s) produto(s) comprado(s) e adiciona o novo role correspondente ao produto para o usuário, removendo o role padrão (setado em configurações->geral). Após x dias/mês, tempo correspondente ao período em que o conteudo virtual poderá ser acessado, o role correspondente ao produto é removido, adicionando novamente o role padrão.
  * Description:
  * Version:           2.0.1
  * Requires at least: 5.2
  * Requires PHP:      7.2
  * Domain Path:       /languages/
  * Author:            SAFRA - Web Solutions
  * Author URI:        https://www.facebook.com/safraweb/
  */
if (!defined('ABSPATH')) {
    exit;
}

define('URM_PLUGIN_PATH', plugin_dir_path(__FILE__));

require(URM_PLUGIN_PATH.'db.php');
require(URM_PLUGIN_PATH.'template.php');
require(URM_PLUGIN_PATH.'app.php');

new URM_Template;
register_activation_hook( __FILE__, array( 'URM_Template', 'urm_install' ) );
register_deactivation_hook( __FILE__, array( 'URM_Template', 'urm_uninstall' ) );

require(URM_PLUGIN_PATH.'cron.php');
