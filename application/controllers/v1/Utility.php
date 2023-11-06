<?php

class Utility extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_model');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, x-api-key,client-id');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Origin: *');
        if ("OPTIONS" === $_SERVER['REQUEST_METHOD']) {
            die();
        }
    }

    // CALL API
    public function call_api($method, $url, $header, $data = false)
    {
        
        $curl = curl_init();
        // return $response = array('status' => FALSE,'response' => $urlll ,'message' => $data );
        // return $data;
        switch ($method) {
            case "POST":
                //   return $response = array('status' => FALSE,'response' => $url ,'message' => $data );
                curl_setopt($curl, CURLOPT_POST, true);
                if ($data) {
                   
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "Q_POST":
                curl_setopt($curl, CURLOPT_POST, true);
                if ($data) {
                    $data = http_build_query($data);
                   
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                     $url = sprintf("%s?%s", $url, http_build_query($data));

                if ($data) {
                    $url = $url . "/$data";
                }

        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $response = "cURL Error #:" . $err;
        } else {
            $response = $result;
        }

        return $response;
    }


    //To check if exist
    function is_user_exist($email , $user_type_id){
        $response = array("status_code" => "0" , "message" => "Users not found");
        $query = $this->db->query("select email, user_type_id from user_accounts where email = '$email' and user_type_id = '$user_type_id'")->result_array();
        if ( sizeof($query ) > 0){
            $response = array("status_code" => "1" , "message" => "User details already exist");  
        }
        return $response;
    }
    function is_email_exist($email){
        $response = array("status_code" => "0" , "message" => "Email not found");
        $query = $this->db->query("select email from user_accounts where email = '$email'")->result_array();
        if ( sizeof($query ) > 0){
            $response = array("status_code" => "1" , "message" => "Email already exist");  
        }
        return $response;
    }

    // function is_emailanduser_type_exist($email,$user_type_id){
    //     $response = array("status_code" => "0" , "message" => "Email not found");
    //     $query = $this->db->query("select email , user_type_id from user_accounts where email = '$email' AND user_type_id = '$user_type_id'")->result_array();
    //     if ( sizeof($query ) > 0){
    //         $response = array("status_code" => "1" , "message" => "Email already exist");  
    //     }
    //     return $response;
    // }
    function is_image_exist($image){
        $response = array("status_code" => "0" , "message" => "File not found");
        $query = $this->db->query("select image from document_logs where image = '$image'")->result_array();
        if ( sizeof($query ) > 0){
            $response = array("status_code" => "1" , "message" => "File  already exist");  
        }
        return $response;
    }

    public function document_details_list(){
         $document =$this->db->query("SELECT COUNT(document_owner)doc_count FROM document_logs;")->result();
         $department =$this->db->query("SELECT COUNT(id)dep_count FROM departments;")->result();
         $document_owner =$this->db->query("SELECT COUNT( DISTINCT document_owner)doc_owner_count FROM document_logs")->result();
        if(count($document)>0){
        $response = array('status_code' => '0',  'message' =>'Successfull','document' => $document, 'department' => $department,'document_owner' => $document_owner);
        }
        else{
        $response = array('status_code' => '1', 'message'=>'Campaign does not Exist');
        }
        return $response;
    }

    function is_unit_exist($unit){
        $response = array("status_code" => "0" , "message" => "Users not found");
        $query = $this->db->query("select unit from units where unit = '$unit'")->result_array();
        if ( sizeof($query ) > 0){
            $response = array("status_code" => "1" , "message" => "Unit already exist");  
        }
        return $response;
    }

    function is_password_exist($email,$old_password,$user_type_id){
        $response = array("status_code" => "0" , "message" => "pass  not found");
        $query = $this->db->query("select password from user_accounts where email = '$email' and password = '$old_password' and user_type_id = '$user_type_id'")->result_array();
        if ( sizeof($query ) > 0){
            $response = array("status_code" => "1" , "message" => "pass already exist");  
        }
        return $response;
    }


    


    public function is_department_exist($department){
        $response = array("status_code" => "0" , "message" => "Department name not found");
        $query = $this->db->query("select department from departments where department = '$department'")->result_array();
        if ( sizeof($query ) > 0){
            $response = array("status_code" => "1" , "message" => "Such Department name already exist, Kindly choose another name");  
        }
        return $response;
    }


    function is_document_exist($document_type){
        $response = array("status_code" => "0" , "message" => "Users not found");
        $query = $this->db->query("select document_type from document_types where document_type = '$document_type'")->result_array();
        if ( sizeof($query ) > 0){
            $response = array("status_code" => "1" , "message" => "Unit already exist");  
        }
        return $response;
    }
   
   
    public function super_admin_types(){
        $sqlQuery =$this->db->query("SELECT user_type_id, user_type from user_types where user_type_id != '1'")->result();
        $response = array('status_code' => '0',  'result' => $sqlQuery);
        return $response;
    }
     
    public function admin_types(){
        $sqlQuery =$this->db->query("SELECT user_type_id, user_type from user_types where user_type_id not in ( '1', '2')")->result();
        $response = array('status_code' => '0',  'result' => $sqlQuery);
        return $response;
    }

    public function department(){
        $sqlQuery =$this->db->query('SELECT department_id, department from departments')->result();
        $response = array('status_code' => '0',  'result' => $sqlQuery);
        return $response;
    }

    public function document_counts(){
        $sqlQuery =$this->db->query("SELECT a.document_owner , a.create_by, COUNT(a.create_by)txn_count, d.department , a.email
        FROM document_logs a INNER JOIN units b ON a.unit_id = b.unit_id INNER JOIN document_types c ON a.document_id = c.document_id INNER JOIN departments d
        ON a.department_id = d.department_id  GROUP BY  a.document_owner,d.department, a.email,a.create_by")->result();
        $response = array('status_code' => '0',  'result' => $sqlQuery);
        return $response;
    }
    public function unit(){
        $sqlQuery =$this->db->query('SELECT unit_id, unit from units')->result();
        $response = array('status_code' => '0',  'result' => $sqlQuery);
        return $response;
    }
    public function document(){
        $sqlQuery =$this->db->query('SELECT document_id, document_type from document_types')->result();
        $response = array('status_code' => '0',  'result' => $sqlQuery);
        return $response;
    }
    public function user_view_lists($document_name){
        $sqlQuery = "SELECT a.id,a.email, a.ref_id,CONCAT(b.firstname, ' ', b.lastname) AS full_name , document_name, url, action_perform, a.inserted_dt FROM user_views a, user_accounts b
        WHERE a.ref_id = b.ref_id";
        
        if ($document_name != "") {
            
            $sqlQuery .= " AND document_name = '$document_name'";
            
        }else{
            $sqlQuery =  $sqlQuery;
        }
        
        $result = $this->db->query($sqlQuery)->result();
        
        $response = array('status_code' => '0', 'result' => $result);
        return $response;
    }
    
    

    //For Random Key 
    function get_operation_id($type){
        $value =  date('YmdHis');
        if($type == "NU"){
          $value = $value.$this->random_number(10);
        }elseif($type == "AN"){
          $value = $value.$this->random_alphanumeric(10);
        }elseIf($type == "AL"){
          $value = $value.$this->random_alphabet(10);
        }
        return $value;
      }

      function random_alphanumeric($maxlength = 17) {
        $chart = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                         "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N" , "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $return_str = "";
        for ( $x=0; $x<=$maxlength; $x++ ) {
            $return_str .= $chart[rand(0, count($chart)-1)];
        }
        return $return_str;
    }
    function random_alphabet($maxlength = 17) {
        $chart = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                       "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N" , "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $return_str = "";
        for ( $x=0; $x<=$maxlength; $x++ ) {
            $return_str .= $chart[rand(0, count($chart)-1)];
        }
        return $return_str;
      }
      function random_number($maxlength = 17) {
        $chart = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $return_str = "";
        for ( $x=0; $x<=$maxlength; $x++ ) {
            $return_str .= $chart[rand(0, count($chart)-1)];
        }
        return $return_str;
      }
      
      public function create_super_admin($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name,$create_by){
        $dt = date('Y-m-d H:i:s');
        $ref_id = $this->get_operation_id('NU');
        $response = array();
        $query1 = "INSERT into user_accounts( ref_id,email,firstname,lastname,password,phonenumber,user_name,user_type_id,inserted_dt,create_by,status,department_id,unit_id)
                    VALUES ('$ref_id','$email','$firstname','$lastname','$password','$phonenumber','$user_name', '$user_type_id','$dt','$create_by','0','','')";

        $this->db->query($query1);
        $this->db->trans_commit();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response =   array('status_code' => '1','message' => "User Account Creation Unsuccessful");
        } else {
            $this->db->trans_commit();
             $response =  array('status_code' => '0' ,'message' => 'User Account Creation Successful');
             $message_content ='Congratulations on taking your first step to share goodness and benfit humanity through mosquepay.
             You can start by creating a campaign and updating your other account details. <br> To ask islamic related questions, please check out our Ask A Sheikh section
             <br> <b>Thanks for joining the family that shares goodness globally</b>';
            $subject = 'Welcome to MosquePay';
            $this->sendgrid($email,$user_name,$subject,$message_content);
        }
        return $response;
      }

      public function create_super_super_admin($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name){
        $dt = date('Y-m-d H:i:s');
        $ref_id = $this->get_operation_id('NU');
        $create_by =   $ref_id ;
        $response = array();
        $query1 = "INSERT into user_accounts( ref_id,email,firstname,lastname,password,phonenumber,user_name,user_type_id,inserted_dt,create_by,status,department_id,unit_id)
                    VALUES ('$ref_id','$email','$firstname','$lastname','$password','$phonenumber','$user_name', '$user_type_id','$dt','$create_by','0','','')";

        $this->db->query($query1);
        $this->db->trans_commit();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response =   array('status_code' => '1','message' => "User Account Creation Unsuccessful");
        } else {
            $this->db->trans_commit();
             $response =  array('status_code' => '0' ,'message' => 'User Account Creation Successful');
             $message_content ='Congratulations on taking your first step to share goodness and benfit humanity through mosquepay.
             You can start by creating a campaign and updating your other account details. <br> To ask islamic related questions, please check out our Ask A Sheikh section
             <br> <b>Thanks for joining the family that shares goodness globally</b>';
            $subject = 'Welcome to MosquePay';
            $this->sendgrid($email,$user_name,$subject,$message_content);
        }
        return $response;
      }

      public function create_admin_user($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name,$create_by,$department_id){
        $dt = date('Y-m-d H:i:s');
        $ref_id = $this->get_operation_id('NU');
        $response = array();
        $query1 = "INSERT into user_accounts( ref_id,email,firstname,lastname,password,phonenumber,user_name,user_type_id,inserted_dt,create_by,status,department_id,unit_id)
                    VALUES ('$ref_id','$email','$firstname','$lastname','$password','$phonenumber','$user_name', '$user_type_id','$dt','$create_by','0', '$department_id','')";

        $this->db->query($query1);
        $this->db->trans_commit();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response =   array('status_code' => '1','message' => "User Account Creation Unsuccessful");
        } else {
            $this->db->trans_commit();
             $response =  array('status_code' => '0' ,'message' => 'User Account Creation Successful');
             $message_content ='Congratulations on taking your first step to share goodness and benfit humanity through mosquepay.
             You can start by creating a campaign and updating your other account details. <br> To ask islamic related questions, please check out our Ask A Sheikh section
             <b r> <b>Thanks for joining the family that shares goodness globally</b>';
            $subject = 'Welcome to MosquePay';
            $this->sendgrid($email,$user_name,$subject,$message_content);
        }
        return $response;
      }

      public function create_user($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name,$create_by,$department_id,$unit_id){
        $dt = date('Y-m-d H:i:s');
        $ref_id = $this->get_operation_id('NU');
        $response = array();
        $query1 = "INSERT into user_accounts( ref_id,email,firstname,lastname,password,phonenumber,user_name,user_type_id,inserted_dt,create_by,status,department_id,unit_id)
                    VALUES ('$ref_id','$email','$firstname','$lastname','$password','$phonenumber','$user_name', '$user_type_id','$dt','$create_by','0','$department_id','$unit_id')";

        $this->db->query($query1);
        $this->db->trans_commit();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response =   array('status_code' => '1','message' => "User Account Creation Unsuccessful");
        } else {
            $this->db->trans_commit();
             $response =  array('status_code' => '0' ,'message' => 'User Account Creation Successful');
             $message_content ='Congratulations on taking your first step to share goodness and benfit humanity through mosquepay.
             You can start by creating a campaign and updating your other account details. <br> To ask islamic related questions, please check out our Ask A Sheikh section
             <br> <b>Thanks for joining the family that shares goodness globally</b>';
            $subject = 'Welcome to MosquePay';
            $this->sendgrid($email,$user_name,$subject,$message_content);
        }
        return $response;
      }
    
      public function  create_document($document_owner,$document_id,$email,$phonenumber,$department_id,$unit_id,$image,$purpose,$create_by){
        $dt = date('Y-m-d H:i:s');
        $ref_id = $this->get_operation_id('NU');
        $response = array();
        $query1 = "INSERT into document_logs(ref_id ,document_owner,document_id,department_id,unit_id,email,phonenumber,image,create_by,purpose,uploaded_dt,status)
                    VALUES ('$ref_id ','$document_owner','$document_id','$department_id','$unit_id','$email','$phonenumber','$image','$create_by','$purpose','$dt','0')";

        $this->db->query($query1);
        $this->db->trans_commit();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response =   array('status_code' => '1','message' => "User Document Creation Unsuccessful");
        } else {
            $this->db->trans_commit();
             $response =  array('status_code' => '0' ,'message' => 'User Document Creation Successful');

        }
        return $response;
      }

      public function deleteImageFromDatabase($image) {
        $query = $this->db->query("select image from document_logs where image = '$image'")->result_array();
        if ( sizeof($query ) > 0){
            $query1 ="DELETE FROM document_logs WHERE image='$image'";
            $this->db->query($query1);
            $this->db->trans_commit();
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $response =   array('status_code' => '1','message' => "Image deleted  Unsuccessful");
            } else {
                $this->db->trans_commit();
                 $response =  array('status_code' => '0' ,'message' =>'Image deleted Successful' );
    
            }
              
        }else{
            $response = array("status_code" => "1" , "message" => 'Image does not exist');
        }
        return $response;
    }

    public function get_document($document_id,$document_type,$description){
       // $insert_dt = date('Y-m-d H:i:s');
       $document_id = sprintf('%04d', rand(1, 9999));
        $response = array();
        $query1 = "INSERT into document_types(document_id,document_type,description)
                    VALUES ('$document_id','$document_type','$description')";

        $this->db->query($query1);
        $this->db->trans_commit();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response =   array('status_code' => '1','message' => "Document  Creation Unsuccessful");
        } else {
            $this->db->trans_commit();
             $response =  array('status_code' => '0' ,'message' => 'Document Creation Successful');
        }
        return $response;
    }

    public function get_department($department_id,$department,$description){
         $response = array();
         $query1 = "INSERT into departments(department_id,department,description)
                     VALUES ('$department_id','$department','$description')";
 
         $this->db->query($query1);
         $this->db->trans_commit();
 
         if ($this->db->trans_status() === FALSE){
             $this->db->trans_rollback();
             $response =   array('status_code' => '1','message' => "Department  Creation Unsuccessful");
         } else {
             $this->db->trans_commit();
              $response =  array('status_code' => '0' ,'message' => 'Department Creation Successful');
         }
         return $response;
    }

    public function create_user_view($email,$ref_id,$document_name,$url,$action,$inserted_dt){
        $response = array();
        $query1 = "INSERT into user_views(email,ref_id,document_name,url,action_perform,inserted_dt)
                    VALUES ('$email','$ref_id','$document_name','$url','$action','$inserted_dt')";

        $this->db->query($query1);
        $this->db->trans_commit();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response =   array('status_code' => '1','message' => "User view  Creation Unsuccessful");
        } else {
            $this->db->trans_commit();
             $response =  array('status_code' => '0' ,'message' => 'User view  Creation Successful');
        }
        return $response;
   }

    
    public function get_unit( $department_id,$unit_id,$unit,$description){
        // $insert_dt = date('Y-m-d H:i:s');
         $response = array();
         $query1 = "INSERT into units(department_id,unit_id,unit,description)
                     VALUES ('$department_id','$unit_id','$unit','$description')";
 
         $this->db->query($query1);
         $this->db->trans_commit();
 
         if ($this->db->trans_status() === FALSE){
             $this->db->trans_rollback();
             $response =   array('status_code' => '1','message' => "Unit  Creation Unsuccessful");
         } else {
             $this->db->trans_commit();
              $response =  array('status_code' => '0' ,'message' => 'Unit Creation Successful');
         }
         return $response;
    }
    public function get_pass($email,$user_type_id,$new_password){
         $response = array();
         $query1 = "UPDATE user_accounts SET password='$new_password'WHERE email = '$email' AND user_type_id = '$user_type_id'";
 
         $this->db->query($query1);
         $this->db->trans_commit();
 
         if ($this->db->trans_status() === FALSE){
             $this->db->trans_rollback();
             $response =   array('status_code' => '1','message' => "it was not updated Uunsuccessful");
         } else {
             $this->db->trans_commit();
              $response =  array('status_code' => '0' ,'message' => 'It was update successful');
         }
         return $response;
    }

    public function user_login($email, $password)
    {
        $query1 = $this ->db ->query("SELECT email , password from user_accounts WHERE email='$email' AND password='$password'")->result();
        $query2 = $this ->db ->query("SELECT ref_id,email ,firstname,lastname,phonenumber, user_name, user_type_id, inserted_dt, create_by,
        STATUS, a.department_id ,a.unit_id, c.department,b.unit  FROM user_accounts a
        LEFT JOIN  units b 
        ON a.unit_id = b.unit_id
        LEFT JOIN departments c
        ON a.department_id = c.department_id
        WHERE  email='$email'AND STATUS = '0'")->result();
    
        if(count($query1) > 0){
            $response =   array('status_code' => '0','message' => "Login Successful", 'user_details' => $query2);
        }
        else{
            $response =   array('status_code' => '1','message' => "Incorrect User details");
        }
        return $response;
    }



    public function update_department($department_id,$department,$description){
        // $dt = date('Y-m-d H:i:s');
    
        $query = "UPDATE departments SET department= '$department', description ='$description'
        WHERE department_id = '$department_id'";

          $this->db->query($query);
          $this->db->trans_commit();

          if ($this->db->trans_status() === FALSE){
              $this->db->trans_rollback();
              $response =   array('status_code' => '1','message' => 'Department Name cannot be updated');
          } else {
              $this->db->trans_commit();
              $response =  array('status_code' => '0' ,'message' => 'Department Name updated succesful');
          }
          return $response;
    }

    public function update_document($document_id,$document_type,$description){
        // $dt = date('Y-m-d H:i:s');
    
        $query = "UPDATE document_types SET document_type= '$document_type', description ='$description'
        WHERE document_id = '$document_id'";

          $this->db->query($query);
          $this->db->trans_commit();

          if ($this->db->trans_status() === FALSE){
              $this->db->trans_rollback();
              $response =   array('status_code' => '1','message' => 'Document Name cannot be updated');
          } else {
              $this->db->trans_commit();
              $response =  array('status_code' => '0' ,'message' => 'Document Name updated succesful');
          }
          return $response;
    }

    public function update_unit($unit_id,$department_id,$unit,$description){
        // $dt = date('Y-m-d H:i:s');
    
        $query = "UPDATE units SET department_id='$department_id', unit= '$unit', description ='$description'
        WHERE unit_id = '$unit_id'";

          $this->db->query($query);
          $this->db->trans_commit();

          if ($this->db->trans_status() === FALSE){
              $this->db->trans_rollback();
              $response =   array('status_code' => '1','message' => 'Unit cannot be updated');
          } else {
              $this->db->trans_commit();
              $response =  array('status_code' => '0' ,'message' => 'Unit updated succesful');
          }
          return $response;
    }

    public function document_details($create_by,$email){
        $query = "SELECT  f.user_name,a.document_owner, a.create_by , c.document_type , d.department , b.unit, a.purpose , a.email,a.image , a.uploaded_dt, a.phonenumber , a.status
        FROM document_logs a LEFT JOIN units b ON a.unit_id = b.unit_id RIGHT JOIN document_types c ON a.document_id = c.document_id INNER JOIN departments d
        ON a.department_id = d.department_id  INNER JOIN user_accounts f  ON f.ref_id = a.create_by";
        if($create_by == ""){
                    $query = $query ;
                    
        }else{
                   $query = $query ." WHERE a.create_by = '$create_by'AND a.email = '$email'";   
        }
        $result = $this->db->query($query)->result();
        $response = array('status_code' => 0, 'message'=>'Successful', 'result' => $result);
        return $response;
    }

    public function get_document_details_by_id($document_id){
        $query = "SELECT  a.document_id,a.document_owner , c.document_type , d.department , b.unit, a.purpose , a.email,a.image , a.uploaded_dt, a.phonenumber , a.status
        FROM document_logs a LEFT JOIN units b ON a.unit_id = b.unit_id RIGHT JOIN document_types c ON a.document_id = c.document_id INNER JOIN departments d
        ON a.department_id = d.department_id";
        if($document_id == ""){
                    $query = $query ;
                    
        }else{
                   $query = $query ." WHERE a.document_id = '$document_id'";   
        }
        $result = $this->db->query($query)->result();
        $response = array('status_code' => 0, 'message'=>'Successful', 'result' => $result);
        return $response;
    }

    public function document_type_details(){
        $query = "SELECT document_id,document_type, description FROM document_types";
        $result = $this->db->query($query)->result();
        $response = array('status_code' => 0, 'message'=>'Successful', 'result' => $result);
        return $response;
    }

    public function unit_details($department_id){
        $query = "SELECT a.department_id ,a.unit_id , department, a.unit, a.description FROM units a LEFT JOIN departments b ON a.department_id = b.department_id";
        if($department_id == ""){
            $query = $query ;
            
         }else{
           $query = $query ." WHERE a.department_id = '$department_id'";   
}
        $result = $this->db->query($query)->result();
        $response = array('status_code' => 0, 'message'=>'Successful', 'result' => $result);
        return $response;
    }


    public function department_details(){
        $query = "SELECT department_id,department, description FROM departments";
        $result = $this->db->query($query)->result();
        $response = array('status_code' => 0, 'message'=>'Successful', 'result' => $result);
        return $response;
    }
    function is_user_image_exist($profile_img){
        $response = array('status_code'=>'0', 'message'=>'Campaign Image not found');

        $sqlQuery = $this->db->query("select user_image from user_accounts where user_image = '$profile_img'") ->result_array();
        if (sizeof($sqlQuery)>0) {
                        $response = array('status_code' => '1', 'message' => 'Image File Name Exist, Kindly rename your file or choose another ');
        }
        return $response;
    }

    public function generate_token($email,$user_type_id){
         $token = $this->random_alphanumeric(6);   
         $user_name = explode('@', $email)[0];
         $encode_token =md5($token);
         $dt = date('Y-m-d H:i:s');
         $this->db->query("INSERT into token_managers(email,token,operation_type,token1,inserted_dt) 
          VALUES('$email','$encode_token','$user_type_id','$token','$dt')");   
        
    
        $message_content = 'You have requested to reset your password for your MosquePay account. To reset your password, please click the following link:
            <a href="https://docmanage.mosquepay.org/forgotPassword/' . $encode_token . '?email=' . $email . '&user_type_id=' .$user_type_id .'">Your Link Text</a>
              
              If you did not request this password reset, you can safely ignore this message. Your password will not be changed unless you click the link above.
              
              Thank you for using MosquePay!';
           $subject = 'Rest Password';
          $this->sendgrid($email,$user_name,$subject,$message_content);
           return array('status_code' => '0', 'message'=>'Successful', 'message' => "Token Generated Successfully");
    
    }

    public function get_current_datetime(){
        return date('Y-m-d H:i:s');
    }

    
  public function confirm_token($email , $token, $user_type_id ){

    $response = array();
  // $token = strtoupper(hash('SHA512' , $token));
   $response = array('status_code' =>  '1' , 'message' => 'Token Invalid.');

   $result = $this->db->query("select inserted_dt con from token_managers where email = '$email' and  token = '$token' and operation_type = '$user_type_id' order by id desc limit 1")->result_array();

   if (sizeof($result) > 0){
   $close_at = new DateTime($result[0]['con']);
   $cdate = new DateTime($this->get_current_datetime());
   $interval = $close_at->diff($cdate);
   // return $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
     if(($interval->format('%y') > 0) || ($interval->format('%m') > 0)|| ($interval->format('%a') > 0) || ($interval->format('%h') > 0)){
       $response = array('status_code' =>  '1' , 'message' => 'Token Expired');
     }else{
        if ($interval->format('%i') <= 5){
        $response = array('status_code' =>  '0' , 'message' => 'Successful');
        }
      }        
   }else{    
     $response = array('status_code' =>  '1' , 'message' => 'Token Invalid');    
   }    
  return $response;
  }

    public function  forget_password($email, $password, $user_type_id ){
        $password = md5($password);
        $response =TRUE;
          $this->db->query("update user_accounts set password='$password'  where email = '$email'AND user_type_id ='$user_type_id' ");
        $db_error = $this->db->error();
        if( $db_error['message'] != ""){
         
          $response =FALSE;
          
        }
        return $response;
    
       }

       public function sendgrid($user_email,$user_name,$subject,$message_content){
        $message = "Hi ".$user_name.",

              ".$message_content."
             ";
     $this->load->library('email');
     $this->email->initialize(array(
     'protocol' => 'smtp',
     'smtp_host' => 'smtp.sendgrid.net',
     'smtp_user' => 'apikey',
     'smtp_pass' => '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',
     'smtp_port' => 587,
     'crlf' => "\r\n",
     'newline' => "\n"
     ));
   
     $this->email->from('support@mosquepay.org', 'Mosquepay');
     $this->email->to($user_email);
     // $this->email->cc('another@another-example.com');
     // $this->email->bcc('them@their-example.com');
     $this->email->subject($subject);
     $this->email->message($message);
     $this->email->send();

     }

public function sendgrids($user_email,$user_name,$subject,$message_content){
        // print_r($subject); 
        // print_r($message_content);
        // print_r($user_email);
        // die;
        $message = "Hi ".$user_name.",

              ".$message_content."
             
             ";
     $this->load->library('email');
     $this->email->initialize(array(
     'protocol' => 'smtp',
     'smtp_host' => 'smtp.sendgrid.net',
     'smtp_user' => 'apikey',
     'smtp_pass' => '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',
     'smtp_port' => 587,
     'crlf' => "\r\n",
     'newline' => "\n"
     ));
   
     $this->email->from('support@mosquepay.org', 'Mosquepay');
     $this->email->to($user_email);
 
     // $this->email->cc('another@another-example.com');
     // $this->email->bcc('them@their-example.com');
     $this->email->subject($subject);
     $this->email->message($message);
     $this->email->send();
     }

     public function sendgridss($user_email, $user_name, $subject, $message_content) {
        $message = "Hi " . $user_name . ",
        
    " . $message_content . "
        
    ";
        $this->load->library('email');
        $this->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_user' => 'apikey',
            'smtp_pass' => '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',
            'smtp_port' => 587,
            'crlf' => "\r\n",
            'newline' => "\n"
        ));
    
        $this->email->from('support@mosquepay.org', 'Mosquepay');
        $this->email->to($user_email);
        print_r($this->email->to($user_email)); die;
        $this->email->subject($subject);
        $this->email->message($message);
    
        // Enable SMTP debugging for debugging purposes
        $this->email->smtp_debug = 2;
    
        try {
            $this->email->send();
            echo'bbbbb';
        } catch (Exception $e) {
        echo 'ddddd';
        }
    }



}