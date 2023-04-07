 <!-- auth  with user permission  -->
 <!--$guzzle = new \GuzzleHttp\Client();
$url = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
$tenant_id = 'f8cdef31-a31e-4b4a-93e4-5f571e91255a';
$client_id = 'e94d47ec-fa0f-4b76-bed5-30ab571edabe';
$client_secret = 'fVc8Q~4.HMfGD8WsTafznxOiHLBZ_VPNymGUZbJV';
$response = $guzzle->post($url, [
    'form_params' => [
        'grant_type' => 'client_credentials',
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'scope' => 'https://graph.microsoft.com/.default',
        
    ],
]);


$access_token = json_decode($response->getBody()->getContents())->access_token;
dd($access_token);

$graph = new \Microsoft\Graph\Graph();
$graph->setAccessToken('EwB4A8l6BAAUAOyDv0l6PcCVu89kmzvqZmkWABkAAYAJecr5fm7UWnJ0cS67H9xeMuBrIbPY8WaKwCX2l/5jJIuDyi8X6rFGRs5ESQQ2fJFZhx+evJvCX2DFBEVQKaiUk5mKyByUazCTJCqWllZGtdjCaDbvmYtQY18k3kq3CtHCYLdvh+qmxmI6dyeOzyQWH5Jy3k2UM9ewWc5YJcnRbysqcdWVif8DaaNXXCH5jCkA9VLyFFci5ebQFwQ9XCgHjT6rLX5oBt99Fhhrf1uf/NUR4mRzc26SFyccUgg8Ozp0gdGCw3464RELBPIRjh3odMzfb0Sx6SnV+PPHzqMnKiWzTGKtRnD9Zyq994qy+oSrDwnaxhOtAfOLlK2YdhcDZgAACPLqivH1CoVISAKJzhHDgfJ8YAVpvZWVgshoCuCExkjKIobcY1FdChPKHgW7MvHjgvuVU/6XLlqYaKVn386nR8MC4wz3+S5VqenjQckaiCVGc7l3LhrgcVDRWEDqfLsBPOmR4LvmTz8Gti2CumptfQmH2lqGmrVSuH44nC/MRcCF4oY/92KS4r8djhqsV43nqYk3AJfzu8NeuvZYkc2B7t0mmvfyCXXm0bOcqoKADme5XVuNNVQOs9vc4p6AxfTMAybC2rhgSYgDSiUr7X3dtAQwLl4oMpetBxV5rLB6Afc2FM7z7yq29ruc2Wre/4KWfLuAeqEPjM73SFVk+kWTlEXBCrf/uOnN4zRObOnUhGDqy/o233jSWHqWG2fNbR0vQwrmv89BzffTMg/SUDZNmP9imB0TrptVYEE7EJ7lee2UZdJZLOXXsNioURPooXDaWp326AB0SqHzUELA7LBCTtuSwe7nCPQfrUsQ68B3+15zhipWyLJCimkJBF2llT5ms/p/dLTj0A8ed8z/4k1hei/pDDDE3HtCLdQms+gGvNcsMEnvLAzhUR66dM8pOU7qFzJeCkkooIXZVdMuTDj+oJA7DsYp7s7q+VBLEdXypeKrj3Sv2PO3O1Q9BUfRAaslxkBeBVlT1iKw2+R7rHtpyQXiqGzy0QPJYGktBTSGXpszoflsaDl8NFjPJ4bhKN68L9OVnFCo1UQ3VFEDprCmyJ0zf/+q39S8xLWhOdnBtEis9u85FaHx5MIX8ldiurAb+aTh3e+JVMReEN3d+Rb4yRAYi48C');
// dd($graph);

$user = $graph->createRequest('GET', '/me')
             ->setReturnType(\Microsoft\Graph\Model\User::class)
             ->execute();
            //  dd($user);

$messages = $graph->createRequest('GET', '/me/messages?$select=subject,from,receivedDateTime&$filter=receivedDateTime ge 2022-01-01T00:00:00Z')
                ->setReturnType(\Microsoft\Graph\Model\Message::class)
                ->execute();

                dd($messages);

-->