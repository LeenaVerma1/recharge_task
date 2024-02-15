<?php
class Tblrecharge_log_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function log_api_call($request, $response)
    {
        $data = array(
            'request' => $request,
            'response' => $response
        );
        return $this->db->insert('tblrecharge_log', $data);
    }
}
