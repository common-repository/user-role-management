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

class URM_Template
{

  // Constructor
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'urm_add_menu' ));
    }

    /*
      * Actions perform at loading of admin menu
      */
    public function urm_add_menu() {

      add_menu_page( 'URM', 'User Role Management', 'manage_options', 'urm-settings', array(
                        __CLASS__,
                       'urm_page_file_path'
                      ));

      add_submenu_page( 'urm-settings', 'URM' . 'Configurações', ' Configurações', 'manage_options', 'urm-settings', array(
                            __CLASS__,
                           'submenu_page_settings1'
                          ));
    }

    /**
    * Render submenu
    * @return void
    */
    static function submenu_page_settings1() {

      $DB_URM_Manager = new DB_URM_Manager;

      if(isset($_POST['urm-time'])) {
        $DB_URM_Manager->urmGetSettingsOptionsForm();
        $DB_URM_Manager->urmUpdateOption('admin.php?page=urm-settings','urm-time',$DB_URM_Manager->config_urm_meli['urm-time']);
      }
      $config_urm_meliOption = $DB_URM_Manager->urmGetOption();

      if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'urm_messages', 'urm_message', __( 'Alterações Salvas', 'urm' ), 'updated' );
        settings_errors( 'urm_messages' );
      }

      if( ! $config_urm_meliOption['urm-read'] ) {
      ?>
      <div id="wrap1" class="wrap1" style="margin:10px 100px 10px 100px;padding:10px;background:#e1e1e1;border:2px solid #cbcbcc;display:block">
          <h2>Welcome to User Role Management
            <img draggable="false" class="emoji" alt="🚀" src="https://s.w.org/images/core/emoji/12.0.0-1/svg/1f680.svg">
            <img draggable="false" class="emoji" alt="🎉" src="https://s.w.org/images/core/emoji/12.0.0-1/svg/1f389.svg">
          </h2>
          <p>
            Thank you for installing and using User Role Management. This plugin allows you to manage allowed content for users, so as to access only allowed content.
          </p>
          <p>
            User Role Management was developed to be used in virtual products, linking a created post referring to the content of the product sold.
          </p>
          <h3>
            How to use this plugin?
          </h3>
          <p>
            When installed, the plugin automatically creates all user roles by reference to the Woocommerce product id <strong> (Ex: subscriber-4032, where 4032 is the id of a virtual product and the "subscriber" is the characteristic of the user) </strong>.
          </p>
          <p>
            From this moment on, the plugin is waiting for the default time that users will have to access the purchased content. This setting occurs after reading this guide.
          </p>
          <p>
            Once completed, the plugin will be ready to take over. It checks for orders where the access limit has already been exceeded (takes into account the date the order was paid) and removes user access (roles).
          </p>
          <p>
            Also checks for orders where the access limit has not been exceeded. If so, verify that the user corresponding to the purchase has the appropriate permissions (roles). If so, the request is ignored. If not, the plugin adds as permissions (roles).
          </p>
          <!-- <p>A documentação completa pode ser encontrada no
            <a href="https://redirection.me/support/" target="_blank" rel="noopener noreferrer">site do Redirection (em inglês).
            </a>
          </p> -->
          <h3>
            Suggestions
          </h3>
          <p>
          Like you know, this plugin make exclusive the posts to users that bougth it (subscriber-**** roles). If you have more than 1 virtual product in more than 1 post, all users that have a subscriber role will can see the private posts.
          </p>
          <p>
          If you wish to give permission only to users who purchase their product so that other users cannot access the private posts, we recommend installing the Members (<a href="https://br.wordpress.org/plugins/members/">https://br.wordpress.org/plugins/members/<a>) plugin which enables the desired configuration. Just indicate who can access private posts (the roles) while they are being created.
        </p>
          <h3>
            What is next?
          </h3>
          <p>
          You will now set the default time <strong> (in days) </strong> that users will have access to purchased content.
          </p>
          <p>When ready, press the Setting button..
          </p>
          <div class="wizard-buttons">
            <button type="button" onclick="MissDismiss(true)" class="button-primary button">
              Start Settings
            </button>
          </div>
        </div>
      <?php }
      if( !$config_urm_meliOption['urm-read'] ) echo '<div id="wrap2" class="wrap2" style="margin:100px;display:none">';
      else echo '<div id="wrap2" class="wrap2" style="margin:100px;display:block">'; ?>
      <h1><?php echo __( 'User Role Management - Configuração' ); ?></h1>
      <?php
          // an associative array containing the query var and its value
          $params = array('page' => 'urm-settings');
      ?>
      <!-- <form method="post" action="../wp-content/plugins/user-role-management/action.php?advanced-settings" novalidate="novalidate"> -->
      <form method="post" action="<?php echo add_query_arg($params, 'admin.php'); ?>" novalidate="novalidate">

      <table class="form-table">

      <tbody><tr>
      <th scope="row"><label for="urm-time">Time, in days, that the user will have access to private content.</label></th>
      <td><input name="urm-time" type="text" id="urm-time" value="<?php echo isset($config_urm_meliOption['urm-time']) ?  $config_urm_meliOption['urm-time'] : 30;?>" class="regular-text">
      <p class="description" id="tagline-description">1 month = 30 days | 2 month = 60 days | 3 month = 90 days | 6 month = 180 days | 1 ano = 365 days | 2 anos = 730 days</p></td>
      </tr>



      </tbody></table>

      <?php submit_button( 'Salvar alterações', ['large','primary'], 'large', 'submit', ['style' => 'width:100%'] );?>
      </form>
      </div>

      <script>
        function MissDismiss(value) {
        var wrap1 = document.getElementById("wrap1");
        wrap1.style.display = "none";
        var wrap2 = document.getElementById("wrap2");
        wrap2.style.display = "block";
        }
      </script>
      <?php
    }

    /*
     * Actions perform on loading of menu pages
     */
    static function urm_page_file_path() {



    }

    /*
     * Actions perform on activation of plugin
     */
    public function urm_install() {
      add_action( 'admin_notices', 'urm_message' );
      if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $DB_URM_Manager = new DB_URM_Manager;
      	global $wp_roles;

      	if (!isset($wp_roles)) {
      		$wp_roles = new WP_Roles();
      	}

      	$args = array(
      		'posts_per_page' => -1,
      		'return'				=> 'ids',
      		'virtual'				=> true
      	);

      	$query = new WC_Product_Query($args);
      	$allVirtualProducts = $query->get_products();

      	foreach ($allVirtualProducts as $key => $value) {
      		$roleName = 'subscriber-'.$value;

      		if( !isset( $wp_roles->roles[$roleName] ) ) {
      			if( add_role( $roleName , __( $roleName ), array( 'read' => true , 'read_private_posts' => true ) ) )
      			$array_roles[] = $roleName;
      		}
      	}
      }
    }
    /*
     * Actions perform on de-activation of plugin
     */
    public function urm_uninstall() {


    }

}
