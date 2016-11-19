<?php
/* Authorize.net AIM Payment Gateway Class */
class WebcreativesCardPayment extends WC_Payment_Gateway {

	// Setup our Gateway's id, description and other values
	function __construct() {

		// The global ID for this Payment method
		$this->id = "webcreatives_card_payment";

		// The Title shown on the top of the Payment Gateways Page next to all the other Payment Gateways
		$this->method_title = __( "K & H Bankkártyás fizetés", 'webcreatives-core' );

		// The description for this Payment Gateway, shown on the actual Payment options page on the backend
		$this->method_description = __( "K & H bankkártyás fizetési module woocommercehez", 'webcreatives-core' );

		// The title to be used for the vertical tabs that can be ordered top to bottom
		$this->title = __( "K & H Bankkártyás fizetés", 'webcreatives-core' );

		// If you want to show an image next to the gateway's name on the frontend, enter a URL to an image.
		$this->icon = null;

		// Bool. Can be set to true if you want payment fields to show on the checkout 
		// if doing a direct integration, which we are doing in this case
		$this->has_fields = false;

		// Supports the default credit card form
		$this->supports = array( );

		// This basically defines your settings which are then loaded with init_settings()
		$this->init_form_fields();

		// After init_settings() is called, you can get the settings and load them into variables, e.g:
		// $this->title = $this->get_option( 'title' );
		$this->init_settings();
		
		// Turn these settings into variables we can use
		foreach ( $this->settings as $setting_key => $value ) {
			$this->$setting_key = $value;
		}
				
		// Save settings
		if ( is_admin() ) {
			// Versions over 2.0
			// Save our administration options. Since we are not going to be doing anything special
			// we have not defined 'process_admin_options' in this class so the method in the parent
			// class will be used instead
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		}		
	} // End __construct()

	// Build the administration fields for this specific Gateway
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'		=> __( 'Enable / Disable', 'webcreatives-core' ),
				'label'		=> __( 'Enable this payment gateway', 'webcreatives-core' ),
				'type'		=> 'checkbox',
				'default'	=> 'no',
			),
			'title' => array(
				'title'		=> __( 'Title', 'webcreatives-core' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Payment title the customer will see during the checkout process.', 'webcreatives-core' ),
				'default'	=> __( 'Credit card', 'webcreatives-core' ),
			),
			'description' => array(
				'title'		=> __( 'Description', 'webcreatives-core' ),
				'type'		=> 'textarea',
				'desc_tip'	=> __( 'Payment description the customer will see during the checkout process.', 'webcreatives-core' ),
				'default'	=> __( 'Pay securely using your credit card.', 'webcreatives-core' ),
				'css'		=> 'max-width:350px;'
			),
			'environment' => array(
				'title'		=> __( 'Test Mode', 'webcreatives-core' ),
				'label'		=> __( 'Enable Test Mode', 'webcreatives-core' ),
				'type'		=> 'checkbox',
				'description' => __( 'Place the payment gateway in test mode.', 'webcreatives-core' ),
				'default'	=> 'no',
			)
		);		
	}
	
	// Submit payment and handle response
	public function process_payment( $order_id ) {
		global $woocommerce;
		
		// Get this Order's information so that we know
		// who to charge and how much
		$customer_order = new WC_Order( $order_id );
		
		// Are we testing right now or is it a real transaction
		$environment = ( $this->environment == "yes" ) ? 'TRUE' : 'FALSE';

		// Decide which URL to post to
		//https://ebank.khb.hu/PaymentGatewayTest/PGPayment?txid=3141592653&type=PU&mid=10234506&amount=1234000&ccy=HUF&sign=a1154ffeb7…535cfc88cfd784&lang=HU

		$environment_url = ( "FALSE" == $environment ) 
						   ? 'https://ebank.khb.hu/PaymentGatewayTest/PGPayment?'
						   : 'https://ebank.khb.hu/PaymentGatewayTest/PGPayment?';
						   
		   
		$payload = array(
			"mid"		=> 1274,
			"txid" 	 	=> $customer_order->get_order_number(),
			"type"		=> "PU",
			"amount" 	=> number_format($customer_order->order_total, 2,  '', ''),
			"ccy"	 	=> "HUF",
		);
		
		$data =  http_build_query( $payload );
		$file =  dirname(dirname(__FILE__)) . "/private_key.pem";
		$fp = fopen($file, "r");
		
		$priv_key = fread($fp, 8192);
		fclose($fp);
		$pkeyid = openssl_get_privatekey($priv_key, "6xqrqs4N");
		
		
		// compute signature
		openssl_sign($data, $signature, $pkeyid);
		
		// free the key from memory
		openssl_free_key($pkeyid);						   
		
		$sign = array(
			"lang"	 	=> "HU",
			"sign"		=> bin2hex($signature),
			//"nocheck"	=> "1"
		);
		
		return array(
			'result'   => 'success',
			'redirect' => $environment_url . http_build_query( $payload ) . "&" . http_build_query( $sign )
		);		
			
	}
	
	// Validate fields
	public function validate_fields() {
		return true;
	}

} // End of WebcreativesCardPayment