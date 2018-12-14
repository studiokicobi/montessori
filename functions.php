<?php
/**
 * Basic Genesis functions, followed by Montessori site customisation.
 *
 */


/**
 * Force clear CSS Cache while developing theme:
 *
 */

// add_filter( 'stylesheet_uri', 'child_stylesheet_uri' );
// function child_stylesheet_uri( $stylesheet_uri ) {
// return add_query_arg( 'v', filemtime( get_stylesheet_directory() . '/style.css' ), $stylesheet_uri );
// }


/**
 * Genesis defaults:
 *
 */

// Start the engine.
require_once get_template_directory() . '/lib/init.php';

// Set up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action('after_setup_theme', 'genesis_sample_localization_setup');
/**
 * Set localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup()
{
    load_child_theme_textdomain('montessori', get_stylesheet_directory() . '/languages');
}

// Add helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Add image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Include Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Defines the child theme (do not remove).
define('CHILD_THEME_NAME', 'Montessori');
define('CHILD_THEME_URL', 'https://skargardensmontessori.se');
define('CHILD_THEME_VERSION', '1.0');

add_action('wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles');
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles()
{
    wp_enqueue_style(
        'montessori-fonts',
        '//fonts.googleapis.com/css?family=Lato:700',

        array(),
        CHILD_THEME_VERSION
    );
    wp_enqueue_style('dashicons');

    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    wp_enqueue_script(
        'montessori-responsive-menu',
        get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
        array( 'jquery' ),
        CHILD_THEME_VERSION,
        true
    );
    wp_localize_script(
        'montessori-responsive-menu',
        'genesis_responsive_menu',
        genesis_sample_responsive_menu_settings()
    );

    wp_enqueue_script(
 		'montessori',
 		get_stylesheet_directory_uri() . '/js/montessori.min.js',
 		array( 'jquery' ),
 		CHILD_THEME_VERSION,
 		true
 	);
}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings()
{
    $settings = array(
        'mainMenu'         => __('Meny', 'montessori'),
        'menuIconClass'    => 'dashicons-before dashicons-menu',
        'subMenu'          => __('Submenu', 'montessori'),
        'subMenuIconClass' => 'dashicons-before mont-dashicons-before dashicons-arrow-down-alt2',
        'menuClasses'      => array(
            'combine' => array(
                '.nav-primary',
            ),
            'others'  => array(),
        ),
    );

    return $settings;
}

// Set the content width based on the theme's design and stylesheet.
if (! isset($content_width)) {
    $content_width = 702; // Pixels.
}

// Add support for HTML5 markup structure.
add_theme_support(
    'html5',
    array(
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
    )
);

// Add support for accessibility.
add_theme_support(
    'genesis-accessibility',
    array(
        '404-page',
        'drop-down-menu',
        'headings',
        'rems',
        'search-form',
        'skip-links',
    )
);

// Add viewport meta tag for mobile browsers.
add_theme_support(
    'genesis-responsive-viewport'
);

// Add custom logo in Customizer > Site Identity.
add_theme_support(
    'custom-logo',
    array(
        'height'      => 120,
        'width'       => 700,
        'flex-height' => true,
        'flex-width'  => true,
    )
);

// Rename primary and secondary navigation menus.
add_theme_support(
    'genesis-menus',
    array(
        'primary'   => __('Header Menu', 'montessori'),
        'secondary' => __('Footer Menu', 'montessori'),
    )
);

// Add support for after entry widget.
add_theme_support('genesis-after-entry-widget-area');

// Add support for 3-column footer widgets.
add_theme_support('genesis-footer-widgets', 3);

// Remove header right widget area.
unregister_sidebar('header-right');

// Remove secondary sidebar.
unregister_sidebar('sidebar-alt');

// Remove site layouts.
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-content-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');

// Remove output of primary navigation right extras.
remove_filter('genesis_nav_items', 'genesis_nav_right', 10, 2);
remove_filter('wp_nav_menu_items', 'genesis_nav_right', 10, 2);

add_action('genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes');
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes($_genesis_admin_settings)
{
    remove_meta_box('genesis-theme-settings-header', $_genesis_admin_settings, 'main');
    remove_meta_box('genesis-theme-settings-nav', $_genesis_admin_settings, 'main');
}

/**
 * Remove more metaboxes
 *
 */

// Remove Genesis in-post SEO Settings
remove_action('admin_menu', 'genesis_add_inpost_seo_box');

// Remove Genesis Layout Settings
remove_theme_support('genesis-inpost-layouts');

// Remove Genesis SEO Settings menu link
remove_theme_support('genesis-seo-settings-menu');

