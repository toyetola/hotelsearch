<?php

namespace App\Service;

use SoapClient;


private function _client($F5srv) {
    $opts = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $context = stream_context_create($opts);
    $wsdl = "http://api.tbotechnology.in/hotelapi_v7/hotelservice.svc?wsdl";

    try {
        $this->client = new \SoapClient($wsdl, array(
                'stream_context' => $context, 'trace' => true,
                'login' => 'behtarin', 'password' => 'beht@123')
        );

        return $this->client;
    }

    catch ( \Exception $e) {
        Log::info('Caught Exception in client'. $e->getMessage());
    }
}

public function getCurrency($params) {
    $this->client = $this->_client($params['config']);

    try {
        $result = $this->client->HotelSearch($params);
        return $result;
    }

    catch (\Exception $e) {
        Log::info('Caught Exception :'. $e->getMessage());
        return $e;       // just re-throw it
    }
}

?>