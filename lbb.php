<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
    
    /*
    Plugin Name: Local Business Booster
    Plugin URI: http://wordpress.plustime.com.au/local-business-booster/
    Description: Boost your local business by implementing the proper techniques, improving wordpress and adding extra features.
    Version: 1.0.0
    Author: second2none
    Author URI: http://wordpress.plustime.com.au/
    License: GPL2
    */

include( plugin_dir_path( __FILE__ ) . 'options.php');

add_action( 'plugins_loaded' , 'lbb_init_plugin');
function lbb_activate() {
    include( plugin_dir_path( __FILE__ ) . 'php_libraries/lbb_sitemap.php');
    $sitemap = new lbb_sitemap();
    $args = array(
    'plugin_dir_path'   => plugin_dir_path( __FILE__ ), 
    'xsl_sitemaps'      => plugins_url('xsl/sitemaps.xsl', __FILE__ ),
    'xsl_child'         => plugins_url('xsl/xsl_child.xsl', __FILE__ )
    );
    $sitemap->generate($args);
}
register_activation_hook( __FILE__, 'lbb_activate' );
function lbb_init_plugin(){
    $wpfeatures_option = get_option('lbb_wpfeatures_details');
    add_action('admin_menu', 'lbb_create_menu');
    
    if(isset($wpfeatures_option['wpfeatures_ONOFF']) && $wpfeatures_option['wpfeatures_ONOFF'] != 'off'){
        if(isset($wpfeatures_option['wpfeaturesAdminBar']) && $wpfeatures_option['wpfeaturesAdminBar'] != 'off'){
            add_filter('show_admin_bar', '__return_false');
        }
        if(isset($wpfeatures_option['wpfeaturesBlankPage']) && $wpfeatures_option['wpfeaturesBlankPage'] != 'off'){ 
            lbb_blank_page_template('lbb_blankpage.php', esc_html__( 'LBB Blank Page', 'local-business-booster' ));
            add_filter(
    			'theme_page_templates',
    			function ( array $templates ) {
    				return array_merge( $templates, lbb_blank_page_get_templates() );
    			}
    		);
            add_filter(
    			'template_include',
    			function ( $template ) {
    				if ( is_singular() ) {
    					$assigned_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
    					if ( lbb_blank_page_get_template( $assigned_template ) ) {
    						if ( file_exists( $assigned_template ) ) {
    							return $assigned_template;
    						}
    						$file = wp_normalize_path( plugin_dir_path( __FILE__ ) . '/php_libraries/' . $assigned_template );
    						if ( file_exists( $file ) ) {
    							return $file;
    						}
    					}
    				}
    				return $template;
    			}
    		);
        }    
    }
}  
function lbb_blank_page_template( $file, $label ) {
		add_filter(
			'lbb_blank_page_templates',
			function ( array $templates ) use ( $file, $label ) {
				$templates[ $file ] = $label;

				return $templates;
			}
		);
}
function lbb_blank_page_get_templates() {
		return (array) apply_filters( 'lbb_blank_page_templates', array() );
} 
function lbb_blank_page_get_template( $file ) {
		$templates = lbb_blank_page_get_templates();
		return isset( $templates[ $file ] ) ? $templates[ $file ] : null;
}
function lbb_create_menu() {
	add_menu_page('Local Business Booster', 'Local Business Booster', 'manage_options', 'lbb', 'lbb_settings_page' , 'dashicons-dashboard' );
	add_action( 'admin_init', 'register_lbb_settings' ); 
}
function lbb_admin_head() {
    $screen = get_current_screen();
    $wpfeatures_option = get_option('lbb_wpfeatures_details');
    if($screen->id == 'toplevel_page_lbb'){
        if(isset($wpfeatures_option['wpfeatures_ONOFF']) && $wpfeatures_option['wpfeatures_ONOFF'] != 'off'){
            //if(isset($wpfeatures_option['wpfeaturesGoogleANA_ONOFF']) && $wpfeatures_option['wpfeaturesGoogleANA_ONOFF'] != 'off'){
	        //   echo '<meta name="google-signin-client_id" content="946059328354-dkklnuhran903kl33e3kan7u8odeftdh.apps.googleusercontent.com">';
            //}
        }
    }
}
add_action( 'admin_head', 'lbb_admin_head' );
function lbb_admin_scripts($args){
    $screen = get_current_screen();
    $wpfeatures_option = get_option('lbb_wpfeatures_details');
    if($screen->id == 'toplevel_page_lbb'){
        wp_enqueue_style('lbb_admin_css', plugins_url('css/admin_page_css.css',__FILE__ ));
        wp_enqueue_script('lbb_admin_js', plugins_url('js/lbb_admin_js.js',__FILE__ ), ['jquery'], '1.0', true);  
        if(isset($wpfeatures_option['wpfeatures_ONOFF']) && $wpfeatures_option['wpfeatures_ONOFF'] != 'off'){
        //    if(isset($wpfeatures_option['wpfeaturesGoogleANA_ONOFF']) && $wpfeatures_option['wpfeaturesGoogleANA_ONOFF'] != 'off'){
        //        wp_enqueue_script('lbb_google_js', 'https://apis.google.com/js/platform.js', '', '', true);   
        //    }
        //    
        }         
    }
    if(isset($wpfeatures_option['wpfeatures_ONOFF']) && $wpfeatures_option['wpfeatures_ONOFF'] != 'off'){
        if(isset($wpfeatures_option['wpfeatures_SELECT2']) && $wpfeatures_option['wpfeatures_SELECT2'] != 'off'){
            wp_enqueue_style('lbb_selec2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css');
            wp_enqueue_script('lbb_selec2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', '', '', true);
            wp_enqueue_script('lbb_add_select2_js', plugins_url('js/add_select2.js',__FILE__ ), ['jquery'], '1.0', true);       
        }        
    }
}
add_action('admin_enqueue_scripts', 'lbb_admin_scripts');
function lbb_with_jquery(){
    wp_localize_script( 'lbb_ajax', 'lbb_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' )));    
}
add_action( 'wp_enqueue_scripts', 'lbb_with_jquery' );

