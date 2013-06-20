<?php
/*
 Plugin Name: Debug Bar Template Trace
 Plugin URI: https://github.com/Clorith/wordpress-debug-bar-template-trace/
 Description: Adds a template trace panel to the Debug Bar. Requires the Debug Bar plugin.
 Author: Clorith
 Version: 0.1.2
 Author URI: http://www.mrstk.net
 */


add_action('debug_bar_panels', 'debug_bar_template_trace_panel');

function debug_bar_template_trace_panel( $panels ) {
    require_once 'class-debug-bar-template-trace.php';
    $panels[] = new Debug_Bar_Template_Trace();
    return $panels;
}
