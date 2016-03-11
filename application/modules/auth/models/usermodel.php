<?php
class Usermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function userlist()
    {
    	
    	$query= $this->db->query("SELECT users.*,groups.name,company.name as companyname from groups JOIN users_groups ON groups.id=users_groups.group_id JOIN  users ON
    	users_groups.user_id=users.id JOIN company On users.company=company.id where company.id<>1");

    	return $query->result_array();

    }
    
}