<?php

function register_lbb_settings() {
    
    $about_defaults = array(
      'BusinessCategory'                   => 'LocalBusiness',
      'BusinessName'                   => '',
      'BusinessNo'                     => '',
      'BusinessEmail'                  => '',
      'BusinessPhone'                  => '',
      'BusinessStreet'                 => '',
      'BusinessSuburb'                 => '',
      'BusinessPostcode'               => '',
      'BusinessState'                  => '',
      'BusinessCountry'                => '',
      'BussinesHours'                  => '',
      'googleLink'                     => '',
      'facebookLink'                   => '',
      'twitterLink'                    => '',
      'BusinessMapsLink'               => '',
      'BusinessLong'                   => '',
      'BusinessLat'                    => '',  
      'BusinessSchema_ONOFF'           => 'off',  
      'BusinessSchemaPosts_ONOFF'      => 'off',  
    );
    $wp_shortcodes = array(
        'BusinessName'      => '[lbb show="name"]',
        'BusinessNo'        => '[lbb show="number"]',
        'BusinessEmail'     => '[lbb show="email"]',
        'BusinessPhone'     => '[lbb show="phone"]',
        'BusinessDesc'      => '[lbb show="desc"]',
        'BusinessStreet'    => '[lbb show="address"]',
        'BusinessSuburb'    => '[lbb show="address"]',
        'BusinessPostcode'  => '[lbb show="address"]',
        'BusinessState'     => '[lbb show="address"]',
        'BussinesHours'     => '[lbb show="hours"]',
        'googleLink'        => '[lbb show="google"]',
        'facebookLink'      => '[lbb show="facebook"]',
        'twitterLink'       => '[lbb show="twitter"]'
    );
    
    
    $about_option = wp_parse_args(get_option('lbb_about_details'), $about_defaults);
    if($about_option['BusinessSchema_ONOFF'] == 'on'){$about_option['BusinessSchema_ONOFF'] = 'checked';}
    if($about_option['BusinessSchemaPosts_ONOFF'] == 'on'){$about_option['BusinessSchemaPosts_ONOFF'] = 'checked';}
    
    $google_defaults = array(
      'googleANA_ONOFF'                 => 'off',
      'googleUA'                        => '',
      'googlePAGES'                     => 'all',
      'googleWMT_ONOFF'                 => 'off',
      'googleWMT_ID'                    => ''
    );
    $google_option = wp_parse_args(get_option('lbb_google_details'), $google_defaults);
    if($google_option['googleANA_ONOFF'] == 'on'){$google_option['googleANA_ONOFF'] = 'checked';}
    if($google_option['googleWMT_ONOFF'] == 'on'){$google_option['googleWMT_ONOFF'] = 'checked';}
    
    $sitemaps_defaults = array(
      'sitemaps_ONOFF'                  => 'off',
      'sitemapsPAGES_ONOFF'             => 'off',
      'sitemapsPOST_ONOFF'              => 'off',
      'sitemapsPOST_ONOFF'              => 'off',
      'sitemapsCAT_ONOFF'               => 'off',
      'sitemapsTAGS_ONOFF'              => 'off',
      'sitemapsPING_GOOGLE'             => 'on',
      'sitemapsPING_BING'               => 'on',
    );
    $sitemap_option = wp_parse_args(get_option('lbb_sitemaps_details'), $sitemaps_defaults);
    add_settings_section( 
        'lbb_sitemaps',
        'Integrate XML Sitemaps',
        'lbb_sitemaps_callback',
        'lbb_sitemaps'
    );
    
    if($sitemap_option['sitemaps_ONOFF'] == 'on'){$sitemap_option['sitemaps_ONOFF'] = 'checked';}
    if($sitemap_option['sitemapsPAGES_ONOFF'] == 'on'){$sitemap_option['sitemapsPAGES_ONOFF'] = 'checked';}
    if($sitemap_option['sitemapsPOST_ONOFF'] == 'on'){$sitemap_option['sitemapsPOST_ONOFF'] = 'checked';}
    if($sitemap_option['sitemapsCAT_ONOFF'] == 'on'){$sitemap_option['sitemapsCAT_ONOFF'] = 'checked';}
    if($sitemap_option['sitemapsTAGS_ONOFF'] == 'on'){$sitemap_option['sitemapsTAGS_ONOFF'] = 'checked';}
    // SITEMAPS IMAGE
    //if($sitemap_option['sitemapsIMG_ONOFF'] == 'on'){$sitemap_option['sitemapsIMG_ONOFF'] = 'checked';}
    if($sitemap_option['sitemapsPING_GOOGLE'] == 'on'){$sitemap_option['sitemapsPING_GOOGLE'] = 'checked';}
    if($sitemap_option['sitemapsPING_BING'] == 'on'){$sitemap_option['sitemapsPING_BING'] = 'checked';}
    
    $bing_defaults = array(
      'bingWMT_ONOFF'                   => 'off',
      'bingWMT_ID'                      => ''
    );
    $bing_option = wp_parse_args(get_option('lbb_bing_details'), $bing_defaults);
    if($bing_option['bingWMT_ONOFF'] == 'on'){$bing_option['bingWMT_ONOFF'] = 'checked';}
    
    $wpfeatures_defaults = array(
      'wpfeatures_ONOFF'                => 'off',
      'wpfeatures_SELECT2'              => 'off',
      'wpfeaturesBlankPage'             => 'off',
      'wpfeaturesAdminBar'              => 'off'
    );
    $wpf = false;
    $wpf_sc = false;

    $wpfeatures_option = wp_parse_args(get_option('lbb_wpfeatures_details'), $wpfeatures_defaults); 
    if($wpfeatures_option['wpfeatures_ONOFF'] == 'on'){$wpfeatures_option['wpfeatures_ONOFF'] = 'checked'; $wpf = true;}
    if($wpfeatures_option['wpfeatures_SELECT2'] == 'on'){$wpfeatures_option['wpfeatures_SELECT2'] = 'checked';}
    if($wpfeatures_option['wpfeaturesBlankPage'] == 'on'){$wpfeatures_option['wpfeaturesBlankPage'] = 'checked';}
    if($wpfeatures_option['wpfeaturesAdminBar'] == 'on'){$wpfeatures_option['wpfeaturesAdminBar'] = 'checked';}
    if($wpfeatures_option['wpfeaturesShortcodes'] == 'on'){ $wpfeatures_option['wpfeaturesShortcodes'] = 'checked'; if($wpf){$wpf_sc = true;}}
              
    //if($wpfeatures_option['wpfeaturesGoogleANA_ONOFF'] == 'on'){$wpfeatures_option['wpfeaturesGoogleANA_ONOFF'] = 'checked';}
    
    add_settings_section( 
        'lbb_about',
        'Your Local Business Information',
        'lbb_about_callback',
        'lbb_about'
    );
    
    //start business information fields
    add_settings_field(  
        'BusinessCategory',                      
        'Business Category',               
        'lbb_infoclass_select_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'type'        => 'category', 
            'label_for'   => 'BusinessCategory', 
            'ID'          => 'BusinessCategory', 
            'name'        => 'BusinessCategory',
            'value'       => $about_option['BusinessCategory'],
            'option_name' => 'lbb_about_details',
            'default'     => 'Pick Category',
            'class'       => '',
            'hint'        => 'If you don\'t see your category, select LocalBusiness'
        )
    );
    add_settings_field(  
        'BusinessName',                      
        'Business Name:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessName', 
            'ID'          => 'BusinessName', 
            'name'        => 'BusinessName',
            'value'       => $about_option['BusinessName'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Legal Business Name ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessName'] : '')
        )
    );
    add_settings_field(  
        'BusinessNo',                      
        'Business Number:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessNo', 
            'ID'          => 'BusinessNo', 
            'name'        => 'BusinessNo',
            'value'       => $about_option['BusinessNo'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Legal Business Number (A.B.N etc) ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessNo'] : '')
        )
    );
    add_settings_field(  
        'BusinessDesc',                      
        'Business Description:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessDesc', 
            'ID'          => 'BusinessDesc', 
            'name'        => 'BusinessDesc',
            'value'       => $about_option['BusinessDesc'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Brief description about your business ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessDesc'] : '')
        )
    );
    add_settings_field(  
        'BusinessEmail',                      
        'Business Email:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessEmail', 
            'ID'          => 'BusinessEmail', 
            'name'        => 'BusinessEmail',
            'value'       => $about_option['BusinessEmail'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Contact Email ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessEmail'] : '')
        )
    );
    add_settings_field(  
        'BusinessPhone',                      
        'Business Phone:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessPhone', 
            'ID'          => 'BusinessPhone', 
            'name'        => 'BusinessPhone',
            'value'       => $about_option['BusinessPhone'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Contact Phone ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessPhone'] : '')
        )
    );
    add_settings_field(  
        'BusinessStreet',                      
        'Business Street:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessStreet', 
            'ID'          => 'BusinessStreet', 
            'name'        => 'BusinessStreet',
            'value'       => $about_option['BusinessStreet'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'eg. 12 Roady Rd ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessStreet'] : '')
        )
    );
    add_settings_field(  
        'BusinessSuburb',                      
        'Business Suburb:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessSuburb', 
            'ID'          => 'BusinessSuburb', 
            'name'        => 'BusinessSuburb',
            'value'       => $about_option['BusinessSuburb'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'eg. Brisbane ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessSuburb'] : '')
        )
    );
    add_settings_field(  
        'BusinessPostcode',                      
        'Business Postcode:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessPostcode', 
            'ID'          => 'BusinessPostcode', 
            'name'        => 'BusinessPostcode',
            'value'       => $about_option['BusinessPostcode'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'eg. 4000 ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessPostcode'] : '')
        )
    );
    add_settings_field(  
        'BusinessState',                      
        'Business State:',               
        'lbb_infoclass_select_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'type'        => 'state',
            'label_for'   => 'BusinessState', 
            'ID'          => 'BusinessState', 
            'name'        => 'BusinessState',
            'value'       => $about_option['BusinessState'],
            'country'       => $about_option['BusinessCountry'],
            'default'     => 'Pick State',
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'eg. Queensland ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BusinessState'] : '')
        )
    );
    add_settings_field(  
        'BusinessCountry',                      
        'Business Country',               
        'lbb_infoclass_select_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'type'        => 'country', 
            'label_for'   => 'BusinessCountry', 
            'ID'          => 'BusinessCountry', 
            'name'        => 'BusinessCountry',
            'value'       => $about_option['BusinessCountry'],
            'option_name' => 'lbb_about_details',
            'default'     => 'Pick Country',
            'class'       => '',
            'hint'        => 'eg. Australia'
        )
    );
    add_settings_field(  
        'BusinessMapsLink',                      
        'Google Maps CID',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessMapsLink', 
            'ID'          => 'BusinessMapsLink', 
            'name'        => 'BusinessMapsLink',
            'value'       => $about_option['BusinessMapsLink'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => '<a href="https://help.agencyanalytics.com/rankings/how-to/find-the-cid-number-for-a-google-my-business-listing/" target="_blank"> Find Google Maps CID Number</a>'
        )
    );
    add_settings_field(  
        'BusinessLong',                      
        'Business Longitude:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessLong', 
            'ID'          => 'BusinessLong', 
            'name'        => 'BusinessLong',
            'value'       => $about_option['BusinessLong'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => '<a href="https://www.latlong.net/" target="_blank"> Get Coords</a>'
        )
    );
    add_settings_field(  
        'BusinessLat',                      
        'Business Latitude:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessLat', 
            'ID'          => 'BusinessLat', 
            'name'        => 'BusinessLat',
            'value'       => $about_option['BusinessLat'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => '<a href="https://www.latlong.net/" target="_blank"> Get Coords</a>'
        )
    );
    add_settings_field(  
        'BusinessPriceRange',                      
        'Price Range:',               
        'lbb_range_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessPriceRange', 
            'ID'          => 'BusinessPriceRange', 
            'name'        => 'BusinessPriceRange',
            'value'       => $about_option['BusinessPriceRange'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Average Price Range of Products or Services'
        )
    );
    add_settings_field(  
        'BussinesHours',                      
        'Operating Hours',               
        'lbb_infoclass_select_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'type'        => 'time',
            'label_for'   => 'BussinesHours', 
            'ID'          => 'BussinesHours', 
            'name'        => 'BussinesHours',
            'value'       => $about_option['BussinesHours'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Your Business opertating hours ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['BussinesHours'] : '')
        )
    );
    add_settings_field(  
        'facebookLink',                      
        'Facebook URL:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'facebookLink', 
            'ID'          => 'facebookLink', 
            'name'        => 'facebookLink',
            'value'       => $about_option['facebookLink'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Your Full Facebook URL ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['facebookLink'] : '')
        )
    );
    add_settings_field(  
        'twitterLink',                      
        'Twitter URL:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'twitterLink', 
            'ID'          => 'twitterLink', 
            'name'        => 'twitterLink',
            'value'       => $about_option['twitterLink'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Your Full Twitter URL ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['twitterLink'] : '')
        )
    );
    add_settings_field(  
        'googleLink',                      
        'Google URL:',               
        'lbb_textbox_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'googleLink', 
            'ID'          => 'googleLink', 
            'name'        => 'googleLink',
            'value'       => $about_option['googleLink'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Your Full Google+ Link ' . (($wpf_sc) ? ' - Shortcode: ' . $wp_shortcodes['googleLink'] : '')
        )
    );
    add_settings_field(  
        'BusinessSchema_ONOFF',                      
        'Build Business JSON-LD Schema',               
        'lbb_switch_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessSchema_ONOFF', 
            'ID'          => 'BusinessSchema_ONOFF', 
            'name'        => 'BusinessSchema_ONOFF',
            'value'       => $about_option['BusinessSchema_ONOFF'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Build JSON-LD Schema On / Off'
        )
    );
    add_settings_field(  
        'BusinessSchemaPosts_ONOFF',                      
        'Build Posts JSON-LD Schema',               
        'lbb_switch_callback',   
        'lbb_about',                     
        'lbb_about',
        array (
            'label_for'   => 'BusinessSchemaPosts_ONOFF', 
            'ID'          => 'BusinessSchemaPosts_ONOFF', 
            'name'        => 'BusinessSchemaPosts_ONOFF',
            'value'       => $about_option['BusinessSchemaPosts_ONOFF'],
            'option_name' => 'lbb_about_details',
            'class'       => '',
            'hint'        => 'Build JSON-LD Schema For Posts On / Off'
        )
    );
    
    // google settings
    add_settings_section( 
        'lbb_google',
        'Integrate Google',
        'lbb_google_callback',
        'lbb_google'
    );
    
    
    
    add_settings_field(  
        'googleANA_ONOFF',                      
        'Google Analytics',               
        'lbb_switch_callback',   
        'lbb_google',                     
        'lbb_google',
        array (
            'label_for'   => 'googleANA_ONOFF', 
            'ID'          => 'googleANA_ONOFF', 
            'name'        => 'googleANA_ONOFF',
            'value'       => $google_option['googleANA_ONOFF'],
            'option_name' => 'lbb_google_details',
            'class'       => '',
            'hint'        => 'Turn Google Analytics On / Off Sitewide'
        )
    );
    add_settings_field(  
        'googleUA',                      
        'Tracking ID:',               
        'lbb_textbox_callback',   
        'lbb_google',                     
        'lbb_google',
        array (
            'label_for'   => 'googleUA', 
            'ID'          => 'googleUA', 
            'name'        => 'googleUA',
            'value'       => $google_option['googleUA'],
            'option_name' => 'lbb_google_details',
            'class'       => '',
            'hint'        => 'Google Analytics Tracking ID (UA-*********-*)'
        )
    );
    add_settings_field(  
        'googlePAGES',                      
        'Tracking Pages:',               
        'lbb_pages_2_select',   
        'lbb_google',                     
        'lbb_google',
        array (
            'label_for'   => 'lbb_google_details[googlePAGES]', 
            'ID'          => 'lbb_google_details[googlePAGES]', 
            'name'        => 'lbb_google_details[googlePAGES]',
            'value'       => $google_option['googlePAGES'],
            'option_name' => 'lbb_google_details',
            'class'       => '',
            'hint'        => 'Select Pages To Track',
            'echo'        => 0,
        )
    );
    
    add_settings_field(  
        'googleWMT_ONOFF',                      
        'Google Webmaster Tools',               
        'lbb_switch_callback',   
        'lbb_google',                     
        'lbb_google',
        array (
            'label_for'   => 'googleWMT_ONOFF', 
            'ID'          => 'googleWMT_ONOFF', 
            'name'        => 'googleWMT_ONOFF',
            'value'       => $google_option['googleWMT_ONOFF'],
            'option_name' => 'lbb_google_details',
            'class'       => '',
            'hint'        => 'Turn Google Webmaster Tools On / Off Sitewide'
        )
    );
    add_settings_field(  
        'googleWMT_ID',                      
        'Content Value:',               
        'lbb_textbox_callback',   
        'lbb_google',                     
        'lbb_google',
        array (
            'label_for'   => 'googleWMT_ID', 
            'ID'          => 'googleWMT_ID', 
            'name'        => 'googleWMT_ID',
            'value'       => $google_option['googleWMT_ID'],
            'option_name' => 'lbb_google_details',
            'class'       => '',
            'hint'        => 'Google Webmaster Tools "google-site-verification" content value'
        )
    );
    
    // Sitemap Settings
    
    add_settings_field(  
        'sitemaps_ONOFF',                      
        'XML Sitemaps',               
        'lbb_switch_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemaps_ONOFF', 
            'ID'          => 'sitemaps_ONOFF', 
            'name'        => 'sitemaps_ONOFF',
            'value'       => $sitemap_option['sitemaps_ONOFF'],
            'option_name' => 'lbb_sitemaps_details',
            'class'       => '',
            'hint'        => 'Turn XML Sitemaps On / Off Sitewide'
        )
    );
    add_settings_field(  
        'sitemapsPAGES_ONOFF',                      
        'Page Sitemap',               
        'lbb_switch_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsPAGES_ONOFF', 
            'ID'          => 'sitemapsPAGES_ONOFF', 
            'name'        => 'sitemapsPAGES_ONOFF',
            'value'       => $sitemap_option['sitemapsPAGES_ONOFF'],
            'option_name' => 'lbb_sitemaps_details',
            'class'       => '',
            'hint'        => 'Create Pages Sitemap'
        )
    );
    add_settings_field(  
        'sitemapsPOST_ONOFF',                      
        'Post Sitemap',               
        'lbb_switch_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsPOST_ONOFF', 
            'ID'          => 'sitemapsPOST_ONOFF', 
            'name'        => 'sitemapsPOST_ONOFF',
            'value'       => $sitemap_option['sitemapsPOST_ONOFF'],
            'option_name' => 'lbb_sitemaps_details',
            'class'       => '',
            'hint'        => 'Create Posts Sitemap'
        )
    );
    add_settings_field(  
        'sitemapsCAT_ONOFF',                      
        'Category Sitemap',               
        'lbb_switch_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsCAT_ONOFF', 
            'ID'          => 'sitemapsCAT_ONOFF', 
            'name'        => 'sitemapsCAT_ONOFF',
            'value'       => $sitemap_option['sitemapsCAT_ONOFF'],
            'option_name' => 'lbb_sitemaps_details',
            'class'       => '',
            'hint'        => 'Create Category Sitemap'
        )
    );
    add_settings_field(  
        'sitemapsTAGS_ONOFF',                      
        'Tags Sitemap',               
        'lbb_switch_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsTAGS_ONOFF', 
            'ID'          => 'sitemapsTAGS_ONOFF', 
            'name'        => 'sitemapsTAGS_ONOFF',
            'value'       => $sitemap_option['sitemapsTAGS_ONOFF'],
            'option_name' => 'lbb_sitemaps_details',
            'class'       => '',
            'hint'        => 'Create Tags Sitemap'
        )
    );
    
    // SITEMAPS IMAGE
    //add_settings_field(  
    //    'sitemapsIMG_ONOFF',                      
    //    'Image Sitemap',               
    //    'lbb_switch_callback',   
    //    'lbb_sitemaps',                     
    //    'lbb_sitemaps',
    //    array (
    //        'label_for'   => 'sitemapsIMG_ONOFF', 
    //        'ID'          => 'sitemapsIMG_ONOFF', 
    //        'name'        => 'sitemapsIMG_ONOFF',
    //        'value'       => $sitemap_option['sitemapsIMG_ONOFF'],
    //        'option_name' => 'lbb_sitemaps_details',
    //        'class'       => '',
    //        'hint'        => 'Create Image Sitemap'
    //    )
    //);
    
    add_settings_field(  
        'sitemapsPING_GOOGLE',                      
        'Ping Google',               
        'lbb_checkbox_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsPING_GOOGLE', 
            'ID'          => 'sitemapsPING_GOOGLE', 
            'name'        => 'sitemapsPING_GOOGLE',
            'value'       => $sitemap_option['sitemapsPING_GOOGLE'],
            'option_name' => 'lbb_sitemaps_details',
            'class'       => '',
            'hint'        => 'Ping Sitemaps to Google'
        )
    );
    add_settings_field(  
        'sitemapsPING_BING',                      
        'Ping Bing',               
        'lbb_checkbox_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsPING_BING', 
            'ID'          => 'sitemapsPING_BING', 
            'name'        => 'sitemapsPING_BING',
            'value'       => $sitemap_option['sitemapsPING_BING'],
            'option_name' => 'lbb_sitemaps_details',
            'class'       => '',
            'hint'        => 'Ping Sitemaps to Bing'
        )
    );
    add_settings_field(  
        'sitemapsPING_BUTTON',                      
        '',               
        'lbb_button_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsPING_BUTTON', 
            'ID'          => 'sitemapsPING_BUTTON', 
            'name'        => 'sitemapsPING_BUTTON',
            'value'       => 'Ping Sitemaps to Search Engines',
            'option_name' => 'lbb_sitemaps_details',
            'type'        => 'secondary',
            'hint'        => 'Use Ajax to Ping Sitemaps to Search Engines Now'
        )
    );
    add_settings_field(  
        'sitemapsPING_STATUS',                      
        'Ping Status',               
        'lbb_ajaxstatus_callback',   
        'lbb_sitemaps',                     
        'lbb_sitemaps',
        array (
            'label_for'   => 'sitemapsPING_STATUS', 
            'ID'          => 'sitemapsPING_STATUS', 
            'value'       => 'Idle...',
            'option_name' => 'lbb_sitemaps_details'
        )
    );
    
    
    // Bing settings
    add_settings_section( 
        'lbb_bing',
        'Integrate Bing',
        'lbb_bing_callback',
        'lbb_bing'
    );
    
    add_settings_field(  
        'bingWMT_ONOFF',                      
        'Bing Webmaster Tools',               
        'lbb_switch_callback',   
        'lbb_bing',                     
        'lbb_bing',
        array (
            'label_for'   => 'bingWMT_ONOFF', 
            'ID'          => 'bingWMT_ONOFF', 
            'name'        => 'bingWMT_ONOFF',
            'value'       => $bing_option['bingWMT_ONOFF'],
            'option_name' => 'lbb_bing_details',
            'class'       => '',
            'hint'        => 'Turn Bing Webmaster Tools On / Off'
        )
    );
    add_settings_field(  
        'bingWMT_ID',                      
        'Content Value:',               
        'lbb_textbox_callback',   
        'lbb_bing',                     
        'lbb_bing',
        array (
            'label_for'   => 'bingWMT_ID', 
            'ID'          => 'bingWMT_ID', 
            'name'        => 'bingWMT_ID',
            'value'       => $bing_option['bingWMT_ID'],
            'option_name' => 'lbb_bing_details',
            'class'       => '',
            'hint'        => 'Bing Webmaster Tools "google-site-verification" content value'
        )
    );
    

    // WP Features settings
    add_settings_section( 
        'lbb_wpfeatures',
        'Extra Wordpress Features',
        'lbb_wpfeatures_callback',
        'lbb_wpfeatures'
    );
    
    add_settings_field(  
        'wpfeatures_ONOFF',                      
        'Wordpress Features Tools',               
        'lbb_switch_callback',   
        'lbb_wpfeatures',                     
        'lbb_wpfeatures',
        array (
            'label_for'   => 'wpfeatures_ONOFF', 
            'ID'          => 'wpfeatures_ONOFF', 
            'name'        => 'wpfeatures_ONOFF',
            'value'       => $wpfeatures_option['wpfeatures_ONOFF'],
            'option_name' => 'lbb_wpfeatures_details',
            'class'       => '',
            'hint'        => 'Turn ALL Wordpress Features On / Off'
        )
    );
    add_settings_field(  
        'wpfeatures_SELECT2',                      
        'Searchable Selects',               
        'lbb_switch_callback',   
        'lbb_wpfeatures',                     
        'lbb_wpfeatures',
        array (
            'label_for'   => 'wpfeatures_SELECT2', 
            'ID'          => 'wpfeatures_SELECT2', 
            'name'        => 'wpfeatures_SELECT2',
            'value'       => $wpfeatures_option['wpfeatures_SELECT2'],
            'option_name' => 'lbb_wpfeatures_details',
            'class'       => '',
            'hint'        => 'Add Select2 Searchable Selects On / Off'
        )
    );
    add_settings_field(  
        'wpfeaturesBlankPage',                      
        'Blank Page Template',               
        'lbb_switch_callback',   
        'lbb_wpfeatures',                     
        'lbb_wpfeatures',
        array (
            'label_for'   => 'wpfeaturesBlankPage', 
            'ID'          => 'wpfeaturesBlankPage', 
            'name'        => 'wpfeaturesBlankPage',
            'value'       => $wpfeatures_option['wpfeaturesBlankPage'],
            'option_name' => 'lbb_wpfeatures_details',
            'class'       => '',
            'hint'        => 'Include Blank Page in Temaplates'
        )
    );
    add_settings_field(  
        'wpfeaturesShortcodes',                      
        'Business Info Shortcodes',               
        'lbb_switch_callback',   
        'lbb_wpfeatures',                     
        'lbb_wpfeatures',
        array (
            'label_for'   => 'wpfeaturesShortcodes', 
            'ID'          => 'wpfeaturesShortcodes', 
            'name'        => 'wpfeaturesShortcodes',
            'value'       => $wpfeatures_option['wpfeaturesShortcodes'],
            'option_name' => 'lbb_wpfeatures_details',
            'class'       => '',
            'hint'        => 'Enable Business Information Shortcodes'
        )
    );
    add_settings_field(  
        'wpfeaturesAdminBar',                      
        'Remove Admin Bar',               
        'lbb_switch_callback',   
        'lbb_wpfeatures',                     
        'lbb_wpfeatures',
        array (
            'label_for'   => 'wpfeaturesAdminBar', 
            'ID'          => 'wpfeaturesAdminBar', 
            'name'        => 'wpfeaturesAdminBar',
            'value'       => $wpfeatures_option['wpfeaturesAdminBar'],
            'option_name' => 'lbb_wpfeatures_details',
            'class'       => '',
            'hint'        => 'Remove front end admin bar for everyone.'
        )
    );
    //add_settings_field(  
    //    'wpfeaturesGoogleANA_ONOFF',                      
    //    'Google Analytics Dashboard Widget',               
    //    'lbb_switch_callback',   
    //    'lbb_wpfeatures',                     
    //    'lbb_wpfeatures',
    //    array (
    //        'label_for'   => 'wpfeaturesGoogleANA_ONOFF', 
    //        'ID'          => 'wpfeaturesGoogleANA_ONOFF', 
    //        'name'        => 'wpfeaturesGoogleANA_ONOFF',
    //        'value'       => $wpfeatures_option['wpfeaturesGoogleANA_ONOFF'],
    //        'option_name' => 'lbb_wpfeatures_details',
    //        'class'       => '',
    //        'hint'        => 'Turn Google Analytics Dashboard Widget On / Off'
    //    )
    //);
    //add_settings_field(  
    //    'wpfeaturesGoogleSIGNIN',                      
    //    'Google Sign In',               
    //    'lbb_iframe_callback',   
    //    'lbb_wpfeatures',                     
    //    'lbb_wpfeatures',
    //    array (
    //        'label_for'   => 'wpfeaturesGoogleSIGNIN', 
    //        'ID'          => 'wpfeaturesGoogleSIGNIN', 
    //        'name'        => 'wpfeaturesGoogleSIGNIN',
    //        'value'       => $wpfeatures_option['wpfeaturesGoogleSIGNIN'],
    //        'option_name' => 'lbb_wpfeatures_details',
    //        'class'       => '',
    //        'hint'        => 'Sign Into Your Google Account'
    //    )
    //);
    
     add_settings_section( 
        'lbb_details',
        'Local Business Booster',
        'lbb_details_callback',
        'lbb_details'
    );
    add_settings_field(  
        'lbbDonate',                      
        '',               
        'lbb_infobox_callback',   
        'lbb_details',                     
        'lbb_details',
        array ( 
            'ID'          => 'lbbDonate',
            'title'       => 'Donate',
            'class'       => '',
            'text'        => 'This is a free plugin built to help make your website and business better. <a href="http://wordpress.plustime.com.au/donate/" target="_blank">Please consider donating to second2none </a>.'
        )
    );
    add_settings_field(  
        'lbbInfoDetails',                      
        '',               
        'lbb_infobox_callback',   
        'lbb_details',                     
        'lbb_details',
        array ( 
            'ID'          => 'lbbInfoDetails',
            'title'       => 'Business Information',
            'class'       => '',
            'text'        => 'Keeping all your Business information uniform is important to search engines and customers. Give the search engines the right info with JSON-LD Schema.'
        )
    );
    add_settings_field(  
        'lbbGoogleDetails',                      
        '',               
        'lbb_infobox_callback',   
        'lbb_details',                     
        'lbb_details',
        array ( 
            'ID'          => 'lbbGoogleDetails',
            'title'       => 'Google Integration',
            'class'       => '',
            'text'        => 'Setting your website up with google gives you many benefits. This plugin allows you to connect your google analytics account and search console (formally webmasters tools) to your wordpress site easily.'
        )
    );
    add_settings_field(  
        'lbbBingDetails',                      
        '',               
        'lbb_infobox_callback',   
        'lbb_details',                     
        'lbb_details',
        array ( 
            'ID'          => 'lbbBingDetails',
            'title'       => 'Bing Integration',
            'class'       => '',
            'text'        => 'Bing also offer a set of webmaster tools to help push your website in the right direction.'
        )
    );
    add_settings_field(  
        'lbbXMLDetails',                      
        '',               
        'lbb_infobox_callback',   
        'lbb_details',                     
        'lbb_details',
        array ( 
            'ID'          => 'lbbXMLDetails',
            'title'       => 'Sitemaps XML Integration',
            'class'       => '',
            'text'        => 'Ensuring you have the correct sitemaps is important so you can ensure search engines index all the pages you want.'
        )
    );
    add_settings_field(  
        'lbbFeaturesDetails',                      
        '',               
        'lbb_infobox_callback',   
        'lbb_details',                     
        'lbb_details',
        array ( 
            'ID'          => 'lbbFeaturesDetails',
            'title'       => 'Wordpress Features',
            'class'       => '',
            'text'        => 'Wordpress is already easy to use, enabling these features make it even easier.'
        )
    );
    
    register_setting('lbb_about', 'lbb_about_details', array('sanitize_callback' => 'lbb_sanitize'));
    register_setting('lbb_google', 'lbb_google_details', array('sanitize_callback' => 'lbb_google_sanitize'));
    register_setting('lbb_bing', 'lbb_bing_details', array('sanitize_callback' => 'lbb_bing_sanitize'));
    register_setting('lbb_sitemaps', 'lbb_sitemaps_details', array('sanitize_callback' => 'lbb_sitemaps_sanitize'));
    register_setting('lbb_wpfeatures', 'lbb_wpfeatures_details', array('sanitize_callback' => 'lbb_wpfeatures_sanitize'));
    register_setting('lbb_details', 'lbb_details_option');
}

