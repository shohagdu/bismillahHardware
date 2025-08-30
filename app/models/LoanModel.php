<?php
class LoanModel extends CI_Model {

    function listLoan() {
        $this->db->select('l.*, l.id as lid, l.payable as lpayable, l.status as lstatus, l.loan as receivedLoan, a.*,b.accountName,b.accountNumber');
        $this->db->from('loan as l');
        $this->db->join('loan_authority as a', 'l.authorityId = a.id');
        $this->db->join('transaction_info as t', 't.loan_id = l.id AND t.type=4');
        $this->db->join('tbl_pos_accounts as b', 't.bank_id = b.accountID');
        $this->db->order_by('l.id', 'DESC');
        $query= $this->db->get();
        if($query->num_rows()>0) {
            return $query->result_array();
        }else{
            return false;
        }
    }
    function accInfo($transId) {
        $this->db->select('b.id, b.acc_no, b.b_name');
        $this->db->from('bank_details as b');
        $this->db->join('transaction_summary as t', 't.b_id = b.id');
        $this->db->where('t.id', $transId);
        return $this->db->get()->row_array();
    }
    function loanAuthority() {
        $this->db->select('*');
        $this->db->from('loan_authority');
        $this->db->where('status', 1);
        $this->db->order_by("name","ASC");
        return $this->db->get()->row_array();
    }
    function allLoanAuthority() {
        $this->db->select('a.*,( select SUM(credit.credit_amount)  FROM `transaction_info` as `credit` WHERE `credit`.`loan_auth_id` = `a`.`id` AND `credit`.`type`= 19 AND `credit`.`is_active`=1 GROUP BY `credit`.`loan_auth_id`  ) as totalPayable,SUM(t.debit_amount) as totalPaid ',
            false);
        $this->db->from('loan_authority as a');
        $this->db->join('loan as l', 'l.authorityId = a.id',"left");
        $this->db->join('transaction_info as t', 't.loan_auth_id = a.id AND t.type =20 AND t.is_active=1',"left");
        $this->db->order_by("name","ASC");
        $this->db->group_by("a.id");
        return $this->db->get()->result();
    }
    function listPay() {
        $this->db->select('a.*, t.*,b.accountName,b.accountNumber');
        $this->db->from('transaction_info as t');
        $this->db->join('loan_authority as a', 't.loan_auth_id = a.id');
        $this->db->join('transaction_info as tb', 'tb.parent_id =t.id');
        $this->db->join('tbl_pos_accounts as b', 'tb.bank_id = b.accountID');
        $this->db->where("t.type",20);
        $this->db->where("t.is_active",1);
        $this->db->order_by('t.id', 'DESC');
        return $this->db->get()->result_array();
    }
    function getSingleLoanInfo($where) {
        $this->db->select('l.*,l.id as lid,a.name,a.contact,a.address,t.remarks,t.bank_id');
        $this->db->from('loan as l');
        $this->db->join('loan_authority as a', 'l.authorityId = a.id');
        $this->db->join('transaction_info as t', 't.loan_id = l.id');
        $this->db->where($where);
        $query= $this->db->get();
        if($query->num_rows()>0) {
           return $query->row();
        }else{
            return false;
        }
    }
    function getSinglePayInfo($where) {
        $this->db->select('t.*,b.accountName,b.accountNumber,tb.bank_id,tb.id tb_id');
        $this->db->from('transaction_info as t');
        $this->db->join('loan_authority as a', 't.loan_auth_id = a.id');
        $this->db->join('transaction_info as tb', 'tb.parent_id =t.id');
        $this->db->join('tbl_pos_accounts as b', 'tb.bank_id = b.accountID');
        $this->db->where($where);
        $query= $this->db->get();
        if($query->num_rows()>0) {
            return $query->row();
        }else{
            return false;
        }
    }
    function loanLedgerReports($id) {
        $this->db->select('t.*',false);
        $this->db->from('transaction_info as t');
        $this->db->where('t.loan_auth_id',$id);
        $this->db->where('t.is_active',1);
        $this->db->order_by("t.id","ASC");
        return $this->db->get()->result();
    }
    function singleLoanAuthority($id) {
        $this->db->select('*');
        $this->db->from('loan_authority');
        $this->db->where('id', $id);
        $this->db->order_by("name","ASC");
        return $this->db->get()->row();
    }
    
}