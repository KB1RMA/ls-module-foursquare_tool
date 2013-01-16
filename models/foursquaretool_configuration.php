<?

class FoursquareTool_Configuration extends Core_Configuration_Model	{

	public $record_code = 'foursquaretool_configuration';

	public static function create() {
	
		$obj = new self();
		return $obj->load();
		
	}
	
	protected function build_form() {
	
		$this->add_field('client_key', 'Client Key', 'full', db_varchar);
		$this->add_field('client_secret', 'Client Secret', 'full', db_varchar);
		$this->add_field('token', 'Token', 'full', db_varchar);
		
	}

}