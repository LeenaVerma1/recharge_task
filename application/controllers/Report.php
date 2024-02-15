<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tblrecharge_model');
    }

    public function search()
    // {
    //     $date = $this->input->post('date');
    //     $status = $this->input->post('status');
    //     $search_report = $this->Tblrecharge_model->get_search_report($date, $status);
    //     echo json_encode($search_report);

    // }
    {
        $date = $this->input->post('date');
        $status = $this->input->post('status');

        // echo $status;
        // exit;
        // Call the model method to fetch search report
        $search_report = $this->Tblrecharge_model->get_search_report($date, $status);

        foreach ($search_report as &$item) {
            $total = (int) $item['total_amount'];
            $pending = (int) $item['pending_amount'];
            $failure = (int) $item['failure_amount'];
            $success = (int) $item['success_amount'];
            
            // Calculate percentages
            $success_percentage = ($total != 0) ? ($success / $total) * 100 : 0;
            $failure_percentage = ($total != 0) ? ($failure / $total) * 100 : 0;
            $pending_percentage = ($total != 0) ? ($pending / $total) * 100 : 0;
            
            // Add percentages to the array
            $item['success_in_percentage'] = number_format($success_percentage, 2);
            $item['failure_in_percentage'] = number_format($failure_percentage, 2);
            $item['pending_in_percentage'] = number_format($pending_percentage, 2);
        }

        // Return JSON response
        $this->output->set_content_type('application/json')->set_output(json_encode($search_report));
    }

    public function month_summary()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $month_summary_report = $this->Tblrecharge_model->get_month_summary_report($start_date, $end_date);
        echo json_encode($month_summary_report);
    }

    public function company_sales()
    {
        $company_id = $this->input->post('company_id');
        $company_sales_report = $this->Tblrecharge_model->get_company_sales_report($company_id);
        echo json_encode($company_sales_report);
    }
}
