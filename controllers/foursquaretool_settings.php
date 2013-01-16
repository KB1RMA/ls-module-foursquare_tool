<?php

class FoursquareTool_Settings extends Backend_SettingsController {

	protected $access_for_groups = array(Users_Groups::admin);
	public $implement = 'Db_FormBehavior';

	public $form_edit_title = 'FoursquareTool Settings';
	public $form_model_class = 'FoursquareTool_Configuration';
	public $form_redirect = null;

	public $redirect_uri = null;

	public function __construct() {
	
		parent::__construct();		
		
		$this->app_tab = 'Foursquare Tool';
		$this->app_module_name = 'FoursquareTool';

		$this->app_page = 'settings';
		
		$this->redirect_uri  = site_url(url('/foursquaretool/settings/authenticate/'));
		$this->form_redirect = url('/foursquaretool/settings/authenticate/');

	}

	public function index()	{

		try {
			$this->app_page_title = 'Foursquare Tool Configuration';
		
			$obj = new FoursquareTool_Configuration();
			$obj = $obj->load();
			
			$this->viewData['form_model'] = $obj;		
			$this->viewData['authenticated'] = $this->test_authentication();		
		} catch (exception $ex) {
			$this->_controller->handlePageError($ex);
		}
	}
	
	protected function index_onSave() {
		
		try {
			$obj = new FoursquareTool_Configuration();
			$obj = $obj->load();

			$obj->save(post($this->form_model_class, array()), $this->formGetEditSessionKey());
			Phpr::$session->flash['success'] = 'Configuration has been saved successfully!';
			Phpr::$response->redirect($this->form_redirect);
		} catch (Exception $ex) {
			Phpr::$response->ajaxReportException($ex, true, true);
		}
		
	}
	
	public function authenticate() {
		
		$configuration = FoursquareTool_Configuration::create();
	
		$foursquare = $this->_load_foursquare( false );;
		
		$token = Phpr::$request->get_value_array('code');
		
		// If token isn't sent, redirect to the foursquare authentication link		
		
		if ( empty($token) ) {
			Phpr::$response->redirect( $foursquare->AuthenticationLink($this->redirect_uri) );		
			return;
		}
		
		$configuration->token = $foursquare->GetToken($token, $this->redirect_uri );
	
		$configuration->save();
		
		Phpr::$response->redirect( url('/foursquaretool/settings/') );

	}
	
	public function test_authentication() {
		
		$foursquare = $this->_load_foursquare();
		
		$params = array('near'=>'Chicago, IL');
		$response = $foursquare->GetPrivate("users/self", $params);
		return json_decode($response);
	
	}

	private function _load_foursquare( $set_token = true ) {
	
		$configuration = FoursquareTool_Configuration::create();
		
		require_once( __DIR__ . "/../vendor/php-foursquare/src/FoursquareAPI.class.php" );

		$foursquare = new FoursquareAPI($configuration->client_key,$configuration->client_secret);
		
		if ($set_token)
			$foursquare->SetAccessToken($configuration->token);
		
		return $foursquare;
	}

}