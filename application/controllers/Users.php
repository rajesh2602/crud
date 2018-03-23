<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users
        extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->library("excel");
        $this->load->library('google');
    }

    public function index() {
        $data['google_login_url'] = $this->google->get_login_url();
        //$this->load->view('home', $data);
        //$this->load->view('welcome_message', $contents);
        $this->load->view('login', $data);
    }

    public function register() {
        $postData = $this->input->post();
        $email = $this->input->post('u_email');
        $checkEmail = $this->user_model->checkEmail($email);
        if (empty($checkEmail)) {
            if (isset($_FILES['u_profile']['name']) && $_FILES['u_profile']['name'] != '') {
                $fileName = $_FILES['u_profile']['name'];
                $tempName = $_FILES['u_profile']['tmp_name'];
                $extension = explode('.', $fileName);
                $newFileName = time() . $extension[0] . "." . $extension[1];
                move_uploaded_file($_FILES['u_profile']['tmp_name'], 'uploads/' . $newFileName);
                $postData['u_profile'] = $newFileName;
            }
            $this->user_model->insertUser($postData);
            echo json_encode(array('status' => 0, 'message' => 'User Registered Done Successfully.'));
        } else {
            echo json_encode(array('status' => 1, 'message' => 'Email Address Already Exit.'));
        }
    }

    public function login() {
        if (isset($_GET['code'])) {
            $this->googleplus->getAuthenticate();
            $this->session->set_userdata('login', true);
            $this->session->set_userdata('user_profile', $this->googleplus->getUserInfo());
            // redirect('welcome/profile');
        }

        $contents['login_url'] = $this->googleplus->loginURL();
        //$this->load->view('welcome_message', $contents);
        $this->load->view('login', $contents);
    }

    public function checkLogin() {
        $postData = $this->input->post();
        $email = $this->input->post('u_email');
        $checkEmail = $this->user_model->checkEmail($email);
        if (!empty($checkEmail)) {
            $checkLogin = $this->user_model->checkLogin($postData);
            if (!empty($checkLogin)) {
                $login = array(
                    'u_id' => $checkLogin->u_id,
                    'u_fullname' => $checkLogin->u_firstname . " " . $checkLogin->u_lastname,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($login);
                echo json_encode(array('status' => 0, 'message' => 'Login Success'));
            } else {
                echo json_encode(array('status' => 1, 'message' => 'Password Doesnt Match.'));
            }
        } else {
            echo json_encode(array('status' => 1, 'message' => 'Email Id is not registered.'));
        }
    }

    public function userListView() {
        if ($this->session->userdata('logged_in') == TRUE) {
            $data['users'] = $this->user_model->getUsers();
            $this->load->view('user_view', $data);
        } else {
            redirect('users/login');
            exit;
        }
    }

//    public function logout() {
//        $this->session->unset_userdata('u_id');
//        $this->session->unset_userdata('u_fullname');
//        $this->session->unset_userdata('logged_in');
//        redirect('users/login');
//    }

    public function deleteUser($id) {
        $this->user_model->deleteUser($id);
        echo json_encode(array('status' => 0, 'message' => 'UserDelete Successfully'));
    }

    public function editUser($id) {
        $data['users'] = $this->user_model->getUsers($id);
        $this->load->view('edituser', $data);
    }

    public function editData() {
        $postData = $this->input->post();
        if (isset($_FILES['u_profile']['name']) && $_FILES['u_profile']['name'] != '') {
            $fileName = $_FILES['u_profile']['name'];
            $tempName = $_FILES['u_profile']['tmp_name'];
            $extension = explode('.', $fileName);
            $newFileName = time() . $extension[0] . "." . $extension[1];
            move_uploaded_file($_FILES['u_profile']['tmp_name'], 'uploads/' . $newFileName);
            $postData['u_profile'] = $newFileName;
        }

        $this->user_model->updateData($postData);
        echo json_encode(array('status' => 0, 'message' => 'Update Done SuccessFully'));
    }

    public function addMoreoption() {
        $this->load->view('add_more');
    }

    public function createXLS() {
        // create file name
        $fileName = time() . '.xlsx';
        // load excel library
        $this->load->library('excel');
        $empInfo = $this->user_model->getUsers();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'User ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Phone');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'About Me');
        // set Row
        $rowCount = 2;
        foreach ($empInfo as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['u_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['u_firstname']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['u_lastname']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['u_email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['u_phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['u_about']);
            $rowCount++;
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('users_' . $fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(HTTP_UPLOAD_IMPORT_PATH . 'users_' . $fileName);
    }

    public function productAdd() {
        $totalRecords = count($this->input->post('prod_name'));
        for ($i = 0; $i < $totalRecords; $i++) {
            $postData['prod_name'] = $this->input->post('prod_name')[$i] ? $this->input->post('prod_name')[$i] : '';
            $postData['prod_quantity'] = $this->input->post('prod_quantity')[$i] ? $this->input->post('prod_quantity')[$i] : '';
            $postData['prod_price'] = $this->input->post('prod_price')[$i] ? $this->input->post('prod_price')[$i] : '';
            $postData['prod_stock'] = $this->input->post('prod_stock')[$i] ? $this->input->post('prod_stock')[$i] : '';
            if (isset($_FILES['prod_image']['name'][$i]) && $_FILES['prod_image']['name'][$i] != '') {
                $fileName = $_FILES['prod_image']['name'][$i];
                $tmpName = $_FILES['prod_image']['tmp_name'][$i];
                $extension = explode('.', $fileName);
                $newFileName = time() . $extension[0] . "." . $extension[1];
                move_uploaded_file($_FILES['prod_image']['tmp_name'][$i], 'uploads/' . $newFileName);
                $postData['prod_image'] = $newFileName;
            }
            $this->user_model->insertProduct($postData);
        }
        echo json_encode(array('status' => 0, 'message' => 'Product Added Successfully'));
    }

    public function productListView() {
        if ($this->session->userdata('logged_in') == TRUE) {
            $data['products'] = $this->user_model->getProduct();
            $this->load->view('product_view', $data);
        } else {
            redirect('users/login');
            exit;
        }
    }

    public function deleteProduct($id) {
        $this->user_model->deleteProduct($id);
        echo json_encode(array('status' => 0, 'message' => 'Product Deleted Successfully'));
    }

    public function createdb() {
        $this->load->view('create_db_table');
    }

    public function oauth2callback() {
        $google_data = $this->google->validate();
        $session_data = array(
            'name' => $google_data['name'],
            'email' => $google_data['email'],
            'source' => 'google',
            'profile_pic' => $google_data['profile_pic'],
            'link' => $google_data['link'],
            'sess_logged_in' => 1
        );
        $this->session->set_userdata($session_data);
        redirect(base_url());
    }
    
     public function logout() {
        session_destroy();
        unset($_SESSION['access_token']);
        $session_data = array(
            'sess_logged_in' => 0);
        $this->session->set_userdata($session_data);
        redirect(base_url());
    }

}
