<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recharge extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tblrecharge_model');
        $this->load->model('Tblrecharge_log_model');
    }

    public function insert_recharge()
    {
        $data = $this->input->post();
        $result = $this->Tblrecharge_model->insert_recharge($data);

        $request = json_encode($data);
        $response = json_encode(array('success' => $result));
        $this->Tblrecharge_log_model->log_api_call($request, $response);

        echo json_encode(array('success' => $result));
    }

    public function import_csv()
    {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 1024;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('submit')) {
            $response = array('status' => 'error', 'message' => $this->upload->display_errors());
        } else {
            $file_data = $this->upload->data();
            $file_path = './uploads/' . $file_data['file_name'];
            $csv_data = array_map('str_getcsv', file($file_path));
            unset($csv_data[0]);
            // print_r($csv_data);
            // exit;
            $this->Tblrecharge_model->import_csv_data($csv_data);
            $response = array('status' => 'success', 'message' => 'CSV import successful');
        }





        // if ($this->input->post('submit')) {
        //     $config['upload_path'] = './uploads/';
        //     $config['allowed_types'] = 'csv';
        //     $config['max_size'] = 1024;
        //     $this->load->library('upload', $config);

        //     if (!$this->upload->do_upload('csv_file')) {
        //         $response = array('status' => 'error', 'message' => $this->upload->display_errors());
        //     } else {
        //         $file_data = $this->upload->data();
        //         $file_path = './uploads/' . $file_data['file_name'];
        //         $csv_data = array_map('str_getcsv', file($file_path));
        //         $this->Tblrecharge_model->import_csv_data($csv_data);
        //         $response = array('status' => 'success', 'message' => 'CSV import successful');
        //     }
        // } else {
        //     $response = array('status' => 'error', 'message' => 'No file submitted');
        // }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
