<?php
#
#   Actions
#
add_action('init', function(){
    global $wp,$wp_rewrite;
    $wp->add_query_var('studentID');   
    add_rewrite_rule(
        '^student/([^/]*)/?$',
        'index.php?pagename=student&studentID=$matches[1]',
        'top'
    );
    $wp_rewrite->flush_rules();
});


if(get_query_var('studentID'))
add_action('wp', function(){
    dd(
        get_query_var('studentID')
    );
});