function codemirror_fix($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }
    wp_enqueue_script( 'codemirror_fix', plugins_url('js/codemirror-fix.js',__FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'codemirror_fix' );
function lbb_client_styles($args){
    wp_enqueue_style('lbb_css', plugins_url('css/lbb.css',__FILE__ ), '', '1.0');
}
add_action( 'wp_enqueue_scripts', 'lbb_client_styles' );
function lbb_dropdown_pages_multiple($output) {
    if (strpos($output, 'name=\'lbb_google_details[googlePAGES]\'') !== false) {
        $output = str_replace( '<select name=\'lbb_google_details[googlePAGES]\' id=\'lbb_google_details[googlePAGES]\'>', '<select multiple="multiple" name="lbb_google_details[googlePAGES][]" id="lbb_google_details[googlePAGES]"><option class="level-0" value="all">All Pages</option>', $output);
    }   
    return $output;	 
}
add_action( 'wp_dropdown_pages', 'lbb_dropdown_pages_multiple', 10, 1 );
function lbb_header_code(){
    $wp_p = array('H'=>get_option('page_on_front'), 'C'=>get_the_ID());
    $google_option = get_option('lbb_google_details');
    $bing_option = get_option('lbb_bing_details');
    $about_option = get_option('lbb_about_details');
    
    if(isset($google_option['googleANA_ONOFF']) && $google_option['googleANA_ONOFF'] != 'off' && $google_option['googleUA'] != ''){
        $google_show = 0;
        if(is_array($google_option['googlePAGES']) && !empty($google_option['googlePAGES'])){
            foreach($google_option['googlePAGES'] as $ind => $val){
                if($wp_p['C'] == $val || $val == 'all'){$google_show = 1;}
            }
        }else{
            if($google_option['googlePAGES'] == 'all'){$google_show = 1;}
        }
        if($google_show === 1){
            echo '<script async src="https://www.googletagmanager.com/gtag/js?id='.$google_option['googleUA'].'"></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag(\'js\', new Date());gtag(\'config\', \''.$google_option['googleUA'].'\');</script>';    
        }
    }
    if(isset($google_option['googleWMT_ONOFF']) && $google_option['googleWMT_ONOFF'] != 'off' && $google_option['googleWMT_ID'] != ''){
        if($wp_p['H'] == $wp_p['C']){
            echo '<meta name="google-site-verification" content="'.$google_option['googleWMT_ID'].'" />';
        }        
    }
    if(isset($bing_option['bingWMT_ONOFF']) && $bing_option['bingWMT_ONOFF'] != 'off' && $bing_option['bingWMT_ID'] != ''){
        if($wp_p['H'] == $wp_p['C']){
            echo '<meta name="google-site-verification" content="'.$bing_option['bingWMT_ID'].'" />';
        }        
    }
    if(isset($about_option['BusinessSchema_ONOFF']) && $about_option['BusinessSchema_ONOFF'] != 'off'){
        include( plugin_dir_path( __FILE__ ) . 'php_libraries/lbb_schema.php');
        $schema = new lbb_schema();
        if($wp_p['H'] == $wp_p['C']){
            if(isset($about_option['BusinessSchemaPosts_ONOFF']) && $about_option['BusinessSchemaPosts_ONOFF'] != 'off' && is_singular('post')){
                 echo $schema->blogpost();
            }else{
                 echo $schema->localbusiness();
            } 
        } else{
          if(isset($about_option['BusinessSchemaPosts_ONOFF']) && $about_option['BusinessSchemaPosts_ONOFF'] != 'off' && is_singular('post')){
                 echo $schema->blogpost();
          }  
        }       
    }
}
add_action('wp_head', 'lbb_header_code');
function lbb_ajax_ping_se(){
    include( plugin_dir_path( __FILE__ ) . 'php_libraries/lbb_sitemap.php');
    $sitemap = new lbb_sitemap();

    if(isset($_POST['action']) && $_POST['action'] =='lbb_ajax_ping_se'){
            $sitemap_url = urlencode(get_site_url().'/'.$sitemap->xml_files['Main']['File']);
            $googleping_url = 'http://google.com/ping?sitemap='.$sitemap_url;
            $bingping_url = 'http://www.bing.com/ping?sitemap='.$sitemap_url;
            
            if(isset($_POST['pb']) && $_POST['pb'] =='Y'){
                // ping bing
                $data = file_get_contents($bingping_url);
            }
            if(isset($_POST['pg']) && $_POST['pg'] =='Y'){
                // ping google
                $data = file_get_contents($googleping_url);
            } 
            echo json_encode(array('Success', 'Success'), JSON_FORCE_OBJECT);        
    }else{
        echo json_encode(array('Error', 'Error Posting Data'), JSON_FORCE_OBJECT);
    }
    die();
}
add_action( 'wp_ajax_lbb_ajax_ping_se', 'lbb_ajax_ping_se' );
//analytics dashboard widget
//add_action( 'wp_dashboard_setup', 'lbb_dashboard_add_widgets' );
//function lbb_dashboard_add_widgets() {
//    $wpfeatures_option = get_option('lbb_wpfeatures_details');
//    if(isset($wpfeatures_option['wpfeatures_ONOFF']) && $wpfeatures_option['wpfeatures_ONOFF'] != 'off'){
//        if(isset($wpfeatures_option['wpfeaturesGoogleANA_ONOFF']) && $wpfeatures_option['wpfeaturesGoogleANA_ONOFF'] != 'off'){
//            wp_add_dashboard_widget( 'lbb_analytics_dashboard_widget', 'Google Analytics', 'lbb_analytics_handler', 'lbb_analytics_config_handler' );    
//        }
//    }
//	
//}
//
//function lbb_analytics_handler() {
//  
//	echo 'This is some text.';
//}
//function lbb_analytics_config_handler() {
//    
//    
//}
add_shortcode('lbb', 'lbb_display_shortcode');
function lbb_display_shortcode($atts) {
    $about_option = get_option('lbb_about_details');
    $wpfeatures_option = get_option('lbb_wpfeatures_details');
    if(isset($wpfeatures_option['wpfeatures_ONOFF']) && $wpfeatures_option['wpfeatures_ONOFF'] != 'off'){
        if(isset($wpfeatures_option['wpfeaturesShortcodes']) && $wpfeatures_option['wpfeaturesShortcodes'] != 'off'){
            if(isset($atts['show']) && !empty($atts['show'])){
                $atts['show'] = strtolower($atts['show']);
                if($atts['show'] == 'name'){
                    return $about_option['BusinessName'];
                }elseif($atts['show'] == 'desc'){
                    return $about_option['BusinessDesc'];
                }elseif($atts['show'] == 'number'){
                    return $about_option['BusinessNo'];
                }elseif($atts['show'] == 'email'){
                    return $about_option['BusinessEmail'];
                }elseif($atts['show'] == 'phone'){
                    return $about_option['BusinessPhone'];
                }elseif($atts['show'] == 'address'){
                    return $about_option['BusinessStreet'] . ', ' . $about_option['BusinessSuburb'] . ', ' . $about_option['BusinessPostcode'] . ', ' . $about_option['BusinessState'];
                }elseif($atts['show'] == 'hours'){
                    return build_hours($about_option['BussinesHours']);
                }elseif($atts['show'] == 'facebook'){
                    return $about_option['facebookLink'];
                }elseif($atts['show'] == 'twitter'){
                    return $about_option['twitterLink'];
                }elseif($atts['show'] == 'google'){
                    return $about_option['googleLink'];
                }else{
                    return 'Not Found';
                }
            }else{
                // display contact list - Business Name, Number, Phone, Address
                $html = '<div class="lbb_display">
                            <div class="lbb_name bold">' . $about_option['BusinessName'] . '</div>
                            <div class="lbb_name">' . $about_option['BusinessDesc'] . '</div>
                            <div class="lbb_name">' . $about_option['BusinessEmail'] . '</div>
                            <div class="lbb_name">' . $about_option['BusinessPhone'] . '</div>
                            <div class="lbb_name">' . $about_option['BusinessStreet'] . ', ' . $about_option['BusinessSuburb'] . ', ' . $about_option['BusinessPostcode'] . ', ' . $about_option['BusinessState'] . '</div>
                            <div class="lbb_name">' . build_hours($about_option['BussinesHours']) . '</div>
                            <div class="lbb_name">' . $about_option['facebookLink'] . '</div>                     
                            <div class="lbb_name">' . $about_option['twitterLink'] . '</div>                     
                            <div class="lbb_name">' . $about_option['googleLink'] . '</div>                     
                        </div>';
                return $html;
            }    
        }else{
            return '';
        }
    }else{
        return '';
    }
}
function build_hours($hours){
    $html = '<div id="lbb_hours">';
    if(is_array($hours) && !empty($hours)){
        foreach($hours as $day => $dets){
            $html .= '<div class="lbb_line"><div class="lbb_day">' . ucfirst($day) . ':</div>';
            if(isset($dets['closed'])){
                $html .= '<div class="lbb_closed">Closed</div></div>';        
            }else{
                $html .= '<div class="lbb_open">' . $dets['open'] . '</div>';  
                $html .= '<div class="lbb_split"> - </div>';  
                $html .= '<div class="lbb_close">' . $dets['close'] . '</div></div>';  
            }
        }
    }
    $html .= '</div>';
    return $html;
}
?>