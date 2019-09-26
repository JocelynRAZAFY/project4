<?php
/**
 * Created by PhpStorm.
 * User: jocelyn
 * Date: 11/07/19
 * Time: 12:35
 */

namespace App\Services;


use Symfony\Component\Dotenv\Dotenv;

class EnvDotService
{

    public $host;

    public $scope;

    public $accessType;

    public $redirectUri;

    public $googleId;

    public $googleSecret;

    public $redirect_uri;

    public $responseType;

    public $hostAccountsGoogle;

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__.'/../../.env');

        $this->host = $_ENV['HOST'];
        $this->scope = $_ENV['SCOPE'];
        $this->accessType = $_ENV['ACCESS_TYPE'];
        $this->redirectUri = $_ENV['REDIRECT_URI'];
        $this->responseType = $_ENV['RESPONSE_TYPE'];
        $this->googleId = $_ENV['GOOGLE_ID'];
        $this->googleSecret = $_ENV['GOOGLE_SECRET'];
        $this->hostAccountsGoogle = $_ENV['HOST_ACCOUNTS_GOOGLE'];
    }

}