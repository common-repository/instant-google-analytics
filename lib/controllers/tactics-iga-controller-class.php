<?php
 
/**
 * The main plugin controller
 *
 */
class tacticsIgaController
{
    /**
     * the class constructor
     *
     */
    public function __construct()
    {
		if ( !is_admin() ) {
			//Front-end
			add_action( 'wp', array( $this, 'init' ) );
		} elseif ( is_admin() )
		{
			//Back-end
			add_action( 'admin_menu', array( $this, 'admin_menu') );		
		}
    }
	
	/**
	 * add Google Analytics Code to Page Head
	 *
	 */
	public function init()
	{	
		/* Add Analytics Code to Head of DOM */
		add_action( 'wp_head', 'tactics_iga_add_analytics', 0 );
		function tactics_iga_add_analytics() {
			$ga_tracking_id = get_option( 'tactics_iga_tracking_id' );
			
			$analytics = "<!-- Global site tag (gtag.js) - Google Analytics -->\n<script async src='https://www.googletagmanager.com/gtag/js?id=" . $ga_tracking_id . "'></script>\n<script>\n\t window.dataLayer = window.dataLayer || [];\n\t function gtag(){dataLayer.push(arguments);}\n\t gtag('js', new Date());\n\t gtag('config', '" . $ga_tracking_id . "');\n</script>\n";

			echo $analytics;
		}
	}

	/**
     * add admin menu item for settings page
     *
     */
	public function admin_menu()
	{
		add_options_page( 'Instant Google Analytics Settings', 'Inst. Google Analytics', 'manage_options', 'tactics-analytics-settings', array( $this, 'ga_analytics_options' ) );
	}	
	
	/**
	 * add Settings Page in Admin
	 *
	 */
	public function ga_analytics_options(){
		if ( !current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		$ga_id_setting = 'tactics_iga_tracking_id';
		$submit_token_field = 'ga_submit_hidden';
		$ga_id_field_name = 'tactics_iga_tracking_id';
		
		// Get Tracking ID from database
		$ga_id_value = get_option( $ga_id_setting );
		
		if ( isset( $_POST[ $submit_token_field ] ) && $_POST[ $submit_token_field ] == 'Y' ){
			$ga_id_value = $_POST[ $ga_id_field_name ];
			
			if ( preg_match( '/UA-\d+-\d+/', $ga_id_value ) ) {
				update_option( $ga_id_setting, $ga_id_value );
				
				echo '<div class="updated"><p><strong>Tracking ID Saved.</strong></p></div>';
			} else {

				echo '<div class="updated"><p><strong>Not A Valid Tracking ID.</strong></p></div>';
			}
		}
		
		?>
			<div class="wrap">
				<h2>Sync Website With Google Analytics.</h2>
				<form name="tactics-iga-analytics-form" method="post" action="">
					<input type="hidden" name="<?php echo $submit_token_field; ?>" value="Y">
					<p>
						<label for="<?php echo $ga_id_field_name; ?>">Google Analytics Tracking ID</label>
						<input type="text" name="<?php echo $ga_id_field_name; ?>" value="<?php echo $ga_id_value; ?>" size="20">
					</p>
					<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="Save" />
					</p>
				</form>
				<hr />
				<h3>How to find your Google Analytics Tracking ID</h3>
				<ol>
				    <li>Sign in to your Analytics account.</li>
					<li>Click Admin.</li>
					<li>Select an account from the menu in the ACCOUNT column.</li>
					<li>Select a property from the menu in the PROPERTY column.</li>
					<li>Under PROPERTY, click Tracking Info > Tracking Code. Your tracking ID is displayed at the top of the page.</li>
				</ol>
				<p>
					<img src="<?php echo TACTICS_IGA_PLUGIN_URL; ?>/assets/images/ga-tracking-code-location.png" alt="Google Analytics Tracking ID" /></br>
					This image shows the tracking ID in Google Analytics.
				</p>
			</div>
		<?php
	}	
}

$tacticsIgaController = new tacticsIgaController();