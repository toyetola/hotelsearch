<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use SoapParam;
use SoapVar;


class getHotels extends Controller
{
    public  function  fetchresults(Request $request){
            $xml = new \DOMDocument( "1.0", "UTF-8" );

        $xml_env = $xml->createElement( "soap:Envelope" );
        $xml_env->setAttribute( "xmlns:soap", "http://www.w3.org/2003/05/soap-envelope" );
        $xml_env->setAttribute( "xmlns:hot", "http://TekTravel/HotelBookingApi" );

        /*create header*/
        $xml_hed = $xml->createElement( "soap:Header" );
        $xml_hed->setAttribute( "xmlns:wsa", "http://www.w3.org/2005/08/addressing" );

        $xml_cred = $xml->createElement( "hot:Credentials" );
        $xml_cred->setAttribute( "UserName", "behtarin" );
        $xml_cred->setAttribute( "Password", "beht@123" );

        $xml_wsaa = $xml->createElement( "wsa:Action","http://TekTravel/HotelBookingApi/HotelSearch" );
        $xml_wsat = $xml->createElement( "wsa:To","https://api.tbotechnology.in/hotelapi_v7/hotelservice.svc" );

        $xml_hed->appendChild($xml_cred);
        $xml_hed->appendChild($xml_wsaa);
        $xml_hed->appendChild($xml_wsat);

        $xml_env->appendChild($xml_hed);

        /*create body*/
        $xml_bdy = $xml->createElement( "soap:Body" );
        $xml_bdyreq = $xml->createElement( "hot:HotelSearchRequest" );
        $xml_bdyreqele = $xml->createElement( "hot:CheckInDate","2019-01-24" );
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:CheckOutDate","2019-01-26" );
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:CountryName","United Arab Emirates" );
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:CityName","Dubai" );
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:CityId","25921" );
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:NoOfRooms","1" );
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:GuestNationality","AE" );
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:RoomGuests");
        $xml_bdyreqinnerele = $xml->createElement( "hot:RoomGuest");
        $xml_bdyreqinnerele->setAttribute("AdultCount","1");
        $xml_bdyreqele->appendChild($xml_bdyreqinnerele);
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdyreqele = $xml->createElement( "hot:Filters");
        $xml_bdyreqinnerele = $xml->createElement( "hot:StarRating","All");
        $xml_bdyreqele->appendChild($xml_bdyreqinnerele);
        $xml_bdyreq->appendChild($xml_bdyreqele);

        $xml_bdy->appendChild($xml_bdyreq);
        $xml_env->appendChild($xml_bdy);

        $xml->appendChild($xml_env);
        $request = $xml->saveXML();
        $opts = array(
            'ssl' => array(
                //'ciphers' => 'RC4-SHA',
                'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT,
                'verify_peer' => false,
                'verify_peer_name' => false
            )
        );

// SOAP 1.2 client
        $params = array(
            'encoding' => 'UTF-8',
            'verifypeer' => false,
            'verifyhost' => false,
            'soap_version' => SOAP_1_2,
            'trace' => 1,
            'exceptions' => 1,
            'cache_wsdl'=>WSDL_CACHE_NONE,
            'connection_timeout' => 180,
            'stream_context' => stream_context_create($opts)
        );


        $location = "https://api.tbotechnology.in/hotelapi_v7/hotelservice.svc";
        $action = "http://TekTravel/HotelBookingApi/HotelSearch";
         $client = new \SoapClient("https://api.tbotechnology.in/hotelapi_v7/hotelservice.svc?wsdl", $params);
        $resp = $client->__doRequest($request , $location , $action , 2 );
        print_r($resp);

        /*$URL = 'http://api.tbotechnology.in/hotelapi_v7/hotelservice.svc';

        $client = new SoapClient(null, array(
            'location' => $URL,
            'uri'      => "http://TekTravel/HotelBookingApi",
            'trace'    => 1,
        ));

        $return = $client->__soapCall("HotelSearch",
            array('soapaction' => 'http://TekTravel/HotelBookingApi/HotelSearch')
        );*/

        /*client = new SoapClient('http://publicbetawebservices.hotel.de/V2_8/FreeHotelSearchWebService.svc?WSDL',array("trace"=>1));
        $client->__setLocation('http://publicbetawebservices.hotel.de/V2_8/FreeHotelSearchWebService.svc');*/


    }





}
