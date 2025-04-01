<?php

function reading_time($post_id) {
	$post = get_post($post_id);
	$content = $post->post_content;
	$word_count = str_word_count( strip_tags( $content ) );
	$readingtime = ceil($word_count / 200);
	$totalreadingtime = $readingtime > 1 ? $readingtime . ' Minutes' : '1 Minute';

	return $totalreadingtime;
}
