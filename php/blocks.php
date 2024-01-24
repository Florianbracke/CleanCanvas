<?php
/*--------------------------------------------------------------------------------------*\
| ADD BLOCKS
\*--------------------------------------------------------------------------------------*/
function my_acf_init_block_types() {
    if( function_exists('acf_register_block_type') ) {

        acf_register_block_type( array(
            'name'              => "faq",
            'title'             => "Faq",
            'description'       => "Faq",
            'render_template'   => "assets/blocks/faq.php",
            'category'          => '...',
            'mode'	            => 'edit',
            'icon'              => 'admin-comments',
            'keywords'          => array( "FAQ" ),
        ));

    }
}
add_action('acf/init', 'my_acf_init_block_types');
