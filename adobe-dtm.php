<?php
/*
Plugin Name: Adobe DTM for Wordpress
Version: 1.3
Plugin URI: http://www.searchdiscovery.com/adobe-dtm-for-wordpress/
Description: The first Adobe Dynamic Tag Management (DTM) plugin for WordPress.
Author: Search Discovery
Author URI: http://www.searchdiscovery.com
*/

define('SDIDTM_VERSION', '1.3');
define('SDIDTM_PATH', plugin_dir_path(__FILE__));

$sdidtm_url = plugin_dir_url(__FILE__);
$sdidtm_basename = plugin_basename(__FILE__);

$dtm_file = file_get_contents(__DIR__."/options.json");
$dtm = json_decode($dtm_file, true);
$dtmSaved = get_option('sdidtm-options');

function SDIDTM_get_options( $type, $isAssoc=false ) {
  global $dtm, $dtmSaved;
  $options = $dtm[$type];
  $newOptions = array();

  if($options){
    if($isAssoc == true){
      foreach($options as $opt){
        $value = isset($dtmSaved[$opt['name']]) ? $dtmSaved[$opt['name']] : '';
        if(!$value){
          $value = $opt['default'];
        }
        if(!$value){
          $value = '';
        }
        $newOptions[$opt['name']] = $opt;
        $newOptions[$opt['name']]['value'] = $value;
      }
    }
    else {
      if($type == 'config'){
        foreach($options as $opt){
          if(isset($dtmSaved) && isset($dtmSaved[$opt['name']])){
            $opt['value'] = $dtmSaved[$opt['name']];
          }
          else if($opt['default']){
            $opt['value'] = $opt['default'];
          }
          else {
            $opt['value'] = '';
          }
          $opt['name'] = 'sdidtm-options['.$opt['name'].']';
          $newOptions[] = $opt;
        }
      }
      else if($type == 'dataLayer'){
        foreach($options as $opt){
          $chk = $opt;
          $ipt = $opt;
          if(isset($dtmSaved) && isset($dtmSaved['include-'.$opt['name']])){
            $chk['value'] = $dtmSaved['include-'.$opt['name']];
          }
          else {
            $chk['value'] = '';
          }
          $chk['name'] = 'sdidtm-options[include-'.$chk['name'].']';
          $chk['type'] = 'checkbox';
          $newOptions[] = $chk;

          if($dtmSaved && $dtmSaved['name-'.$opt['name']]){
            $ipt['value'] = $dtmSaved['name-'.$opt['name']];
          }
          else if($opt['default']){
            $ipt['value'] = $opt['default'];
          }
          else {
            $ipt['value'] = '';
          }
          $ipt['type'] = 'text';
          $ipt['name'] = 'sdidtm-options[name-'.$ipt['name'].']';
          $ipt['label'] = '';
          $ipt['desc'] = '';
          $newOptions[] = $ipt;
        }
      }
      else if($type == 'disable'){
        foreach($options as $opt){
          if(isset($dtmSaved) && isset($dtmSaved['disable-'.$opt['name']])){
            $opt['value'] = $dtmSaved['disable-'.$opt['name']];
          }
          else {
            $opt['value'] = '';
          }
          $opt['type'] = 'checkbox';
          $opt['name'] = 'sdidtm-options[disable-'.$opt['name'].']';
          $opt['desc'] = 'Disable DTM for '.$opt['label'].'s';

          $newOptions[] = $opt;
        }
      }
      else if($type == 'credits'){
        $newOptions = $options;
      }
    }
  }

  return $newOptions;
}

function sdidtm_init() {
  if (is_admin()) {
      require_once (SDIDTM_PATH . "/admin.php");
  }
  else {
      require_once (SDIDTM_PATH . "/dtm.php");
  }
}
add_action('plugins_loaded', 'sdidtm_init');