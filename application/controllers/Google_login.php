<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/vendor/autoload.php';

class Google_login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        
    }

    public function index() {  
        if (isset($_SESSION['access_token'])) {
            echo 'you are already log in';
            die();
        } 
        return $this->load->view('google_login');
    }

    public function login() {
        if (isset($_SESSION['access_token'])) {
            echo 'you are already log in';
            die();
        }
        
        $client = new Google_Client();
        $client->setClientId('501267801629-h20lklu3sprhg8ip1qtc73c61f2kq2q5.apps.googleusercontent.com');
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

    public function dashboard($email) {

        if (isset($_SESSION['access_token'])) {
            $data['user'] = $this->user_model->get_user_by_google_email(urldecode($email));
            // echo '<pre>';
            // print_r($data['user']);
            // exit();
            $this->load->view('dashboard_view', $data);
        } else {
            return $this->load->view('google_login');
        }
    }

    public function callback() {
        $client = new Google_Client();
        $client->setClientId('501267801629-h20lklu3sprhg8ip1qtc73c61f2kq2q5.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost/login/google_login/callback');
        $client->addScope('email');
        $client->addScope('profile');
        $client->addScope('https://www.googleapis.com/auth/user.phonenumbers.read');
        
        try {
            $token = $client->fetchAccessTokenWithAuthCode($this->input->get('code'));
            $client->setAccessToken($token);
            $_SESSION['access_token'] = $token;

        } catch (Exception $e) {
            die('Error fetching access token: ' . $e->getMessage());
        }

        if ($client->isAccessTokenExpired()) {
            die('Access token has expired.');
        }

        $service = new Google_Service_Oauth2($client);

        try {
            $user = $service->userinfo->get();
        } catch (Exception $e) {
            die('Error fetching user info: ' . $e->getMessage());
        }

        // echo '<pre>';
        // print_r($user);
        // exit();

        $data = array(
            'google_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email, 
            'profile_picture' => $user->picture 
        );

        $user = $this->user_model->get_user_by_google_email($user->email);

        if ($user) {
            $this->user_model->update_user_by_google_email($user->email, $data);
        } else {
            $this->user_model->insert_user($data);
        }

        $redirectUrl = base_url('google_login/dashboard/') . urlencode($user->email);
        redirect($redirectUrl);
    }

    public function logout() {
        unset($_SESSION['access_token']);
        redirect(base_url().'google_login');
    }
}
?>