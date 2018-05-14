<?php get_header();
	$vbegy_sidebar_all = vpanel_options("sidebar_layout");
	$tag_description   = tag_description();
	$tax_slug          = get_term_by('slug',get_query_var('term'),esc_attr(get_query_var('taxonomy')));
	$paged             = (get_query_var("paged") != ""?(int)get_query_var("paged"):(get_query_var("page") != ""?(int)get_query_var("page"):1));
	$sticky_posts      = get_option('sticky_posts');
	$active_sticky     = true;
	if (!empty($tag_description)) {?>
		<article class="post clearfix">
			<div class="post-inner">
		        <h2 class="post-title"><?php echo esc_html__("Tag","vbegy")." : ".esc_attr(single_tag_title("", false));?></a></h2>
		        <div class="post-content">
		            <?php echo $tag_description?>
		        </div><!-- End post-content -->
		    </div><!-- End post-inner -->
		</article><!-- End article.post -->
	<?php }
	$custom_args = array('tax_query' => array(array('taxonomy' => 'question_tags','field' => 'slug','terms' => $tax_slug->slug)));
	include("sticky-question.php");
	
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
	$args = array_merge($custom_args,array("paged" => $paged,"meta_query" => array($meta_query)));
	query_posts($args);
	$active_sticky = false;
	get_template_part("loop-question","category");
	vpanel_pagination();
get_footer();?>