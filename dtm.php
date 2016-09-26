<?php
global $dtm, $v;

function SDIDTM_checked( $args ){
  if($args){
    $v = $args['value'];
    if($v == 1 || $v == '1' || $v == 'on'){
      return true;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}

function SDIDTM_disable(){
  global $dtm, $current_user, $wp_admin_bar;
  $isDisabled = false;
  $disable = SDIDTM_get_options('disable');
  //$perms = array();
  $guest = array();

  foreach($disable as $d){
    if(SDIDTM_checked($d)){
      if(in_array($d['code'], $current_user->roles)){
        $isDisabled = true;
      }
    }
    if($d['code'] == 'guest' && count($current_user->roles) == 0){
        if(isset($v)){
            if(SDIDTM_checked($v)){
                $isDisabled = true;
            }
        }
    }
  }

  if($isDisabled){
    // notify the logged in user in the admin bar that DTM is disabled
    if($wp_admin_bar){
      $wp_admin_bar->add_menu(
        array(
          'id'=>'adobe-dtm',
          'title'=>'Adobe DTM Disabled'
        )
      );
    }
  }

  // disable for guests
  if(!$isDisabled && SDIDTM_checked($guest) && count($current_user->roles) == 0){
    $isDisabled = true;
  }

  return $isDisabled;
}

function SDI_dtm_exists(){
  global $config;
  if($SDIDTM_options[SDIDTM_OPTION_DTM_EXISTS]){
    return true;
  }
  else {
    return false;
  }
}

function SDIDTM_get_name($name){
  global $SDIDTM_defaultoptions, $SDIDTM_options;
  $value = $SDIDTM_options[$name];
  if(!$value || $value == ''){
    $value = $SDIDTM_defaultoptions[$name];
  }
  return $value;
}

function SDIDTM_include( $value ){
  if($value === 1 || $value == '1' || $value === true || $value == 'true'){
    return true;
  }
  else {
    return false;
  }
}

function SDIDTM_value( $field ){
  global $dtmSaved;
  if(isset($field['name'])){
    return $dtmSaved['name-'.$field['name']];
  }
}

function SDIDTM_add_datalayer($dataLayer) {
  global $current_user, $wp_query, $dtmSaved;
  $config = SDIDTM_get_options('config', true);
  $data = SDIDTM_get_options('dataLayer', true);
  $s = $dtmSaved;

  $postType = isset($s['include-posttype']) ? SDIDTM_include($s['include-posttype']) : '';
  $postLbl = isset($data['posttype']) ? SDIDTM_value($data['posttype']) : '';
  $subPostType = isset($s['include-postsubtype']) ? SDIDTM_include($s['include-postsubtype']) : '';
  $subPostLbl = isset($data['postsubtype']) ? SDIDTM_value($data['postsubtype']) : '';

  if(SDIDTM_disable()){
    return array();
  }

  $date = $modifiedDate = array();

  if(isset($s['include-loggedin'])){
      if (SDIDTM_include($s['include-loggedin'])) {
        if (is_user_logged_in()) {
          $dataLayer[SDIDTM_value($data['loggedin'])] = "logged-in";
        } else {
          $dataLayer[SDIDTM_value($data['loggedin'])] = "logged-out";
        }
      }
  }

  if(isset($s['include-userrole'])){
      if (SDIDTM_include($s['include-userrole'])) {
        get_currentuserinfo();
        $dataLayer[SDIDTM_value($data['userrole'])] = ($current_user->roles[0] == NULL ? "guest" : $current_user->roles[0]);
      }
  }

  if(isset($s['include-posttitle'])){
      if (SDIDTM_include($s['include-posttitle'])) {
        $dataLayer[SDIDTM_value($data['posttitle'])] = strip_tags(wp_title("|", false, "right"));
      }
  }

  if(isset($s['include-postexcerpt'])){
      if (SDIDTM_include($s['include-postexcerpt'])) {
        $dataLayer[SDIDTM_value($data['postexcerpt'])] = strip_tags(get_the_excerpt());
      }
  }

  if(isset($s['include-sitetitle'])){
      if (SDIDTM_include($s['include-sitetitle'])) {
        $dataLayer[SDIDTM_value($data['sitetitle'])] = get_bloginfo('name', 'display');
      }
  }

  if(isset($s['include-siteurl'])){
      if (SDIDTM_include($s['include-siteurl'])) {
        $dataLayer[SDIDTM_value($data['siteurl'])] = get_bloginfo('url', 'display');
      }
  }

  if(isset($s['include-sitedescription'])){
      if (SDIDTM_include($s['include-sitedescription'])) {
        $dataLayer[SDIDTM_value($data['sitedescription'])] = get_bloginfo('description', 'display');
      }
  }

  if(isset($s['include-siteplatform'])){
      if (SDIDTM_include($s['include-siteplatform'])) {
        $dataLayer[SDIDTM_value($data['siteplatform'])] = "WordPress";
      }
  }

  if (is_singular()) {
    if(get_the_ID() && SDIDTM_include($s['include-pageid'])){
      $dataLayer[SDIDTM_value($data['pageid'])] = get_the_ID();
    }

    if(isset($s['include-custom'])){
        if(SDIDTM_include($s['include-custom'])){
          $meta = get_post_custom();
          $newmeta = array();
          foreach($meta as $mn=>$mv){
            if(strpos($mn, "_edit_")===false && strpos($mn, "_wp_")===false){
              $newmeta[$mn] = $mv;
            }
          }
          $dataLayer[SDIDTM_value($data['custom'])] = $newmeta;
        }
    }

    if ($postType) {
      $dataLayer[$postLbl] = get_post_type();
    }
    if($subPostType) {
      $dataLayer[$subPostLbl] = "single-" . get_post_type();
    }

    if(isset($s['include-comments'])){
        if(SDIDTM_include($s['include-comments'])){
          if(comments_open()){
            $dataLayer[SDIDTM_value($data['comments'])] = get_comments_number();
          }
        }
    }

    if(isset($s['include-categories'])){
        if (SDIDTM_include($s['include-categories'])) {
          $_post_cats = get_the_category();
          if ($_post_cats) {
            $dataLayer[SDIDTM_value($data['categories'])] = array();
            foreach ($_post_cats as $_one_cat) {
              $dataLayer[SDIDTM_value($data['categories'])][] = $_one_cat->slug;
            }
          }
        }
    }

    if(isset($s['include-tags'])){
        if (SDIDTM_include($s['include-tags'])) {
          $_post_tags = get_the_tags();
          if ($_post_tags) {
            $dataLayer[SDIDTM_value($data['tags'])] = array();
            foreach ($_post_tags as $tag) {
              $dataLayer[SDIDTM_value($data['tags'])][] = $tag->slug;
            }
          }
        }
    }

    if(isset($s['include-author'])){
        if (SDIDTM_include($s['include-author'])) {
          $postuser = get_userdata($GLOBALS["post"]->post_author);
          if (false !== $postuser) {
            $dataLayer[SDIDTM_value($data['author'])] = $postuser->display_name;
          }
        }
    }

    $date["date"] = get_the_date();
    $date["year"] = get_the_date("Y");
    $date["month"] = get_the_date("m");
    $date["day"] = get_the_date("d");

    $modifiedDate["date"] = get_the_modified_date();
    $modifiedDate["year"] = get_the_date("Y");
    $modifiedDate["month"] = get_the_date("m");
    $modifiedDate["day"] = get_the_date("d");
  }

  if (is_archive() || is_post_type_archive()) {
    if ($postType) {
      $dataLayer[$postLbl] = get_post_type();

      if (is_category()) {
        $dataLayer[$subPostLbl] = "category-" . get_post_type();
      } else if (is_tag()) {
        $dataLayer[$subPostLbl] = "tag-" . get_post_type();
      } else if (is_tax()) {
        $dataLayer[$subPostLbl] = "tax-" . get_post_type();
      } else if (is_author()) {
        $dataLayer[$subPostLbl] = "author-" . get_post_type();
      } else if (is_year()) {
        $dataLayer[$subPostLbl] = "year-" . get_post_type();

        $date["year"] = get_the_date("Y");
        $modifiedDate["year"] = get_the_modified_date("Y");
      } else if (is_month()) {
        $dataLayer[$subPostLbl] = "month-" . get_post_type();
        $date["year"] = get_the_date("Y");
        $date["month"] = get_the_date("m");

        $modifiedDate["year"] = get_the_modified_date("Y");
        $modifiedDate["month"] = get_the_modified_date("m");
      } else if (is_day()) {
        $dataLayer[$subPostLbl] = "day-" . get_post_type();

        $date["date"] = get_the_date();
        $date["year"] = get_the_date("Y");
        $date["month"] = get_the_date("m");
        $date["day"] = get_the_date("d");

        $modifiedDate["date"] = get_the_modified_date('Y-m-d\TH:i:sO');
        $modifiedDate["year"] = get_the_modified_date("Y");
        $modifiedDate["month"] = get_the_modified_date("m");
        $modifiedDate["day"] = get_the_modified_date("d");
      } else if (is_time()) {
        $dataLayer[$subPostLbl] = "time-" . get_post_type();
      } else if (is_date()) {
        $dataLayer[$subPostLbl] = "date-" . get_post_type();

        $date["date"] = get_the_date();
        $date["year"] = get_the_date("Y");
        $date["month"] = get_the_date("m");
        $date["day"] = get_the_date("d");

        $modifiedDate["date"] = get_the_modified_date('Y-m-d\TH:i:sO');
        $modifiedDate["year"] = get_the_modified_date("Y");
        $modifiedDate["month"] = get_the_modified_date("m");
        $modifiedDate["day"] = get_the_modified_date("d");
      }
    }

    if ((is_tax() || is_category()) && $SDIDTM_options[SDIDTM_include($s['include-categories'])]) {
      $_post_cats = get_the_category();
      $dataLayer[SDIDTM_value($data['categories'])] = array();
      foreach ($_post_cats as $_one_cat) {
        $dataLayer[SDIDTM_value($data['categories'])][] = $_one_cat->slug;
      }
    }

    if (SDIDTM_include($s['include-author']) && (is_author())) {
      $dataLayer[SDIDTM_value($data['author'])] = get_the_author();
    }
  }

  if (is_search()) {
    if(SDIDTM_include($s['include-searchterm'])){
      $dataLayer[SDIDTM_value($data['searchterm'])] = get_search_query();
    }
    if(SDIDTM_include($s['include-searchorigin'])){
      $dataLayer[SDIDTM_value($data['searchorigin'])] = $_SERVER["HTTP_REFERER"];
    }
    if(SDIDTM_include($s['include-searchresults'])){
      $dataLayer[SDIDTM_value($data['searchresults'])] = $wp_query->post_count;
    }
  }

  if (is_front_page() && $postType) {
    $dataLayer[$postLbl] = "homepage";
  }

  if (!is_front_page() && is_home() && $postType) {
    $dataLayer[$postLbl] = "blog-home";
  }

  if(isset($s['include-postcount'])){
      if (SDIDTM_include($s['include-postcount'])) {
        $dataLayer[SDIDTM_value($data['postcount'])] = (int)$wp_query->post_count;
        // $dataLayer["postCountTotal"] = (int)$wp_query->found_posts;
      }
  }

  if(isset($s['include-postdate'])){
      if (SDIDTM_include($s['include-postdate']) && count($date)>0) {
        $dataLayer[SDIDTM_value($data['postdate'])] = $date;
      }
  }

  if(isset($s['include-modifieddate'])){
    if (SDIDTM_include($s['include-modifieddate']) && count($modifiedDate)>0) {
      $dataLayer[SDIDTM_value($data['modifieddate'])] = $modifiedDate;
    }
  }

  return $dataLayer;
}

function SDIDTM_wp_header() {
  global $dtm;
  $config = SDIDTM_get_options('config', true);

  $dataLayer = array();
  $dataLayer = (array)apply_filters("sdidtm_build_datalayer", $dataLayer);
  $dataLayer = SDIDTM_parseDataLayerConfig($dataLayer);

  $_dtm_header_content = '';

  if ($config['dtm-code']['value'] != "" && !SDIDTM_disable()) {
    $_dtm_header_content.= '
<script type="text/javascript">
var ' . $config['dtm-datalayer-variable-name']['value'] . ' = ' . json_encode($dataLayer) . ';
</script>';

    if(!SDIDTM_checked($config['include-dtm-exists'])){
      $_dtm_header_content.= '
<script type="text/javascript" src="' . $config['dtm-code']['value'] . '"></script>';
    }
  }

  echo $_dtm_header_content."\n<meta name=\"adobe-dtm-wordpress\" content=\"true\">";
}


function SDIDTM_wp_footer() {
  global $dtm;
  $config = SDIDTM_get_options('config', true);

  $_dtm_tag = '';

  if ($config['dtm-code']['value'] != "" && !SDIDTM_checked($config['include-dtm-exists']) && !SDIDTM_disable()) {
    $_dtm_tag.= '
<script type="text/javascript">
if(typeof _satellite !== "undefined"){
  _satellite.pageBottom();
}
</script>';
  }

  echo $_dtm_tag;
}


/*
 * Convert the dot notation into a nested array
 */
function SDIDTM_parseDataLayerConfig($config) {
  if (is_array($config) && sizeof($config) > 0) {
    $dataLayer = array();

    foreach($config as $key => $value){
      if ( isset($dataLayer[$key]) ) {
        if ( is_array($dataLayer[$key]) && sizeof($dataLayer[$key]) === sizeof($dataLayer[$key], COUNT_RECURSIVE)) {
          $dataLayer[$key][] = $value;
        }else{
          $dataLayer[$key] = $value;
        }
      } else {
        $dataLayer = array_merge_recursive($dataLayer, SDIDTM_createElement($key, $value));
      }
    }
  }else{
    $dataLayer = $config;
  }

  return $dataLayer;
}

// recursive function to construct an object from dot-notation
function SDIDTM_createElement($key, $value) {
  $element = array();
  $key = (string)$key;
  // if the key is a property
  if (strpos($key, '.') !== false) {
    // extract the first part with the name of the object
    $list = explode('.', $key);
    // the rest of the key
    $sub_key = substr_replace($key, "", 0, strlen($list[0])+1);
    // create the object if it doesnt exist
    if (!$element[$list[0]]) $element[$list[0]] = array();
    // if the key is not empty, create it in the object
    if ($sub_key !== '') {
      $element[$list[0]] = SDIDTM_createElement($sub_key, $value);
    } else {
      //var_export('SDIDTM_createElement :: empty property in key "'. $key .'"');
    }
  }
  // just normal key
  else {
    $element[$key] = $value;
  }
  return $element;
}

add_action("wp_head", "SDIDTM_wp_header", 1);
add_action("wp_footer", "SDIDTM_wp_footer", 100000);
add_filter("sdidtm_build_datalayer", "SDIDTM_add_datalayer");