// Remove Genesis Scripts Meta box on pages
add_action('admin_menu', 'remove_genesis_page_scripts_box');
    function remove_genesis_page_scripts_box()
    {
        remove_meta_box('genesis_inpost_scripts_box', 'page', 'normal');
    }

add_filter('genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings');
/**
 * Removes output of header settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings($config)
{
    unset($config['genesis']['sections']['genesis_header']);
    return $config;
}

// Display custom logo.
add_action('genesis_site_title', 'the_custom_logo', 0);

// Reposition primary navigation menu.
remove_action('genesis_after_header', 'genesis_do_nav');
add_action('genesis_header', 'genesis_do_nav', 12);

// Reposition the secondary navigation menu.
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_footer', 'genesis_do_subnav', 10);

add_filter('wp_nav_menu_args', 'genesis_sample_secondary_menu_args');

/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args($args)
{
    if ('secondary' !== $args['theme_location']) {
        return $args;
    }

    $args['depth'] = 1;
    return $args;
}

/**
 * Edit breadcrumbs
 *
 */

// Reposition the Genesis breadcrumb above main.content box
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
add_action('genesis_before_content', 'genesis_do_breadcrumbs');

// Remove 'You are here' from the front of breadcrumb trail
function mont_prefix_breadcrumb($args)
{
    $args['labels']['prefix'] = '';
    return $args;
}

add_filter('genesis_breadcrumb_args', 'mont_prefix_breadcrumb');

// Change the text at the front of breadcrumb trail
function mont_home_text_breadcrumb($args)
{
    $args['home'] = 'Hem';
    return $args;
}

add_filter('genesis_breadcrumb_args', 'mont_home_text_breadcrumb');

/**
 * Remove default image links
 *
 */

