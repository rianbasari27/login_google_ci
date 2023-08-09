<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/vendor/autoload.php';

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index($user_id) {
        $data['user'] = $this->user_model->get_user_by_id($user_id);
        $this->load->view('dashboard_view', $data);
    }
}
 

?>