<?php /* Template Name: Recently Answered  */
get_header();
	$rows_per_page  = get_option("posts_per_page");
	$paged          = (get_query_var("paged") != ""?(int)get_query_var("paged"):(get_query_var("page") != ""?(int)get_query_var("page"):1));
	$offset		    = ($paged-1)*$rows_per_page;
	$comments	    = get_comments(array("post_type" => "question","status" => "approve","meta_query" => array(array("key" => "answer_question_user","compare" => "NOT EXISTS"))));
	$query		    = get_comments(array("offset" => $offset,"post_type" => "question","status" => "approve","number" => $rows_per_page,"meta_query" => array(array("key" => "answer_question_user","compare" => "NOT EXISTS"))));
	$total_comments = count($comments);
	$total_query    = count($query);
	$total_pages    = (int)ceil($total_comments/$rows_per_page);
	if ($query) {?>
		<div id="commentlist" class="page-content">
			<ol class="commentlist clearfix">
				<?php $k = 0;
				foreach ($query as $comment) {
					$k++;
					$comment_vote = get_comment_meta($comment->comment_ID,'comment_vote',true);
					$comment_vote = (!empty($comment_vote)?$comment_vote:0);
					if ($comment->user_id != 0){
						$user_login_id_l = get_user_by("id",$comment->user_id);
					}
					$yes_private = ask_private($comment->comment_post_ID,get_post($comment->comment_post_ID)->post_author,get_current_user_id());
					if ($yes_private == 1) {
						$answer_type = "answer";
						include("includes/answers.php");
					}else {?>
						<li class="comment"><div class="comment-body clearfix"><?php _e("Sorry it a private answer.","vbegy");?></div></li>
					<?php }
				}?>
			</ol>
		</div>
		<?php if ($total_comments > $total_query) {
			echo '<div class="pagination">';
			$current_page = max(1,$paged);
			echo paginate_links(array(
				'base' => @esc_url(add_query_arg('page','%#%')),
				'format' => 'page/%#%/',
				'current' => $current_page,
				'show_all' => false,
				'total' => $total_pages,
				'prev_text' => '<i class="icon-angle-left"></i>',
				'next_text' => '<i class="icon-angle-right"></i>',
			));
			echo '</div><div class="clearfix"></div>';
		}
	}else {?>
		<div class="error_404">
			<div>
				<h2><?php _e("No answers","vbegy")?></h2>
				<h3><?php _e("No answers yet .","vbegy")?></h3>
			</div>
			<div class="clearfix"></div><br>
			<a href="<?php echo esc_url(home_url('/'));?>" class="button large color margin_0"><?php _e("Home Page","vbegy")?></a>
		</div>
	<?php }
get_footer();?>