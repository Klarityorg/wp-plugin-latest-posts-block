<?php

if (!defined('ABSPATH')) {
    exit;
}

function klarity_latest_posts_block_assets() {
    wp_enqueue_style(
        'klarity_latest_posts_block-cgb-style-css',
        plugins_url('dist/blocks.style.build.css', __DIR__),
        ['wp-editor'],
        filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' )
    );
}

add_action('enqueue_block_assets', 'klarity_latest_posts_block_assets');

function klarity_latest_posts_block_editor_assets() {
    wp_enqueue_script(
        'klarity_latest_posts_block-js',
        plugins_url('/dist/blocks.build.js', __DIR__),
        ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'],
        filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' )
    );

    wp_enqueue_style(
        'klarity_latest_posts_block-editor-css', // Handle.
        plugins_url('dist/blocks.editor.build.css', __DIR__),
        ['wp-edit-blocks'],
        filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
    );
}

add_action('enqueue_block_editor_assets', 'klarity_latest_posts_block_editor_assets');

register_block_type('klarity/klarity-latest-posts-block', [
    'render_callback' => 'render_klarity_latest_posts',
    'attributes' => [
        'numberOfPosts' => [
            'type' => 'string',
            'default' => '',
        ]
    ]
]);

function render_klarity_latest_posts( $attributes ) {
  $numberOfPosts = $attributes['numberOfPosts'] ?? '';
  $childpages = array_slice ( array_merge(get_posts()) , 0, $numberOfPosts) ;

  if (count($childpages) > 0) {
    return '<div class="latest-posts">'
      .implode(
        '',
        array_map(function($post) {
          $content = wp_trim_words($post->post_content, $num_words = 100 );
          $formated_date = get_the_date( 'j F Y', $post);
          preg_match('/videoThumbnail":"(.+)"/', $post->post_content, $matches);
          $image = $matches[1] ?? wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail')[0] ?? '';
          $imageTag = $image === '' ? '' : "<img src='$image' />";

          return '<div class="latest-post-container">
            <a href="'.get_permalink($post).'">
              <div class="post">
                <div class="post-thumbnail">
                  '.$imageTag.'
                </div>
                <div class="post-content">
                  <div class="left-align">
                      <p class="meta-data">Created '.$formated_date.' - '.get_the_author_meta('display_name',$post->post_author).'</p>
                    </div>
                  <h3 class="left-align">'.$post->post_title.'</h3>
                  <p>'.$content.'</p>
                  <div class="action">
                    <p>Read more</p>
                  </div>
                </div>
              </div>
            </a>
            </div>';
          }, $childpages))
    .'</div>';
  }
	return 'No posts to display! You either need to add a post or set number of post to a higher number then 0!';
}
