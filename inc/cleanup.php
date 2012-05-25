<?php

//Remove the Toolbar from the front end
show_admin_bar(false);

// clean wordpress head section
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Remove recent comments widget css style
function cosmos_remove_recent_comments_style() {
  global $wp_widget_factory;

  if ( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}
add_action('widgets_init', 'cosmos_remove_recent_comments_style');

// URL rewrite of search results page
function search_url_rewrite_rule() {
  if ( is_search() && !empty($_GET['s']) ) {
    wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
    exit();
  }	
}
add_action('template_redirect', 'search_url_rewrite_rule');

function roots_nice_search_redirect() {
  if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {
    wp_redirect(home_url('/search/' . str_replace(array(' ', '%20'), array('+', '+'), urlencode(get_query_var('s')))), 301);
    exit();
  }
}
add_action('template_redirect', 'roots_nice_search_redirect');