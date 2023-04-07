<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Gmail;
use Google_Service_Gmail;
use Exception;


// APi_Key =AIzaSyBiOYFqYxc7Nf49E5BcR4G6VpeMAi5o9WY



class GoogleAPIController extends Controller
{
    
    public function fetchEmails()
    {
        $path = storage_path('app/keys/client_secret.json');

        $client = new Client();
        $client->setApplicationName('Gmail API PHP Quickstart');
        $client->setScopes('https://www.googleapis.com/auth/gmail.addons.current.message.readonly');
        $client->setAuthConfig($path);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
    
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        // dd($client);
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
            dd($accessToken);
        }
    
        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {

            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {

                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                // $authCode = trim(fgets(STDIN));
                $authCode ="4/0AVHEtk7iA5S-4Mv9TUE8r5b7bz7l9YKP-jWTvCHWNJqMo5lennu2t-52I1L22WRyTs-u1w";
    
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);


                $service = new Gmail($client);

try{

    // Print the labels in the user's account.
    $user = 'me';
    $results = $service->users_labels->listUsersLabels($user);

    if (count($results->getLabels()) == 0) {
        print "No labels found.\n";
    } else {
        print "Labels:\n";
        foreach ($results->getLabels() as $label) {
            printf("- %s\n", $label->getName());
        }
    }
}
catch(Exception $e) {
    // TODO(developer) - handle error appropriately
    echo 'Message: ' .$e->getMessage();
}
    
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    dd("true");
                    throw new Exception(join(', ', $accessToken));
                }
                dd("false");
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }
    
    

}

