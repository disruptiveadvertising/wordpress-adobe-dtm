<?php
define('SDIDTM_OPTIONS', 'sdidtm-options');
define('SDIDTM_OPTION_DTM_CODE', 'dtm-code');
define('SDIDTM_OPTION_DATALAYER_NAME', 'dtm-datalayer-variable-name');
define('SDIDTM_OPTION_INCLUDE_DTM', 'include-dtm');
define('SDIDTM_OPTION_DTM_EXISTS', 'include-dtm-exists');

// data layer options
define('SDIDTM_OPTION_INCLUDE_LOGGEDIN', 'include-loggedin');
define('SDIDTM_OPTION_INCLUDE_USERROLE', 'include-userrole');
define('SDIDTM_OPTION_INCLUDE_POSTTYPE', 'include-posttype');
define('SDIDTM_OPTION_INCLUDE_PAGEID', 'include-pageid');
define('SDIDTM_OPTION_INCLUDE_POSTSUBTYPE', 'include-postsubtype');
define('SDIDTM_OPTION_INCLUDE_CATEGORIES', 'include-categories');
define('SDIDTM_OPTION_INCLUDE_TAGS', 'include-tags');
define('SDIDTM_OPTION_INCLUDE_AUTHOR', 'include-author');
define('SDIDTM_OPTION_INCLUDE_POSTDATE', 'include-postdate');
define('SDIDTM_OPTION_INCLUDE_POSTTITLE', 'include-posttitle');
define('SDIDTM_OPTION_INCLUDE_POSTCOUNT', 'include-postcount');
define('SDIDTM_OPTION_INCLUDE_SEARCHTERM', 'include-searchterm');
define('SDIDTM_OPTION_INCLUDE_SEARCHRESULTS', 'include-searchresults');
define('SDIDTM_OPTION_INCLUDE_SEARCHORIGIN', 'include-searchorigin');
define('SDIDTM_OPTION_INCLUDE_COMMENTS', 'include-comments');
define('SDIDTM_OPTION_INCLUDE_POSTCUSTOM', 'include-custom');


// data layer opyion names
define('SDIDTM_OPTION_NAME_LOGGEDIN', 'name-loggedin');
define('SDIDTM_OPTION_NAME_USERROLE', 'name-userrole');
define('SDIDTM_OPTION_NAME_POSTTYPE', 'name-posttype');
define('SDIDTM_OPTION_NAME_PAGEID', 'name-pageid');
define('SDIDTM_OPTION_NAME_POSTSUBTYPE', 'name-postsubtype');
define('SDIDTM_OPTION_NAME_CATEGORIES', 'name-categories');
define('SDIDTM_OPTION_NAME_TAGS', 'name-tags');
define('SDIDTM_OPTION_NAME_AUTHOR', 'name-author');
define('SDIDTM_OPTION_NAME_POSTDATE', 'name-postdate');
define('SDIDTM_OPTION_NAME_POSTTITLE', 'name-posttitle');
define('SDIDTM_OPTION_NAME_POSTCOUNT', 'name-postcount');
define('SDIDTM_OPTION_NAME_SEARCHTERM', 'name-searchterm');
define('SDIDTM_OPTION_NAME_SEARCHRESULTS', 'name-searchresults');
define('SDIDTM_OPTION_NAME_SEARCHORIGIN', 'name-searchorigin');
define('SDIDTM_OPTION_NAME_COMMENTS', 'name-comments');
define('SDIDTM_OPTION_NAME_POSTCUSTOM', 'name-custom');

define('SDIDTM_OPTION_DISABLE_ADMIN', 'disable-admin');
define('SDIDTM_OPTION_DISABLE_EDITOR', 'disable-editor');
define('SDIDTM_OPTION_DISABLE_AUTHOR', 'disable-author');
define('SDIDTM_OPTION_DISABLE_CONTRIBUTOR', 'disable-contributor');
define('SDIDTM_OPTION_DISABLE_SUBSCRIBER', 'disable-subscriber');
define('SDIDTM_OPTION_DISABLE_GUEST', 'disable-guest');

$SDIDTM_options = array();

