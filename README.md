# Using Ringcaptcha widget on your Website

Register or Log-in to the [Ringcaptcha.com](http://ringcaptcha.com) site and create a new widget matching the domain or mobile application name it will be placed on. It is important that the name is exactly as shown on the URL bar or on the respective App Stores for the widget to work correctly, any mistake can lead to unexpected errors. Select the default service to use for PIN code requests, and activate desired features. An embed code, with a unique app key, will be created for you automatically.

## Installing your widget on your website

To embed the widget, simply paste the embed code into your HTML. The widget will be rendered in the spot where the code is placed. Replace the _XXXXXXXXX_ with the APPLICATION KEY of the service you intend on using.

    #!javascript
    <script type='text/javascript' charset='UTF-8' src='//api.ringcaptcha.com/widget/XXXXXXXXX'></script>

The Javascript loads asynchronously by default. Should you want to display the widget on a different position rather than the position of where the script tag is placed, you need to add the following html element somewhere on the HTML:

	#!javascript
    <div id='ringcaptcha_widget' style='display:none'></div> 

The widget allows the language to be hardcoded by specifying it on a Javascript variable called: _RingcaptchaOptions_. It also emits events per action for which the webmaster can listen to and act accordingly. For details please refer below example:

	#!javascript
    <script type='text/javascript'>
	var RingcaptchaOptions = {
		‘lang’ : ‘es’,
		‘events’ : {
			‘onWidgetDisplayed’ : function () {},
			‘onWaitingForPinCode’ : function () {},
			‘onRetryRequested’ : function () {},
			‘onSuccessfulPinRequestSent’ : function () {},
			‘onInvalidNumberEntered’ : function () {},
		}
	}
	</script>


> _Note: For the service to work correctly, it must be used under “**localhost**” domain or under a subdomain of the one configured for the widget in Ringcaptcha site._

## Ending the verification loop

Clone any of our PHP, Python, Java, Ruby, C# or Node.js repositories on yours and add a reference to it in your code.

    #!bash
    git clone https://[user]@bitbucket.org/ringcaptcha/ringcaptcha-php.git

Integrate within your form verification code. Example below:

	#!php
    <?php  
    //Referencing to Ringcaptcha lib 
    require_once('lib/Ringcaptcha.php');  
    
    $appKey = "your_app_key"; //Please safeguard this key as if it were an acquaintance bank account password 
    $secretKey = "your_secret_key"; //Please safeguard this key as if it were your bank account password  
    $lib = new Ringcaptcha($appKey, $secretKey);  
    $lib->setSecure(true); //Configure to send the request using SSL.
    
    if ( $lib->isValid($_POST["ringcaptcha_pin_code"], $_POST["ringcaptcha_session_id"]) ) {    
	   // Successfull verification flow.   
	   $user_phone = $lib->getPhoneNumber(); //retrieve phone number
	   $geo_located = $lib->isGeoLocated(); //retrieve whether its been geo located or not   
	   $id = $lib->getId(); //retrieve and store transaction id for reconciliation purposes  
	} else {    
	   die ("RingCaptcha verification failed. Reason: " . $lib->getMessage());  
	}  
	?>

There are available SDKs in different languages you can use here: [PHP](https://bitbucket.org/ringcaptcha/ringcaptcha-php/src), [Python](https://bitbucket.org/ringcaptcha/ringcaptcha-python/src), [C#](https://bitbucket.org/ringcaptcha/ringcaptcha-c#/src), [Ruby](https://bitbucket.org/ringcaptcha/ringcaptcha-ruby/src) and [Node.js](https://bitbucket.org/ringcaptcha/ringcaptcha-nodejs/src). 

Should there not be an available SDK in your language, you are allowed to write your own. Following are the docs for the 1.0 API Verification endpoint:

	#!bash
	>> Request:
	POST https://api.ringcaptcha.com/${app_key}/verify
	Content-Type: application/x-www-url-encoded
	app_key={Your application key}&secret_key={Your Secret key}&token={Active token}&code={4 digit PIN code}

	<< Response:
	{"id":"Transaction ID", "status":"SUCCESS or ERROR", "message":"Error code when Status is ERROR", "phone":"Cleansed phone number", "geolocation":"Information about the geo-location of the phone if possible and feature enabled", "threat_level":"an indicator detailing the transaction threat level. (e.g.: low, medium or high)", "phone_type":"LANDLINE, MOBILE, VOIP, etc", "carrier":"name of carrier"}

Example:

	#!bash
	>> Request:
	curl --data "token=XXXXYYYYZZZZAAAABBBB&code=1234&secret_key=XXXXXXXXXXXXXXXXXXXX" https://api.ringcaptcha.com/YYYYYYYYYYYYYYYYYY/verify

	<< Response:
	{"status":"SUCCESS","id":"UUUUUUUUUUUUUUU","phone":"+5491112345678","geolocation":0, "phone_type":"MOBILE","carrier":"Claro","threat_level":"LOW"}

Refer to the [ERROR Codes](https://bitbucket.org/ringcaptcha/ringcaptcha-docs/src/b8ef094514ac8613a73796407dcb02d17746d588/api?at=master) reference on the API docs.
