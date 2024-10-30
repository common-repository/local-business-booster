<?php

class lbb_sitemap{
    public $xml_files;
    public $options;
    function __construct(){
        $this->xml_files = array(
            'Main'            => array('File' => "lbb_sitemap.php",           'Title' => 'Main XML Sitemap',         'Function' => 'return_main_xml',       'Option' => 'sitemaps_ONOFF'),
            'Pages'           => array('File' => "lbb_pages_sitemap.php",     'Title' => 'Pages XML Sitemap',        'Function' => 'return_page_xml',       'Option' => 'sitemapsPAGES_ONOFF'),
            'Posts'           => array('File' => "lbb_posts_sitemap.php",     'Title' => 'Posts XML Sitemap',        'Function' => 'return_post_xml',       'Option' => 'sitemapsPOST_ONOFF'),
            'Category'        => array('File' => "lbb_category_sitemap.php",  'Title' => 'Category XML Sitemap',     'Function' => 'return_cat_xml',        'Option' => 'sitemapsCAT_ONOFF'),
            'Tags'            => array('File' => "lbb_tags_sitemap.php",      'Title' => 'Tags XML Sitemap',         'Function' => 'return_tags_xml',       'Option' => 'sitemapsTAGS_ONOFF')
        // SITEMAPS IMAGE
        //'Images'          => array('File' => "lbb_images_sitemap.php",    'Title' => 'Images XML Sitemap',       'Function' => 'return_images_xml',     'Option' => 'sitemapsIMG_ONOFF'),
        );
        $this->options = get_option('lbb_sitemaps_details');
    }
    
