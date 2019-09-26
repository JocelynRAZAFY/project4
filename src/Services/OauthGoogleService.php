<?php
/**
 * Created by PhpStorm.
 * User: jocelyn
 * Date: 11/09/19
 * Time: 14:28
 */

namespace App\Services;


use GuzzleHttp\Client;

class OauthGoogleService
{
    public $envDotService;

    private $client;

    private $redirectUri;

    private $responseGoogleAccount;

    public function __construct(EnvDotService $envDotService)
    {
        $this->envDotService = $envDotService;
        $this->client = new Client([
            'timeout' => 10.0
        ]);
        $this->redirectUri = urlencode($envDotService->redirectUri);
        $this->responseGoogleAccount = $this->client->request('GET',$this->envDotService->hostAccountsGoogle);
    }

    public function getAccoutGoogle()
    {
        return "{$this->envDotService->host}?scope={$this->envDotService->scope}&access_type={$this->envDotService->accessType}&redirect_uri={$this->redirectUri}&response_type={$this->envDotService->responseType}&client_id={$this->envDotService->googleId}";
    }

    public function getTokenGoogle($code)
    {
        $accesToken = null;
        try {
            $response = $this->responseGoogleAccount;
            $discoveryJson = json_decode($response->getBody());
            $tokenEndpoint = $discoveryJson->token_endpoint;
            $userInfoEndpoint = $discoveryJson->userinfo_endpoint;

            $response = $this->client->request('POST',$tokenEndpoint,[
                'form_params' => [
                    'code' => $code,
                    'client_id' => $this->envDotService->googleId,
                    'client_secret' => $this->envDotService->googleSecret,
                    'redirect_uri' => 'http://project4.com:9090/connected',
                    'grant_type' => 'authorization_code'
                ]
            ]);
            $accesToken = json_decode($response->getBody())->access_token;
        } catch (ClientException $exception){
            dump($exception);
        }

        return $accesToken;
    }

}