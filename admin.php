<?php
global $dtm, $sdidtm_url;

function SDIDTM_admin_desc( $args ) {
	global $dtm;
	$desc = '';
	if($dtm['adminSections'][$args['id']]){
		$desc = $dtm['adminSections'][$args['id']];
	}
	else if($args['desc']){
		$desc = $args['desc'];
	}
	if($desc){
		_e($desc);
	}
}

function SDIDTM_admin_text_field( $cfg ) {
	$style = '';
	if($cfg['style']){
		$style = ' style="'.$cfg['style'].'"';
	}
	echo '<input type="text" name="'.$cfg['name'].'" value="'.$cfg['value'].'"'.$style.' >';
	if($cfg['desc']){
		echo '<br />'.$cfg['desc'];
	}
}

function SDIDTM_admin_checkbox_field( $cfg ) {
	$style = '';
	if($cfg['style']){
		$style = ' style="'.$cfg['style'].'"';
	}
	$checked = '';
	if($cfg['value'] == 1 || $cfg['value'] == '1' || $cfg['value'] === true || $cfg['value'] == 'on'){
		$checked = ' checked="checked"';
	}
	echo '<input type="checkbox" id="'.$cfg['name'].'" name="'.$cfg['name'].'"'.$checked.$style.' >';
	if($cfg['desc']){
		echo ' <label for="'.$cfg['name'].'">'.$cfg['desc'].'</label>';
	}
}

function SDIDTM_admin_label( $args ){
	return '<label for="'.$args['name'].'">'.$args['label'].'</label>';
}

function SDIDTM_sanitize_options( $inputs ){
	foreach($inputs as $name=>$value){
		if( isset( $inputs[$name])){
			$newvalue = $inputs[$name];
		}
		else {
			$newvalue = '';
		}

		if(substr($name, 0, 8) == 'include-'){
			$inputs[$name] = true;
		}
		else {
			$inputs[$name] = $newvalue;
		}
	}
	return $inputs;
}

function SDIDTM_admin_init() {
	global $dtm;
	$config = SDIDTM_get_options('config');

	register_setting( $dtm['slug'], 'sdidtm-options', 'SDIDTM_sanitize_options' );

	add_settings_section(
		'config',
		__( 'DTM Configuration<hr>' ),
		'SDIDTM_admin_desc',
		$dtm['slug']
	);

	foreach($config as $cfg){
		add_settings_field(
			$cfg['name'],
			__(SDIDTM_admin_label($cfg) ),
			'SDIDTM_admin_'.$cfg['type'].'_field',
			$dtm['slug'],
			'config',
			$cfg
		);
	}

	$dataLayer = SDIDTM_get_options('dataLayer');
	add_settings_section(
		'dataLayer',
		__( 'Data Layer Configuration<hr>' ),
		'SDIDTM_admin_desc',
		$dtm['slug']
	);


	foreach($dataLayer as $dl){
		add_settings_field(
			'include-'.$dl['name'],
			__(SDIDTM_admin_label($dl) ),
			'SDIDTM_admin_'.$dl['type'].'_field',
			$dtm['slug'],
			'dataLayer',
			$dl
		);
	}

	$disable = SDIDTM_get_options('disable');
	add_settings_section(
		'disable',
		__( 'Disable DTM for Logged In Users<hr>' ),
		'SDIDTM_admin_desc',
		$dtm['slug']
	);

	foreach($disable as $ds){
		add_settings_field(
			'disable-'.$ds['name'],
			__(SDIDTM_admin_label($ds) ),
			'SDIDTM_admin_checkbox_field',
			$dtm['slug'],
			'disable',
			$ds
		);
	}

	$credits = SDIDTM_get_options('credits');
	add_settings_section(
		'credits',
		__( 'Credits<hr>' ),
		'SDIDTM_admin_desc',
		$dtm['slug']
	);

	add_settings_field(
		'credits',
		__( 'Author' ),
		'SDIDTM_admin_desc',
		$dtm['slug'],
		'credits',
		$credits
	);
}

function SDIDTM_show_admin_page() {
	global $sdidtm_url, $dtm, $dtmSaved;
	SDIDTM_get_options('config');
?>
<div class="wrap">
	<div id="sdidtm-icon" style="background-image: url(<?php echo $sdidtm_url; ?>images/sdi-dtm.png); height: 50px; width: 58px;"><br /></div>
	<h2><?php _e( 'Adobe DTM for WordPress Options' ); ?></h2>
	<form action="options.php" method="post">
<?php settings_fields( $dtm['slug'] ); ?>
<?php do_settings_sections( $dtm['slug'] ); ?>
<?php submit_button(); ?>
	</form>
</div>
<?php  
}

function SDIDTM_add_admin_page() {
	global $dtm;
	add_options_page(
		__( 'Adobe DTM for WordPress settings' ),
		__( 'Adobe DTM' ),
		'manage_options',
		$dtm['slug'],
		'SDIDTM_show_admin_page'
	);
}

add_action( 'admin_init', 'SDIDTM_admin_init' );
add_action( 'admin_menu', 'SDIDTM_add_admin_page' );
?>