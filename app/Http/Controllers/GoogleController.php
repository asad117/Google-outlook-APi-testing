<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client;
use Google\Service\Gmail;
use Google_Service_Gmail;
use Google_Service_Oauth2;


class GoogleController extends Controller
{

    public function index(){

    // Path to the service account's private key file.
    // $keyFile = storage_path('app/keys/final-project-382904-1d49bb112617.json');
        $keyFile = storage_path('app/keys/final-project-382904-1d49bb112617.json');

        $client = new Client();
        $client->setApplicationName('Email Manager');
        $client->setAuthConfig($keyFile);
        $client->setScopes(['https://www.googleapis.com/auth/gmail.readonly']);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

// create a new Gmail service instance
$gmailService = new Gmail($client);

// retrieve a list of all the user's messages
$messages = $gmailService->users_messages->listUsersMessages('me');
dd($messages);

        
        // dd($accessToken);

        // Create a new instance of the Gmail API service
$service = new Google_Service_Gmail($client);
// dd($service);

// Get the messages in the user's inbox
$results = $service->users_messages->listUsersMessages('me', array('q' => 'in:inbox'));

dd($results);

    // Set up the service account credentials.
    $creds = new ServiceAccountCredentials(
        null,
        ['https://www.googleapis.com/auth/gmail.readonly'],
        file_get_contents($keyFile)
    );

    // Create the Google API client.

    $client = new Client();
    $client->setApplicationName('My Gmail App');
    $client->setAuthConfig($keyFile);
    $client->setScopes(['https://www.googleapis.com/auth/gmail.readonly']);
    $client->setAccessType('offline');
    $client->setAccessToken($creds->fetchAccessToken()['access_token']);

    // Create the Gmail API service.
    $service = new Gmail($client);
    dd($service);

    // Get the user's email messages.
    $messages = $service->users_messages->listUsersMessages('me', []);

    // Loop through each message and get its data.
    $emails = [];
    foreach ($messages as $message) {
        $email = $service->users_messages->get('me', $message->id, ['format' => 'full']);
        $emails[] = $email;
    }

    // Return the list of emails.
    return response()->json($emails);
    
}

public function listLabels()
{
    $path = storage_path('app/keys/client_secret_244835003460-b4t5cc5143alc9dej4mjtb7epiurgqfa.apps.googleusercontent.com.json');

    
}


}