<?php
/**
 * @package User Role Management
 * @author  SAFRA - Web Solutions
 * @license
 * @copyright 2020 SAFRA Web
 */

defined('ABSPATH') || exit;

final class URM_App
{

  public function __construct()
  {
  }

  public static function instance()
  {
    URM_App::add_remove_user_role();
  }

  public static function add_remove_user_role()
  {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // add_action('init', function() {
      $DB_URM_Manager = new DB_URM_Manager;
    	global $wp_roles;

      if( isset( $DB_URM_Manager->option['urm-time'] ) ) $urmTime = $DB_URM_Manager->option['urm-time'];
      else $urmTime = 30;

      $urmTimeSeconds = time() - strtotime('-'.$urmTime.' days');
      $log = new WC_Logger();
      $log_entry = print_r( 'Serialize: '.$urmTime.' '.$urmTimeSeconds, true );
      $log->add( 'wcmeli', $log_entry );
      // var_dump($DB_URM_Manager->urmNextOption());
      // exit;
      $user = $DB_URM_Manager->urmNextOption();
      if(!$user) {
    	  $users = get_users([
    		  'role__not_in'  => array('administrator'),
    		  // 'role'          => 'customer',
    		  'orderby'       => 'ID'
    	  ]);
        $DB_URM_Manager->urmUpdateOptionList($users);
        $user = $DB_URM_Manager->urmNextOption();
      }
    	echo "<pre>";
      $user = array($user);

    	foreach ($user as $u) {

    		$arg =	 array(
    			// 'order' => 'desc',
    			'limit' => 1,
    			// 'orderby' => 'date_created',
    			'date_created' => date( 'Y-m-d', strtotime('-'.$urmTime.' days')),
    			'customer' => $u->data->user_email,
    			'return' => 'objects'
    		) ;

    		$lastCustomerOrder = wc_get_orders($arg);

        $log = new WC_Logger();
        $log_entry = print_r( 'Serialize: '.$u->data->user_email.' '.serialize($lastCustomerOrder), true );
        $log->add( 'wcmeli', $log_entry );

    		if(!empty($lastCustomerOrder)) {
    			$role = false;
    			foreach ($u->roles as $key => $value) {
    				if($value == 'customer') {
    					$role = true;
    					break;
    				}
    			}

    			if(!$role) $u->set_role( 'customer' );
    		}

    		$arg =	 array(
    			'order' => 'desc',
    			'limit' => 1,
    			'orderby' => 'date_created',
    			'customer' => $u->data->user_email,
    			'return' => 'objects'
    		) ;
    		$lastCustomerOrder = wc_get_orders($arg);

    		// echo "<pre>";
    		if(!empty($lastCustomerOrder)) {
    			$lastCustomerOrderDate = $lastCustomerOrder[0]->data['date_created']->getOffsetTimestamp()+$urmTimeSeconds;
    			if($lastCustomerOrderDate > time()) {
    			foreach( $lastCustomerOrder[0]->get_items() as $item_id => $item ) {
    				// get product id
    				$product_id	= $item->get_product_id();

    				$role = false;

    				if(is_int(array_search('subscriber-'.$product_id,$u->roles))) $role = true;

    				if(!$role) {
              $log = new WC_Logger();
              $log_entry = print_r( 'Serialize !role: '.serialize(wc_get_product($product_id)->is_virtual()), true );
              $log->add( 'wcmeli', $log_entry );
    					//get product info and check if product is virtual.
    					if(wc_get_product($product_id)->is_virtual()) {
    						$u->remove_role('customer');
    						if(!$u->add_role( 'subscriber-'.$product_id )) {
                  add_role( 'subscriber-'.$product_id , __( 'subscriber-'.$product_id ), array( 'read' => true , 'read_private_posts' => true ) );
                  $u->add_role( 'subscriber-'.$product_id );
                };
    					}
    				}
    			}
    			}
    		}
    	}
    	// exit;
    // });
    } else {
    	function sample_admin_notice() {
    		$class = 'notice notice-warning is-dismissible';
        $message = __( 'WooCommerce não está ativo. Por favor ative o plugin do Woocommerce.', 'sample-text-domain' );
        $div = '<div class="%1$s">
        <p>%2$s</p>
        <a href="plugins.php" class="button button-primary">'. __( 'Ativar Plugin', 'woocommerce' ).'</a>
        </div>';

        printf( $div, esc_attr( $class ), esc_html( $message ) );
      }
      add_action( 'admin_notices', 'sample_admin_notice' );
    }

  }

}


// URM_App::instance();
// exit;
