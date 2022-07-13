<?php
/*
 * Register sidebars
 */
function register_ai_child_starter_theme_sidebars() {
	
	register_sidebar(array( 
	   'name' => 'MC Logo',
	   'id'=>'mc-logo',
	   'before_widget' => '',
	   'after_widget' => '',
	   'before_title' => '',
	   'after_title' => ''
    ));

    register_sidebar(array( 
        'name' => 'MC Homepage Slider',
        'id'=>'mc-homepage-slider',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

    register_sidebar(array( 
        'name' => 'MC Topfold Content',
        'id'=>'mc-topfold-content',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Featured Properties',
        'id'=>'mc-featured-properties',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Welcome Section',
        'id'=>'mc-welcome-section',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Team Section',
        'id'=>'mc-team-section',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Work With Us Section',
        'id'=>'mc-work-with-us',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Testimonial Section',
        'id'=>'mc-testimonial',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC CTA Section',
        'id'=>'mc-cta',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Sold Properties',
        'id'=>'mc-sold',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Communities',
        'id'=>'mc-communities',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Social Media Section',
        'id'=>'mc-social-media',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Contact Form Section',
        'id'=>'mc-social-media',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));
    
     register_sidebar(array( 
        'name' => 'MC Footer Section',
        'id'=>'mc-footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));

     register_sidebar(array( 
        'name' => 'MC Floating SMI',
        'id'=>'mc-floating-smi',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
     ));
}