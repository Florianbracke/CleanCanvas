<?php

/*--------------------------------------------------------------------------------------*\
| FUNCTION REUSABLE BLOCKS TO FRONTEND
\*--------------------------------------------------------------------------------------*/
function get_reusable_block($block_id) {
	$reuse_block = get_post($block_id);
	if ($reuse_block == null) return '';
	$reuse_block_content = apply_filters('the_content', $reuse_block->post_content);
	return $reuse_block_content;
}


