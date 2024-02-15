<?php
class Tblrecharge_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function import_csv_data($csv_data)
    {
        foreach ($csv_data as $row) {
            $data = array(
                'mobile' => $row[0],
                'company' => $row[1],
                'amount' => $row[2],
                'status' => $row[3],
                'recharge_date' => $row[4],
                'update_date' => $row[5]
            );
            $this->db->insert('tblrecharge', $data);
        }
    }

    public function insert_recharge($data)
    {
        return $this->db->insert('tblrecharge', $data);
    }

    // public function get_search_report($date, $status)
    // {
    //     $this->db->select('recharge_date, company, SUM(CASE WHEN status = "pending" THEN amount ELSE 0 END) as pending, SUM(CASE WHEN status = "Success" THEN amount ELSE 0 END) as Success, SUM(CASE WHEN status = "Failure" THEN amount ELSE 0 END) as Failure, SUM(amount) as credit');
    //     $this->db->from('tblrecharge');
    //     $this->db->where('recharge_date', $date);
    //     if ($status !== 'All') {
    //         $this->db->where('status', $status);
    //     }
    //     $this->db->group_by('company,date');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function get_search_report($date, $status)
    {
        $this->db->select('DATE_FORMAT(recharge_date, "%d-%m-%Y") as date, company, 
            SUM(CASE WHEN status = "Pending" THEN amount ELSE 0 END) as pending_amount, 
            SUM(CASE WHEN status = "Failure" THEN amount ELSE 0 END) as failure_amount, 
            SUM(CASE WHEN status = "Success" THEN amount ELSE 0 END) as success_amount,
            SUM(amount) as total_amount');

        $this->db->from('tblrecharge');
        if (!empty($date)) {
            $this->db->where('DATE(recharge_date)', $date);
        }
        if (!empty($status)) {
            $this->db->where('status', $status);
        }
        $this->db->group_by('DATE(recharge_date), company');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_month_summary_report($start_date, $end_date)
    {
        $next_month_start = date('Y-m-01', strtotime('+1 month', strtotime($start_date)));
        $next_month_end = date('Y-m-t', strtotime('+1 month', strtotime($start_date)));

        $this->db->select('YEAR(recharge_date) as year, MONTH(recharge_date) as month, COUNT(*) as total_recharges');
        $this->db->from('tblrecharge');

        if ($end_date <= $next_month_start) {
            $this->db->where('recharge_date >=', $start_date);
            $this->db->where('recharge_date <=', $end_date);
        } else {
            $this->db->where('recharge_date >=', $start_date);
            $this->db->where('recharge_date <', $next_month_start);
        }

        $this->db->group_by('YEAR(recharge_date), MONTH(recharge_date)');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_company_sales_report($company_id)
    {
        $this->db->select('*');
        $this->db->from('tblsales');
        $this->db->where('id', $company_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
