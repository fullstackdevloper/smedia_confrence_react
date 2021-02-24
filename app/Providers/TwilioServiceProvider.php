<?php
namespace App\Providers;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use App\Models\Configurations;

class TwilioServiceProvider {
    
    private $twilioAccountSid;
    private $twilioApiKey;
    private $twilioApiSecret;
    
    /**
     * The single instance of the class.
     *
     * @var ActivityHub
     * @since 1.0.0
     */
    protected static $_instance = null;
    
    /**
     * constructor
     */
    public function __construct() {
         $this->twilioAccountSid = Configurations::getByKey('twilio_account_sid');
         $this->twilioApiKey = Configurations::getByKey('twilio_api_key');
         $this->twilioApiSecret = Configurations::getByKey('twilio_api_secret');
    }
    
    /**
     * Main ActivityHub Instance.
     *
     * Ensures only one instance of IsLayouts is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return ActivityHub.
     */
    public static function init() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * get the twilio token 
     * @param string $identity
     * @param string $roomName
     * @return string Twilio Token
     */
    public function generateToken($identity, $roomName) {
        // Create access token, which we will serialize and send to the client
        $token = new AccessToken($this->twilioAccountSid, $this->twilioApiKey, $this->twilioApiSecret, 3600, $identity);
        // Create Video grant
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        // Add grant to token
        $token->addGrant($videoGrant);
        // render token to string
        return $token->toJWT();
    }
}