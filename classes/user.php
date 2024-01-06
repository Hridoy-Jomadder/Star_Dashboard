<?php 
class User
{
    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM users WHERE userid = ? LIMIT 1";
        $DB = new Database();
        $result = $DB->readWithParams($query, [$id]);

        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function get_user_by_username($username)
    {
        $query = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $DB = new Database();
        $result = $DB->readWithParams($query, [$username]);

        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
}
