<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Microsoft\Graph\Model;
use Microsoft\Graph\Model\Message;
use Microsoft\Graph\OAuth2\GrantType;
use Microsoft\Graph\OAuth2\ClientCredentialProvider;
use Microsoft\Graph\Graph;
use Microsoft\Graph\OAuth2\GraphConstants;
use Microsoft\Graph\OAuth2\AuthorizationCodeProvider;
use Microsoft\Graph\OAuth2\AccessToken;
// use Microsoft\Graph\Connect\Authentication\OAuth2;
use Microsoft\Graph\Http\GraphRequest;
use Microsoft\Graph\Connect\AuthenticationException;
use Microsoft\Graph\Connect\Constants;
use Microsoft\Graph\Exception\GraphException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Microsoft\Graph\GraphServiceRequestBuilder;
use Microsoft\Graph\Authentication\OAuth2;
use Exception;





class OutlookApiController extends Controller
{
   public function index(){

    $url = 'https://login.microsoftonline.com/';
$clientId = '388c6fdb-6e22-46e8-945d-e226b64b7225';
$clientSecret = 'wDV8Q~9Awa0xAQBML3whvHSOb2~oU4qpZDJoFdit';
$tenantId = 'd63e9471-3de5-4086-96ce-2e0b2d8306d6';
$resource = 'https://graph.microsoft.com';



// ---------------------
$client = new Client();

$tokenEndpoint = $url . $tenantId . '/oauth2/v2.0/token';

$response = $client->post($tokenEndpoint, [
    'form_params' => [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'scope' => 'https://graph.microsoft.com/.default',
        'grant_type' => 'client_credentials'
    ]
]);

$accessToken = json_decode($response->getBody())->access_token;
// dd($accessToken);

$tokenParts = explode('.', $accessToken);
$header = base64_decode($tokenParts[0]);
$payload = base64_decode($tokenParts[1]);

$jwt = json_decode($payload);

// dd($jwt);

// Check if the token has expired
$now = time();
$expired = $jwt->exp <= $now;
// dd($expired);

$graphEndpoint = 'https://graph.microsoft.com/v1.0/users';


$response = $client->get($graphEndpoint, [
    'headers' => [
        'Authorization' => 'Bearer ' . $accessToken
    ]
]);

$users = json_decode($response->getBody());

dd($users);


// $graphEndpoint = 'https://graph.microsoft.com/v1.0/users/e8a49f04-6e68-41ba-815f-1205c95427f0/mailfolders/inbox/messages?$skip=0&count=true';

// $response = $client->get($graphEndpoint, [
//     'headers' => [
//         'Authorization' => 'Bearer ' . $accessToken,
//             'Accept' => 'application/json'

//     ]
// ]);
// if ($response->getStatusCode() !== 200) {
//     throw new Exception('Error: ' . $response->getStatusCode());
// }

// $users = json_decode($response->getBody());

// // Extract the list of emails from the users data
// $emails = array_map(function ($user) {
//     return $user->mail;
// }, $users->value);
// dd($emails);



$graph = new Graph();

$graph->setAccessToken($accessToken);
$user_id = 'graphqltesting@outlook.com';



$messages = $graph->createRequest('GET', '/users/'.$user_id.'/mailFolders/inbox/messages')
    ->setReturnType(Model\Message::class)
    ->execute();
            
    dd($messages);




    // To access the outlook emails microsoft 365 buniness subscription is required.


}
}

// function getAccessToken($tenant_id, $client_id, $client_secret) {
//     $url = 'https://login.microsoftonline.com/'.$tenant_id.'/oauth2/v2.0/token';
//     $data = [
//         'grant_type' => 'client_credentials',
//         'client_id' => $client_id,
//         'client_secret' => $client_secret,
//         'scope' => 'https://graph.microsoft.com/.default',

//     ];

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     $response = json_decode(curl_exec($ch));
//     curl_close($ch);

//     return $response->access_token;
// }

// }



