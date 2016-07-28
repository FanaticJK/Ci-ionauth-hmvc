<?php
class Mymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    /**
     * [get description]
     * @param  [type]  $table   [description]
     * @param  [type]  $fields  [description]
     * @param  string  $where   [description]
     * @param  integer $perpage [description]
     * @param  integer $start   [description]
     * @param  boolean $one     [description]
     * @param  string  $array   [description]
     * @return [type]           [description]
     */
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

        //echo $where;
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }

        $query = $this->db->get();
        $result = !$one ? $query->result($array) : $query->row() ;
        return $result;
    }

    /**
     * [getValue description]
     * @param  [type] $fieldname  [comparing string]
     * @param  [type] $fieldvalue [comparing value]
     * @param  [type] $table      [description]
     * @param  [type] $id         [description]
     * @return [type]             [description]
     */
    function getValue($fieldname,$fieldvalue,$table,$id){
        $this->db->where($fieldname,$fieldvalue);
        $query=$this->db->get($table);

        $result=$query->row()->$id;

        return $result;
    }

    /**
     * [add description]
     * @param [type] $table [description]
     * @param [type] $data  [description]
     */
    function add($table,$data){
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1')
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * [edit description]
     * @param  [type] $table   [description]
     * @param  [type] $data    [description]
     * @param  [type] $fieldID [description]
     * @param  [type] $ID      [description]
     * @return [type]          [description]
     */
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * [delete description]
     * @param  [type] $table   [description]
     * @param  [type] $fieldID [description]
     * @param  [type] $ID      [description]
     * @return [type]          [description]
     */
    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
        {
            return TRUE;
        }

        return FALSE;
    }


    function getCount($fields,$tablename,$where="1=1")
    {
        $this->db->select($fields);
        $this->db->from($tablename);
        $this->db->where($where);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->num_rows();
        }else{
            return false;
        }


    }
    /**
     * [count description]
     * @param  [type] $table [description]
     * @return [type]        [description]
     */
    function count($table){
        return $this->db->count_all($table);
    }

    /**
     * [query description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    function query($sql)
    {
        $result = mysql_query($sql);
        if($result)
        {
            return $result;
        }
        else
        {
            echo mysql_error();
        }
    }




    function user_zone($zone,$id)
    {
        if (!empty($zone))
        {

            foreach ($zone as $zone)
            {
                $data['users_id']=$id;
                $data['zone_id']=$zone;
                $this->add('users_zone',$data);
            }
            return true;
        }
        return false;
    }
    function user_zone_update($zone,$id)
    {
        $this->delete('users_zone','users_id',$id);

        if (!empty($zone))
        {

            foreach ($zone as $zone)
            {
                $data['users_id']=$id;
                $data['zone_id']=$zone;
                $this->add('users_zone',$data);

            }
            return true;

        }
        return false;

    }

}

