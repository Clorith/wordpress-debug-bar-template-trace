<?php

class Debug_Bar_Template_Trace extends Debug_Bar_Panel {
	function init() {
		$this->title( __('Template Trace', 'debug-bar') );
		add_action('load_template', array( $this, 'log_template_load' ) );
		add_action('template_include', array( $this, 'log_template_load' ) );
		$this->check_if_wp_was_upgraded();
		add_action('admin_init', array( $this, 'example_nag_ignore') );
	}

	function log_template_load( $template ) {
		$this->templates[] = $template;
		return $template;
	}

	function prerender() {

	}

	function render() {
		echo "<div id='template-trace'>";
		echo "<h3>Template Trace</h3>";
		if ( isset( $this->templates ) ) {
			foreach($this->templates as $template) :
				echo str_replace( ABSPATH, "", $template ) . "<BR>";
			endforeach;
		}
		else
			echo "No templates loaded.";
		
		echo "</div>";

	}

	function check_if_wp_was_upgraded() {
		global $wp_version;
		$last_updated_core_on_version = get_option('debug-bar-template-trace-last-updated-core-on-version');
		
		if ( ! $last_updated_core_on_version || version_compare( $wp_version, $last_updated_core_on_version, ">" ) ) {
			$added_filter = $this->maybe_insert_filter_into_load_template();

			if ( $added_filter ) {
				update_option('debug-bar-template-trace-last-updated-core-on-version', $wp_version);
			}
		}

	}

	function maybe_insert_filter_into_load_template() {
		ob_start();
		$handle = fopen( ABSPATH . WPINC . "/theme.php", "r+");
		ob_end_clean();
		if ( ! $handle ) {
			add_action('admin_notices', array( $this, 'add_admin_notice') );
			return false;
		}
		$source = fread( $handle, 100000);

		$string_to_insert = "\$_template_file = apply_filters('load_template', \$_template_file );";
		$string_to_insert_before = "if ( \$require_once )";

		if ( $s = strpos($source, $string_to_insert) )
			return true;
		else {
			$source = str_replace($string_to_insert_before, $string_to_insert . "\n\n\t" . $string_to_insert_before, $source );
		}
		rewind($handle);
		$success = fwrite($handle, $source);
		return $success;
	}
	/* Display a notice that can be dismissed */

	function add_admin_notice() {
	    global $current_user, $wp_version;
        $user_id = $current_user->ID;
      
        if ( current_user_can( 'administrator' ) 
        	&& 
        	! get_user_meta($user_id, 'debug_template_trace_ignore_nag-' . $wp_version)
        	) {
        	echo '<div class="updated"><p>';
	        printf(__('The file wp-includes/theme.php is not writeable. You will need to manually edit it to use WP Debug Bar Template Trace. Add this line in the load_template() function, in wp-includes/theme.php around line 1108:<BR>
	        	<PRE>$_template_file = apply_filters(\'load_template\', $_template_file );</PRE><a href="%1$s">Hide Notice</a>'), '?debug_template_trace_ignore_nag=yes');
	        echo "</p></div>";
        }
        	
	        /* Check that the user hasn't already clicked to ignore the message */
	    if ( ! get_user_meta($user_id, 'example_ignore_notice') ) {
	        
	    }
	}

	function example_nag_ignore() {
	    global $current_user, $wp_version;
	        $user_id = $current_user->ID;
	        /* If user clicks to ignore the notice, add that to their user meta */
	        if ( isset($_GET['debug_template_trace_ignore_nag']) && 'yes' == $_GET['debug_template_trace_ignore_nag'] ) {
	             add_user_meta($user_id, 'debug_template_trace_ignore_nag-' . $wp_version, 'true', true);
	    }
	}
}

?>
