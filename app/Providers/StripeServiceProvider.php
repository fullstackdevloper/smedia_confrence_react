<?php

namespace App\Providers;

use App\Models\Configurations;
use App\Models\Meetings;

class StripeServiceProvider {

    private $stripeMode;
    private $stripeKey;
    private $stripeSecret;
    private $meetingCharge;
    private $currency;
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
        $this->stripeMode = Configurations::getByKey('stripe_mode');
        $this->meetingCharge = Configurations::getByKey('meeting_price');
        $this->currency = Configurations::getByKey('stripe_currency');
        if ($this->stripeMode == 'live') {
            $this->stripeKey = Configurations::getByKey('stripe_publish_key');
            $this->stripeSecret = Configurations::getByKey('stripe_secret_key');
        } else {
            $this->stripeKey = Configurations::getByKey('stripe_test_publish_key');
            $this->stripeSecret = Configurations::getByKey('stripe_test_secret_key');
        }
    }

    /**
     * Main StripeServiceProvider Instance.
     *
     * Ensures only one instance of StripeServiceProvider is loaded or can be loaded.
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
     * get stripe client
     * @return \Stripe\StripeClient
     */
    private function client() {
        return new \Stripe\StripeClient($this->stripeSecret);
    }

    public function createMeetingCharge($token, Meetings $meeting) {
        return $this->client()->charges->create([
            'amount' => $this->meetingCharge * 100,
            'currency' => $this->currency,
            'source' => $token,
            'description' => $meeting->title,
        ]);
    }

}
