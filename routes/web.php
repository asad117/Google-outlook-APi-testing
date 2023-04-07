<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutlookApiController;
use App\Http\Controllers\GoogleAPIController;
use App\Http\Controllers\GoogleController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/outlook', [OutlookApiController::class, 'index']);

Route::get('/google', [GoogleAPIController::class, 'fetchEmails']);


Route::get('/googleoauth', [GoogleController::class, 'index']);

Route::get('/googlelabel', [GoogleController::class, 'listLabels']);













Route::get('/oauth', function () {
    $guzzleClient = new \GuzzleHttp\Client();

    $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize' .
        '?client_id=' . env('MS_GRAPH_CLIENT_ID') .
        '&response_type=code' .
        '&redirect_uri=' . urlencode(env('MS_GRAPH_REDIRECT_URI')) .
        '&response_mode=query' .
        '&scope=' . urlencode(env('MS_GRAPH_SCOPES')) .
        '&state=12345';

    return redirect()->away($url);
});

Route::get('/oauth/callback', function () {
    $guzzleClient = new \GuzzleHttp\Client();

    $tokenUrl = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
    $response = $guzzleClient->post($tokenUrl, [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => env('MS_GRAPH_CLIENT_ID'),
            'client_secret' => env('MS_GRAPH_CLIENT_SECRET'),
            'scope' => env('MS_GRAPH_SCOPES'),
            'code' => request('code'),
            'redirect_uri' => env('MS_GRAPH_REDIRECT_URI'),
        ],
    ]);

    $accessToken = json_decode($response->getBody()->getContents())->access_token;
    dd($accessToken);

    // Save the access token in the session or database

    return redirect('/dashboard');
});
