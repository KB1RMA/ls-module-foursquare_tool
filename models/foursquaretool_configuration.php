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
		
		$this->add_field('limit', 'Limit', 'full', db_varchar)->tab('Default Options')->comment('Default limit of results to return', 'above');
		$this->add_field('offset', 'Offset', 'full', db_varchar)->tab('Default Options')->comment('The number of results to skip. Used to page through results.', 'above');
		$this->add_field('sort', 'Offset', 'full', db_varchar)->tab('Default Options')->comment('How to sort the returned checkins: newestfirst/oldestfirst', 'above');

	}
	
	protected function init_config_data() {
		$this->limit 	= 100;
		$this->offset 	= 0;
		$this->sort 	= 'newestfirst';
	}
	
}