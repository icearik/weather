<?php

namespace App\Http\Controllers;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{

	public function getWeather(Request $request, $zipcode)
	{
	// Log the request information
    	$ip_address = $request->ip();
    	Log::info("API call made from IP address $ip_address");    
	// Check if the zipcode is valid
	if (!ctype_digit($zipcode) || strlen($zipcode) !== 5) {
		$error_message = 'Invalid zipcode';
        	Log::error("API call failed with error: $error_message.");
        	return response()->json(['status' => 'FAIL', 'message' => $error_message], 403);       
        }
	    // Check if the authorization key is present and valid
	$auth_key = $request->header('X-AUTH');
        if (!$auth_key || !Cache::has($auth_key)) {
            	$error_message = 'Authorization key is missing or invalid';
            	Log::error("API call failed with error: $error_message.");
	    	return response()->json(['status' => 'FAIL', 'message' => $error_message], 401);
        }

        // Check if the user has exceeded the limit of 5 requests
        $auth_key_count = Cache::get($auth_key);
	if ($auth_key_count >= 5) {
		$error_message = 'Authorization limit exceeded. Refresh the page to get a new key';
        	Log::error("API call failed with error: $error_message.");
        	return response()->json(['status' => 'FAIL', 'message' => $error_message], 400);
	}

        // Increment the request count for the authorization key
        Cache::forever($auth_key, $auth_key_count + 1);
    
	$status="FAIL";
	$weather = [];    
	// Check if the data is cached
	if (Cache::has($zipcode)) {
            $weather = Cache::get($zipcode);
            $status = 'CACHE';
	} else {
	    // Call VC API
	    $client = new Client();
            $url = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/'.$zipcode;
            $params = [
               'query' => [
                  'key' => env("API_KEY"),
               ],
	    ];
	    try {
	    	$response = $client->get($url, $params);
            	$data = json_decode($response->getBody(), true);
	    	$weather = [
            	    'today' => $data['days'][0],
            	    'tomorrow' => $data['days'][1],
	    	];
	    	// cache the result
            	Cache::put($zipcode, $weather, $seconds=15);
            	$status = 'LIVE';
	    } catch (RequestException $e) {
		    Log::error(Psr7\Message::toString($e->getResponse()));
		    return response()->json(['status' => 'FAIL', 'message' => $e->getResponse()->getBody()->__toString()], $e->getResponse()->getStatusCode());
            }
        }

        // Return the response as JSON
        return response()->json([
            'status' => $status,
            'today' => $weather['today'],
            'tomorrow' => $weather['tomorrow'],
        ]);
    }
}

