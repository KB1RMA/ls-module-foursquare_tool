<?

class FoursquareTool_Configuration extends Core_Configuration_Model	{

	public $record_code = 'foursquaretool_configuration';

	public static function create() {
	
		$obj = new self();
		return $obj->load();
		
	}
	
	protected function build_form() {
	
		$this->add_field('client_key', 'Client Key', 'full', db_varchar)->tab('Authentication')->comment('User identifier from Foursquare', 'above');
		$this->add_field('client_secret', 'Client Secret', 'full', db_varchar)->tab('Authentication')->comment('Secret Key from Foursquare', 'above');
		$this->add_field('token', 'Token', 'full', db_varchar)->tab('Authentication')->comment('Token after you authenticate', 'above');
		
		$this->add_field('redirect_uri', 'Redirect URI', 'full', db_varchar)->tab('Configuration')->comment('Where foursquare will redirect you after a token request', 'above');
		
	}
	
	protected function init_config_data() {
	
		$this->redirect_uri = url('/foursquaretool/settings/authenticate/');

	}
	
}