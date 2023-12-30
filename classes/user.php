<?php 

class User
{

	public function get_data($id)
	{

		$query = "select * from users where userid = '$id' limit 1";
		
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{

			$row = $result[0];
			return $row;
		}else
		{
			return false;
		}
	}

    public function get_user($id)
	{

		$query = "select * from users where userid = '$id' limit 1";
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result[0];
		}else
		{

			return false;
		}
	}

	public function get_friends($id)
	{

		$query = "select * from users where userid != '$id' ";
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;
		}else
		{

			return false;
		}
	}   
    
    public function get_following($id,$type){
                
    $DB = new Database();
    //$type = addslashes($type);
   
        if(is_numeric($id)){

         // get following details
         $sql = "setect following from stars where type = '$type' && contentid = '$id' limit 1"; 
         $result = $DB->read($sql); 
            
        if(is_array($result)){

                $following = json_decode($result[0]['following'],true);
                return $following;
            }
          }
    
        return false;
    }
    
    public function follow_user($id,$type,$star_userid){
        
        if($id == $star_userid && $type == 'user'){
				return;
			}
        
        $DB = new Database();
        
    // save stars details
     $sql = "setect following from stars where type='$type' && contentid = '$star_userid' limit 1"; 
     $result = $DB->read($sql); 
        if(is_array($result)){
            
            $stars = json_decode($result[0]['following'],true);
            
            $user_ids = array_column($stars, "userid");
            
            if(!in_array($id, $user_ids)){
                
            $arr["userid"] = $id;
            $arr["date"] = date("Y-m-d H:i:s");
                
            $stars[] = $arr;    
            
            $stars_string = json_encode($stars);
            $sql = "update stars set following = '$stars_string' where type='$type' && contentid = '$star_userid' limit 1"; 
            $DB->save($sql);
                
            $user = new User();
            $single_post = $user->get_user($id);     

             //add notification
            add_notification($_SESSION['star_userid'],"follow",$single_post);
        }else{
               
                $key = array_search($id, $user_ids);
                unset($stars[$key]);
                
                $stars_string = json_encode($stars);
                $sql = "update stars set following = '$stars_string' where type='$type' && contentid = '$star_userid' limit 1"; 
                $DB->save($sql);   
            } 
        }else{
            
            $arr["userid"] = $id;
            $arr["date"] = date("Y-m-d H:i:s");
            
            $arr2[] = $arr;
            
            $following = json_encode($arr2);
            $sql = "insert into stars (type,contentid,following) values ('$type','$star_userid','$following')"; 
            $DB->save($sql); 
            
            $user = new User();
            $single_post = $user->get_user($id);     

             //add notification
            add_notification($_SESSION['star_userid'],"follow",$single_post);

        }

     }
    
}
