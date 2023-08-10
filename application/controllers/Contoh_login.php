<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/vendor/autoload.php';

class Contoh_login extends CI_Controller {
    public function googleLogin() {
        $client = new Google_Client();
        $client->setClientId('501267801629-devopc0usnphqit1bgh1ovijl3jf04uj.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost/login/google_login/callback');
        $client->addScope('email');
        $client->addScope('profile');

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            $_SESSION['access_token'] = $token;

            redirect('dashboard');
        } else {
            $authUrl = $client->createAuthUrl();
            redirect($authUrl);
        }
    }

    public function dashboard() {
        if (isset($_SESSION['access_token'])) {
            $client = new Google_Client();
            $client->setAccessToken($_SESSION['access_token']);

            $service = new Google_Service_Oauth2($client);
            $user = $service->userinfo->get();

        } else {
            redirect('login');

            // test okesip
            // coba

            // baru nih
            // baru

            // lets go then
            // continue dude

        }
    }
}


?>