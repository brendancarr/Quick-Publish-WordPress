<?php
/*
Plugin Name: @Infinus Quick Publish
Description: Adds a quick publish action to draft posts in the admin list table.
Version: 1.1
Author: Infinus
*/

// Add custom action link to post row actions
add_filter('post_row_actions', 'add_quick_publish_action', 10, 2);
function add_quick_publish_action($actions, $post) {
    if ($post->post_status == 'draft') {
        $current_url = add_query_arg(array());
        $publish_url = wp_nonce_url(
            add_query_arg(
                array(
                    'action' => 'quick_publish',
                    'post_id' => $post->ID,
                    'redirect_to' => urlencode($current_url)
                ),
                admin_url('admin-ajax.php')
            ),
            'quick-publish-' . $post->ID
        );
        $actions['quick_publish'] = '<a href="' . esc_url($publish_url) . '" class="quick-publish">Quick Publish</a>';
    }
    return $actions;
}

// Handle the AJAX request to publish the post
add_action('wp_ajax_quick_publish', 'handle_quick_publish');
function handle_quick_publish() {
    if (!current_user_can('publish_posts')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

    if (!$post_id) {
        wp_die(__('No post ID provided.'));
    }

    check_admin_referer('quick-publish-' . $post_id);

    $post = array(
        'ID' => $post_id,
        'post_status' => 'publish'
    );

    wp_update_post($post);

    $redirect_to = isset($_GET['redirect_to']) ? urldecode($_GET['redirect_to']) : admin_url('edit.php');
    wp_redirect($redirect_to);
    exit;
}

// Add custom CSS to style the Quick Publish link
add_action('admin_head', 'quick_publish_css');
function quick_publish_css() {
    echo '<style>
        .quick-publish { color: #0073aa; }
        .quick-publish:hover { color: #00a0d2; }
    </style>';
}