$SDIDTM_defaultoptions = array(
  SDIDTM_OPTION_DTM_CODE => "", 
  SDIDTM_OPTION_DATALAYER_NAME => "dataLayer",  
  SDIDTM_OPTION_DTM_EXISTS => false, 
  SDIDTM_OPTION_INCLUDE_DTM => true, 
  // data layer toggles
  SDIDTM_OPTION_INCLUDE_LOGGEDIN => false, 
  SDIDTM_OPTION_INCLUDE_USERROLE => false,
  SDIDTM_OPTION_INCLUDE_POSTTYPE => true, 
  SDIDTM_OPTION_INCLUDE_POSTSUBTYPE => true, 
  SDIDTM_OPTION_INCLUDE_POSTCUSTOM => false,
  SDIDTM_OPTION_INCLUDE_PAGEID => true, 
  SDIDTM_OPTION_INCLUDE_CATEGORIES => true, 
  SDIDTM_OPTION_INCLUDE_TAGS => true, 
  SDIDTM_OPTION_INCLUDE_AUTHOR => true, 
  SDIDTM_OPTION_INCLUDE_POSTDATE => false, 
  SDIDTM_OPTION_INCLUDE_POSTTITLE => false, 
  SDIDTM_OPTION_INCLUDE_POSTCOUNT => false, 
  SDIDTM_OPTION_INCLUDE_SEARCHTERM => false, 
  SDIDTM_OPTION_INCLUDE_SEARCHRESULTS => false,
  SDIDTM_OPTION_INCLUDE_SEARCHORIGIN => false,
  SDIDTM_OPTION_INCLUDE_COMMENTS => false, 
  // disable by user type
  SDIDTM_OPTION_DISABLE_ADMIN => false, 
  SDIDTM_OPTION_DISABLE_EDITOR => false, 
  SDIDTM_OPTION_DISABLE_AUTHOR => false, 
  SDIDTM_OPTION_DISABLE_CONTRIBUTOR => false, 
  SDIDTM_OPTION_DISABLE_SUBSCRIBER => false, 
  SDIDTM_OPTION_DISABLE_GUEST => false, 
  // data layer names
  SDIDTM_OPTION_NAME_LOGGEDIN => 'loginState', 
  SDIDTM_OPTION_NAME_USERROLE => 'visitorType', 
  SDIDTM_OPTION_NAME_POSTTYPE=> 'pageType', 
  SDIDTM_OPTION_NAME_PAGEID=> 'pageID', 
  SDIDTM_OPTION_NAME_POSTSUBTYPE => 'pageSubType', 
  SDIDTM_OPTION_NAME_POSTCUSTOM => 'postCustomFields',
  SDIDTM_OPTION_NAME_CATEGORIES => 'category', 
  SDIDTM_OPTION_NAME_TAGS => 'tags', 
  SDIDTM_OPTION_NAME_AUTHOR => 'author', 
  SDIDTM_OPTION_NAME_POSTDATE => 'pagePostDate',
  SDIDTM_OPTION_NAME_POSTTITLE => 'postTitle', 
  SDIDTM_OPTION_NAME_POSTCOUNT => 'postCount', 
  SDIDTM_OPTION_NAME_SEARCHTERM => 'searchTerm',
  SDIDTM_OPTION_NAME_SEARCHRESULTS => 'searchResults',
  SDIDTM_OPTION_NAME_SEARCHORIGIN => 'searchOrigin',
  SDIDTM_OPTION_NAME_COMMENTS => 'numberComments'
);

function SDIDTM_reload_options() {
  global $SDIDTM_defaultoptions;
  
  $storedoptions = (array)get_option(SDIDTM_OPTIONS);
  if (!is_array($SDIDTM_defaultoptions)) {
    $SDIDTM_defaultoptions = array();
  }

  if($storedoptions[SDIDTM_OPTION_DATALAYER_NAME]==''){
    $storedoptions[SDIDTM_OPTION_DATALAYER_NAME] = $SDIDTM_defaultoptions[SDIDTM_OPTION_DATALAYER_NAME];
  }
  
  return array_merge($SDIDTM_defaultoptions, $storedoptions);
}

$SDIDTM_options = SDIDTM_reload_options();
