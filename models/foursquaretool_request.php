<?php

	class FoursquareTool_Request {
	
		private $configuration;
		private $foursquare;
		private $endpoint = '';
		private $lastresponse;
		private $lasterror;
		
		// Default params to be populated in the construct
		private $params = array();
		
		public function __construct() {
			
			$this->configuration = FoursquareTool_Configuration::create();
		
			$this->params = array(
				'limit' 	=> $this->configuration->limit,
				'offset' 	=> $this->configuration->offset,
				'sort' 		=> $this->configuration->sort
			);
			
			require_once( __DIR__ . "/../vendor/php-foursquare/src/FoursquareAPI.class.php" );

			$this->foursquare = new FoursquareAPI($this->configuration->client_key,$this->configuration->client_secret);
			$this->foursquare->SetAccessToken($this->configuration->token);
			
			traceLog($this->configuration->token);
		
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
	
		public function sendRequest( $authorized = true, $raw_results = false ) {
			
			if ( $authorized )
				$response = $this->foursquare->GetPrivate( $this->endpoint, $this->params );
			else
				$response = $this->foursquare->GetPublic( $this->endpoint, $this->params );

			$response = json_decode($response);
			
			if ( $response->meta->code != 200 ) {
				$this->lasterror = $response;
				return false;
			}
			
			$this->lastresponse = $response;
			
			if ( $raw_results )
				return $this->lastresponse;
			else
				return $this->lastresponse->response;

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