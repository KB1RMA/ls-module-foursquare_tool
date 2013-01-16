<?php

class FoursquareTool_Module extends Core_ModuleBase  {
	/**
	 * Creates the module information object
	 * @return Core_ModuleInfo
	 */
	 
	protected function createModuleInfo() {
	  return new Core_ModuleInfo(
		"Foursquare Tool",
		"Various tools to use the Foursquare API in Lemonstand",
		"Keyed-Up Media LLC" );
	}
	
	public function listSettingsItems()	{
		return array(
			array(
				'title'=>'Foursquare Tool',
				'url'=>'/foursquaretool/settings',
				'icon'=>'/modules/foursquaretool/resources/img/foursquare.png',
				'description'=>'Foursquare Authentication Settings',
				'sort_id'=>40,
				'section'=>'CMS'
			)
		);
	}

}