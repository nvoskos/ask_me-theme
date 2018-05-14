<?php if (isset($sticky_posts) && is_array($sticky_posts) && !empty($sticky_posts) && $paged == 1) {
	if (isset($custom_args) && is_array($custom_args) && !empty($custom_args)) {
		$custom_args = $custom_args;
	}else {
		$custom_args = array();
	}
	$args = array_merge($custom_args,array("nopaging" => true,"post_type" => "question","post__in" => $sticky_posts,
		"meta_query" => array(
			'relation' => 'OR',
			array(
				'relation' => 'AND',
				array("key" => "sticky","compare" => "=","value" => 1),
				array("key" => "start_sticky_time","compare" => "NOT EXISTS"),
				array("key" => "end_sticky_time","compare" => "NOT EXISTS")
			),
			array(
				'relation' => 'AND',
				array("key" => "sticky","compare" => "=","value" => 1),
				array("key" => "end_sticky_time","type" => "NUMERIC","compare" => ">=","value" => strtotime(date("Y-m-d")))
			)
		)
	));
	query_posts($args);
	global $blog_style,$authordata,$question_bump_template,$question_vote_template,$k;
	if (!isset($k)) {
		$k = 0;
	}
	if (have_posts() ) :
		//do_action("askme_before_question_loop_if");
		while (have_posts() ) : the_post();
			$k++;
			//do_action("askme_before_question_loop");
			include ("question.php");
			//do_action("askme_after_question_loop");
		endwhile;
		$is_questions_sticky = true;
		//do_action("askme_after_question_loop_if");
	endif;
	wp_reset_query();
}?>