    public function generate($args){
        $this->options['plugin_dir_path'] = $args['plugin_dir_path'];
        $this->options['xsl_sitemaps'] = $args['xsl_sitemaps'];
        $this->options['xsl_child'] = $args['xsl_child'];
        
        update_option('lbb_sitemaps_details', $this->options);
        
        foreach($this->xml_files as $name => $dets){
            $xml_template = '<?php 
    include("wp-load.php");
    include("'.$args['plugin_dir_path'].'php_libraries/lbb_sitemap.php");
    $sitemap = new lbb_sitemap();
    $sitemapname = "'.$name.'";
    header("Content-type: application/xml");
    echo trim($sitemap->display_sitemap($sitemapname));
?>';  
            $this->make_xml_file(ABSPATH.$dets['File'], $xml_template);
            $this->options['sitemap_'.$name.'_lastmod'] = date('c',time());
            update_option('lbb_sitemaps_details', $this->options);
        }  
    }
    public function display_sitemap($name){
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        '.(($name == 'Main') ? '<?xml-stylesheet type="text/xsl" href="'.$this->options['xsl_sitemaps'].'"?>' : '<?xml-stylesheet type="text/xsl" href="'.$this->options['xsl_child'].'"?>').'
';
        if(isset($this->xml_files[$name]) && method_exists($this, $this->xml_files[$name]['Function'])){
            $function_call = $this->xml_files[$name]['Function'];
            $xml .= $this->$function_call($name);
        }else{
            $xml .= '
    <error>
        <msg>404 - No Sitemap Found.</msg>
    </error>
                    ';
        }
        return $xml;
    }
    public function make_xml_file($name, $contents){
        $xml = fopen($name, "w");
        if($xml){
            fwrite($xml, $contents);
            fclose($xml);
            return true;    
        }else{
            return false;
        }
    }
    function return_main_xml($fname){
        $main = '
  <sitemapindex title="' . $fname . '" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
        foreach($this->xml_files as $name => $dets){
            if($name != 'Main'){
                if(isset($this->options[$dets['Option']])){
                    if($this->options[$dets['Option']] == 'on'){
                        $main .= '
       <sitemap>
         <loc>'.get_site_url().'/'.$dets['File'].'</loc>
         '.((isset($this->options['sitemap_'.$name.'_lastmod'])) ? '<lastmod>'.$this->options['sitemap_'.$name.'_lastmod'].'</lastmod>' : '') .'
       </sitemap>';    
                    }    
                }
            }
        }
        $main .= '
  </sitemapindex>';
        return $main;
    }
    function return_page_xml($fname){
        $pages = get_pages();
        $homeID = get_option('page_on_front');
        $urls_xml = '';
        $page_xml = '<urlset title="' . $fname . '"  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ( $pages as $page=>$dets) {
            $priority = '0.5';
            if($dets->ID == $homeID){ 
                $priority = '1.0';
                $freq = 'daily';
            }else{
                if($dets->post_parent === 0){
                    $priority = '0.8';
                    $freq = 'weekly';    
                }else{
                    $freq = 'weekly'; 
                }
            }
            
            $tmp_xml = '
    <url>
      <loc>'.get_permalink( $dets->ID ).'</loc>
      <lastmod>' . gmdate('Y-m-d\TH:i:s+00:00', strtotime($dets->post_modified_gmt)) . '</lastmod>
      <changefreq>'.$freq.'</changefreq>
      <priority>'.$priority.'</priority>
    </url>';
            if($dets->ID == $homeID){ 
                $urls_xml = $tmp_xml.$urls_xml;       
            }else{
                $urls_xml .= $tmp_xml;
            }
        }
        $page_xml .= $urls_xml.'
  </urlset>';
        return $page_xml;
    }
    function return_post_xml($fname){
        $posts = get_posts();
        $post_xml = '<urlset title="' . $fname . '"  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ( $posts as $post=>$dets) {
            $post_xml .= '
    <url>
      <loc>'.get_permalink( $dets->ID ).'</loc>
      <lastmod>' . gmdate('Y-m-d\TH:i:s+00:00', strtotime($dets->post_modified_gmt)) . '</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.5</priority>
    </url>';
        }
        $post_xml .= '
  </urlset>';
        return $post_xml;
    }
    function return_tags_xml($fname){
        $tags = get_tags();
        $post_xml = '<urlset title="' . $fname . '"  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ( $tags as $tag=>$dets) {
            $post_xml .= '
    <url>
      <loc>'.get_tag_link($dets->term_id).'</loc>
      <changefreq>weekly</changefreq>
      <priority>0.7</priority>
    </url>';
        }
        $post_xml .= '
  </urlset>';
        return $post_xml;
        
    }
    function return_cat_xml($fname){
        $cats = get_categories();
        $post_xml = '<urlset title="' . $fname . '"  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ( $cats as $cat=>$dets) {
            $post_xml .= '
    <url>
      <loc>'.get_category_link($dets->cat_ID).'</loc>
      <changefreq>weekly</changefreq>
      <priority>0.7</priority>
    </url>';
        }
        $post_xml .= '
  </urlset>';
        return $post_xml;
    }
    function return_images_xml(){
        $child_images = array();
        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
        );
        
        $query_images = new WP_Query( $query_images_args );
        
        $images = array();
        foreach ( $query_images->posts as $image ) {
            $images[$image->post_name] = wp_get_attachment_url( $image->ID );
        }
        $parent_images = $this->return_parent_theme_images();
        if(is_child_theme()){
            $child_images = $this->return_child_theme_images();    
        }
        
        return array_merge($images, $parent_images, $child_images);
    }
    function return_child_theme_images(){
        $parent_dir = trailingslashit( get_stylesheet_directory() );
        $parent_url = trailingslashit( get_stylesheet_directory_uri() );
        
        $media_dir = $parent_dir . 'assets/images/';
        $media_url = $parent_url . 'assets/images/';
        $image_paths = glob($media_dir."*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        $images = array();
        
        foreach ( $image_paths as $image ) {
            $name = str_replace( $media_dir, '', $image );
            $images[$name] = str_replace( $media_dir, $media_url, $image );
        }
        return $images;
        
    }
    function return_parent_theme_images(){
        $parent_dir = trailingslashit( get_template_directory() );
        $parent_url = trailingslashit( get_template_directory_uri() );
        
        $media_dir = $parent_dir . 'assets/images/';
        $media_url = $parent_url . 'assets/images/';
        $image_paths = glob($media_dir."*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        $images = array();
        
        foreach ( $image_paths as $image ) {
            $name = str_replace( $media_dir, '', $image );
            $images[$name] = str_replace( $media_dir, $media_url, $image );
        }
        return $images;
        
    }
    
}

?>