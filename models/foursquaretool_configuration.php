<?

class FoursquareTool_Configuration extends Core_Configuration_Model	{

	public $record_code = 'foursquaretool_configuration';

	public $token;
	
	public static function create() {
	
		$obj = new self();
		return $obj->load();
		
	}
	
	protected function build_form() {
	
		$this->add_field('client_key', 'Client Key', 'full', db_varchar)->tab('Authentication')->comment('User identifier from Foursquare', 'above');
		$this->add_field('client_secret', 'Client Secret', 'full', db_varchar)->tab('Authentication')->comment('Secret Key from Foursquare', 'above');
		$this->add_field('token', 'Token', 'full', db_varchar)->tab('Authentication')->comment('Token after you authenticate', 'above')->disabled();

	}
	
	protected function init_config_data() {

	}
	
}