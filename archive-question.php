<?php get_header();
	global $vbegy_sidebar_all;
	$paged         = (get_query_var("paged") != ""?(int)get_query_var("paged"):(get_query_var("page") != ""?(int)get_query_var("page"):1));
	$sticky_posts  = get_option('sticky_posts');
	$active_sticky = true;
	include("sticky-question.php");
	
	$custom_args = (isset($custom_args) && is_array($custom_args)?$custom_args:array());
	$user_id_query = array("key" => "user_id","compare" => "NOT EXISTS");
	$sticky_query = array(
		'relation' => 'OR',
		array(
			'relation' => 'AND',
			array("key" => "sticky","compare" => "NOT EXISTS"),
			array("key" => "start_sticky_time","compare" => "NOT EXISTS"),
			array("key" => "end_sticky_time","compare" => "NOT EXISTS")
		),
		array(
			'relation' => 'AND',
			array("key" => "sticky","compare" => "=","value" => 1),
			array("key" => "end_sticky_time","type" => "NUMERIC","compare" => "<","value" => strtotime(date("Y-m-d")))
		)
	);
	$meta_query = array_merge((is_array($sticky_posts) && !empty($sticky_posts)?array('relation' => 'AND'):array()),array($user_id_query),(is_array($sticky_posts) && !empty($sticky_posts)?array($sticky_query):array()));
	$args = array_merge($custom_args,array("paged" => $paged,"post_type" => "question","meta_query" => array($meta_query)));
	query_posts($args);
	$active_sticky = false;
	get_template_part("loop-question","archive");
	vpanel_pagination();
	wp_reset_query();
get_footer();?>