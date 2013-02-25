# Foursquare Tool for Lemonstand

Foursquare Tool is a module for the Lemonstand eCommerce platform (http://lemonstand.com) that facilitates the use of the Foursquare PHP Library by Stephen Young ([https://github.com/stephenyoung/php-foursquare](https://github.com/stephenyoung/php-foursquare)).

Documentation for the Foursquare api can be found here: [https://developer.foursquare.com/docs/](https://developer.foursquare.com/docs/)

## Installation

Clone this repository into modules/ in the root directory of your Lemonstand application

	git clone git://github.com/KB1RMA/foursquare_tool.git modules/foursquaretool

Foursquare Tool uses a git submodule for the Vimeo PHP library ([https://github.com/stephenyoung/php-foursquare](https://github.com/stephenyoung/php-foursquare)) so be sure to init that before using or you won't get very far.

	git submodule init

The Foursquare Tool module will add a settings page to System > Settings > CMS in the Lemonstand backend where you will enter your Client ID and Client Secret. You can create these for your application here: [https://foursquare.com/developers/apps](https://foursquare.com/developers/apps)

After entering your Client ID and Client Secret, click the 'Authenticate' button and you'll be sent off to Foursquare to grant access. When you return, if all went well, your store will be authenticated and you can now use the class in your partials/pages.

## Example Usage

Grabbing a list of all your uploaded videos:

	<? $results = FoursquareTool_Request::create()->setEndpoint('users/self/checkins')->getResult(); ?>
Looping through all the results and sending them to a partial:

	<? if ( $results->checkins->count ) : ?>
		<? foreach( $results->checkins->items as $checkin) : ?>
			*do stuff*
		<? endforeach; ?>
	<? endif ?>
