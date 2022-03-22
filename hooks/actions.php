<?php
#
#   Actions
#
add_action('init', function(){
    global $wp,$wp_rewrite;
    
    $wp->add_query_var('studentID');
    
    $wp->add_query_var('orgID');

    add_rewrite_rule(
        '^student/([^/]*)/?$',
        'index.php?pagename=student&studentID=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^organisation/([^/]*)/?$',
        'index.php?pagename=organisation&orgID=$matches[1]',
        'top'
    );

    $wp_rewrite->flush_rules();
});


// if(get_query_var('studentID'))
// add_action('wp', function(){
//     dd(
//         get_query_var('studentID')
//     );
// });
