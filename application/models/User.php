<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Model {


    public function get_last_ten_user()
    {
        $query = $this->db->get('user', 10);
        return $query->result();
    }

    //W
    public function get_where_user_info($where = array())
    {
        if(!empty($where))
        {
            $query = $this->db->select("*")->from("user")->where($where)->get();
            return $query->row_array(); 
        }
    }

    //C
    public function insert_user_entry($userinfo='')
    {   
        return $this->db->insert('user', $userinfo);
    }

    //U
    public function update_entry()
    {
        $this->title    = $_POST['title'];
        $this->content  = $_POST['content'];
        $this->date     = time();

        $this->db->update('user', $this, array('id' => $_POST['id']));
    }

    //D
    public function delete_entry()
    {}

}
