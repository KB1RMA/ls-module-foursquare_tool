<?php

	class FoursquareTool_Request {
	
		public $foursquare;

		private $configuration;
		private $endpoint = '';
		private $lastresponse;
		private $lasterror;
		private $cache;
		private $useCache = false;

		// Default params to be populated in the construct
		private $params = array();
		
		public function __construct() {
			
			$this->configuration = FoursquareTool_Configuration::create();
			$this->cache = Core_CacheBase::create();	

			if ( $this->configuration->cache_enabled )	
				$this->useCache = true;
		
			$this->params = array(
				'limit' 	=> $this->configuration->limit,
				'offset' 	=> $this->configuration->offset,
				'sort' 		=> $this->configuration->sort
			);
			
			require_once( __DIR__ . "/../vendor/php-foursquare/src/FoursquareAPI.class.php" );

			$this->foursquare = new FoursquareAPI($this->configuration->client_key,$this->configuration->client_secret);
			$this->foursquare->SetAccessToken($this->configuration->token);
		
		}
		
		public static function create() {
			return new self();			
		}
		
		public function setEndpoint( $value = '' ) {
			$this->endpoint = $value;
			return $this;
		}
		
		public function setParams( $params = array() ) {
			$this->params[] = $params;
			return $this;
		}
	
		public function getResult( $recache = false ) {	

			if ( $this->useCache ) {

				// Use the endpoint as the key (without slashes)
				$key = 'foursquare_tool_' . str_replace("/",'',$this->endpoint);

				$this->cache->create_key($key, $recache );
				$response = $this->cache->get($key);

				if ( !$response || $recache )  {
					$response = $this->sendRequest();
					$this->cache->set( $key, $response );
					return $response;
				}
						
				return $response;			
			}

			return $this->sendRequest();

		}

		private function sendRequest() {
			
			$response = $this->foursquare->GetPrivate( $this->endpoint, $this->params );

			$response = json_decode($response);

			if ( $response->meta->code != 200 ) {
				$this->lasterror = $response;
				return false;
			}
			
			$this->lastresponse = $response;
			
			return $response->response;

		}
		
		public function getLastError() {
		
			if ( empty($this->lasterror) )
				return false;
			else
				return $this->lasterror;

		}
		
		public function getLastResponse() {
			if ( empty($this->lastresponse) )
				return false;
			else
				return $this->lastresponse;
		}
	}
