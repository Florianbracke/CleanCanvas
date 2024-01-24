<?php

/*--------------------------------------------------------------------------------------*\
|  REUSABLE BLOCK ID
\*--------------------------------------------------------------------------------------*/
add_action('add_meta_boxes', 'add_block_id_meta_box');

function add_block_id_meta_box() {
    add_meta_box(
        'block_id_meta_box', // unieke ID voor de meta-box
        'Block ID', // titel van de meta-box
        'display_block_id_meta_box', // callback functie om de inhoud van de meta-box weer te geven
        'wp_block', // post type waarop de meta-box moet worden weergegeven
        'side', // positie van de meta-box (bijv. 'normal', 'advanced', of 'side')
        'high' // prioriteit van de meta-box (bijv. 'high', 'core', 'default' of 'low')
    );
}

function display_block_id_meta_box($post) {
    $block_id = $post->ID;
    echo "Block ID: $block_id";
}

// Voeg de kolom toe aan de blokentabel
add_filter('manage_wp_block_posts_columns', 'add_block_id_column');

function add_block_id_column($columns) {
    $columns['block_id'] = 'Block ID';
    return $columns;
}

// Toon de blok-ID in de nieuwe kolom
add_action('manage_wp_block_posts_custom_column', 'display_block_id_column', 10, 2);

function display_block_id_column($column, $post_id) {
    if ($column === 'block_id') {
        echo $post_id;
    }
}
