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
    }

    public function index() {
        $this->load->view('register');
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
        $this->load->view('login');
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

    public function logout() {
        $this->session->unset_userdata('u_id');
        $this->session->unset_userdata('u_fullname');
        $this->session->unset_userdata('logged_in');
        redirect('users/login');
    }

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

}
