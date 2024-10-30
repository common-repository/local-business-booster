<?php


class lbb_schema {

    function localbusiness(){
        $about = get_option('lbb_about_details');
        $logo = $this->return_logo_src();
        $sameAs = '';
        if((isset($about['facebookLink']) && $about['facebookLink'] != '') || (isset($about['twitterLink']) && $about['twitterLink'] != '') || (isset($about['googleLink']) && $about['googleLink'] != '') ){
            $sameAs = '"sameAs": [
                    ' . ((isset($about['facebookLink']) && $about['facebookLink'] != '') ? '"' . $about['facebookLink'].'",' : '').'
                    ' . ((isset($about['twitterLink']) && $about['twitterLink'] != '') ? '"' . $about['twitterLink'].'",' : '').'
                    ' . ((isset($about['googleLink']) && $about['googleLink'] != '') ? '"' . $about['googleLink']. '"' : '').'
                   ],';        
        }
        
        $json_ld = '
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "' . ((isset($about['BusinessCategory']) && $about['BusinessCategory'] != '') ? $about['BusinessCategory'] : 'LocalBusiness') . '",
        "name": "' . ((isset($about['BusinessName']) && $about['BusinessName'] != '') ? $about['BusinessName'] : get_bloginfo('name')) . '",
        "@id": "' . ((get_bloginfo("url") != '') ? get_bloginfo('url') : '') . '/#site",
        "url": "' . ((get_bloginfo("url") != '') ? get_bloginfo('url') : '') . '",
        ' . ( ($logo) ? '"image": ["'.$logo.'"],' : '') .'
        ' . ( ($logo) ? '"logo": "'.$logo.'",' : '') .'
        ' . ((isset($about['BusinessPhone']) && $about['BusinessPhone'] != '') ? '"telephone": "' . $about['BusinessPhone'] . '",' : '') . '
        ' . ((isset($about['BusinessDesc']) && $about['BusinessDesc'] != '') ? '"description": "' . $about['BusinessDesc'] . '",' : '') . '
        ' . ((isset($about['BusinessMapsLink']) && $about['BusinessMapsLink'] != '') ? '"hasMap": "https://maps.google.com/maps?cid=' . $about['BusinessMapsLink'] . '",' : '') . '
        ' . ((isset($about['BusinessPriceRange']) && $about['BusinessPriceRange'] != '') ? '"priceRange": "$' . $about['BusinessPriceRange']['min'] . '-$' . $about['BusinessPriceRange']['max'] . '",' : '') . '
        "address" :{
            "@type": "PostalAddress",
            ' . ((isset($about['BusinessStreet']) && $about['BusinessStreet'] != '') ? '"streetAddress": "' . $about['BusinessStreet'] . '",' : '') . '
            ' . ((isset($about['BusinessState']) && $about['BusinessState'] != '') ? '"addressRegion": "' . $about['BusinessState'] . '",' : '') . '
            ' . ((isset($about['BusinessPostcode']) && $about['BusinessPostcode'] != '') ? '"postalCode": "' . $about['BusinessPostcode'] . '",' : '') . '
            ' . ((isset($about['BusinessCountry']) && $about['BusinessCountry'] != '') ? '"addressCountry": "' . $about['BusinessCountry'] . '"' : '') . '
        },
        '. $sameAs . '
        ' . $this->return_operating_hours_json($about['BussinesHours']) . '
        "geo":{
                "@type": "GeoCoordinates",
                ' . ((isset($about['BusinessLat']) && $about['BusinessLat'] != '') ? '"latitude": "' . $about['BusinessLat'] . '",' : '') . '
                ' . ((isset($about['BusinessLong']) && $about['BusinessLong'] != '') ? '"longitude": "' . $about['BusinessLong'] . '"' : '') . '
        }
        
     }
</script>';
        return $json_ld;
    }  
    function blogpost(){
        $post = get_post();
        setup_postdata($post);
        $categories = get_the_category(); 
        $tags = get_the_tags(); 
        $author = get_the_author();
        $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );
        $logo = $this->return_logo_src();
        if($logo){
            $logo_i = '
                    "logo": {
                      "@type": "ImageObject",
                      "url": "' . $logo . '"
                    }';   
        }
        $genre = '';    
        $keywords = '';
        if(is_array($categories) && !empty($categories)){    
            foreach($categories as $i=>$val){
                $genre .= $val->name . ' ';
            }
        }
        if(is_array($tags) && !empty($tags)){
            foreach($tags as $i=>$val){
                $keywords .= $val->name . ' ';
            }
        }
        $modified = explode( ' ' ,$post->post_modified);
        $published = explode( ' ' ,$post->post_date);
        $json = '
        <script type="application/ld+json">
            { 
                 "@context": "http://schema.org", 
                 "@type": "BlogPosting",
                 "mainEntityOfPage": "' . get_permalink( $post->ID ) . '",
                 "headline": "' . $post->post_title . '",
                 ' . (($image_url != '') ? '"image": "' . $image_url .'",' : '' ) . '
                 "editor": "' . $author . '", 
                 ' . (($genre != '') ? '"genre": "' . $genre .'",' : '' ) . '
                 ' . (($keywords != '') ? '"keywords": "' . $keywords .'",' : '' ) . '
                 "wordcount": "' . strlen($post->post_content) . '",
                 "publisher": {
                    "@type": "Organization",
                    "name": "' . get_bloginfo('name') . '",
                    ' . $logo_i .'
                  },
                 "url": "' . get_permalink( $post->ID ) . '",
                 "datePublished": "' . $published[0] . '",
                 "dateCreated": "' . $published[0] . '",
                 "dateModified": "' . $modified[0] . '",
                 "description": "' . $post->post_excerpt . '",
                 "articleBody": "' . $post->post_content . '",
                   "author": {
                    "@type": "Person",
                    "name": "' . $author . '"
                  }
             }
        </script>';


        
return $json;   
    }
    function return_operating_hours_json($operatinghours){
        $json = '';
        if(is_array($operatinghours) && !empty($operatinghours) && isset($operatinghours['monday'])){
            $json .= '"openingHoursSpecification": [';
                foreach($operatinghours as $day => $dets){
                    $json .= '{
                                "@type": "OpeningHoursSpecification",
                                "dayOfWeek": [
                                  "' . ucfirst($day) . '"
                                ],
                                "opens": "' . ( (!isset($dets['closed'])) ? $dets['open']: '00:00') . '",
                                "closes": "' . ( (!isset($dets['closed'])) ? $dets['close']: '00:00') . '"
                              },';
                }
                $json = substr($json, 0, strlen($json) - 1);
            $json .= '],';    
        }
        return $json;
    }
    function return_logo_src() {
        if (has_custom_logo()) {
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo_meta = wp_get_attachment_image_src($custom_logo_id,'full');
            return $logo_meta[0];
        } else {
            return false;
        }
    }
}
?>
