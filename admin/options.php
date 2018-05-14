<?php
/* Save default options */
$options_framework_admin = new Options_Framework_Admin;
$default_options = $options_framework_admin->get_default_values();
if (!get_option(vpanel_options)) {
	add_option(vpanel_options,$default_options);
}
function optionsframework_options() {

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll');

	// Pull all the categories into an array
	$options_categories = array();
	$args = array(
		'type'                     => 'post',
		'child_of'                 => 0,
		'parent'                   => '',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => 'category',
		'pad_counts'               => false
	);
		
	$options_categories_obj = get_categories($args);
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the question category into an array
	$options_categories_q = array();
	$args = array(
		'type'                     => 'question',
		'child_of'                 => 0,
		'parent'                   => '',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => ask_question_category,
		'pad_counts'               => false
	);
	
	$options_categories_obj_q = get_categories($args);
	$options_categories_q = array();
	foreach ($options_categories_obj_q as $category_q) {
		$options_categories_q[$category_q->term_id] = $category_q->name;
	}
	
	// Pull all the groups into an array
	$options_groups = array();
	global $wp_roles;
	$options_groups_obj = $wp_roles->roles;
	foreach ($options_groups_obj as $key_r => $value_r) {
		$options_groups[$key_r] = $value_r['name'];
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ($options_tags_obj as $tag) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}
	
	// Pull all the sidebars into an array
	$sidebars = get_option('sidebars');
	$new_sidebars = array('default'=> 'Default');
	foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
		$new_sidebars[$sidebar['id']] = $sidebar['name'];
	}
	
	// Pull all the roles into an array
	global $wp_roles;
	$new_roles = array();
	foreach ($wp_roles->roles as $key => $value) {
		$new_roles[$key] = $value['name'];
	}
	
	$export = array(vpanel_options,"sidebars","badges","coupons","roles");
	$current_options = array();
	foreach ($export as $options) {
		if (get_option($options)) {
			$current_options[$options] = get_option($options);
		}else {
			$current_options[$options] = array();
		}
	}
	$current_options_e = json_encode($current_options);
	
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri().'/admin/images/';
	$imagepath_theme =  get_template_directory_uri().'/images/';
	
	$options = array();
	
	$options[] = array(
		'name' => 'General settings',
		'icon' => 'admin-site',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Active the lightbox at the site',
		'desc' => 'Select ON if you want to active the lightbox at the site.',
		'id' => 'active_lightbox',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Hide the top bar for WordPress',
		'desc' => 'Select ON if you want to hide the top bar for WordPress.',
		'id' => 'top_bar_wordpress',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Enable loader',
		'desc' => 'Select ON to enable loader.',
		'id' => 'loader',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Enable nicescroll',
		'desc' => 'Select ON to enable nicescroll.',
		'id' => 'nicescroll',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Type the date format see this link also : https://codex.wordpress.org/Formatting_Date_and_Time',
		'desc' => 'Type here your date format.',
		'id' => 'date_format',
		'std' => 'F j, Y',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Header code",
		'desc' => "Past your Google analytics code in the box",
		'id' => 'head_code',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => "Footer code",
		'desc' => "Paste footer code in the box",
		'id' => 'footer_code',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => "Custom CSS code",
		'desc' => "Advanced CSS options, Paste your CSS code in the box",
		'id' => 'custom_css',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => 'Enable SEO options',
		'desc' => 'Select ON to enable SEO options.',
		'id' => 'seo_active',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "SEO keywords",
		'desc' => "Paste your keywords in the box",
		'id' => 'the_keywords',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => "FaceBook share image",
		'desc' => "This is the FaceBook share image",
		'id' => 'fb_share_image',
		'type' => 'upload');
	
	$options[] = array(
		'name' => "WordPress login logo",
		'desc' => "This is the logo that appears on the default WordPress login page",
		'id' => 'login_logo',
		'type' => 'upload');
	
	$options[] = array(
		"name" => "WordPress login logo height",
		"id" => "login_logo_height",
		"type" => "sliderui",
		"step" => "1",
		"min" => "0",
		"max" => "300");
	
	$options[] = array(
		"name" => "WordPress login logo width",
		"id" => "login_logo_width",
		"type" => "sliderui",
		"step" => "1",
		"min" => "0",
		"max" => "300");
	
	$options[] = array(
		'name' => "Custom favicon",
		'desc' => "Upload the site’s favicon here, You can create new favicon here favicon.cc",
		'id' => 'favicon',
		'type' => 'upload');
	
	$options[] = array(
		'name' => "Custom favicon for iPhone",
		'desc' => "Upload your custom iPhone favicon",
		'id' => 'iphone_icon',
		'type' => 'upload');
	
	$options[] = array(
		'name' => "Custom iPhone retina favicon",
		'desc' => "Upload your custom iPhone retina favicon",
		'id' => 'iphone_icon_retina',
		'type' => 'upload');
	
	$options[] = array(
		'name' => "Custom favicon for iPad",
		'desc' => "Upload your custom iPad favicon",
		'id' => 'ipad_icon',
		'type' => 'upload');
	
	$options[] = array(
		'name' => "Custom iPad retina favicon",
		'desc' => "Upload your custom iPad retina favicon",
		'id' => 'ipad_icon_retina',
		'type' => 'upload');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end');
	
	$options[] = array(
		'name' => 'Header settings',
		'icon' => 'menu',
		'type' => 'heading');
	
	$options[] = array(
		'name' => 'Top panel',
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Top panel settings',
		'desc' => 'Select ON to enable the top panel.',
		'id' => 'login_panel',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Select top panel skin",
		'desc' => "Select your preferred skin for the top panel.",
		'id' => "top_panel_skin",
		'std' => "panel_dark",
		'type' => "images",
		'options' => array(
			'panel_dark' => $imagepath.'panel_dark.jpg',
			'panel_light' => $imagepath.'panel_light.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Select side panel skin",
		'desc' => "Select your preferred skin for the side panel.",
		'id' => "side_panel_skin",
		'std' => "dark",
		'type' => "images",
		'options' => array(
			'dark'  => $imagepath.'menu_dark.jpg',
			'gray'  => $imagepath.'sidebar_no.jpg',
			'light' => $imagepath.'menu_light.jpg'
		)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end');
	
	$options[] = array(
		'name' => 'Header setting',
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Header top menu settings',
		'desc' => 'Select ON to enable the top menu in the header.',
		'id' => 'top_menu',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Top header Layout",
		'desc' => "Top header columns Layout.",
		'id' => "top_header_layout",
		'std' => "2c",
		'type' => "images",
		'options' => array(
			'2c'          => $imagepath.'2c.jpg',
			'header_2c_2' => $imagepath.'header_2c_2.jpg',
			'header_2c_3' => $imagepath.'header_2c_3.jpg',
			'menu'        => $imagepath.'menu.jpg',
			'left_ontent' => $imagepath.'left_ontent.jpg'
		)
	);
	
	if (is_rtl()) {
		$options[] = array(
			'name' => "Logo position",
			'desc' => "Select where you would like your logo to appear.",
			'id' => "logo_position",
			'std' => "left_logo",
			'type' => "images",
			'options' => array(
				'left_logo' => $imagepath.'right_logo.jpg',
				'right_logo' => $imagepath.'left_logo.jpg',
				'center_logo' => $imagepath.'center_logo.jpg'
			)
		);
	}else {
		$options[] = array(
			'name' => "Logo position",
			'desc' => "Select where you would like your logo to appear.",
			'id' => "logo_position",
			'std' => "left_logo",
			'type' => "images",
			'options' => array(
				'left_logo' => $imagepath.'left_logo.jpg',
				'right_logo' => $imagepath.'right_logo.jpg',
				'center_logo' => $imagepath.'center_logo.jpg'
			)
		);
	}
	
	$options[] = array(
		'name' => "Header skin",
		'desc' => "Select your preferred header skin.",
		'id' => "header_skin",
		'std' => "header_dark",
		'type' => "images",
		'options' => array(
			'header_dark' => $imagepath.'left_logo.jpg',
			'header_light' => $imagepath.'header_light.jpg'
		)
	);
	
	$options[] = array(
		'name' => 'Fixed header option',
		'desc' => 'Select ON to enable fixed header.',
		'id' => 'header_fixed',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Header search settings',
		'desc' => 'Select ON to enable the search in the header.',
		'id' => 'header_search',
		'std' => 1,
		'type' => 'checkbox');
	
	if (class_exists('woocommerce')) {
		$options[] = array(
			'name' => 'Header cart settings',
			'desc' => 'Select ON to enable the cart in the header.',
			'id' => 'header_cart',
			'std' => 1,
			'type' => 'checkbox');
	}
	
	$options[] = array(
		'name' => 'Header notifications settings',
		'desc' => 'Select ON to enable the notifications in the header.',
		'id' => 'header_notifications',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Header notifications number',
		'desc' => 'Put the header notifications number.',
		'id' => 'notifications_number',
		'std' => 10,
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Logo display',
		'desc' => 'choose Logo display.',
		'id' => 'logo_display',
		'std' => 'display_title',
		'type' => 'radio',
		'options' => array("display_title" => "Display site title","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Logo upload',
		'desc' => 'Upload your custom logo.',
		'id'   => 'logo_img',
		'std'  => $imagepath_theme."logo.png",
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Logo retina upload',
		'desc' => 'Upload your custom logo retina.',
		'id'   => 'retina_logo',
		'std'  => $imagepath_theme."logo-2x.png",
		'type' => 'upload');
	
	$options[] = array(
		"name" => "Logo height",
		"id" => "logo_height",
		"type" => "sliderui",
		"step" => "1",
		"min" => "0",
		"max" => "300",
		'std' => '57');
	
	$options[] = array(
		"name" => "Logo width",
		"id" => "logo_width",
		"type" => "sliderui",
		"step" => "1",
		"min" => "0",
		"max" => "300",
		'std' => '146');
	
	$options[] = array(
		'name' => 'Breadcrumbs settings',
		'desc' => 'Select ON to enable breadcrumbs.',
		'id' => 'breadcrumbs',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end');
	
	$options[] = array(
		'name' => 'Big search setting',
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Big search after header',
		'desc' => 'Select ON to enable big search.',
		'id' => 'big_search',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name'    => 'Big search in all pages or home page only?',
		'desc'    => 'Big search work in all pages or home page only?',
		'id'      => 'big_search_work',
		'std'     => "all_pages",
		'options' => array(
			'home_page'     => 'Home page',
			'all_pages'     => 'All pages',
			'pages_no_home' => 'All pages without home',
		),
		'type'    => 'select'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end');
	
	$options[] = array(
		'name' => 'Video setting',
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Big video after header',
		'desc' => 'Select ON to enable big video.',
		'id'   => 'big_video',
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'video_setting',
		'type' => 'heading-2');
		
	$options[] = array(
		'name'    => 'Big video in all pages or home page only?',
		'desc'    => 'Big video work in all pages or home page only?',
		'id'      => 'big_video_work',
		'std'     => "all_pages",
		'options' => array(
			'home_page'     => 'Home page',
			'all_pages'     => 'All pages',
			'pages_no_home' => 'All pages without home',
		),
		'type'    => 'select'
	);
	
	$options[] = array(
		'name'		=> 'Video height',
		'id'		=> 'video_height',
		'desc'		=> 'Put here the video height.',
		'type'		=> 'text',
		'std'		=> '500',
	);
	
	$options[] = array(
		'name'		=> 'Video type',
		'id'		=> 'video_type',
		'type'		=> 'select',
		'options'	=> array(
			'youtube'  => "Youtube",
			'vimeo'    => "Vimeo",
			'daily'    => "Dialymotion",
			'facebook' => "Facebook video",
			'html5'    => "HTML 5",
			'embed'    => "Custom embed",
		),
		'std'		=> 'youtube',
		'desc'		=> 'Choose from here the video type'
	);
	
	$options[] = array(
		'name'		=> 'Video ID',
		'id'		=> 'video_id',
		'desc'		=> 'Put here the video id : https://www.youtube.com/watch?v=sdUUx5FdySs EX : "sdUUx5FdySs".',
		'type'		=> 'text',
	);
	
	$options[] = array(
		'name'		=> 'Custom embed',
		'id'		=> 'custom_embed',
		'desc'		=> 'Put your Custom embed html',
		'type'		=> 'textarea',
	);
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'video_html5_setting',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Video Image',
		'desc' => 'Upload a image, or enter URL to an image if it is already uploaded. ',
		'id'   => 'video_image',
		'type' => 'upload'
	);
	
	$options[] = array(
		'name' => 'Mp4 video',
		'id'   => 'video_mp4',
		'desc' => 'Put here the mp4 video',
		'type' => 'text',
	);
	
	$options[] = array(
		'name' => 'M4v video',
		'id'   => 'video_m4v',
		'desc' => 'Put here the m4v video',
		'type' => 'text',
	);
	
	$options[] = array(
		'name' => 'Webm video',
		'id'   => 'video_webm',
		'desc' => 'Put here the webm video',
		'type' => 'text',
	);
	
	$options[] = array(
		'name' => 'Ogv video',
		'id'   => 'video_ogv',
		'desc' => 'Put here the ogv video',
		'type' => 'text',
	);
	
	$options[] = array(
		'name' => 'Wmv video',
		'id'   => 'video_wmv',
		'desc' => 'Put here the wmv video',
		'type' => 'text',
	);
	
	$options[] = array(
		'name' => 'Flv video',
		'id'   => 'video_flv',
		'desc' => 'Put here the flv video',
		'type' => 'text',
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Responsive settings',
		'icon' => 'smartphone',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => "Choose the mobile menu skin",
		'desc' => "Choose the mobile menu skin.",
		'id'   => "mobile_menu",
		'std'  => "dark",
		'type' => "images",
		'options' => array(
			'dark'  => $imagepath.'menu_dark.jpg',
			'gray'  => $imagepath.'sidebar_no.jpg',
			'light' => $imagepath.'menu_light.jpg',
		)
	);
	
	$options[] = array(
		'name' => 'Header top menu settings',
		'desc' => 'Select ON to enable the top menu in the mobile menu.',
		'id' => 'top_menu_mobile',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Ask question settings',
		'desc' => 'Select ON to enable the ask question in the mobile menu.',
		'id' => 'ask_question_mobile',
		'std' => 1,
		'type' => 'checkbox');
	
	if (class_exists('woocommerce')) {
		$options[] = array(
			'name' => 'Cart settings',
			'desc' => 'Select ON to enable the cart in the mobile menu.',
			'id' => 'mobile_cart',
			'std' => 1,
			'type' => 'checkbox');
	}
	
	$options[] = array(
		'name' => 'Notifications settings',
		'desc' => 'Select ON to enable the notifications in the mobile menu.',
		'id' => 'mobile_notifications',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Header menu settings',
		'desc' => 'Select ON to enable the menu in the mobile menu.',
		'id' => 'main_menu_mobile',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Social enable or disable',
		'desc' => 'Social or disable.',
		'id' => 'social_mobile',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Search settings',
		'desc' => 'Select ON to enable the search in the mobile menu.',
		'id' => 'search_mobile',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Home page',
		'icon' => 'admin-home',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Note: this options work in the home page only and if you don\'t choose the Front page.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => 'Home top box settings',
		'desc' => 'Select ON if you want to enable the home top box.',
		'id' => 'index_top_box',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Home top box layout',
		'desc' => 'Home top box layout.',
		'id' => 'index_top_box_layout',
		'std' => '1',
		'type' => 'radio',
		'options' => array("1" => "Style 1","2" => "Style 2"));
	
	$options[] = array(
		'name' => 'Question title or comment',
		'desc' => 'Question title or comment.',
		'id' => 'index_title_comment',
		'std' => 'title',
		'type' => 'radio',
		'options' => array("title" => "Title","comment" => "Comment"));
	
	$options[] = array(
		'name' => 'Remove the content?',
		'desc' => 'Remove the content (Title, Content, Buttons and Ask question)?',
		'id'   => 'remove_index_content',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'    => 'Home top box background',
		'desc'    => 'Home top box background.',
		'id'      => 'index_top_box_background',
		'std'     => 'background',
		'type'    => 'hidden',
	);
	
	$options[] = array(
		'name' =>  "Background",
		'desc' => "Upload a image, Or enter URL to an image if it is already uploaded.",
		'id' => 'background_home',
		'std' => $background_defaults,
		'type' => 'background');
	
	$options[] = array(
		'name' => "Full Screen Background",
		'id'   => "background_full_home",
		'type' => 'checkbox',
		'std'  => 0,
	);
	
	$options[] = array(
		'name' => 'Home top box title',
		'desc' => 'Put the Home top box title.',
		'id' => 'index_title',
		'std' => 'Welcome to Ask me',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Home top box content',
		'desc' => 'Put the Home top box content.',
		'id' => 'index_content',
		'std' => 'Duis dapibus aliquam mi, Eget euismod sem scelerisque ut.Vivamus at elit quis urna adipiscing iaculis.Curabitur vitae velit in neque dictum blandit.Proin in iaculis neque.',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => 'About Us title',
		'desc' => 'Put the About Us title.',
		'id' => 'index_about',
		'std' => 'About Us',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'About Us link',
		'desc' => 'Put the About Us link.',
		'id' => 'index_about_h',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Join Now title',
		'desc' => 'Put the Join Now title.',
		'id' => 'index_join',
		'std' => 'Join Now',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Join Now link',
		'desc' => 'Put the Join Now link.',
		'id' => 'index_join_h',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'About Us title if logged in',
		'desc' => 'Put the About Us title if logged in.',
		'id' => 'index_about_login',
		'std' => 'About Us',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'About Us link if login',
		'desc' => 'Put the About Us link if logged in.',
		'id' => 'index_about_h_login',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Ask question title if logged in',
		'desc' => 'Put the Ask question title if logged in.',
		'id' => 'index_join_login',
		'std' => 'Ask question',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Ask question link if logged in',
		'desc' => 'Put the Ask question link if logged in.',
		'id' => 'index_join_h_login',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Go to the page and add new page template <a href="post-new.php?post_type=page">from here</a>, Choose the template page (Home) set it a static page <a href="options-reading.php">from here</a>.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Questions',
		'icon' => 'editor-help',
		'type' => 'heading',
		'std'     => 'general_setting',
		'options' => array(
			"general_setting"   => "General settings",
			"question_slug"     => "Question slugs",
			"add_edit_delete"   => "Add - Edit - Delete",
			"questions_loop"    => "Questions & Loop settings",
			"inner_question"    => "Inner question",
		)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'general_setting',
		'name' => "General settings"
	);
	
	$options[] = array(
		'name' => 'Active the reports in site?',
		'desc' => 'Active the reports enable or disable.',
		'id' => 'active_reports',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the reports in site for the logged users only?',
		'desc' => 'Active the reports in site for the logged users only enable or disable.',
		'id' => 'active_logged_reports',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the vote in site?',
		'desc' => 'Active the vote enable or disable.',
		'id' => 'active_vote',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the points system in site?',
		'desc' => 'Active the points system enable or disable.',
		'id' => 'active_points',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select ON to hide the dislike at questions',
		'desc' => 'If you put it ON the dislike will not show.',
		'id' => 'show_dislike_questions',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'When delete the question or answer have a best answer remove it from the stats and user point?',
		'desc' => 'Select ON if you want to remove the best answer from the user point.',
		'id' => 'remove_best_answer_stats',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'question_slug',
		'name' => "Question slugs"
	);
	
	$options[] = array(
		'name' => 'Questions slug',
		'desc' => 'Add your questions slug.',
		'id' => 'questions_slug',
		'std' => 'question',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Questions category slug',
		'desc' => 'Add your questions category slug.',
		'id' => 'category_questions_slug',
		'std' => ask_question_category,
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Questions tag slug',
		'desc' => 'Add your questions tag slug.',
		'id' => 'tag_questions_slug',
		'std' => 'question-tag',
		'type' => 'text');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'add_edit_delete',
		'name' => "Add - Edit - Delete"
	);
	
	$options[] = array(
		'name' => 'Add question setting.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => "Add question page",
		'desc' => "Create a page using the Add question template and select it here",
		'id' => 'add_question',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => 'Any one can ask question without register',
		'desc' => 'Any one can ask question without register enable or disable.',
		'id' => 'ask_question_no_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'ask_question_no_register',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Active username and email for not register users.',
		'desc' => 'The username and email for not register users is enable or disable.',
		'id' => 'username_email_no_register',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'name' => 'Active ask question form with popup also?',
		'desc' => 'Active ask question form with popup is enable or disable.',
		'id' => 'ask_question_popup',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Charge points for questions',
		'desc' => 'How many points should be taken from the user’s account for asking questions.',
		'id' => 'question_points',
		'std' => '5',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Charge points for questions settings',
		'desc' => 'Select ON if you want to charge points from users for asking questions.',
		'id' => 'question_points_active',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Point back to the user when he select the best answer',
		'desc' => 'Point back to the user when he select the best answer.',
		'id' => 'point_back',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'point_back',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Or type here the point want back',
		'desc' => 'Or type here the point want back, Type 0 to back all the point.',
		'id' => 'point_back_number',
		'std' => '0',
		'type' => 'text');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'name' => 'Choose question status for users only',
		'desc' => 'Choose question status after user publish the question.',
		'id' => 'question_publish',
		'options' => array("publish" => "Publish","draft" => "Draft"),
		'std' => 'draft',
		'type' => 'select');
	
	$options[] = array(
		'name' => 'Choose question status for unlogged user only',
		'desc' => 'Choose question status after unlogged user publish the question.',
		'id' => 'question_publish_unlogged',
		'options' => array("publish" => "Publish","draft" => "Draft"),
		'std' => 'draft',
		'type' => 'select');
	
	$options[] = array(
		'name' => 'Send email when the question need a review',
		'desc' => 'Email for questions review enable or disable.',
		'id' => 'send_email_draft_questions',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Title in ask question form',
		'desc' => 'Title in ask question form enable or disable.',
		'id' => 'title_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'title_question',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Excerpt type for title from the content',
		'desc' => 'Choose form here the excerpt type.',
		'id' => 'title_excerpt_type',
		'type' => "select",
		'options' => array(
			'words' => 'Words',
			'characters' => 'Characters')
		);
	
	$options[] = array(
		'name' => 'Excerpt title from the content',
		'desc' => 'Put here the excerpt title from the content.',
		'id' => 'title_excerpt',
		'std' => 10,
		'type' => 'text');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'name' => 'Category in ask question form',
		'desc' => 'Category in ask question form enable or disable.',
		'id' => 'category_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'category_question',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Category in ask question form is required',
		'desc' => 'Category in ask question form is required.',
		'id' => 'category_question_required',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Category at ask question form single, multi or ajax",
		'desc' => "Choose category is show at ask question form single, multi or ajax",
		'id' => 'category_single_multi',
		'std' => 'single',
		'type' => 'radio',
		'options' => 
			array(
				"single" => "Single",
				"multi"  => "Multi",
				"ajax"  => "Ajax"
		)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'name' => 'Tags enable or disable in add question form',
		'desc' => 'Select ON to enable the tags in add question form.',
		'id' => 'tags_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Poll enable or disable in add question form',
		'desc' => 'Select ON to enable the poll in add question form.',
		'id' => 'poll_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Attachment in add question form',
		'desc' => 'Select ON to enable the attachment in add question form.',
		'id' => 'attachment_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Featured image in add question form',
		'desc' => 'Select ON to enable the Featured image in add question form.',
		'id' => 'featured_image_question',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Details in ask question form is required',
		'desc' => 'Details in ask question form is required.',
		'id' => 'comment_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Editor enable or disable for details in add question form',
		'desc' => 'Editor enable or disable for details in add question form.',
		'id' => 'editor_question_details',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Video description settings',
		'desc' => 'Select ON if you want to let users to add video with their question.',
		'id' => 'video_desc_active',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active notified at ask question form or not',
		'desc' => 'Select ON if you want active the notified.',
		'id' => 'active_notified',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Send email for the user to notified a new question',
		'desc' => 'Send email enable or disable.',
		'id' => 'send_email_new_question',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'send_email_new_question',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Send email for custom groups to notified a new question',
		'desc' => 'Send email for custom groups to notified a new question.',
		'id' => 'send_email_question_groups',
		'type' => 'multicheck',
		'std' => array("editor" => 1,"administrator" => 1,"author" => 1,"contributor" => 1,"subscriber" => 1),
		'options' => $options_groups);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'name' => 'Active the private question or not?',
		'desc' => 'Select ON if you want active the private question.',
		'id' => 'private_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active ask anonymously or not?',
		'desc' => 'Select ON if you want active ask anonymously.',
		'id' => 'anonymously_question',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the page terms?',
		'desc' => 'Select ON if you want active the page terms.',
		'id' => 'terms_active',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'terms_active',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Open the page in same page or a new page?',
		'desc' => 'Open the page in same page or a new page.',
		'id' => 'terms_active_target',
		'std' => "new_page",
		'type' => 'select',
		'options' => array("same_page" => "Same page","new_page" => "New page"));
	
	$options[] = array(
		'name' => "Terms page",
		'desc' => "Select the terms page",
		'id' => 'terms_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "Type the terms link if you don't like a page",
		'desc' => "Type the terms link if you don't like a page",
		'id' => 'terms_link',
		'type' => 'text');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'name' => 'Edit question setting.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => "Edit question page",
		'desc' => "Create a page using the Edit question template and select it here",
		'id' => 'edit_question',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => 'After edit question approved auto or need to approved again?',
		'desc' => 'Press ON to approved auto',
		'id' => 'question_approved',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active user can edit the questions',
		'desc' => 'Select ON if you want the user can edit the questions.',
		'id' => 'question_edit',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'After edit question change the URL like the title?',
		'desc' => 'Press ON to edit the URL',
		'id' => 'change_question_url',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Delete question setting.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => 'Active user can delete the questions',
		'desc' => 'Select ON if you want the user can delete the questions.',
		'id' => 'question_delete',
		'std' => 1,
		'type' => 'checkbox');
		
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'questions_loop',
		'name' => "Questions & Loop settings"
	);
	
	$options[] = array(
		'name' => 'Select the meta for the questions loop',
		'desc' => 'Select the meta for the questions loop.',
		'id' => 'questions_meta',
		'type' => 'multicheck',
		'std' => array(
			"status" => 1,
			"category" => 1,
			"user_name" => 1,
			"date" => 1,
			"answer_meta" => 1,
			"view" => 1,
			"question_bump" => 1,
		),
		'options' => array(
			"status" => "Quetion status",
			"category" => "Category",
			"user_name" => "Username and asked to",
			"date" => "Date",
			"answer_meta" => "Answer meta",
			"view" => "Views",
			"question_bump" => "Question bump points",
		));
	
	$options[] = array(
		'name' => 'Display Like/disLike in the loop',
		'desc' => 'Display Like/disLike in the loop enable or disable.',
		'id' => 'question_vote_show',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the author image in the questions loop',
		'desc' => 'If you put it OFF the author name will add in the meta.',
		'id' => 'question_author',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Click on to show featured image in the questions',
		'desc' => 'Click on to show featured image in the questions.',
		'id' => 'featured_image_loop',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Click on to enable the lightbox for featured image',
		'desc' => 'Select ON to enable the lightbox for featured image.',
		'id' => 'featured_image_question_lightbox',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		"name" => "Set the width for the featured image for the questions",
		"desc" => "Set the width for the featured image for the questions",
		"id" => "featured_image_question_width",
		"type" => "sliderui",
		'std' => 260,
		"step" => "1",
		"min" => "50",
		"max" => "600");
	
	$options[] = array(
		"name" => "Set the height for the featured image for the questions",
		"desc" => "Set the height for the featured image for the questions",
		"id" => "featured_image_question_height",
		"type" => "sliderui",
		'std' => 185,
		"step" => "1",
		"min" => "50",
		"max" => "600");
	
	$options[] = array(
		'name'    => 'Featured image position',
		'desc'    => 'Choose the featured image position.',
		'id'      => 'featured_position',
		'options' => array("before" => "Before content","after" => "After content"),
		'std'     => 'before',
		'type'    => 'select');
	
	$options[] = array(
		'name' => 'Video description settings at the question loop',
		'desc' => 'Select ON if you want to let users to add video with their question.',
		'id' => 'video_desc_active_loop',
		'type' => 'checkbox');
	
	$options[] = array(
		'div'  => 'div',
		'id'   => 'video_desc_active_loop',
		'type' => 'heading-2');
	
	$options[] = array(
		'name' => 'Video description position at the question loop',
		'desc' => 'Choose the video description position.',
		'id' => 'video_desc_loop',
		'options' => array("before" => "Before content","after" => "After content"),
		'std' => 'after',
		'type' => 'select');
	
	$options[] = array(
		"name" => "Set the width for the video description for the questions",
		"desc" => "Set the width for the video description for the questions",
		"id" => "video_description_width",
		"type" => "sliderui",
		'std' => 260,
		"step" => "1",
		"min" => "50",
		"max" => "600");
	
	$options[] = array(
		'name' => 'Or set the video description with 100%?',
		'desc' => 'Select ON if you want to set the video description 100%.',
		'id' => 'video_desc_100_loop',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		"name" => "Set the height for the video description for the questions",
		"desc" => "Set the height for the video description for the questions",
		"id" => "video_description_height",
		"type" => "sliderui",
		'std' => 500,
		"step" => "1",
		"min" => "50",
		"max" => "600");
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end',
		'div'  => 'div');
	
	$options[] = array(
		'name' => 'Click on to hide the excerpt in questions',
		'desc' => 'Click on to hide the excerpt in questions.',
		'id' => 'excerpt_questions',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Click on to show continue reading button in the questions',
		'desc' => 'Click on to show continue reading button in the questions.',
		'id' => 'continue_reading_questions',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Excerpt type for question',
		'desc' => 'Choose form here the excerpt type.',
		'id' => 'question_excerpt_type',
		'type' => "select",
		'options' => array(
			'words' => 'Words',
			'characters' => 'Characters')
		);
	
	$options[] = array(
		'name' => 'Excerpt question',
		'desc' => 'Put here the excerpt question.',
		'id' => 'question_excerpt',
		'std' => 40,
		'type' => 'text');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end');
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'inner_question',
		'name' => "Inner question"
	);
	
	$options[] = array(
		'desc' => "Sort your sections.",
		'name' => "Sort your sections.",
		'id' => "order_sections_question",
		'std' => '',
		'type' => 'sections');
	
	$options[] = array(
		'name' => 'Select the meta for the single question page',
		'desc' => 'Select the meta for the single question page.',
		'id' => 'questions_meta_single',
		'type' => 'multicheck',
		'std' => array(
			"status" => 1,
			"category" => 1,
			"user_name" => 1,
			"date" => 1,
			"answer_meta" => 1,
			"view" => 1,
		),
		'options' => array(
			"status" => "Quetion status",
			"category" => "Category",
			"user_name" => "Username and asked to",
			"date" => "Date",
			"answer_meta" => "Answer meta",
			"view" => "Views",
		));
	
	$options[] = array(
		'name' => 'Video description position',
		'desc' => 'Choose the video description position.',
		'id' => 'video_desc',
		'options' => array("before" => "Before content","after" => "After content"),
		'std' => 'after',
		'type' => 'select');
	
	$options[] = array(
		'name' => 'Click on to show featured image in the single question',
		'desc' => 'Click on to show featured image in the single question.',
		'id' => 'featured_image_single',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active poll for user only?',
		'desc' => 'Select ON if you want the poll allow to users only.',
		'id' => 'poll_user_only',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select the question control style',
		'desc' => 'Select the question control style.',
		'id' => 'question_control_style',
		'std' => "style_1",
		'type' => 'select',
		'options' => array("style_1" => "Style 1","style_2" => "Style 2"));
	
	$options[] = array(
		'name' => 'Active user can follow the questions',
		'desc' => 'Select ON if you want the user can follow the questions.',
		'id' => 'question_follow',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active close and open questions',
		'desc' => 'Select ON if you want active close and open questions.',
		'id' => 'question_close',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the question bump',
		'desc' => 'Select ON if you want the question bump.',
		'id' => 'question_bump',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Share enable or disable',
		'desc' => 'Share enable or disable.',
		'id' => 'question_share',
		'std' => 1,
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => 'Author info box enable or disable',
		'desc' => 'Author info box enable or disable.',
		'id' => 'question_author_box',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Answers enable or disable',
		'desc' => 'Answers enable or disable.',
		'id' => 'question_answers',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Click on to show featured image in the question answers',
		'desc' => 'Select ON to enable the featured image in the question answers.',
		'id' => 'featured_image_question_answers',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Related question enable or disable',
		'desc' => 'Related question enable or disable.',
		'id' => 'related_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Related question number',
		'desc' => 'Type related question number from here.',
		'id' => 'related_number_question',
		'std' => '5',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Related question query",
		'desc' => "Select your related question query.",
		'id' => "related_query_question",
		'std' => "categories",
		'type' => "select",
		'options' => array(
			'categories' => 'Categories',
			'tags' => 'Tags',
		)
	);
	
	$options[] = array(
		'name' => 'Navigation question enable or disable',
		'desc' => 'Navigation question (next and previous questions) enable or disable.',
		'id' => 'question_navigation',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Navigation question for the same category only?',
		'desc' => 'Navigation question (next and previous questions) for the same category only?',
		'id' => 'question_nav_category',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Answers & comments',
		'icon' => 'format-chat',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Enable or disable the editor in the comment or answer',
		'desc' => 'Enable or disable the editor in the comment or answer.',
		'id' => 'comment_editor',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Comments & answers enable or disable for user only',
		'desc' => 'Comments & answers enable or disable for user only.',
		'id' => 'post_comments_user',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Note: if you need all the answers/comments manually approved, From here Settings >> Discussion >> Comment must be manually approved.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => 'Choose answers/comments status for unlogged user only',
		'desc' => 'Choose answers/comments status after unlogged user publish the answers/comments.',
		'id' => 'comment_unlogged',
		'options' => array("publish" => "Publish","draft" => "Draft"),
		'std' => 'draft',
		'type' => 'select');
	
	$options[] = array(
		'name' => 'Active the private answer or not?',
		'desc' => 'Select ON if you want active the private answer.',
		'id' => 'private_answer',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'User can edit the comment or answer?',
		'desc' => 'User can edit the comment or answer?',
		'id' => 'can_edit_comment',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		"name" => "User can edit the comment or answer after x hours",
		"desc" => "If you want the user edit it all the time leave it 0",
		"id" => "can_edit_comment_after",
		"type" => "sliderui",
		'std' => 1,
		"step" => "1",
		"min" => "0",
		"max" => "24");
	
	$options[] = array(
		'name' => "Edit comment page",
		'desc' => "Create a page using the Edit post template and select it here",
		'id' => 'edit_comment',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => 'After edit comment or answer approved auto or need to approved again?',
		'desc' => 'Press ON to approved auto',
		'id' => 'comment_approved',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select ON to hide the dislike at answers',
		'desc' => 'If you put it ON the dislike will not show.',
		'id' => 'show_dislike_answers',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Attachment in a new answer form',
		'desc' => 'Select ON to enable the attachment in a new answer form.',
		'id' => 'attachment_answer',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Featured image in a new answer form',
		'desc' => 'Select ON to enable the featured image in a new answer form.',
		'id' => 'featured_image_answer',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Click on to show featured image in the answers',
		'desc' => 'Select ON to enable the featured image in the answers.',
		'id' => 'featured_image_in_answers',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Click on to enable the lightbox for featured image',
		'desc' => 'Select ON to enable the lightbox for featured image.',
		'id' => 'featured_image_answers_lightbox',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		"name" => "Set the width for the featured image for the answers",
		"desc" => "Set the width for the featured image for the answers",
		"id" => "featured_image_answer_width",
		"type" => "sliderui",
		'std' => 260,
		"step" => "1",
		"min" => "50",
		"max" => "600");
	
	$options[] = array(
		"name" => "Set the height for the featured image for the answers",
		"desc" => "Set the height for the featured image for the answers",
		"id" => "featured_image_answer_height",
		"type" => "sliderui",
		'std' => 185,
		"step" => "1",
		"min" => "50",
		"max" => "600");
	
	$options[] = array(
		'name'    => 'Featured image position',
		'desc'    => 'Choose the featured image position.',
		'id'      => 'featured_answer_position',
		'options' => array("before" => "Before content","after" => "After content"),
		'std'     => 'before',
		'type'    => 'select');
	
	$options[] = array(
		'name' => "Answers sort by",
		'desc' => "Choose the answers sort by (it's show at the question page only)",
		'id' => 'answers_sort',
		'std' => 'date',
		'type' => 'radio',
		'options' => 
			array(
				"date" => "Date",
				"vote" => "Vote"
		)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Payment setting',
		'icon' => 'tickets-alt',
		'type' => 'heading',
		'std'     => 'general_setting',
		'options' => array(
			"payment_setting" => "Payment setting",
			"pay_to_ask"      => "Pay to ask",
			"pay_to_sticky"   => "Pay to sticky question",
			"coupons_setting" => "Coupons setting",
		)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'payment_setting',
		'name' => "Payment setting"
	);
	
	$options[] = array(
		'name' => 'Enable PayPal sandbox',
		'desc' => 'PayPal sandbox can be used to test payments.',
		'id' => 'paypal_sandbox',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Currency code',
		'desc' => 'Choose form here the currency code.',
		'id' => 'currency_code',
		'std' => 'USD',
		'type' => "select",
		'options' => array(
			'USD' => 'USD',
			'EUR' => 'EUR',
			'GBP' => 'GBP',
			'JPY' => 'JPY',
			'CAD' => 'CAD',)
		);
	
	$options[] = array(
		'name' => "PayPal email",
		'desc' => "put your PayPal email",
		'id' => 'paypal_email',
		'type' => 'text');
	
	$options[] = array(
		'name' => "PayPal Identity Token",
		'desc' => "From here Profile >> Profile and settings >> My selling tools >> Website preferences >> Update >> Identity Token",
		'id' => 'identity_token',
		'type' => 'text');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'pay_to_ask',
		'name' => "Pay to ask"
	);
	
	$options[] = array(
		'name' => 'Pay to ask question',
		'desc' => 'Select ON to active the pay to ask question.',
		'id' => 'pay_ask',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Choose the groups add a question without pay",
		'desc' => "Choose the groups add a question without pay",
		'id' => 'payment_group',
		'type' => 'multicheck',
		'options' => $new_roles);
	
	$options[] = array(
		"name" => "What's the price to ask a new question?",
		"desc" => "Type here the price of the payment to ask a new question",
		"id" => "pay_ask_payment",
		"type" => "text",
		'std' => 10,);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'pay_to_sticky',
		'name' => "Pay to sticky question"
	);
	
	$options[] = array(
		'name' => 'Pay to sticky question at the top',
		'desc' => 'Select ON to active the pay to sticky question.',
		'id' => 'pay_to_sticky',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		"name" => "What's the price to sticky the question?",
		"desc" => "Type here the price of the payment to sticky the question",
		"id" => "pay_sticky_payment",
		"type" => "text",
		'std' => 5,);
	
	$options[] = array(
		"name" => "What's the days to sticky the question?",
		"desc" => "Type here the days of the payment to sticky the question",
		"id" => "days_sticky",
		"type" => "sliderui",
		'std' => 7,
		"step" => "1",
		"min" => "0",
		"max" => "365");
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'coupons_setting',
		'name' => "Coupons setting"
	);
	
	$options[] = array(
		'name' => 'Active the Coupons',
		'desc' => 'Select ON to active the coupons.',
		'id' => 'active_coupons',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Show the free coupons when add a new question or sticky questions?',
		'desc' => 'Select ON to show the free coupons.',
		'id' => 'free_coupons',
		'type' => 'checkbox');
	
	$options[] = array(
		'desc' => "Add your Coupons.",
		'id' => "coupons",
		'std' => '',
		'type' => 'coupons');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Captcha setting',
		'icon' => 'admin-network',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Captcha enable or disable (in ask question form)',
		'desc' => 'Captcha enable or disable (in ask question form).',
		'id' => 'the_captcha',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Captcha enable or disable (in add post form)',
		'desc' => 'Captcha enable or disable (in add post form).',
		'id' => 'the_captcha_post',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Captcha enable or disable (in register form)',
		'desc' => 'Captcha enable or disable (in register form).',
		'id' => 'the_captcha_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Captcha enable or disable (in login form)',
		'desc' => 'Captcha enable or disable (in login form).',
		'id' => 'the_captcha_login',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Captcha enable or disable (in answer form)',
		'desc' => 'Captcha enable or disable (in answer form).',
		'id' => 'the_captcha_answer',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Captcha enable or disable (in comment form)',
		'desc' => 'Captcha enable or disable (in comment form).',
		'id' => 'the_captcha_comment',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Captcha enable or disable (in send message form)',
		'desc' => 'Captcha enable or disable (in send message form).',
		'id' => 'the_captcha_message',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Captcha style",
		'desc' => "Choose the captcha style",
		'id' => 'captcha_style',
		'std' => 'question_answer',
		'type' => 'radio',
		'options' => 
			array(
				"question_answer" => "Question and answer",
				"normal_captcha" => "Normal captcha"
		)
	);
	
	$options[] = array(
		'name' => 'Captcha answer enable or disable in forms',
		'desc' => 'Captcha answer enable or disable.',
		'id' => 'show_captcha_answer',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Captcha question",
		'desc' => "put the Captcha question",
		'id' => 'captcha_question',
		'type' => 'text',
		'std' => "What is the capital of Egypt?");
	
	$options[] = array(
		'name' => "Captcha answer",
		'desc' => "put the Captcha answer",
		'id' => 'captcha_answer',
		'type' => 'text',
		'std' => "Cairo");
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'User setting',
		'icon' => 'admin-users',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Ask question to the users',
		'desc' => 'Any one can ask question to the users enable or disable.',
		'id'   => 'ask_question_to_users',
		'std'  => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'All the site for the register users only?',
		'desc' => 'Click ON to active the site for the register users only.',
		'id' => 'site_users_only',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the notifications system in site?',
		'desc' => 'Active the notifications system enable or disable.',
		'id' => 'active_notifications',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the activity log in site?',
		'desc' => 'Active the activity log enable or disable.',
		'id' => 'active_activity_log',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select the user links',
		'desc' => 'Select the user links.',
		'id' => 'user_links',
		'type' => 'multicheck',
		'std' => array(
			"profile" => "Profile page",
			"messages" => "Messages",
			"questions" => "Questions",
			"polls" => "Polls",
			"asked_questions" => "Asked Questions",
			"paid_questions" => "Paid Questions",
			"answers" => "Answers",
			"best_answers" => "Best Answers",
			"favorite" => "Favorite Questions",
			"followed" => "Followed Questions",
			"points" => "Points",
			"i_follow" => "Authors I Follow",
			"followers" => "Followers",
			"posts" => "Posts",
			"comments" => "Comments",
			"follow_questions" => "Follow Questions",
			"follow_answers" => "Follow Answers",
			"follow_posts" => "Follow Posts",
			"follow_comments" => "Follow Comments",
			"edit_profile" => "Edit Profile",
			"activity_log" => "Activity Log",
			"logout" => "Logout",
		),
		'options' => array(
			"profile" => "Profile page",
			"messages" => "Messages",
			"questions" => "Questions",
			"polls" => "Polls",
			"asked_questions" => "Asked Questions",
			"paid_questions" => "Paid Questions",
			"answers" => "Answers",
			"best_answers" => "Best Answers",
			"favorite" => "Favorite Questions",
			"followed" => "Followed Questions",
			"points" => "Points",
			"i_follow" => "Authors I Follow",
			"followers" => "Followers",
			"posts" => "Posts",
			"comments" => "Comments",
			"follow_questions" => "Follow Questions",
			"follow_answers" => "Follow Answers",
			"follow_posts" => "Follow Posts",
			"follow_comments" => "Follow Comments",
			"edit_profile" => "Edit Profile",
			"activity_log" => "Activity Log",
			"logout" => "Logout",
		));
	
	$options[] = array(
		'name' => 'Select the columns in the user admin',
		'desc' => 'Select the columns in the user admin.',
		'id' => 'user_meta_admin',
		'type' => 'multicheck',
		'std' => array(
			"phone" => 0,
			"country" => 0,
			"age" => 0,
		),
		'options' => array(
			"phone" => "Phone",
			"country" => "Country",
			"age" => "Age",
		));
	
	$options[] = array(
		'name' => "Login and register page",
		'desc' => "Select the Login and register page",
		'id' => 'login_register_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User edit profile page",
		'desc' => "Select the User edit profile page",
		'id' => 'user_edit_profile_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "Activity log page",
		'desc' => "Select the Activity log page",
		'id' => 'activity_log_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "Notifications page",
		'desc' => "Select the Notifications page",
		'id' => 'notifications_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User post page",
		'desc' => "Select User post page",
		'id' => 'post_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User comment page",
		'desc' => "Select User comment page",
		'id' => 'comment_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User question page",
		'desc' => "Select User question page",
		'id' => 'question_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User polls page",
		'desc' => "Select User polls page",
		'id' => 'polls_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User asked question page",
		'desc' => "Select User asked question page",
		'id' => 'asked_question_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "Paid questions page",
		'desc' => "Select the paid questions page",
		'id' => 'paid_question',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User answer page",
		'desc' => "Select User answer page",
		'id' => 'answer_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User best answer page",
		'desc' => "Select User best answer page",
		'id' => 'best_answer_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User favorite question page",
		'desc' => "Select User favorite question page",
		'id' => 'favorite_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User followed question page",
		'desc' => "Select User followed question page",
		'id' => 'followed_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User point page",
		'desc' => "Select User point page",
		'id' => 'point_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "Authors I Follow page",
		'desc' => "Select Authors I Follow page",
		'id' => 'i_follow_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User Followers page",
		'desc' => "Select User Followers page",
		'id' => 'followers_user_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User follow question page",
		'desc' => "Select User follow question page",
		'id' => 'follow_question_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User follow answer page",
		'desc' => "Select User follow answer page",
		'id' => 'follow_answer_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User follow posts page",
		'desc' => "Select User follow posts page",
		'id' => 'follow_post_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "User follow comment page",
		'desc' => "Select User follow comment page",
		'id' => 'follow_comment_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => 'Add profile picture in edit profile form',
		'desc' => 'Add profile picture in edit profile form.',
		'id' => 'profile_picture_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Profile picture in edit profile form is required',
		'desc' => 'Profile picture in edit profile form is required.',
		'id' => 'profile_picture_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add country in edit profile form',
		'desc' => 'Add country in edit profile form.',
		'id' => 'country_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Country in edit profile form is required',
		'desc' => 'Country in edit profile form is required.',
		'id' => 'country_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add city in edit profile form',
		'desc' => 'Add city in edit profile form.',
		'id' => 'city_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'City in edit profile form is required',
		'desc' => 'City in edit profile form is required.',
		'id' => 'city_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add age in edit profile form',
		'desc' => 'Add age in edit profile form.',
		'id' => 'age_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Age in edit profile form is required',
		'desc' => 'Age in edit profile form is required.',
		'id' => 'age_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add phone in edit profile form',
		'desc' => 'Add phone in edit profile form.',
		'id' => 'phone_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Phone in edit profile form is required',
		'desc' => 'Phone in edit profile form is required.',
		'id' => 'phone_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add sex in edit profile form',
		'desc' => 'Add sex in edit profile form.',
		'id' => 'sex_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Sex in edit profile form is required',
		'desc' => 'Sex in edit profile form is required.',
		'id' => 'sex_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add names in edit profile form',
		'desc' => 'Add names in edit profile form.',
		'id' => 'names_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Names in edit profile form is required',
		'desc' => 'Names in edit profile form is required.',
		'id' => 'names_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add url in edit profile form',
		'desc' => 'Add url in edit profile form.',
		'id' => 'url_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Url in edit profile form is required',
		'desc' => 'Url in edit profile form is required.',
		'id' => 'url_required_profile',
		'std' => 0,
		'type' => 'checkbox');
	
	$options = apply_filters('askme_edit_profile_options',$options);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Message setting',
		'icon' => 'email-alt',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Active messages to the users',
		'desc' => 'Any one can send message to the users enable or disable.',
		'id'   => 'active_message',
		'std'  => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Messages page",
		'desc' => "Select the messages page",
		'id' => 'messages_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => 'Choose message status',
		'desc' => 'Choose message status after user publish the question.',
		'id' => 'message_publish',
		'options' => array("publish" => "Publish","draft" => "Draft"),
		'std' => 'draft',
		'type' => 'select');
	
	$options[] = array(
		'name' => 'Any one can send message without register',
		'desc' => 'Any one can send message without register enable or disable.',
		'id' => 'send_message_no_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Details in send message form is required',
		'desc' => 'Details in send message form is required.',
		'id' => 'comment_message',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Editor enable or disable for details in send message form',
		'desc' => 'Editor enable or disable for details in send message form.',
		'id' => 'editor_message_details',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Send email after send a message?',
		'desc' => 'Send email after send a message?.',
		'id' => 'send_email_message',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active user can delete the messages',
		'desc' => 'Select ON if you want the user can delete the messages.',
		'id' => 'message_delete',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active user can seen the message by send notification',
		'desc' => 'Select ON if you want the user know if any one seen the message by send notification.',
		'id' => 'seen_message',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Badges & Points setting',
		'icon' => 'star-filled',
		'type' => 'heading',
		'std'     => 'general_setting',
		'options' => array(
			"badges_setting" => "Badges setting",
			"points_setting" => "Points setting",
		)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'badges_setting',
		'name' => "Badges setting"
	);
	
	$options[] = array(
		'desc' => "Add your badges.",
		'id' => "badges",
		'std' => '',
		'type' => 'badges');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'points_setting',
		'name' => "Points setting"
	);
	
	$options[] = array(
		'name' => "Points for add a new question (put it 0 for off the option)",
		'desc' => "put the Points choose for add a new question",
		'id' => 'point_add_question',
		'type' => 'text',
		'std' => 0);
	
	$options[] = array(
		'name' => "Points for add a new post (put it 0 for off the option)",
		'desc' => "put the Points choose for add a new post",
		'id' => 'point_add_post',
		'type' => 'text',
		'std' => 0);
	
	$options[] = array(
		'name' => "Points choose best answer",
		'desc' => "put the Points choose best answer",
		'id' => 'point_best_answer',
		'type' => 'text',
		'std' => 5);
	
	$options[] = array(
		'name' => "Points Rating question",
		'desc' => "put the Points Rating question",
		'id' => 'point_rating_question',
		'type' => 'text',
		'std' => 0);
	
	$options[] = array(
		'name' => "Points add answer",
		'desc' => "put the Points add answer",
		'id' => 'point_add_comment',
		'type' => 'text',
		'std' => 2);
	
	$options[] = array(
		'name' => "Points Rating answer",
		'desc' => "put the Points Rating answer",
		'id' => 'point_rating_answer',
		'type' => 'text',
		'std' => 1);
	
	$options[] = array(
		'name' => "Points following user",
		'desc' => "put the Points following user",
		'id' => 'point_following_me',
		'type' => 'text',
		'std' => 1);
	
	$options[] = array(
		'name' => "Points for a new user",
		'desc' => "put the Points for a new user",
		'id' => 'point_new_user',
		'type' => 'text',
		'std' => 20);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'User group setting',
		'icon' => 'groups',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Select ON to can add a custom permission.',
		'desc' => 'Select ON to can add a custom permission.',
		'id' => 'custom_permission',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Without login user",
		'class' => 'home_page_display custom_permission_note',
		'type' => 'info');
	
	$options[] = array(
		'name' => 'Select ON to can add a question.',
		'desc' => 'Select ON to can add a question.',
		'id' => 'ask_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select ON to can show other questions.',
		'desc' => 'Select ON to can show other questions.',
		'id' => 'show_question',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select ON to can add a answer.',
		'desc' => 'Select ON to can add a answer.',
		'id' => 'add_answer',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select ON to can show other answers.',
		'desc' => 'Select ON to can show other answers.',
		'id' => 'show_answer',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select ON to can add a post.',
		'desc' => 'Select ON to can add a post.',
		'id' => 'add_post',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Select ON to can send a message.',
		'desc' => 'Select ON to can send a message.',
		'id' => 'send_message',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'id' => "roles",
		'std' => '',
		'type' => 'roles');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Register setting',
		'icon' => 'lock',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => "Register in default group",
		'desc' => "Select the default group",
		'id' => 'default_group',
		'std' => 'subscriber',
		'type' => 'select',
		'options' => $new_roles);
	
	$options[] = array(
		'name' => 'After register go to?',
		'desc' => 'After register go to?',
		'id' => 'after_register',
		'std' => "same_page",
		'type' => 'select',
		'options' => array("same_page" => "Same page","home" => "Home","profile" => "Profile","custom_link" => "Custom link"));
	
	$options[] = array(
		'name' => "Type the link if you don't like above",
		'desc' => "Type the link if you don't like above",
		'id' => 'after_register_link',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'After login go to?',
		'desc' => 'After login go to?',
		'id' => 'after_login',
		'std' => "same_page",
		'type' => 'select',
		'options' => array("same_page" => "Same page","home" => "Home","profile" => "Profile","custom_link" => "Custom link"));
	
	$options[] = array(
		'name' => "Type the link if you don't like above",
		'desc' => "Type the link if you don't like above",
		'id' => 'after_login_link',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Confirm with email enable or disable (in register form)',
		'desc' => 'Confirm with email enable or disable.',
		'id' => 'confirm_email',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'The membership under review?',
		'desc' => 'Check ON to review the users before complete the register.',
		'id' => 'user_review',
		'std' => 0,
		'type' => 'checkbox');
	
	/*
	$options[] = array(
		'name'    => 'Select the search options',
		'desc'    => 'Select the search options on the search page.',
		'id'      => 'search_attrs',
		'type'    => 'multicheck_sort',
		'sort'    => 'yes',
		'std'     => array(
			"questions"           => array("sort" => "Questions","value" => "on"),
			"answers"             => array("sort" => "Answers","value" => "on"),
			ask_question_category => array("sort" => "Question categories","value" => "on"),
			"question_tags"       => array("sort" => "Question tags","value" => "on"),
			"posts"               => array("sort" => "Posts","value" => "on"),
			"comments"            => array("sort" => "Comments","value" => "on"),
			"category"            => array("sort" => "Post categories","value" => "on"),
			"post_tag"            => array("sort" => "Post tags","value" => "on"),
			"users"               => array("sort" => "Users","value" => "on"),
		),
		'options' => array(
			"questions"           => array("sort" => "Questions","value" => "on"),
			"answers"             => array("sort" => "Answers","value" => "on"),
			ask_question_category => array("sort" => "Question categories","value" => "on"),
			"question_tags"       => array("sort" => "Question tags","value" => "on"),
			"posts"               => array("sort" => "Posts","value" => "on"),
			"comments"            => array("sort" => "Comments","value" => "on"),
			"category"            => array("sort" => "Post categories","value" => "on"),
			"post_tag"            => array("sort" => "Post tags","value" => "on"),
			"users"               => array("sort" => "Users","value" => "on"),
		));
	*/
	
	$options[] = array(
		'name' => 'Add profile picture in register form',
		'desc' => 'Add profile picture in register form.',
		'id' => 'profile_picture',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Profile picture in register form is required',
		'desc' => 'Profile picture in register form is required.',
		'id' => 'profile_picture_required',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add country in register form',
		'desc' => 'Add country in register form.',
		'id' => 'country_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Country in register form is required',
		'desc' => 'Country in register form is required.',
		'id' => 'country_required',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add city in register form',
		'desc' => 'Add city in register form.',
		'id' => 'city_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'City in register form is required',
		'desc' => 'City in register form is required.',
		'id' => 'city_required',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add age in register form',
		'desc' => 'Add age in register form.',
		'id' => 'age_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Age in register form is required',
		'desc' => 'Age in register form is required.',
		'id' => 'age_required',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add phone in register form',
		'desc' => 'Add phone in register form.',
		'id' => 'phone_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Phone in register form is required',
		'desc' => 'Phone in register form is required.',
		'id' => 'phone_required',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add sex in register form',
		'desc' => 'Add sex in register form.',
		'id' => 'sex_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Sex in register form is required',
		'desc' => 'Sex in register form is required.',
		'id' => 'sex_required',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Add names in register form',
		'desc' => 'Add names in register form.',
		'id' => 'names_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Names in register form is required',
		'desc' => 'Names in register form is required.',
		'id' => 'names_required',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Active the page terms?',
		'desc' => 'Select ON if you want active the page terms.',
		'id' => 'terms_active_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Open the page in same page or a new page?',
		'desc' => 'Open the page in same page or a new page.',
		'id' => 'terms_active_target_register',
		'std' => "new_page",
		'type' => 'select',
		'options' => array("same_page" => "Same page","new_page" => "New page"));
	
	$options[] = array(
		'name' => "Terms page",
		'desc' => "Select the terms page",
		'id' => 'terms_page_register',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "Type the terms link if you don't like a page",
		'desc' => "Type the terms link if you don't like a page",
		'id' => 'terms_link_register',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Register content',
		'desc' => 'Put the register content in top panel and register page.',
		'id' => 'register_content',
		'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.Morbi adipiscing gravdio, sit amet suscipit risus ultrices eu.Fusce viverra neque at purus laoreet consequa.Vivamus vulputate posuere nisl quis consequat.',
		'type' => 'textarea');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Author Page',
		'icon' => 'businessman',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Hide the user registered in profile page',
		'desc' => 'Select ON if you want to hide the user registered in profile page.',
		'id' => 'user_registered',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Hide the user country in profile page',
		'desc' => 'Select ON if you want to hide the user country in profile page.',
		'id' => 'user_country',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Hide the user city in profile page',
		'desc' => 'Select ON if you want to hide the user city in profile page.',
		'id' => 'user_city',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Hide the user phone in profile page',
		'desc' => 'Select ON if you want to hide the user phone in profile page.',
		'id' => 'user_phone',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Hide the user age in profile page',
		'desc' => 'Select ON if you want to hide the user age in profile page.',
		'id' => 'user_age',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Hide the user sex in profile page',
		'desc' => 'Select ON if you want to hide the user sex in profile page.',
		'id' => 'user_sex',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Hide the user url in profile page',
		'desc' => 'Select ON if you want to hide the user url in profile page.',
		'id' => 'user_url',
		'std' => 0,
		'type' => 'checkbox');
	
	$options = apply_filters('askme_author_page_options',$options);
	
	$options[] = array(
		'name' => 'Hide the author stats',
		'desc' => 'Select ON if you want to hide the author stats in profile page.',
		'id' => 'author_stats',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Author sidebar layout",
		'desc' => "Author sidebar layout.",
		'id' => "author_sidebar_layout",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'right' => $imagepath.'sidebar_right.jpg',
			'full' => $imagepath.'sidebar_no.jpg',
			'left' => $imagepath.'sidebar_left.jpg',
		)
	);
	
	$options[] = array(
		'name' => "Author Page Sidebar",
		'desc' => "Author Page Sidebar.",
		'id' => "author_sidebar",
		'std' => '',
		'options' => $new_sidebars,
		'type' => 'select');
	
	$options[] = array(
		'name' => "Author page layout",
		'desc' => "Author page layout.",
		'id' => "author_layout",
		'std' => "full",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'full' => $imagepath.'full.jpg',
			'fixed' => $imagepath.'fixed.jpg',
			'fixed_2' => $imagepath.'fixed_2.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Choose template",
		'desc' => "Choose template layout.",
		'id' => "author_template",
		'std' => "grid_1200",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'grid_1300' => $imagepath.'template_1300.jpg',
			'grid_1200' => $imagepath.'template_1200.jpg',
			'grid_970' => $imagepath.'template_970.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Site skin",
		'desc' => "Choose Site skin.",
		'id' => "author_skin_l",
		'std' => "site_light",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'site_light' => $imagepath.'light.jpg',
			'site_dark' => $imagepath.'dark.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Choose Your Skin",
		'desc' => "Choose Your Skin",
		'class' => "site_skin",
		'id' => "author_skin",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default'	    => $imagepath.'default.jpg',
			'skins'		    => $imagepath.'skin.jpg',
			'blue'			=> $imagepath.'blue.jpg',
			'gray'			=> $imagepath.'gray.jpg',
			'green'			=> $imagepath.'green.jpg',
			'moderate_cyan' => $imagepath.'moderate_cyan.jpg',
			'orange'		=> $imagepath.'orange.jpg',
			'purple'	    => $imagepath.'purple.jpg',
			'red'			=> $imagepath.'red.jpg',
			'strong_cyan'	=> $imagepath.'strong_cyan.jpg',
			'yellow'		=> $imagepath.'yellow.jpg',
		)
	);
	
	$options[] = array(
		'name' => "Primary Color",
		'desc' => "Primary Color",
		'id' => 'author_primary_color',
		'type' => 'color');
	
	$options[] = array(
		'name' => "Background Type",
		'desc' => "Background Type",
		'id' => 'author_background_type',
		'std' => 'patterns',
		'type' => 'radio',
		'options' => 
			array(
				"patterns" => "Patterns",
				"custom_background" => "Custom Background"
			)
	);

	$options[] = array(
		'name' => "Background Color",
		'desc' => "Background Color",
		'id' => 'author_background_color',
		'std' => "#FFF",
		'type' => 'color');
		
	$options[] = array(
		'name' => "Choose Pattern",
		'desc' => "Choose Pattern",
		'id' => "author_background_pattern",
		'std' => "bg13",
		'type' => "images",
		'options' => array(
			'bg1' => $imagepath.'bg1.jpg',
			'bg2' => $imagepath.'bg2.jpg',
			'bg3' => $imagepath.'bg3.jpg',
			'bg4' => $imagepath.'bg4.jpg',
			'bg5' => $imagepath.'bg5.jpg',
			'bg6' => $imagepath.'bg6.jpg',
			'bg7' => $imagepath.'bg7.jpg',
			'bg8' => $imagepath.'bg8.jpg',
			'bg9' => $imagepath.'../../images/patterns/bg9.png',
			'bg10' => $imagepath.'../../images/patterns/bg10.png',
			'bg11' => $imagepath.'../../images/patterns/bg11.png',
			'bg12' => $imagepath.'../../images/patterns/bg12.png',
			'bg13' => $imagepath.'bg13.jpg',
			'bg14' => $imagepath.'bg14.jpg',
			'bg15' => $imagepath.'../../images/patterns/bg15.png',
			'bg16' => $imagepath.'../../images/patterns/bg16.png',
			'bg17' => $imagepath.'bg17.jpg',
			'bg18' => $imagepath.'bg18.jpg',
			'bg19' => $imagepath.'bg19.jpg',
			'bg20' => $imagepath.'bg20.jpg',
			'bg21' => $imagepath.'../../images/patterns/bg21.png',
			'bg22' => $imagepath.'bg22.jpg',
			'bg23' => $imagepath.'../../images/patterns/bg23.png',
			'bg24' => $imagepath.'../../images/patterns/bg24.png',
	));

	$options[] = array(
		'name' =>  "Custom Background",
		'desc' => "Custom Background",
		'id' => 'author_custom_background',
		'std' => $background_defaults,
		'type' => 'background');
		
	$options[] = array(
		'name' => "Full Screen Background",
		'desc' => "Click on to Full Screen Background",
		'id' => 'author_full_screen_background',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Blog & Article settings',
		'icon' => 'admin-post',
		'type' => 'heading',
		'std'     => 'general_setting_blog',
		'options' => array(
			"general_setting_blog" => "General settings",
			"add_edit_delete_blog" => "Add - Edit - Delete",
		)
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'general_setting_blog',
		'name' => "General settings"
	);
	
	$options[] = array(
		'name' => "Blog display",
		'desc' => "Choose the Blog display",
		'id' => 'home_display',
		'std' => 'blog_1',
		'type' => 'radio',
		'options' => 
			array(
				"blog_1" => "Blog 1",
				"blog_2" => "Blog 2"
		)
	);
	
	$options[] = array(
		'desc' => "Sort your sections.",
		'name' => "Sort your sections.",
		'id' => "order_sections_li",
		'std' => '',
		'type' => 'sections');
	
	$options[] = array(
		'name' => 'Hide the featured image in the single post',
		'desc' => 'Click on to hide the featured image in the single post.',
		'id' => 'featured_image',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Excerpt type',
		'desc' => 'Choose form here the excerpt type.',
		'id' => 'excerpt_type',
		'type' => "select",
		'options' => array(
			'words' => 'Words',
			'characters' => 'Characters')
		);
	
	$options[] = array(
		'name' => 'Excerpt post',
		'desc' => 'Put here the excerpt post.',
		'id' => 'post_excerpt',
		'std' => 40,
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Post meta enable or disable',
		'desc' => 'Post meta enable or disable.',
		'id' => 'post_meta',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Share enable or disable',
		'desc' => 'Share enable or disable.',
		'id' => 'post_share',
		'std' => 1,
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => 'Author info box enable or disable',
		'desc' => 'Author info box enable or disable.',
		'id' => 'post_author_box',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Comments enable or disable',
		'desc' => 'Comments enable or disable.',
		'id' => 'post_comments',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Related post enable or disable',
		'desc' => 'Related post enable or disable.',
		'id' => 'related_post',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Related post number',
		'desc' => 'Type related post number from here.',
		'id' => 'related_number',
		'std' => '5',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Related post query",
		'desc' => "Select your related post query.",
		'id' => "related_query",
		'std' => "categories",
		'type' => "select",
		'options' => array(
			'categories' => 'Categories',
			'tags' => 'Tags',
		)
	);
	
	$options[] = array(
		'name' => 'Navigation post enable or disable',
		'desc' => 'Navigation post (next and previous posts) enable or disable.',
		'id' => 'post_navigation',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Navigation post for the same category only?',
		'desc' => 'Navigation post (next and previous posts) for the same category only?',
		'id' => 'post_nav_category',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'id'   => 'add_edit_delete_blog',
		'name' => "Add - Edit - Delete"
	);
	
	$options[] = array(
		'name' => 'Add post setting.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => 'Any one can add post without register',
		'desc' => 'Any one can add post without register enable or disable.',
		'id' => 'add_post_no_register',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Choose post status',
		'desc' => 'Choose post status after user publish the post.',
		'id' => 'post_publish',
		'options' => array("publish" => "Publish","draft" => "Draft"),
		'std' => 'draft',
		'type' => 'select');
	
	$options[] = array(
		'name' => 'Choose post status for unlogged user only',
		'desc' => 'Choose post status after unlogged user publish the post.',
		'id' => 'post_publish_unlogged',
		'options' => array("publish" => "Publish","draft" => "Draft"),
		'std' => 'draft',
		'type' => 'select');
	
	$options[] = array(
		'name' => 'Send email when the post need a review',
		'desc' => 'Email for posts review enable or disable.',
		'id' => 'send_email_draft_posts',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Tags enable or disable in add post form',
		'desc' => 'Select ON to enable the tags in add post form.',
		'id' => 'tags_post',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Attachment in add post form',
		'desc' => 'Select ON to enable the attachment in add post form.',
		'id' => 'attachment_post',
		'std' => 1,
		'type' => 'checkbox');
	/*
	$options[] = array(
		'name' => 'Category in add post form',
		'desc' => 'Category in add post form enable or disable.',
		'id' => 'category_post',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Category in add post form is required',
		'desc' => 'Category in add post form is required.',
		'id' => 'category_post_required',
		'std' => 1,
		'type' => 'checkbox');
	*/
	$options[] = array(
		'name' => 'Details in add post form is required',
		'desc' => 'Details in add post form is required.',
		'id' => 'content_post',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Editor enable or disable for details in add post form',
		'desc' => 'Editor enable or disable for details in add post form.',
		'id' => 'editor_post_details',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Edit post setting.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => 'The users can edit the posts?',
		'desc' => 'The users can edit the posts?',
		'id' => 'can_edit_post',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Edit post page",
		'desc' => "Create a page using the Edit post template and select it here",
		'id' => 'edit_post',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => 'After edit post approved auto or need to approved again?',
		'desc' => 'Press ON to approved auto',
		'id' => 'post_approved',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'After edit post change the URL like the title?',
		'desc' => 'Press ON to edit the URL',
		'id' => 'change_post_url',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Delete post setting.',
		'class' => 'home_page_display',
		'type' => 'info');
	
	$options[] = array(
		'name' => 'Active user can delete the posts',
		'desc' => 'Select ON if you want the user can delete the posts.',
		'id' => 'post_delete',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Search setting',
		'icon' => 'search',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => "Search page",
		'desc' => "Create a page using the Search template and select it here",
		'id' => 'search_page',
		'type' => 'select',
		'options' => $options_pages);
	
	$options[] = array(
		'name' => "Default search",
		'desc' => "Choose what's the default search",
		'id' => 'default_search',
		'type' => 'select',
		'stc' => 'questions',
		'options' => array(
			"questions"           => "Questions",
			"answers"             => "Answers",
			ask_question_category => "Question categories",
			"question_tags"       => "Question tags",
			"posts"               => "Posts",
			"comments"            => "Comments",
			"category"            => "Post categories",
			"post_tag"            => "Post tags",
			"products"            => "Products",
			"product_cat"         => "Products categories",
			"product_tag"         => "Products tags",
			"users"               => "Users",
		));
	
	$options[] = array(
		'name'    => 'Select the search options',
		'desc'    => 'Select the search options on the search page.',
		'id'      => 'search_attrs',
		'type'    => 'multicheck_sort',
		'sort'    => 'yes',
		'std'     => array(
			"questions"           => array("sort" => "Questions","value" => "on"),
			"answers"             => array("sort" => "Answers","value" => "on"),
			ask_question_category => array("sort" => "Question categories","value" => "on"),
			"question_tags"       => array("sort" => "Question tags","value" => "on"),
			"posts"               => array("sort" => "Posts","value" => "on"),
			"comments"            => array("sort" => "Comments","value" => "on"),
			"category"            => array("sort" => "Post categories","value" => "on"),
			"post_tag"            => array("sort" => "Post tags","value" => "on"),
			"products"            => array("sort" => "Products","value" => "on"),
			"product_cat"         => array("sort" => "Products categories","value" => "on"),
			"product_tag"         => array("sort" => "Products tags","value" => "on"),
			"users"               => array("sort" => "Users","value" => "on"),
		),
		'options' => array(
			"questions"           => array("sort" => "Questions","value" => "on"),
			"answers"             => array("sort" => "Answers","value" => "on"),
			ask_question_category => array("sort" => "Question categories","value" => "on"),
			"question_tags"       => array("sort" => "Question tags","value" => "on"),
			"posts"               => array("sort" => "Posts","value" => "on"),
			"comments"            => array("sort" => "Comments","value" => "on"),
			"category"            => array("sort" => "Post categories","value" => "on"),
			"post_tag"            => array("sort" => "Post tags","value" => "on"),
			"products"            => array("sort" => "Products","value" => "on"),
			"product_cat"         => array("sort" => "Products categories","value" => "on"),
			"product_tag"         => array("sort" => "Products tags","value" => "on"),
			"users"               => array("sort" => "Users","value" => "on"),
		));
	
	$options[] = array(
		'name'  => "Choose the live search enable or disable",
		'desc'  => "Choose the live search enable or disable",
		'id'    => "live_search",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name' => 'Search result number',
		'desc' => 'Type the search result number from here.',
		'id' => 'search_result_number',
		'std' => '5',
		'type' => 'text');
	
	$options[] = array(
		'name'  => "Show search at users template",
		'desc'  => "Show search at users template from the breadcrumb",
		'id'    => "user_search",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name'  => "Show filter at users template",
		'desc'  => "Show filter at users template from the breadcrumb",
		'id'    => "user_filter",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name' => 'Show filter at categories and archive pages',
		'desc' => 'Click on to enable the filter at categories and archive pages.',
		'id'   => 'category_filter',
		'std'  => 1,
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => 'Show at the filter categories parent categories',
		'desc' => 'Click on to enable the filter categories parent categories and will show the child categires.',
		'id'   => 'child_category',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name'  => "Show search at category archives",
		'desc'  => "Show search at category archives from the breadcrumb",
		'id'    => "cat_archives_search",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name'  => "Show search at categories template",
		'desc'  => "Show search at categories template from the breadcrumb",
		'id'    => "cat_search",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name'  => "Show filter at categories template",
		'desc'  => "Show filter at categories template from the breadcrumb",
		'id'    => "cat_filter",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name'  => "Show search at tag archives",
		'desc'  => "Show search at tag archives from the breadcrumb",
		'id'    => "tag_archives_search",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name'  => "Show search at tags template",
		'desc'  => "Show search at tags template from the breadcrumb",
		'id'    => "tag_search",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'name'  => "Show filter at tags template",
		'desc'  => "Show filter at tags template from the breadcrumb",
		'id'    => "tag_filter",
		'type'  => 'checkbox',
		'std'   => 1,
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Sidebar',
		'icon' => 'align-none',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'id' => "sidebars",
		'std' => '',
		'type' => 'sidebar');
	
	$options[] = array(
		'name' => "Sidebar width",
		'desc' => "Sidebar width",
		'id' => 'sidebar_width',
		'std' => 'col-md-3',
		'type' => 'radio',
		'options' => 
			array(
				"col-md-3" => "1/4",
				"col-md-4" => "1/3"
			)
		);
	
	$options[] = array(
		'name' => "Sticky sidebar",
		'desc' => "Click on to active the sticky sidebar",
		'id' => 'sticky_sidebar',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Sidebar layout",
		'desc' => "Sidebar layout.",
		'id' => "sidebar_layout",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'right' => $imagepath.'sidebar_right.jpg',
			'full' => $imagepath.'sidebar_no.jpg',
			'left' => $imagepath.'sidebar_left.jpg',
		)
	);
	
	$options[] = array(
		'name' => "Home Page Sidebar",
		'desc' => "Home Page Sidebar.",
		'id' => "sidebar_home",
		'std' => '',
		'options' => $new_sidebars,
		'type' => 'select');
	
	$options[] = array(
		'name' => "Else home page, single and page",
		'desc' => "Else home page, single and page.",
		'id' => "else_sidebar",
		'std' => '',
		'options' => $new_sidebars,
		'type' => 'select');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Styling',
		'icon' => 'art',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => "Home page layout",
		'desc' => "Home page layout.",
		'id' => "home_layout",
		'std' => "full",
		'type' => "images",
		'options' => array(
			'full' => $imagepath.'full.jpg',
			'fixed' => $imagepath.'fixed.jpg',
			'fixed_2' => $imagepath.'fixed_2.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Choose template",
		'desc' => "Choose template layout.",
		'id' => "home_template",
		'std' => "grid_1200",
		'type' => "images",
		'options' => array(
			'grid_1300' => $imagepath.'template_1300.jpg',
			'grid_1200' => $imagepath.'template_1200.jpg',
			'grid_970' => $imagepath.'template_970.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Site skin",
		'desc' => "Choose Site skin.",
		'id' => "site_skin_l",
		'std' => "site_light",
		'type' => "images",
		'options' => array(
			'site_light' => $imagepath.'light.jpg',
			'site_dark' => $imagepath.'dark.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Choose Your Skin",
		'desc' => "Choose Your Skin",
		'class' => "site_skin",
		'id' => "site_skin",
		'std' => "skins",
		'type' => "images",
		'options' => array(
			'skins'		    => $imagepath.'skin.jpg',
			'blue'			=> $imagepath.'blue.jpg',
			'gray'			=> $imagepath.'gray.jpg',
			'green'			=> $imagepath.'green.jpg',
			'moderate_cyan' => $imagepath.'moderate_cyan.jpg',
			'orange'		=> $imagepath.'orange.jpg',
			'purple'	    => $imagepath.'purple.jpg',
			'red'			=> $imagepath.'red.jpg',
			'strong_cyan'	=> $imagepath.'strong_cyan.jpg',
			'yellow'		=> $imagepath.'yellow.jpg',
		)
	);
	
	$options[] = array(
		'name' => "Primary Color",
		'desc' => "Primary Color",
		'id' => 'primary_color',
		'type' => 'color');
	
	$options[] = array(
		'name' => "Background Type",
		'desc' => "Background Type",
		'id' => 'background_type',
		'std' => 'patterns',
		'type' => 'radio',
		'options' => 
			array(
				"patterns" => "Patterns",
				"custom_background" => "Custom Background"
			)
		);

	$options[] = array(
		'name' => "Background Color",
		'desc' => "Background Color",
		'id' => 'background_color',
		'std' => "#FFF",
		'type' => 'color');
		
	$options[] = array(
		'name' => "Choose Pattern",
		'desc' => "Choose Pattern",
		'id' => "background_pattern",
		'std' => "bg13",
		'type' => "images",
		'options' => array(
			'bg1' => $imagepath.'bg1.jpg',
			'bg2' => $imagepath.'bg2.jpg',
			'bg3' => $imagepath.'bg3.jpg',
			'bg4' => $imagepath.'bg4.jpg',
			'bg5' => $imagepath.'bg5.jpg',
			'bg6' => $imagepath.'bg6.jpg',
			'bg7' => $imagepath.'bg7.jpg',
			'bg8' => $imagepath.'bg8.jpg',
			'bg9' => $imagepath.'../../images/patterns/bg9.png',
			'bg10' => $imagepath.'../../images/patterns/bg10.png',
			'bg11' => $imagepath.'../../images/patterns/bg11.png',
			'bg12' => $imagepath.'../../images/patterns/bg12.png',
			'bg13' => $imagepath.'bg13.jpg',
			'bg14' => $imagepath.'bg14.jpg',
			'bg15' => $imagepath.'../../images/patterns/bg15.png',
			'bg16' => $imagepath.'../../images/patterns/bg16.png',
			'bg17' => $imagepath.'bg17.jpg',
			'bg18' => $imagepath.'bg18.jpg',
			'bg19' => $imagepath.'bg19.jpg',
			'bg20' => $imagepath.'bg20.jpg',
			'bg21' => $imagepath.'../../images/patterns/bg21.png',
			'bg22' => $imagepath.'bg22.jpg',
			'bg23' => $imagepath.'../../images/patterns/bg23.png',
			'bg24' => $imagepath.'../../images/patterns/bg24.png',
	));

	$options[] = array(
		'name' =>  "Custom Background",
		'desc' => "Custom Background",
		'id' => 'custom_background',
		'std' => $background_defaults,
		'type' => 'background');
		
	$options[] = array(
		'name' => "Full Screen Background",
		'desc' => "Click on to Full Screen Background",
		'id' => 'full_screen_background',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Questions Styling',
		'icon' => 'editor-help',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => "Custom Logo position - Header skin - Logo display?",
		'desc' => "Click on to make a Custom Logo position - Header skin - Logo display",
		'id' => 'questions_custom_header',
		'std' => '0',
		'type' => 'checkbox');
	
	if (is_rtl()) {
		$options[] = array(
			'name' => "Logo position for questions",
			'desc' => "Select where you would like your logo to appear for questions.",
			'id' => "questions_logo_position",
			'std' => "left_logo",
			'type' => "images",
			'options' => array(
				'left_logo' => $imagepath.'right_logo.jpg',
				'right_logo' => $imagepath.'left_logo.jpg',
				'center_logo' => $imagepath.'center_logo.jpg'
			)
		);
	}else {
		$options[] = array(
			'name' => "Logo position for questions",
			'desc' => "Select where you would like your logo to appear for questions.",
			'id' => "questions_logo_position",
			'std' => "left_logo",
			'type' => "images",
			'options' => array(
				'left_logo' => $imagepath.'left_logo.jpg',
				'right_logo' => $imagepath.'right_logo.jpg',
				'center_logo' => $imagepath.'center_logo.jpg'
			)
		);
	}
	
	$options[] = array(
		'name' => "Header skin for questions",
		'desc' => "Select your preferred header skin for questions.",
		'id' => "questions_header_skin",
		'std' => "header_dark",
		'type' => "images",
		'options' => array(
			'header_dark' => $imagepath.'left_logo.jpg',
			'header_light' => $imagepath.'header_light.jpg'
		)
	);
	
	$options[] = array(
		'name' => 'Logo display for questions',
		'desc' => 'choose Logo display for questions.',
		'id' => 'questions_logo_display',
		'std' => 'display_title',
		'type' => 'radio',
		'options' => array("display_title" => "Display site title","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Logo upload for questions',
		'desc' => 'Upload your custom logo for questions.',
		'id' => 'questions_logo_img',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Logo retina upload for questions',
		'desc' => 'Upload your custom logo retina for questions.',
		'id' => 'questions_retina_logo',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		"name" => "Logo height",
		"id" => "questions_logo_height",
		"type" => "sliderui",
		"step" => "1",
		"min" => "0",
		"max" => "300",
		'std' => '57');
	
	$options[] = array(
		"name" => "Logo width",
		"id" => "questions_logo_width",
		"type" => "sliderui",
		"step" => "1",
		"min" => "0",
		"max" => "300",
		'std' => '146');
	
	$options[] = array(
		'name' => "Questions sidebar layout",
		'desc' => "Questions sidebar layout.",
		'id' => "questions_sidebar_layout",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'right' => $imagepath.'sidebar_right.jpg',
			'full' => $imagepath.'sidebar_no.jpg',
			'left' => $imagepath.'sidebar_left.jpg',
		)
	);
	
	$options[] = array(
		'name' => "Questions Page Sidebar",
		'desc' => "Questions Page Sidebar.",
		'id' => "questions_sidebar",
		'std' => '',
		'options' => $new_sidebars,
		'type' => 'select');
	
	$options[] = array(
		'name' => "Questions page layout",
		'desc' => "Questions page layout.",
		'id' => "questions_layout",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'full' => $imagepath.'full.jpg',
			'fixed' => $imagepath.'fixed.jpg',
			'fixed_2' => $imagepath.'fixed_2.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Choose template",
		'desc' => "Choose template layout.",
		'id' => "questions_template",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'grid_1300' => $imagepath.'template_1300.jpg',
			'grid_1200' => $imagepath.'template_1200.jpg',
			'grid_970' => $imagepath.'template_970.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Site skin",
		'desc' => "Choose Site skin.",
		'id' => "questions_skin_l",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default' => $imagepath.'sidebar_default.jpg',
			'site_light' => $imagepath.'light.jpg',
			'site_dark' => $imagepath.'dark.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Choose Your Skin",
		'desc' => "Choose Your Skin",
		'class' => "site_skin",
		'id' => "questions_skin",
		'std' => "default",
		'type' => "images",
		'options' => array(
			'default'	    => $imagepath.'default.jpg',
			'skins'		    => $imagepath.'skin.jpg',
			'blue'			=> $imagepath.'blue.jpg',
			'gray'			=> $imagepath.'gray.jpg',
			'green'			=> $imagepath.'green.jpg',
			'moderate_cyan' => $imagepath.'moderate_cyan.jpg',
			'orange'		=> $imagepath.'orange.jpg',
			'purple'	    => $imagepath.'purple.jpg',
			'red'			=> $imagepath.'red.jpg',
			'strong_cyan'	=> $imagepath.'strong_cyan.jpg',
			'yellow'		=> $imagepath.'yellow.jpg',
		)
	);
	
	$options[] = array(
		'name' => "Primary Color",
		'desc' => "Primary Color",
		'id' => 'questions_primary_color',
		'type' => 'color');
	
	$options[] = array(
		'name' => "Background Type",
		'desc' => "Background Type",
		'id' => 'questions_background_type',
		'std' => 'patterns',
		'type' => 'radio',
		'options' => 
			array(
				"patterns" => "Patterns",
				"custom_background" => "Custom Background"
			)
	);

	$options[] = array(
		'name' => "Background Color",
		'desc' => "Background Color",
		'id' => 'questions_background_color',
		'std' => "#FFF",
		'type' => 'color');
		
	$options[] = array(
		'name' => "Choose Pattern",
		'desc' => "Choose Pattern",
		'id' => "questions_background_pattern",
		'std' => "bg13",
		'type' => "images",
		'options' => array(
			'bg1' => $imagepath.'bg1.jpg',
			'bg2' => $imagepath.'bg2.jpg',
			'bg3' => $imagepath.'bg3.jpg',
			'bg4' => $imagepath.'bg4.jpg',
			'bg5' => $imagepath.'bg5.jpg',
			'bg6' => $imagepath.'bg6.jpg',
			'bg7' => $imagepath.'bg7.jpg',
			'bg8' => $imagepath.'bg8.jpg',
			'bg9' => $imagepath.'../../images/patterns/bg9.png',
			'bg10' => $imagepath.'../../images/patterns/bg10.png',
			'bg11' => $imagepath.'../../images/patterns/bg11.png',
			'bg12' => $imagepath.'../../images/patterns/bg12.png',
			'bg13' => $imagepath.'bg13.jpg',
			'bg14' => $imagepath.'bg14.jpg',
			'bg15' => $imagepath.'../../images/patterns/bg15.png',
			'bg16' => $imagepath.'../../images/patterns/bg16.png',
			'bg17' => $imagepath.'bg17.jpg',
			'bg18' => $imagepath.'bg18.jpg',
			'bg19' => $imagepath.'bg19.jpg',
			'bg20' => $imagepath.'bg20.jpg',
			'bg21' => $imagepath.'../../images/patterns/bg21.png',
			'bg22' => $imagepath.'bg22.jpg',
			'bg23' => $imagepath.'../../images/patterns/bg23.png',
			'bg24' => $imagepath.'../../images/patterns/bg24.png',
	));

	$options[] = array(
		'name' =>  "Custom Background",
		'desc' => "Custom Background",
		'id' => 'questions_custom_background',
		'std' => $background_defaults,
		'type' => 'background');
		
	$options[] = array(
		'name' => "Full Screen Background",
		'desc' => "Click on to Full Screen Background",
		'id' => 'questions_full_screen_background',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	if (class_exists('woocommerce')) {
		$options[] = array(
			'name' => 'Products Setting',
			'icon' => 'admin-home',
			'type' => 'heading');
		
		$options[] = array(
			'type' => 'heading-2',
		);
		
		$options[] = array(
			'name' => "Custom Logo position - Header skin - Logo display?",
			'desc' => "Click on to make a Custom Logo position - Header skin - Logo display",
			'id' => 'products_custom_header',
			'std' => '0',
			'type' => 'checkbox');
		
		if (is_rtl()) {
			$options[] = array(
				'name' => "Logo position for products",
				'desc' => "Select where you would like your logo to appear for products.",
				'id' => "products_logo_position",
				'std' => "left_logo",
				'type' => "images",
				'options' => array(
					'left_logo' => $imagepath.'right_logo.jpg',
					'right_logo' => $imagepath.'left_logo.jpg',
					'center_logo' => $imagepath.'center_logo.jpg'
				)
			);
		}else {
			$options[] = array(
				'name' => "Logo position for products",
				'desc' => "Select where you would like your logo to appear for products.",
				'id' => "products_logo_position",
				'std' => "left_logo",
				'type' => "images",
				'options' => array(
					'left_logo' => $imagepath.'left_logo.jpg',
					'right_logo' => $imagepath.'right_logo.jpg',
					'center_logo' => $imagepath.'center_logo.jpg'
				)
			);
		}
		
		$options[] = array(
			'name' => "Header skin for products",
			'desc' => "Select your preferred header skin for products.",
			'id' => "products_header_skin",
			'std' => "header_dark",
			'type' => "images",
			'options' => array(
				'header_dark' => $imagepath.'left_logo.jpg',
				'header_light' => $imagepath.'header_light.jpg'
			)
		);
		
		$options[] = array(
			'name' => 'Logo display for products',
			'desc' => 'choose Logo display for products.',
			'id' => 'products_logo_display',
			'std' => 'display_title',
			'type' => 'radio',
			'options' => array("display_title" => "Display site title","custom_image" => "Custom Image"));
		
		$options[] = array(
			'name' => 'Logo upload for products',
			'desc' => 'Upload your custom logo for products.',
			'id' => 'products_logo_img',
			'std' => '',
			'type' => 'upload');
		
		$options[] = array(
			'name' => 'Logo retina upload for products',
			'desc' => 'Upload your custom logo retina for products.',
			'id' => 'products_retina_logo',
			'std' => '',
			'type' => 'upload');
		
		$options[] = array(
			"name" => "Logo height",
			"id" => "products_logo_height",
			"type" => "sliderui",
			"step" => "1",
			"min" => "0",
			"max" => "300",
			'std' => '57');
		
		$options[] = array(
			"name" => "Logo width",
			"id" => "products_logo_width",
			"type" => "sliderui",
			"step" => "1",
			"min" => "0",
			"max" => "300",
			'std' => '146');
		
		$options[] = array(
			'name' => 'Related products number',
			'desc' => 'Type related products number from here.',
			'id' => 'related_products_number',
			'std' => '3',
			'type' => 'text');
		
		$options[] = array(
			'name' => 'Related products number full width',
			'desc' => 'Type related products number full width from here.',
			'id' => 'related_products_number_full',
			'std' => '4',
			'type' => 'text');
		
		$options[] = array(
			'name' => 'Excerpt title in products pages',
			'desc' => 'Type excerpt title in products pages from here.',
			'id' => 'products_excerpt_title',
			'std' => '40',
			'type' => 'text');
		
		$options[] = array(
			'name' => "Products sidebar layout",
			'desc' => "Products sidebar layout.",
			'id' => "products_sidebar_layout",
			'std' => "default",
			'type' => "images",
			'options' => array(
				'default' => $imagepath.'sidebar_default.jpg',
				'right' => $imagepath.'sidebar_right.jpg',
				'full' => $imagepath.'sidebar_no.jpg',
				'left' => $imagepath.'sidebar_left.jpg',
			)
		);
		
		$options[] = array(
			'name' => "Products Page Sidebar",
			'desc' => "Products Page Sidebar.",
			'id' => "products_sidebar",
			'std' => '',
			'options' => $new_sidebars,
			'type' => 'select');
		
		$options[] = array(
			'name' => "Products page layout",
			'desc' => "Products page layout.",
			'id' => "products_layout",
			'std' => "default",
			'type' => "images",
			'options' => array(
				'default' => $imagepath.'sidebar_default.jpg',
				'full' => $imagepath.'full.jpg',
				'fixed' => $imagepath.'fixed.jpg',
				'fixed_2' => $imagepath.'fixed_2.jpg'
			)
		);
		
		$options[] = array(
			'name' => "Choose template",
			'desc' => "Choose template layout.",
			'id' => "products_template",
			'std' => "default",
			'type' => "images",
			'options' => array(
				'default' => $imagepath.'sidebar_default.jpg',
				'grid_1300' => $imagepath.'template_1300.jpg',
				'grid_1200' => $imagepath.'template_1200.jpg',
				'grid_970' => $imagepath.'template_970.jpg'
			)
		);
		
		$options[] = array(
			'name' => "Site skin",
			'desc' => "Choose Site skin.",
			'id' => "products_skin_l",
			'std' => "default",
			'type' => "images",
			'options' => array(
				'default' => $imagepath.'sidebar_default.jpg',
				'site_light' => $imagepath.'light.jpg',
				'site_dark' => $imagepath.'dark.jpg'
			)
		);
		
		$options[] = array(
			'name' => "Choose Your Skin",
			'desc' => "Choose Your Skin",
			'class' => "site_skin",
			'id' => "products_skin",
			'std' => "default",
			'type' => "images",
			'options' => array(
				'default'	    => $imagepath.'default.jpg',
				'skins'		    => $imagepath.'skin.jpg',
				'blue'			=> $imagepath.'blue.jpg',
				'gray'			=> $imagepath.'gray.jpg',
				'green'			=> $imagepath.'green.jpg',
				'moderate_cyan' => $imagepath.'moderate_cyan.jpg',
				'orange'		=> $imagepath.'orange.jpg',
				'purple'	    => $imagepath.'purple.jpg',
				'red'			=> $imagepath.'red.jpg',
				'strong_cyan'	=> $imagepath.'strong_cyan.jpg',
				'yellow'		=> $imagepath.'yellow.jpg',
			)
		);
		
		$options[] = array(
			'name' => "Primary Color",
			'desc' => "Primary Color",
			'id' => 'products_primary_color',
			'type' => 'color');
		
		$options[] = array(
			'name' => "Background Type",
			'desc' => "Background Type",
			'id' => 'products_background_type',
			'std' => 'patterns',
			'type' => 'radio',
			'options' => 
				array(
					"patterns" => "Patterns",
					"custom_background" => "Custom Background"
				)
		);
	
		$options[] = array(
			'name' => "Background Color",
			'desc' => "Background Color",
			'id' => 'products_background_color',
			'std' => "#FFF",
			'type' => 'color');
			
		$options[] = array(
			'name' => "Choose Pattern",
			'desc' => "Choose Pattern",
			'id' => "products_background_pattern",
			'std' => "bg13",
			'type' => "images",
			'options' => array(
				'bg1' => $imagepath.'bg1.jpg',
				'bg2' => $imagepath.'bg2.jpg',
				'bg3' => $imagepath.'bg3.jpg',
				'bg4' => $imagepath.'bg4.jpg',
				'bg5' => $imagepath.'bg5.jpg',
				'bg6' => $imagepath.'bg6.jpg',
				'bg7' => $imagepath.'bg7.jpg',
				'bg8' => $imagepath.'bg8.jpg',
				'bg9' => $imagepath.'../../images/patterns/bg9.png',
				'bg10' => $imagepath.'../../images/patterns/bg10.png',
				'bg11' => $imagepath.'../../images/patterns/bg11.png',
				'bg12' => $imagepath.'../../images/patterns/bg12.png',
				'bg13' => $imagepath.'bg13.jpg',
				'bg14' => $imagepath.'bg14.jpg',
				'bg15' => $imagepath.'../../images/patterns/bg15.png',
				'bg16' => $imagepath.'../../images/patterns/bg16.png',
				'bg17' => $imagepath.'bg17.jpg',
				'bg18' => $imagepath.'bg18.jpg',
				'bg19' => $imagepath.'bg19.jpg',
				'bg20' => $imagepath.'bg20.jpg',
				'bg21' => $imagepath.'../../images/patterns/bg21.png',
				'bg22' => $imagepath.'bg22.jpg',
				'bg23' => $imagepath.'../../images/patterns/bg23.png',
				'bg24' => $imagepath.'../../images/patterns/bg24.png',
		));
	
		$options[] = array(
			'name' =>  "Custom Background",
			'desc' => "Custom Background",
			'id' => 'products_custom_background',
			'std' => $background_defaults,
			'type' => 'background');
			
		$options[] = array(
			'name' => "Full Screen Background",
			'desc' => "Click on to Full Screen Background",
			'id' => 'products_full_screen_background',
			'std' => '0',
			'type' => 'checkbox');
		
		$options[] = array(
			'type' => 'heading-2',
			'end'  => 'end'
		);
	}
	
	$options[] = array(
		'name' => 'Advertising',
		'icon' => 'megaphone',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Advertising at 404 pages enable or disable',
		'desc' => 'Advertising at 404 pages enable or disable.',
		'id'   => 'adv_404',
		'std'  => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'name' => "Advertising after header"
	);
	
	$options[] = array(
		'name' => 'Advertising type',
		'desc' => 'Advertising type.',
		'id' => 'header_adv_type',
		'std' => 'custom_image',
		'type' => 'radio',
		'options' => array("display_code" => "Display code","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Image URL',
		'desc' => 'Upload a image, or enter URL to an image if it is already uploaded.',
		'id' => 'header_adv_img',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Advertising url',
		'desc' => 'Advertising url.',
		'id' => 'header_adv_href',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Advertising Code html (Ex: Google ads)",
		'desc' => "Advertising Code html (Ex: Google ads)",
		'id' => 'header_adv_code',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'name' => "Advertising 1 in post and question"
	);
	
	$options[] = array(
		'name' => 'Advertising type',
		'desc' => 'Advertising type.',
		'id' => 'share_adv_type',
		'std' => 'custom_image',
		'type' => 'radio',
		'options' => array("display_code" => "Display code","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Image URL',
		'desc' => 'Upload a image, or enter URL to an image if it is already uploaded.',
		'id' => 'share_adv_img',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Advertising url',
		'desc' => 'Advertising url.',
		'id' => 'share_adv_href',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Advertising Code html (Ex: Google ads)",
		'desc' => "Advertising Code html (Ex: Google ads)",
		'id' => 'share_adv_code',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'name' => "Advertising 2 in post and question"
	);
	
	$options[] = array(
		'name' => 'Advertising type',
		'desc' => 'Advertising type.',
		'id' => 'related_adv_type',
		'std' => 'custom_image',
		'type' => 'radio',
		'options' => array("display_code" => "Display code","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Image URL',
		'desc' => 'Upload a image, or enter URL to an image if it is already uploaded.',
		'id' => 'related_adv_img',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Advertising url',
		'desc' => 'Advertising url.',
		'id' => 'related_adv_href',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Advertising Code html (Ex: Google ads)",
		'desc' => "Advertising Code html (Ex: Google ads)",
		'id' => 'related_adv_code',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'name' => "Advertising after content"
	);
	
	$options[] = array(
		'name' => 'Advertising type',
		'desc' => 'Advertising type.',
		'id' => 'content_adv_type',
		'std' => 'custom_image',
		'type' => 'radio',
		'options' => array("display_code" => "Display code","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Image URL',
		'desc' => 'Upload a image, or enter URL to an image if it is already uploaded.',
		'id' => 'content_adv_img',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Advertising url',
		'desc' => 'Advertising url.',
		'id' => 'content_adv_href',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Advertising Code html (Ex: Google ads)",
		'desc' => "Advertising Code html (Ex: Google ads)",
		'id' => 'content_adv_code',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'name' => "Between questions and posts"
	);
	
	$options[] = array(
		'name' => 'Between questions or posts position',
		'desc' => 'Between questions or posts position.',
		'id' => 'between_questions_position',
		'std' => '2',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Advertising type',
		'desc' => 'Advertising type.',
		'id' => 'between_adv_type',
		'std' => 'custom_image',
		'type' => 'radio',
		'options' => array("display_code" => "Display code","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Image URL',
		'desc' => 'Upload a image, or enter URL to an image if it is already uploaded.',
		'id' => 'between_adv_img',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Advertising url',
		'desc' => 'Advertising url.',
		'id' => 'between_adv_href',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Advertising Code html (Ex: Google ads)",
		'desc' => "Advertising Code html (Ex: Google ads)",
		'id' => 'between_adv_code',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'name' => "Between comments and answers"
	);
	
	$options[] = array(
		'name' => 'Between comments and answers position',
		'desc' => 'Between comments and answers position.',
		'id' => 'between_comments_position',
		'std' => '2',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Advertising type',
		'desc' => 'Advertising type.',
		'id' => 'between_comments_adv_type',
		'std' => 'custom_image',
		'type' => 'radio',
		'options' => array("display_code" => "Display code","custom_image" => "Custom Image"));
	
	$options[] = array(
		'name' => 'Image URL',
		'desc' => 'Upload a image, or enter URL to an image if it is already uploaded.',
		'id' => 'between_comments_adv_img',
		'std' => '',
		'type' => 'upload');
	
	$options[] = array(
		'name' => 'Advertising url',
		'desc' => 'Advertising url.',
		'id' => 'between_comments_adv_href',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Advertising Code html (Ex: Google ads)",
		'desc' => "Advertising Code html (Ex: Google ads)",
		'id' => 'between_comments_adv_code',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Social settings',
		'icon' => 'share',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Social header enable or disable',
		'desc' => 'Social enable or disable.',
		'id' => 'social_icon_h',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Social footer enable or disable',
		'desc' => 'Social enable or disable.',
		'id' => 'social_icon_f',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'Twitter URL',
		'desc' => 'Type the twitter URL from here.',
		'id' => 'twitter_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Facebook URL',
		'desc' => 'Type the facebook URL from here.',
		'id' => 'facebook_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Google plus URL',
		'desc' => 'Type the google plus URL from here.',
		'id' => 'gplus_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Youtube URL',
		'desc' => 'Type the youtube URL from here.',
		'id' => 'youtube_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Skype',
		'desc' => 'Type the skype from here.',
		'id' => 'skype_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Linkedin URL',
		'desc' => 'Type the linkedin URL from here.',
		'id' => 'linkedin_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Flickr URL',
		'desc' => 'Type the flickr URL from here.',
		'id' => 'flickr_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Instagram URL',
		'desc' => 'Type the instagram URL from here.',
		'id' => 'instagram_icon_f',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'RSS enable or disable',
		'desc' => 'RSS enable or disable.',
		'id' => 'rss_icon_f',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => 'RSS URL if you want change the default URL',
		'desc' => 'Type the RSS URL if you want change the default URL or leave it empty for enable the default URL.',
		'id' => 'rss_icon_f_other',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Emails settings',
		'icon' => 'email',
		'type' => 'heading');
		
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => "Custom logo for email template",
		'desc' => "Upload your custom logo for email template",
		'id' => 'logo_email_template',
		'type' => 'upload');
		
	$options[] = array(
		'name' => 'Enable description',
		'desc' => 'Select ON to enable description.',
		'id' => 'description_email_template',
		'std' => 1,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "Add your email for email template",
		'desc' => "Add your email for email template",
		'id' => 'email_template',
		'std' => get_bloginfo("admin_email"),
		'type' => 'text'
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variables work at the all templates</h4>
		<p>[%blogname%] - The site title.</p>
		<p>[%site_url%] - The site URL.</p>
		<p>[%messages_url%] - The messages URL page.</p>',
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variables work at Reset password, Confirm email and Approve user</h4>
		<p>[%user_login%] - The user login name.</p>
		<p>[%user_name%] - The user name.</p>
		<p>[%user_nicename%] - The user nice name.</p>
		<p>[%display_name%] - The user display name.</p>
		<p>[%user_email%] - The user email.</p>
		<p>[%user_profile%] - The user profile URL.</p>',
	);
	
	$buttons = 'bold,|,italic,|,underline,|,link,unlink,|,bullist,numlist,qaimage,qacode';
	$wp_editor_settings = array(
		'wpautop'       => false,
		'textarea_rows' => 10,
		'quicktags' 	=> false,
		'media_buttons' => false,
		'tabindex' 		=> 5,
		'tinymce' 		=> array(
			'toolbar1'              => $buttons,
			'toolbar2'              => '',
			'toolbar3'              => '',
			'autoresize_min_height' => 300,
			'force_p_newlines'      => false,
			'statusbar'             => true,
			'force_br_newlines'     => false),
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variable work at Reset password and Confirm email</h4>
		<p>[%confirm_link_email%] - Confirm email for the user to reset the password at reset password template and at the confirm email template is confirm email to active the user.</p>',
	);
	
	$options[] = array(
		'name'     => 'Reset password title',
		'id'       => 'title_new_password',
		'std'      => "Reset your password",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Reset password template',
		'id'       => 'email_new_password',
		'std'      => "<p>Someone requested that the password be reset for the following account:</p><p>Username: [%display_name%].' ([%user_login%])</p><p>If this was a mistake, just ignore this email and nothing will happen.</p><p>To reset your password, visit the following address:</p><p><a href='[%confirm_link_email%]'>Click here to reset your password</a></p><p>If the link above does not work, Please use your browser to go to:</p>[%confirm_link_email%]",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variable work at this template only</h4>
		<p>[%reset_password%] - The user password.</p>',
	);
	
	$options[] = array(
		'name'     => 'Reset password 2 title',
		'id'       => 'title_new_password_2',
		'std'      => "Reset your password",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Reset password 2 template',
		'id'       => 'email_new_password_2',
		'std'      => "<p>You are : [%display_name%] ([%user_login%])</p><p>The New Password : [%reset_password%]</p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'Confirm email title',
		'id'       => 'title_confirm_link',
		'std'      => "Confirm account",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Confirm email template',
		'id'       => 'email_confirm_link',
		'std'      => "<p>Hi there</p><p>Your registration has been successful! To confirm your account, kindly click on 'Activate' below.</p><p><a href='[%confirm_link_email%]'>Activate</a></p><p>If the link above does not work, Please use your browser to go to:</p>[%confirm_link_email%]",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'Confirm email 2 title',
		'id'       => 'title_confirm_link_2',
		'std'      => "Confirm account",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Confirm email 2 template',
		'id'       => 'email_confirm_link_2',
		'std'      => "<p>Hi there</p><p>This is the link to activate your membership</p><p><a href='[%confirm_link_email%]'>Activate</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'Approve user title',
		'id'       => 'title_approve_user',
		'std'      => "Confirm account",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Approve user template',
		'id'       => 'email_approve_user',
		'std'      => "<p>Hi there</p><p>We just approved your member.</p><p><a href='[%site_url%]'>[%blogname%]</a></p><p>[%site_url%]</p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variable work at this template only</h4>
		<p>[%messages_title%] - Show the message title.</p>',
	);
	
	$options[] = array(
		'name'     => 'Send message title',
		'id'       => 'title_new_message',
		'std'      => "New message",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Send message template',
		'id'       => 'email_new_message',
		'std'      => "<p>Hi there</p><p>There are a new message</p><p><a href='[%messages_url%]'>[%messages_title%]</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variables work at this template only</h4>
		<p>[%item_price%] - Show the item price.</p>
		<p>[%item_currency%] - Show the item currency.</p>
		<p>[%payer_email%] - Show the payer email.</p>
		<p>[%first_name%] - Show the payer first name.</p>
		<p>[%last_name%] - Show the payer last name.</p>
		<p>[%item_transaction%] - Show the transaction id.</p>
		<p>[%date%] - Show the payment date.</p>
		<p>[%time%] - Show the payment time.</p>',
	);
	
	$options[] = array(
		'name'     => 'New payment title',
		'id'       => 'title_new_payment',
		'std'      => "Instant Payment Notification - Received Payment",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'New payment template',
		'id'       => 'email_new_payment',
		'std'      => "<p>An instant payment notification was successfully recieved</p><p>With [%item_price%] [%item_currency%]</p><p>From [%payer_email%] [%first_name%] - [%last_name%] on [%date%] at [%time%]</p><p>The item transaction id [%item_transaction%]</p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variables work at all next 7 templates</h4>
		<p>[%post_title%] - Show the post title.</p>
		<p>[%post_link%] - Show the post link.</p>
		<p>[%the_author_post%] - Show the post author.</p>',
	);
	
	$options[] = array(
		'type'    => 'content',
		'content' => '<h4>Variables work at Report answer, Notified answer and Follow question</h4>
		<p>[%answer_link%] - Show the answer link.</p>
		<p>[%the_name%] - Show the answer author.</p>',
	);
	
	$options[] = array(
		'name'     => 'Report question title',
		'id'       => 'title_report_question',
		'std'      => "Question report",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Report question template',
		'id'       => 'email_report_question',
		'std'      => "<p>Hi there</p><p>Abuse have been reported on the use of the following question</p><p><a href='[%post_link%]'>[%post_title%]</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'Report answer title',
		'id'       => 'title_report_answer',
		'std'      => "Answer report",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Report answer template',
		'id'       => 'email_report_answer',
		'std'      => "<p>Hi there</p><p>Abuse have been reported on the use of the following comment</p><p><a href='[%answer_link%]'>[%post_title%]</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'Notified answer title',
		'id'       => 'title_notified_answer',
		'std'      => "Answer to your question",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Notified answer template',
		'id'       => 'email_notified_answer',
		'std'      => "<p>Hi there</p><p>We would tell you [%the_author_post%] That the new post was added on a common theme by [%the_name%] Entitled [%the_name%] [%post_title%]</p><p>Click on the link below to go to the topic</p><p><a href='[%answer_link%]'>[%post_title%]</a></p><p>There may be more of Posts and we hope the answer to encourage members and get them to help.</p><p>Accept from us Sincerely</p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'Follow question title',
		'id'       => 'title_follow_question',
		'std'      => "Hi there",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'Follow question template',
		'id'       => 'email_follow_question',
		'std'      => "<p>Hi there</p><p>There are a new answers on your follow question</p><p><a href='[%answer_link%]'>[%post_title%]</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'New questions title',
		'id'       => 'title_new_questions',
		'std'      => "New question",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'New questions template',
		'id'       => 'email_new_questions',
		'std'      => "<p>Hi there</p><p>There are a new question</p><p><a href='[%post_link%]'>[%post_title%]</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'New questions for review title',
		'id'       => 'title_new_draft_questions',
		'std'      => "New question for review",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'New questions for review template',
		'id'       => 'email_draft_questions',
		'std'      => "<p>Hi there</p><p>There are a new question for the review</p><p><a href='[%post_link%]'>[%post_title%]</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'name'     => 'New posts for review title',
		'id'       => 'title_new_draft_posts',
		'std'      => "New post for review",
		'type'     => 'text'
	);
	
	$options[] = array(
		'name'     => 'New posts for review template',
		'id'       => 'email_draft_posts',
		'std'      => "<p>Hi there</p><p>There are a new post for the review</p><p><a href='[%post_link%]'>[%post_title%]</a></p>",
		'type'     => 'editor',
		'settings' => $wp_editor_settings
	);
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => 'Footer settings',
		'icon' => 'tagcloud',
		'type' => 'heading');
		
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => "Footer skin",
		'desc' => "Choose the footer skin.",
		'id' => "footer_skin",
		'std' => "footer_dark",
		'type' => "images",
		'options' => array(
			'footer_dark' => $imagepath.'footer_dark.jpg',
			'footer_light' => $imagepath.'footer_light.jpg'
		)
	);
	
	$options[] = array(
		'name' => "Footer Layout",
		'desc' => "Footer columns Layout.",
		'id' => "footer_layout",
		'std' => "footer_4c",
		'type' => "images",
		'options' => array(
			'footer_1c' => $imagepath.'footer_1c.jpg',
			'footer_2c' => $imagepath.'2c.jpg',
			'footer_3c' => $imagepath.'footer_3c.jpg',
			'footer_4c' => $imagepath.'footer_4c.jpg',
			'footer_5c' => $imagepath.'footer_5c.jpg',
			'footer_no' => $imagepath.'footer_no.jpg'
		)
	);
	
	$options[] = array(
		'name' => 'Copyrights',
		'desc' => 'Put the copyrights of footer.',
		'id' => 'footer_copyrights',
		'std' => 'Copyright 2018 Ask me | <a href=https://2code.info/>By 2code</a>',
		'type' => 'textarea');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	$options[] = array(
		'name' => "Advanced",
		'id'   => "advanced",
		'icon' => 'upload',
		'type' => 'heading');
	
	$options[] = array(
		'type' => 'heading-2',
	);
	
	$options[] = array(
		'name' => 'Ajax file load from admin or theme',
		'desc' => 'choose ajax file load from admin or theme.',
		'id' => 'ajax_file',
		'std' => 'admin',
		'type' => 'select',
		'options' => array("admin" => "Admin","theme" => "Theme"));
	
	$options[] = array(
		'name' => 'Google API (Get it from here : https://developers.google.com/+/api/oauth)',
		'desc' => 'Type here the Google API.',
		'id' => 'google_api',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Facebook access token  (Creat https://developers.facebook.com/apps & Get it from here : https://developers.facebook.com/tools/access_token)',
		'desc' => 'Facebook access token.',
		'id' => 'facebook_access_token',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Twitter consumer key',
		'desc' => 'Twitter consumer key.',
		'id' => 'twitter_consumer_key',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Twitter consumer secret',
		'desc' => 'Twitter consumer secret.',
		'id' => 'twitter_consumer_secret',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => 'Click ON to create all theme pages (26 pages)',
		'desc' => 'Click ON to create all theme pages (26 pages)',
		'id' => 'theme_pages',
		'std' => 0,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => "If you wont to export setting please refresh the page before that",
		'type' => 'info');

	$options[] = array(
		'name' => "Export Setting",
		'desc' => "Copy this to saved file",
		'id' => 'export_setting',
		'export' => $current_options_e,
		'type' => 'export');

	$options[] = array(
		'name' => "Import Setting",
		'desc' => "Put here the import setting",
		'id' => 'import_setting',
		'type' => 'import');
	
	$options[] = array(
		'type' => 'heading-2',
		'end'  => 'end'
	);
	
	return $options;
}