<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tblcompany_model');
    }

    public function create_company()
    {
        $company_name = $this->input->post('company_name');

        if (!empty($company_name)) {
            $data = array(
                'company_name' => $company_name
            );
            $result = $this->Tblcompany_model->create_company($data);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Company created successfully');
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to create company');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Company name is required');
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update_company()
    {
        $company_id = $this->input->post('company_id');
        $company_name = $this->input->post('company_name');

        if (!empty($company_id) && !empty($company_name)) {
            $data = array(
                'company_name' => $company_name
            );
            $result = $this->Tblcompany_model->update_company($company_id, $data);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Company updated successfully');
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to update company');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Company ID and name are required');
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function delete_company()
    {
        $company_id = $this->input->post('company_id');

        if (!empty($company_id)) {
            $result = $this->Tblcompany_model->delete_company($company_id);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Company deleted successfully');
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to delete company');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Company ID is required');
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