function wpb_imagelink_setup()
{
    $image_set = get_option('image_default_link_type');

    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

/**
 * Frontend member form
 *
 */

function frontend_member_form_func($atts)
{
    $a = shortcode_atts(array( 'field_group' => '' ), $atts);
    $uid = get_current_user_id();

    if (! empty($a['field_group']) && ! empty($uid)) {
        $options = array(
        'post_id' => 'user_'.$uid,
          'field_groups' => array( intval($a['field_group']) ),
          'return' => add_query_arg('uppdaterad', 'true', get_permalink())
    );

        ob_start();

        acf_form($options);
        $form = ob_get_contents();

        ob_end_clean();
    }

    return $form;
}

add_shortcode('frontend_member_form', 'frontend_member_form_func');

// Add AFC form head

function add_acf_form_head()
{
    global $post;

    if (!empty($post) && has_shortcode($post->post_content, 'frontend_member_form')) {
        acf_form_head();
    }
}

add_action('get_header', 'add_acf_form_head', 7);

// Save email correctly

function my_acf_save_post($post_id)
{
    // bail early if no ACF data
    if (empty($_POST['acf'])) {
        return;
    }

    // bail early if editing in admin
    if (is_admin()) {
        return;
    }

    if ($_POST['post_id'] != 'new') {
        $emailField = $_POST['acf']['field_5bc6468892b94'];
        $wp_user_id = str_replace("user_", "", $post_id);

        if (isset($emailField)) {
            if (email_exists($emailField)) {
                // Email exists, do not update value.
                update_field('field_5bc6468892b94', get_the_author_meta('user_email', $wp_user_id), $post_id);
            } else {
                $args = array(
                        'ID'         => $wp_user_id,
                        'user_email' => esc_attr($emailField)
                    );
                wp_update_user($args);
            }
        }
    }

    // return the ID
    return $post_id;
}
    add_action('acf/save_post', 'my_acf_save_post', 20);


/**
 * Create child pages navigation in sidebar. List is added before the sidebar widget area.
 *
 *
 */

add_action( 'genesis_before_sidebar_widget_area', 'mont_list_child_pages', 5 );

function mont_list_child_pages() {

  global $post; // global variable $post

  if ( is_page() && $post->post_parent ) {
    $children = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
	} else {
    $children = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
	}
	if ( $children ) {
		echo '<ul class="subpage_nav">';
			echo $children;
		echo '</ul>';
	}
}


/**
 * Load separate menus for logged in and logged out users
 *
 */

function primary_wp_nav_menu_args($args = '')
{
    if (is_user_logged_in()) {
        $args['menu'] = 'Logged-in';
    } else {
        $args['menu'] = 'Logged-out';
    }
    return $args;
}

add_filter('wp_nav_menu_args', 'primary_wp_nav_menu_args');


/**
 * Automatically add child pages to nav
 *
 * auto_child_page_menu
 * */

class auto_child_page_menu
{
    /**
     * class constructor
     * @author Ohad Raz <admin@bainternet.info>
     * @param   array $args
     * @return  void
     */
    public function __construct($args = array())
    {
        add_filter('wp_nav_menu_objects', array($this,'on_the_fly'));
    }
    /**
     * the magic function that adds the child pages
     * @author Ohad Raz <admin@bainternet.info>
     * @param  array $items
     * @return array
     */
    public function on_the_fly($items)
    {
        global $post;
        $tmp = array();
        foreach ($items as $key => $i) {
            $tmp[] = $i;
            //if not page move on
            if ($i->object != 'page') {
                continue;
            }
            $page = get_post($i->object_id);
            //if not parent page move on
            if (!isset($page->post_parent) || $page->post_parent != 0) {
                continue;
            }
            $children = get_pages(array('child_of' => $i->object_id, 'sort_column' => 'menu_order'));
            foreach ((array)$children as $c) {
                //set parent menu
                $c->menu_item_parent      = $i->ID;
                $c->object_id             = $c->ID;
                $c->object                = 'page';
                $c->type                  = 'post_type';
                $c->type_label            = 'Page';
                $c->url                   = get_permalink($c->ID);
                $c->title                 = $c->post_title;
                $c->target                = '';
                $c->attr_title            = '';
                $c->description           = '';
                $c->classes               = array('','menu-item','menu-item-type-post_type','menu-item-object-page');
                $c->xfn                   = '';
                $c->current               = ($post->ID == $c->ID)? true: false;
                $c->current_item_ancestor = ($post->ID == $c->post_parent)? true: false; //probbably not right
                $c->current_item_parent   = ($post->ID == $c->post_parent)? true: false;
                $tmp[] = $c;
            }
        }
        return $tmp;
    }
}
new auto_child_page_menu();

/**
 * Add a custom user role for Staff
 *
 */

$result = add_role(
    'personal',
    __('Personal'),
    array(
        'read' => true,
        'edit_posts' => false,
        'edit_pages' => false,
        'edit_others_posts' => false,
        'create_posts' => false,
        'manage_categories' => false,
        'publish_posts' => false,
    )
);


/**
 * Create custom post type: Matsedel
 *
 */

function create_post_type() {
  register_post_type( 'matsedel',
    array(
      'labels' => array(
        'name' => __( 'Matsedlar' ),
        'singular_name' => __( 'Matsedel' )
      ),
      'public' => true,
      'has_archive' => true,
      'query_var' => true,
    )
  );
}
add_action( 'init', 'create_post_type' );


/**
 * Create custom post type: Matsedel
 *
 */

function matsedel_init() {
  register_post_type( 'matsedel',
    array(
      'labels' => array(
        'name' => __( 'Matsedlar' ),
        'singular_name' => __( 'Matsedel' )
      ),
      'public' => true,
      'has_archive' => true,
      'query_var' => true,
    )
  );
}
add_action( 'init', 'matsedel_init' );


/**
 * Create custom post type: Nyhetsbrev
 *
 */

 function newsletter_init() {
     $args = array(
       'label' => 'Nyhetsbrev',
         'public' => true,
         'show_ui' => true,
         'capability_type' => 'post',
         'rewrite' => array('slug' => 'nyhetsbrev'),
         'query_var' => true,
         //'menu_icon' => 'dashicons-video-alt',
         'supports' => array(
             'title',
             'editor',
             'excerpt',
             'trackbacks',
             'custom-fields',
             'comments',
             'revisions',
             'thumbnail',
             'author',
             'page-attributes',)
         );
     register_post_type( 'nyhetsbrev', $args );
 }
 add_action( 'init', 'newsletter_init' );


/**
 * Remove menu items from WordPress dashboard
 *
 */

function remove_menus()
{
    //remove_menu_page( 'index.php' ); //Dashboard
    //remove_menu_page( 'upload.php' ); //Media
    //remove_menu_page( 'edit.php?post_type=page' ); //Pages
    //remove_menu_page( 'themes.php' ); //Appearance
    //remove_menu_page( 'plugins.php' ); //Plugins
    //remove_menu_page( 'users.php' ); //Users
    //remove_menu_page( 'tools.php' ); //Tools
    //remove_menu_page( 'edit.php?post_type=portfolio' ); //Portfolio
    //remove_menu_page( 'options-general.php' ); //Settings
    remove_menu_page( 'edit.php' ); //Posts
    remove_menu_page( 'edit-comments.php' ); //Comments
}
add_action( 'admin_menu', 'remove_menus' );
