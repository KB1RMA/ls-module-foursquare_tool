<?php

class FoursquareTool_Settings extends Backend_SettingsController {

	protected $access_for_groups = array(Users_Groups::admin);
	public $implement = 'Db_FormBehavior';

	public $form_model_class = 'FoursquareTools_Configuration';
	public $form_redirect = null;
	public $redirect_uri = null;

	public function __construct() {
		$this->redirect_uri = url('/foursquaretool/settings/authenticate/');
		
		parent::__construct();

	}

	public function index()	{

		$this->app_page_title = 'Foursquare Tool Configuration';

		$this->form_redirect = $this->form_redirect = url('/foursquaretool/settings/authenticate');

		$configuration = FoursquareTool_Configuration::create();

		$this->viewData['form_model'] = $configuration;		

	}
	
	public function authenticate() {

		$configuration = FoursquareTool_Configuration::create();
		
		require_once( __DIR__ . "/../vendor/php-foursquare/src/FoursquareAPI.class.php" );
		
		$foursquare = new FoursquareAPI($configuration->client_key,$configuration->client_secret);
		
		$token = Phpr::$request->get_value_array('code');
		
		// If token isn't sent, redirect to the foursquare authentication link		
		if ( empty($token) ) {
			$Phpr::$response->redirect( $foursquare->AuthenticationLink($this->redirect_uri) );		
			return;
		}
		
		$configuration->token = $token;
		
		$configuration->save();
		
		$this->viewData['token'] = $configuration->token;
		
		$this->app_page_title = 'Foursquare Tool Authentication';

	}

}