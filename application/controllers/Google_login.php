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
        return $this->load->view('google_login');
    }

    public function login() {
        $client = new Google_Client();
        $client->setClientId('501267801629-h20lklu3sprhg8ip1qtc73c61f2kq2q5.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost/login');
        $client->addScope('email');
        $client->addScope('profile');

        if (!$this->session->userdata('access_token')) {
            $authUrl = $client->createAuthUrl();
            redirect($authUrl);
        }

        $client->setAccessToken($this->session->userdata('access_token'));
        $service = new Google_Service_Oauth2($client);
        $user = $service->userinfo->get();

        // Handle user data and login logic here
    }

    public function callback() {
        $client = new Google_Client();
        $client->setClientId('501267801629-h20lklu3sprhg8ip1qtc73c61f2kq2q5.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost/login');
        $client->addScope('email');
        $client->addScope('profile');

        $token = $client->fetchAccessTokenWithAuthCode($this->input->get('code'));
        $this->session->set_userdata('access_token', $token);

        $service = new Google_Service_Oauth2($client);
        $user = $service->userinfo->get();

        $data = array(
            'google_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profile_picture' => $user->picture
        );

        $user_id = $this->user_model->insert_user($data);

        redirect('google_login/dashboard/'.$user_id);
    }

    public function dashboard($user_id) {
        $data['user'] = $this->user_model->get_user_by_id($user_id);
        $this->load->view('dashboard_view', $data);
    }
}
 

?>