<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Loan extends CI_Controller {
    public $loginId;
    function __construct(){
        parent::__construct();
        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }

        $this->load->model('loanModel', 'loanModel', TRUE);
        $this->load->model('COMMON_MODEL', 'COMMON_MODEL', TRUE);
        $this->load->model('Settings_model', 'SETTINGS', TRUE);

        $this->userId               = $this->session->userdata('user');
        $this->dateTime             = date('Y-m-d H:i:s');
        $this->ipAddress            = $_SERVER['REMOTE_ADDR'];
    }
    
    function index(){
        $data               =   array();
        $data['opBal']      =   $this->loanModel->allLoanAuthority();
        $data['title']      =   'View Loan Authority';
        $view               =   array();
        $view['content']    =   $this->load->view('dashboard/loan/authority/viewAuth', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function ledger($id){
        $data                       =   array();
        $data['loanAuthInfo']       =   $this->loanModel->singleLoanAuthority($id);
        $data['reports']            =   $this->loanModel->loanLedgerReports($id);
        $data['title']              =   'Ledger of ' . (!empty($data['loanAuthInfo']->name)?$data['loanAuthInfo']->name:'-');
        $view                       =   array();
        $view['content']            =   $this->load->view('dashboard/loan/authority/ledger', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function addAuth(){
        $data['title'] = 'Add Loan Authority';
        $data['content'] = $this->load->view('dashboard/loan/authority/addAuth', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function editAuth($id){
        $data['auth'] = $this->COMMON_MODEL->get_row('*', 'loan_authority', array('id'=>$id));
        $data['title'] = 'Update Loan Authority Information';
        $data['content'] = $this->load->view('dashboard/loan/authority/editAuth', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function insertAuth(){
        $data['name'] = $this->input->post('name');
        $data['contact'] = $this->input->post('contact');
        $data['address'] = $this->input->post('address');
        if($this->input->post('editId')){
            $this->db->update('loan_authority', array('id'=>$this->input->post('editId')), $data);
            $this->session->set_flashdata('success', 'Data has been updated');
            redirect('loan');
        }
        $this->db->insert('loan_authority', $data);
        $this->session->set_flashdata('success', 'Data has been inserted');
        redirect('loan');
    }  
    
    function viewLoan(){
        $data['listLoan'] = $this->loanModel->listLoan();
        $data['title'] = 'Loan List';
        $data['content'] = $this->load->view('dashboard/loan/loan/viewLoan', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function addLoan(){
        $data['auth']       = $this->loanModel->allLoanAuthority();
        $data['accounts']   =  $this->SETTINGS->account();
        $data['title']      = 'Add Loan';
        $data['content']    = $this->load->view('dashboard/loan/loan/addLoan', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function editLoan($id){ 
        $data['loan']       = $this->loanModel->getSingleLoanInfo( array('l.id'=>$id,'t.type'=>4));
        $data['auth']       = $this->loanModel->allLoanAuthority();
        $data['accounts']   =  $this->SETTINGS->account();
        $data['title'] = 'Edit Loan';
        $data['content'] = $this->load->view('dashboard/loan/loan/editLoan', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function insertLoan(){
        extract($_POST);

        if(empty($authorityId)){
            echo json_encode(['status'=>'error','message'=>'Authority is required','data'=>'']);exit;
        }
        if(empty($accId)){
            echo json_encode(['status'=>'error','message'=>'Accounts is required','data'=>'']);exit;
        }

        if(empty($payable)){
            echo json_encode(['status'=>'error','message'=>'Amount is required','data'=>'']);exit;
        }
        if(empty($install)){
            echo json_encode(['status'=>'error','message'=>'Install Type  is required','data'=>'']);exit;
        }
        if(empty($date)){
            echo json_encode(['status'=>'error','message'=>'Date  is required','data'=>'']);exit;
        }
        if(empty($editID)) {
            $loan['authorityId']    = !empty($authorityId) ? $authorityId : NULL;
            $loan['loan']           = $this->input->post('loanAmount');
            $loan['interest']       = $this->input->post('interest');
            $loan['interestAmount'] = $this->input->post('interestAmount');
            $loan['payable']        = $this->input->post('payable');
            $loan['date']           = date('Y-m-d', strtotime($date));
            $loan['install']        = $this->input->post('install');
            $loan['created_by']     =  $this->userId;
            $loan['created_time']   =  $this->dateTime;
            $loan['created_ip']     =  $this->ipAddress;


            if ($loan['install'] == 1) {
                $loan['installType'] = $this->input->post('installType');
                $loan['duration'] = $this->input->post('duration');
                $loan['perInstall'] = $this->input->post('perInstall');
                $loan['date'] = $this->input->post('date');
            }

            $this->db->insert('loan', $loan);
            $loanId = $this->db->insert_id();
            $info = array(
                'transCode' => time(),
                'remarks' => $note,
                'payment_date' => date('Y-m-d', strtotime($date)),
                'created_by' => $this->userId,
                'created_time' => $this->dateTime,
                'created_ip' => $this->ipAddress,
            );


            $creditInfo = $info;
            $creditInfo['type'] = 19; // Authority Credit
            $creditInfo['credit_amount'] = $loan['loan'];
            $creditInfo['loan_id'] = $loanId;
            $creditInfo['loan_auth_id'] = $loan['authorityId'];

            $this->db->insert("transaction_info", $creditInfo);
            $parentID = $this->db->insert_id();

            if (!empty($parentID)) {
                $debitInfo = $info;
                $debitInfo['type']          = 4; // bank debit
                $debitInfo['debit_amount']  = $loan['loan'];
                $debitInfo['loan_id']       = $loanId;
                $debitInfo['bank_id']       = $this->input->post('accId');
                $debitInfo['parent_id']     = $parentID;
                $this->db->insert("transaction_info", $debitInfo);
            }
            $message = 'Successfully Saved Your Record';
            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $redirectUrl = 'loan/viewLoan/';
                echo json_encode(['status' => 'success', 'message' => $message, 'redirect_page' => $redirectUrl]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                    'redirect_page' => '']);
                exit;
            }
        }else{

            $loan['authorityId']        = !empty($authorityId) ? $authorityId : NULL;
            $loan['loan']               = $this->input->post('loanAmount');
            $loan['interest']           = $this->input->post('interest');
            $loan['interestAmount']     = $this->input->post('interestAmount');
            $loan['payable']            = $this->input->post('payable');
            $loan['date']               = date('Y-m-d', strtotime($date));
            $loan['install']            = $this->input->post('install');
            $loan['updated_by']         =  $this->dateTime;
            $loan['updated_ip']         =  $this->ipAddress;


            if ($loan['install'] == 1) {
                $loan['installType']    = $this->input->post('installType');
                $loan['duration']       = $this->input->post('duration');
                $loan['perInstall']     = $this->input->post('perInstall');
                $loan['date']           = $this->input->post('date');
            }
            $this->db->where(['id'=>$editID]);
            $this->db->update('loan', $loan);

            $info = array(
                'remarks'       => $note,
                'payment_date'  => date('Y-m-d', strtotime($date)),
                'updated_by'    => $this->userId,
                'updated_time'  => $this->dateTime,
                'updated_ip'    => $this->ipAddress,
            );

            // Authority Credit
            $creditInfo = $info;
            $creditInfo['credit_amount']    = $loan['loan'];
            $creditInfo['loan_auth_id']     = $loan['authorityId'];

            $this->db->where(['loan_id'=>$editID,'type'=>19]);
            $this->db->update("transaction_info", $creditInfo);


            // bank debit

            $debitInfo = $info;
            $debitInfo['debit_amount'] = $loan['loan'];
            $debitInfo['bank_id'] = $this->input->post('accId');

            $this->db->where(['loan_id'=>$editID,'type'=>4]);
            $this->db->update("transaction_info", $debitInfo);

            $message = 'Successfully Updated Your Record';
            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $redirectUrl = 'loan/viewLoan/';
                echo json_encode(['status' => 'success', 'message' => $message, 'redirect_page' => $redirectUrl]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                    'redirect_page' => '']);
                exit;
            }
        }
    }

    
    function addPay(){
        $data['auth']       = $this->loanModel->allLoanAuthority();
        $data['accounts']   =  $this->SETTINGS->account();
        $data['title'] = 'Add Loan Payment';
        $data['content'] = $this->load->view('dashboard/loan/pay/addPay', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function editPay($id){
        $data['auth']       = $this->loanModel->allLoanAuthority();
        $data['accounts']   = $this->SETTINGS->account();
        $data['payInfo']    = $this->loanModel->getSinglePayInfo(['t.id'=>$id,'t.type'=>20]);
        $data['title']      = 'Update Loan Payment Information';
        $data['content']    = $this->load->view('dashboard/loan/pay/editPay', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function insertPay(){
        extract($_POST);
        if(empty($authId)){
            echo json_encode(['status'=>'error','message'=>'Authority is required','data'=>'']);exit;
        }
        if(empty($accId)){
            echo json_encode(['status'=>'error','message'=>'Accounts is required','data'=>'']);exit;
        }

        if(empty($amount)){
            echo json_encode(['status'=>'error','message'=>'Amount is required','data'=>'']);exit;
        }
        if(empty($date)){
            echo json_encode(['status'=>'error','message'=>'Date  is required','data'=>'']);exit;
        }
        if(empty($editID)) {
            $info = array(
                'transCode'         => time(),
                'remarks'           => $note,
                'payment_date'      => date('Y-m-d', strtotime($date)),
                'created_by'        => $this->userId,
                'created_time'      => $this->dateTime,
                'created_ip'        => $this->ipAddress,
            );

            $debitInfo                  = $info;
            $debitInfo['type']          = 20; // Authority debit
            $debitInfo['debit_amount']  = $amount;
            $debitInfo['loan_auth_id']  = $authId;
            $this->db->insert("transaction_info", $debitInfo);
            $parentID = $this->db->insert_id();

            if (!empty($parentID)) {

                $creditInfo = $info;
                $creditInfo['type']             = 5; // Bank Credit
                $creditInfo['credit_amount']    = $amount;
                $creditInfo['bank_id']          = $this->input->post('accId');
                $creditInfo['parent_id']        = $parentID;
                $this->db->insert("transaction_info", $creditInfo);
            }
            $message = 'Successfully Saved Your Record';
            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $redirectUrl = 'loan/viewPay/';
                echo json_encode(['status' => 'success', 'message' => $message, 'redirect_page' => $redirectUrl]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                    'redirect_page' => '']);
                exit;
            }
        }else{
            $data    = $this->loanModel->getSinglePayInfo(['t.id'=>$editID,'t.type'=>20]);
            if(!empty($data)) {
                $info = array(
                    'remarks'       => $note,
                    'payment_date'  => date('Y-m-d', strtotime($date)),
                    'updated_by'    => $this->userId,
                    'updated_time'  => $this->dateTime,
                    'updated_ip'    => $this->ipAddress,
                );


                $debitInfo = $info;
                $debitInfo['debit_amount']  = $amount;
                $debitInfo['loan_auth_id']  = $authId;

                $this->db->where(['id' => $editID, 'type' => 20]);
                $this->db->update("transaction_info", $debitInfo);


                $creditInfo = $info;
                $creditInfo['credit_amount']    = $amount;
                $creditInfo['bank_id']          = $this->input->post('accId');

                $this->db->where(['parent_id' => $editID, 'type' => 5, 'id' => $data->tb_id]);
                $this->db->update("transaction_info", $creditInfo);

                $message = 'Successfully Updated Your Record';
                $this->db->trans_complete();
                if ($this->db->trans_status() === true) {
                    $redirectUrl = 'loan/viewPay/';
                    echo json_encode(['status' => 'success', 'message' => $message, 'redirect_page' => $redirectUrl]);
                    exit;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                        'redirect_page' => '']);
                    exit;
                }
            }
        }
    }
    function viewPay(){
        $data['listPay'] = $this->loanModel->listPay();
        $data['title'] = 'Loan Payment List';
        $data['content'] = $this->load->view('dashboard/loan/pay/viewPay', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }

    public function deleteLoanPay(){
        extract($_POST);

        $this->db->trans_start();
        if(empty($id)){
            echo json_encode(['status'=>'error','message'=>'ID is required','data'=>'']);exit;
        }
        $data = $this->loanModel->getSinglePayInfo(['t.id'=>$id,'t.type'=>20]);


        if(empty($data) ){
            echo json_encode(['status'=>'error','message'=>'Sorry, Information is missing','data'=>'']);exit;
        }else {
            $info = array(
                'is_active'         => 0,
                'updated_by'        => $this->userId,
                'updated_time'      => $this->dateTime,
                'updated_ip'        => $this->ipAddress,
            );

            $this->db->where(['id' => $id, 'type' => 20]);
            $this->db->update("transaction_info", $info);


            $this->db->where(['parent_id' => $id, 'type' => 5, 'id' => $data->tb_id]);
            $this->db->update("transaction_info", $info);


            $message = 'Successfully Delete this Information';


            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $redirectUrl = 'loan/viewPay/';
                echo json_encode(['status' => 'success', 'message' => $message,'redirect_page' => $redirectUrl]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                    'redirect_page' => '']);
                exit;
            }
        }
    }

}