<?php
class Tblcompany_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_company($data)
    {
        return $this->db->insert('tblcompany', $data);
    }

    public function update_company($company_id, $data)
    {
        $this->db->where('id', $company_id);
        return $this->db->update('tblcompany', $data);
    }

    public function delete_company($company_id)
    {
        $this->db->where('id', $company_id);
        return $this->db->delete('tblcompany');
    }
}
