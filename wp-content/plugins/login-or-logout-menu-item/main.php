<?php
/*
Plugin Name: Login or Logout Menu Item
Description: Adds a new Menu item which dynamically changes from login to logout depending on the current users logged in status.
Version: 1.0.0
Plugin URI: https://caseproof.com
Author: cartpauj
Text Domain: lolmi
Domain Path: /i18n
*/

/*
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
  Thanks goes to Juliobox for his work on the beginning of this via the BAW Login/Logout Menu plugin.
*/

if(!defined('ABSPATH')) { die("Hey yo, why you cheatin?"); }

/* Load up the language */
function lolmi_load_textdomain() {
  $path = basename(dirname(__FILE__)) . '/i18n';

  load_plugin_textdomain('lolmi', false, $path);
}
add_action('plugins_loaded', 'lolmi_load_textdomain');

/* Add a metabox in admin menu page */
function lolmi_add_nav_menu_metabox() {
  add_meta_box('lolmi', __('Login/Logout', 'lolmi'), 'lolmi_nav_menu_metabox', 'nav-menus', 'side', 'default');
}
add_action('admin_head-nav-menus.php', 'lolmi_add_nav_menu_metabox');

/* The metabox code : Awesome code stolen from screenfeed.fr (GregLone) Thank you mate. */
function lolmi_nav_menu_metabox($object) {
  global $nav_menu_selected_id;

  $elems = array(
    '#lolmilogin#' => __('Log In', 'lolmi'),
    '#lolmilogout#' => __('Log Out', 'lolmi'),
    '#lolmiloginout#' => __('Log In', 'lolmi').'|'.__('Log Out', 'lolmi')
  );
  
  class lolmiLogItems {
    public $db_id = 0;
    public $object = 'lolmilog';
    public $object_id;
    public $menu_item_parent = 0;
    public $type = 'custom';
    public $title;
    public $url;
    public $target = '';
    public $attr_title = '';
    public $classes = array();
    public $xfn = '';
  }

  $elems_obj = array();

  foreach($elems as $value => $title) {
    $elems_obj[$title]              = new lolmiLogItems();
    $elems_obj[$title]->object_id		= esc_attr($value);
    $elems_obj[$title]->title			  = esc_attr($title);
    $elems_obj[$title]->url			    = esc_attr($value);
  }

  $walker = new Walker_Nav_Menu_Checklist(array());

  ?>
  <div id="login-links" class="loginlinksdiv">
    <div id="tabs-panel-login-links-all" class="tabs-panel tabs-panel-view-all tabs-panel-active">
      <ul id="login-linkschecklist" class="list:login-links categorychecklist form-no-clear">
        <?php echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $elems_obj), 0, (object) array('walker' => $walker)); ?>
      </ul>
    </div>
    <p class="button-controls">
      <span class="add-to-menu">
        <input type="submit"<?php disabled($nav_menu_selected_id, 0); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu', 'lolmi'); ?>" name="add-login-links-menu-item" id="submit-login-links" />
        <span class="spinner"></span>
      </span>
    </p>
  </div>
  <?php
}

/* Modify the "type_label" */
function lolmi_nav_menu_type_label($menu_item) {
  $elems = array('#lolmilogin#', '#lolmilogout#', '#lolmiloginout#');
  if(isset($menu_item->object, $menu_item->url) && 'custom'== $menu_item->object && in_array($menu_item->url, $elems)) {
    $menu_item->type_label = __('Dynamic Link', 'lolmi');
  }

  return $menu_item;
}
add_filter('wp_setup_nav_menu_item', 'lolmi_nav_menu_type_label');

/* Used to return the correct title for the double login/logout menu item */
function lolmi_loginout_title($title) {
	$titles = explode('|', $title);

	if(!is_user_logged_in()) {
		return esc_html(isset($titles[0])?$titles[0]:$title);
	} else {
		return esc_html(isset($titles[1])?$titles[1]:$title);
	}
}

/* The main code, this replace the #keyword# by the correct links with nonce ect */
function lolmi_setup_nav_menu_item($item) {
	global $pagenow;
	if($pagenow != 'nav-menus.php' && !defined('DOING_AJAX') && isset($item->url) && strstr($item->url, '#lolmi') != '') {
		$item_url = substr($item->url, 0, strpos($item->url, '#', 1)) . '#';
		$item_redirect = str_replace($item_url, '', $item->url);

		if($item_redirect == '%actualpage%') {
			$item_redirect = $_SERVER['REQUEST_URI'];
		}

		switch($item_url) {
			case '#lolmiloginout#':
        $item_redirect = explode('|', $item_redirect);

        if(count($item_redirect) != 2) {
          $item_redirect[1] = $item_redirect[0];
        }
        for($i = 0; $i <= 1; $i++) {
          if('%actualpage%' == $item_redirect[$i]) {
            $item_redirect[$i] = $_SERVER['REQUEST_URI'];
          }
        }

        $item->url = is_user_logged_in()?wp_logout_url($item_redirect[1]):wp_login_url($item_redirect[0]);
        $item->title = lolmi_loginout_title($item->title);
        break;
			case '#lolmilogin#':
        $item->url = wp_login_url($item_redirect);
        break;
			case '#lolmilogout#':
        $item->url = wp_logout_url($item_redirect);
        break;
		}

		$item->url = esc_url($item->url);
	}

	return $item;
}
add_filter('wp_setup_nav_menu_item', 'lolmi_setup_nav_menu_item');