function lbb_sanitize($input){
    if(!isset($input['BusinessName'])){
        $input['BusinessName'] = '';
    }
    
    return $input;
}
function lbb_google_sanitize($input){
    if(isset($input['googleANA_ONOFF'])){
        if($input['googleANA_ONOFF'] != 'on'){
            add_settings_error('Invalid-googleANA_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['googleANA_ONOFF'] = 'off';
        }
    }else{$input['googleANA_ONOFF'] = 'off';}
    if(isset($input['googleWMT_ONOFF'])){
        if($input['googleWMT_ONOFF'] != 'on'){
            add_settings_error('Invalid-googleWMT_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['googleWMT_ONOFF'] = 'off';
        }
    }else{$input['googleWMT_ONOFF'] = 'off';}
    
    return $input;
}
function lbb_bing_sanitize($input){
    if(isset($input['bingWMT_ONOFF'])){
        if($input['bingWMT_ONOFF'] != 'on'){
            add_settings_error('Invalid-bingWMT_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['bingWMT_ONOFF'] = 'off';
        }
    }else{$input['bingWMT_ONOFF'] = 'off';}
    
    return $input;
}
function lbb_wpfeatures_sanitize($input){
    
    if(isset($input['wpfeatures_ONOFF'])){
        if($input['wpfeatures_ONOFF'] != 'on'){
            add_settings_error('Invalid-wpfeatures_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['wpfeatures_ONOFF'] = 'off';
        }
    }else{$input['wpfeatures_ONOFF'] = 'off';}
    
    if(isset($input['wpfeatures_SELECT2'])){
        if($input['wpfeatures_SELECT2'] != 'on'){
            add_settings_error('Invalid-wpfeatures_SELECT2','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['wpfeatures_SELECT2'] = 'off';
        }
    }else{$input['wpfeatures_SELECT2'] = 'off';}
    
    if(isset($input['wpfeaturesBlankPage'])){
        if($input['wpfeaturesBlankPage'] != 'on'){
            add_settings_error('Invalid-wpfeaturesBlankPage','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['wpfeaturesBlankPage'] = 'off';
        }
    }else{$input['wpfeaturesBlankPage'] = 'off';}
    
    if(isset($input['wpfeaturesShortcodes'])){
        if($input['wpfeaturesShortcodes'] != 'on'){
            add_settings_error('Invalid-wpfeaturesShortcodes','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['wpfeaturesShortcodes'] = 'off';
        }
    }else{$input['wpfeaturesShortcodes'] = 'off';}
    
    if(isset($input['wpfeaturesAdminBar'])){
        if($input['wpfeaturesAdminBar'] != 'on'){
            add_settings_error('Invalid-wpfeaturesAdminBar','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['wpfeaturesAdminBar'] = 'off';
        }
    }else{$input['wpfeaturesAdminBar'] = 'off';}
    
    //if(isset($input['wpfeaturesGoogleANA_ONOFF'])){
    //    if($input['wpfeaturesGoogleANA_ONOFF'] != 'on'){
    //        add_settings_error('Invalid-wpfeaturesGoogleANA_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
    //        $input['wpfeaturesGoogleANA_ONOFF'] = 'off';
    //    }
    //}else{$input['wpfeaturesGoogleANA_ONOFF'] = 'off';}
    
    return $input;
}
function lbb_sitemaps_sanitize($input){
    if(isset($input['sitemaps_ONOFF'])){
        if($input['sitemaps_ONOFF'] != 'on'){
            add_settings_error('Invalid-sitemaps_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['sitemaps_ONOFF'] = 'off';
        }
    }else{$input['sitemaps_ONOFF'] = 'off';}
    
    if(isset($input['sitemapsPAGES_ONOFF'])){
        if($input['sitemapsPAGES_ONOFF'] != 'on'){
            add_settings_error('Invalid-sitemapsPAGES_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['sitemapsPAGES_ONOFF'] = 'off';
        }
    }else{$input['sitemapsPAGES_ONOFF'] = 'off';}
    
    if(isset($input['sitemapsPOST_ONOFF'])){
        if($input['sitemapsPOST_ONOFF'] != 'on'){
            add_settings_error('Invalid-sitemapsPOST_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['sitemapsPOST_ONOFF'] = 'off';
        }
    }else{$input['sitemapsPOST_ONOFF'] = 'off';}
    
    if(isset($input['sitemapsCAT_ONOFF'])){
        if($input['sitemapsCAT_ONOFF'] != 'on'){
            add_settings_error('Invalid-sitemapsCAT_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['sitemapsCAT_ONOFF'] = 'off';
        }
    }else{$input['sitemapsCAT_ONOFF'] = 'off';}
    
    if(isset($input['sitemapsTAGS_ONOFF'])){
        if($input['sitemapsTAGS_ONOFF'] != 'on'){
            add_settings_error('Invalid-sitemapsTAGS_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['sitemapsTAGS_ONOFF'] = 'off';
        }
    }else{$input['sitemapsTAGS_ONOFF'] = 'off';}
    
    // SITEMAPS IMAGE
    //if(isset($input['sitemapsIMG_ONOFF'])){
    //    if($input['sitemapsIMG_ONOFF'] != 'on'){
    //        add_settings_error('Invalid-sitemapsIMG_ONOFF','empty','Inncorrect On/Off Value - This has been Switched off','updated');
    //        $input['sitemapsIMG_ONOFF'] = 'off';
    //    }
    //}else{$input['sitemapsIMG_ONOFF'] = 'off';}
    
    if(isset($input['sitemapsPING_GOOGLE'])){
        if($input['sitemapsPING_GOOGLE'] != 'on'){
            add_settings_error('Invalid-sitemapsPING_GOOGLE','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['sitemapsPING_GOOGLE'] = 'off';
        }
    }else{$input['sitemapsPING_GOOGLE'] = 'off';}
    
    if(isset($input['sitemapsPING_BING'])){
        if($input['sitemapsPING_BING'] != 'on'){
            add_settings_error('Invalid-sitemapsPING_BING','empty','Inncorrect On/Off Value - This has been Switched off','updated');
            $input['sitemapsPING_BING'] = 'off';
        }
    }else{$input['sitemapsPING_BING'] = 'off';}
    
    $sitemap_option = get_option('lbb_sitemaps_details');

    $input['plugin_dir_path'] = $sitemap_option['plugin_dir_path'];
    $input['xsl_sitemaps'] = $sitemap_option['xsl_sitemaps'];
    $input['xsl_child'] = $sitemap_option['xsl_child'];

    return $input;
}
function lbb_about_callback($args) { 
    $wpf = false;
    $wpf_sc = false;
    $wpfeatures_option = get_option('lbb_wpfeatures_details'); 
    if($wpfeatures_option['wpfeatures_ONOFF'] == 'on'){$wpf = true;}
    if($wpfeatures_option['wpfeaturesShortcodes'] == 'on'){if($wpf){$wpf_sc = true;}}
    
    echo '<p> Fill in your Local Business Information ' . (($wpf_sc) ? ' - Display All Shortcode: [lbb] ': '') . '</p>';
}
function lbb_wpfeatures_callback($args) { 
    echo '<p> Activate / Deactivate Better Wordpress Features for your website</p>';
}
function lbb_google_callback($args) { 
    echo '<p> Integrate certain Google Features for your website</p>';
}
function lbb_bing_callback($args) { 
    echo '<p> Integrate certain Bing Features for your website</p>';
}
function lbb_sitemaps_callback($args) { 
    echo '<p> Generate XML Sitemaps for your website</p>';
}
function lbb_details_callback($args) { 
    echo '<p> Details about our Local Business Booster </p>';
}



function lbb_switch_callback($args){
    echo '<div class="onoffswitch">
                <input type="checkbox" name="' . $args["option_name"] . '[' . $args["ID"] . ']" class="onoffswitch-checkbox" id="' . $args["ID"] . '" ' . $args["value"] . '>
                <label class="onoffswitch-label" for="' . $args["ID"] . '"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label>
          </div>';         
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
}
function lbb_textbox_callback( $args ) { 
    echo '<input type="text" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" value="' . $args["value"] . '" class="field-40">';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
}
function lbb_googlesignin_callback( $args ) { 
    echo '<div class="g-signin2" data-onsuccess="onSignIn"></div>';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
}
function lbb_iframe_callback( $args ) { 
    echo '<iframe style="height: 80px; width: 250px;" src="https://plustime.com.au/oauth2_callback.php"> </iframe>';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
}
function lbb_textarea_callback( $args ) { 
    echo '<textarea id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" rows="5" class="field-40">' . $args["value"] . '</textarea> ';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
}
function lbb_checkbox_callback( $args ) { 
    echo '<input type="checkbox" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" ' . $args["value"] . ' >';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
}
function lbb_button_callback( $args ) { 
    echo '<input type="submit" name="' . $args["option_name"] . '[' . $args["ID"] . ']" id="' . $args["ID"] . '" class="button button-' . $args["type"] . '" value="' . $args["value"] . '">';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
}
function lbb_ajaxstatus_callback( $args ) { 
    echo '<span id="' . $args["ID"] . '">' . $args["value"] . ' </span>';
}
function lbb_infobox_callback( $args ) { 
    echo '<tr id="' . $args["ID"] . ' class="'.$args["class"].'">';
    echo '<td class="mw_d_title">'.$args["title"].'</td><td>'.$args["text"].'</td>';
    echo '</tr>';
}
function lbb_range_callback( $args ) { 
    echo '<tr id="' . $args["ID"] . ' class="'.$args["class"].'">';
    echo '<td>'.$args["title"].'</td>
          <td>
            <span>$<input type="text" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . '][min]" value="' . $args["value"]["min"] . '" class=""></span> 
            <span>to</span> 
            <span>$<input type="text" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . '][max]" value="' . $args["value"]["max"] . '" class=""></span>
          ';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p class="hint">'.$args["hint"].'</p>';
    }
    echo '</td></tr>';
    
}
function lbb_infoclass_select_callback($args){
    if(class_exists('lbb_business_info')){
        global $binfo;
        if($args['type'] == 'state'){
            echo $binfo->return_state_select($args);
        }elseif($args['type'] == 'country'){
            echo $binfo->return_country_select($args);
        }elseif($args['type'] == 'category'){
            echo $binfo->return_business_cat_select($args);
        }elseif($args['type'] == 'time'){
             $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
            foreach($days as $day){
                $tmp_o = (!isset($args['value'][$day]['closed']) && isset($args['value'][$day]['open']) ? $args['value'][$day]['open'] : '00:00');
                $tmp_c = (!isset($args['value'][$day]['closed']) && isset($args['value'][$day]['close']) ? $args['value'][$day]['close'] : '00:00');
                $args_o = array('default'=>'Open', 'name'=> $args["option_name"] . '[' . $args["ID"] . '][' . $day . '][open]', 'ID'=> $day.'-close', 'class'=>'timebox-close', 'value'=>$tmp_o);
                $args_c = array('default'=>'Close', 'name'=> $args["option_name"] . '[' . $args["ID"] . '][' . $day . '][close]', 'ID'=> $day.'-open', 'class'=>'timebox-open', 'value'=>$tmp_c);
                echo '<tr>';
                echo '<td style="text-align:right;">'. ucfirst($day).':</td>
                        <td>
                        <span><input type="checkbox" id="' . $day . '-closed" name="' . $args["option_name"] . '[' . $args["ID"] . '][' . $day . '][closed]" class="close-day" value="true" '.(isset($args['value'][$day]['closed']) ? 'checked' : '').'> Closed </span>
                        <span id="' . $day . '-details" '.(isset($args['value'][$day]['closed']) ? 'style="display: none;"' : '').'><span>'.$binfo->return_24h_select($args_o).'</span>
                        <span>-</span>
                        <span>'.$binfo->return_24h_select($args_c).'</span>
                        '. (($day == 'monday') ? '<button id="applyall"> Apply To All Days </button>' : '') .'</span>
                        ';
                       
                echo '</td></tr>';        
            }
            if(isset($args["hint"]) && $args["hint"] != ''){
                    echo '<tr><td></td><td><p>'.$args["hint"].'</p></td></tr>';
            } 
        }
    }
    
}
function lbb_pages_2_select( $args ) {
    $page_select = wp_dropdown_pages( $args );
    if(is_array($args["value"])){
        foreach($args["value"] as $pageid){
            $page_select = str_replace('value="'.$pageid.'"', 'value="'.$pageid.'" selected="selected"', $page_select);
        }
    }else{
        if($args["value"] == 'all'){
            $page_select = str_replace('value="all"', 'value="all" selected="selected"', $page_select);
        }    
    }
    echo $page_select;
}
function lbb_select_callback( $args ) { 
    echo '<select id="' . $args["ID"] . '" name="' . $args["option_name"] . '["' . $args["ID"] . '"]" class="field-40">';
    foreach($args['options'] as $type => $label){
        if($args["value"] === $type){
            echo '<option value="'.$type.'" selected>'.$label.'</option>';
        }else{
            echo '<option value="'.$type.'">'.$label.'</option>';
        }
        
    }
    echo '</select>';
    if(isset($args["hint"]) && $args["hint"] != ''){
        echo '<p>'.$args["hint"].'</p>';
    }
}
function lbb_settings_page() {
?>

<div class="wrap">  
        <div id="icon-themes" class="icon32"></div>  
        <h2>Local Business Booster</h2>  
        <div class="description"> Just what your local business needed! </div>
        <?php settings_errors(); ?>  

        <?php  
                $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'about';  
        ?>  
        <h2 class="nav-tab-wrapper">  
            <a href="?page=lbb&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">Business Information</a>  
            <a href="?page=lbb&tab=google" class="nav-tab <?php echo $active_tab == 'google' ? 'nav-tab-active' : ''; ?>">Google Integration</a>  
            <a href="?page=lbb&tab=bing" class="nav-tab <?php echo $active_tab == 'bing' ? 'nav-tab-active' : ''; ?>">Bing Integration</a>  
            <a href="?page=lbb&tab=sitemaps" class="nav-tab <?php echo $active_tab == 'sitemaps' ? 'nav-tab-active' : ''; ?>">XML Sitemaps Integration</a>   
            <a href="?page=lbb&tab=wpfeatures" class="nav-tab <?php echo $active_tab == 'wpfeatures' ? 'nav-tab-active' : ''; ?>">Wordpress Features</a>  
            <a href="?page=lbb&tab=details" class="nav-tab <?php echo $active_tab == 'details' ? 'nav-tab-active' : ''; ?>">Local Business Booster Details</a>  
        </h2>  

        <form method="post" action="options.php">  
            <?php 
            
            if( $active_tab == 'about' ) {
                include( plugin_dir_path( __FILE__ ) . 'php_libraries/lbb_binfo.php');
                include( plugin_dir_path( __FILE__ ) . 'php_libraries/lbb_schema.php');
                global $binfo;
                global $schema;
                $binfo = new lbb_business_info();
                $schema = new lbb_schema();
                
                
                settings_fields( 'lbb_about' );
                do_settings_sections( 'lbb_about' );
                add_thickbox(); 
                ?>
                    <div id="modal-jsonschema-local" style="display:none;">
                         <div class="code-title">
                            Local Business Schema - JSON-LD
                         </div>
                         <div id="code-actions">
                            <button id="copy_schema_local">Copy Schema</button><br />
                          </div>
                         <div class="code-type">
                             <pre id="schema-code">
                                <?php echo htmlentities($schema->localbusiness()); ?>  
                             </pre>
                         </div>
                    </div>
                    
                    <a href="#TB_inline?&width=600&height=550&inlineId=modal-jsonschema-local" class="thickbox button button-secondary"> View JSON-LD Schema </a>
            <?php
                submit_button();
            } else if( $active_tab == 'google' ) {
                settings_fields( 'lbb_google' );
                do_settings_sections( 'lbb_google' );
                submit_button();
            } else if( $active_tab == 'bing' ) {
                settings_fields( 'lbb_bing' );
                do_settings_sections( 'lbb_bing' );
                submit_button();
            } else if( $active_tab == 'sitemaps' ) {
                settings_fields( 'lbb_sitemaps' );
                do_settings_sections( 'lbb_sitemaps' );
                submit_button();
            } else if( $active_tab == 'wpfeatures' ) {
                settings_fields( 'lbb_wpfeatures' );
                do_settings_sections( 'lbb_wpfeatures' );
                submit_button();
            } else if( $active_tab == 'details' ) {
            ?>
            <table id="lbb_details" class="lbb_details">
            <?php
                settings_fields( 'lbb_details' );
                do_settings_sections( 'lbb_details' ); 
            ?>
            </table>
            <?php
            }
            ?>             
        </form> 
    </div> 

<?php 
} 
?>