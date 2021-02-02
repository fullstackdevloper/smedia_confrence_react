<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class TwilioController extends Controller
{
    public function generatetoken() {
        $twilioAccountSid = 'ACe2e557c1282d41cc808f4535c7913141';
        $twilioApiKey = 'SKed3220bbc8ab94c07f48c8e837896679';
        $twilioApiSecret = 'k5WpwK5RnHJJONiDnWR2mV58n7fURF7Z';

        // A unique identifier for this user
        $identity = $_GET['identity'];
        // The specific Room we'll allow the user to access
        $roomName = 'DailyStandup';

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 3600, $identity);

        // Create Video grant
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        // Add grant to token
        $token->addGrant($videoGrant);
        // render token to string
        echo $token->toJWT();
    }
}
