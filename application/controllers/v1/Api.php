<?php
use Restserver\Libraries\REST_Controller;

require_once APPPATH . 'controllers/v1/Utility.php'; 
require_once("application/libraries/Format.php");
require(APPPATH.'/libraries/REST_Controller.php');

//

class Api extends REST_Controller {

    function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	    header('Access-Control-Allow-Headers: Content-Type, x-api-key');
        header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Origin: *');
	   	if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		  	die();
			}
    }



    public function super_super_admin_account_creation_post() {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phonenumber = $this->input->post('phonenumber');
        $password = $this->input->post('password');
        $user_name = $this->input->post('user_name');
        $user_type_id = '4';
        
        // Check if each input is set and not null before trimming
        if ($firstname !== null) {
            $firstname = ucfirst(trim($firstname));
        }
        if ($lastname !== null) {
            $lastname = ucfirst(trim($lastname));
        }
        if ($email !== null) {
            $email = trim($email);
        }
        if ($phonenumber !== null) {
            $phonenumber = trim($phonenumber);
        }
        if ($password !== null) {
            $password = md5(trim($password));
        }
        if ($user_name !== null) {
            $user_name = ucfirst(trim($user_name));
        }
        
        $randomNumber = sprintf('%04d', rand(1, 9999));
    
        if (empty($firstname) || empty($lastname)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide Firstname or Lastname'));
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid email address'));
        }
        
        if (empty($phonenumber)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid Phone Number'));
        }
        
        if (empty($password)) {
            $this->response(array('status_code' => '1', 'message' => 'Password cannot be empty'));
        }
    
        if (empty($user_name)) {
            $user_name = $firstname . ' ' . $lastname;
        }
        $utility = new Utility();
        $check_user = $utility->is_user_exist($email, $user_type_id);
         if( $check_user['status_code'] != '0'){
            $this->response(array('status_code'=>$check_user['status_code'] ,  'message'=>$check_user['message']));
        }
       try {

         return  $this->response($utility->create_super_super_admin($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name));

       } catch (Exception $e) {
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
   }   
    }

    public function super_admin_account_creation_post() {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phonenumber = $this->input->post('phonenumber');
        $password = $this->input->post('password');
        $user_name = $this->input->post('user_name');
        $create_by = $this->input->post('create_by');
        $user_type_id = '1';
        
        // Check if each input is set and not null before trimming
        if ($firstname !== null) {
            $firstname = ucfirst(trim($firstname));
        }
        if ($lastname !== null) {
            $lastname = ucfirst(trim($lastname));
        }
        if ($email !== null) {
            $email = trim($email);
        }
        if ($phonenumber !== null) {
            $phonenumber = trim($phonenumber);
        }
        if ($password !== null) {
            $password = md5(trim($password));
        }
        if ($user_name !== null) {
            $user_name = ucfirst(trim($user_name));
        }
        if ($create_by !== null) {
            $create_by = trim($create_by);
        }
        
        $randomNumber = sprintf('%04d', rand(1, 9999));
    
        if (empty($firstname) || empty($lastname)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide Firstname or Lastname'));
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid email address'));
        }
        
        if (empty($phonenumber)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid Phone Number'));
        }
        
        if (empty($password)) {
            $this->response(array('status_code' => '1', 'message' => 'Password cannot be empty'));
        }

        if (empty($create_by)) {
            $this->response(array('status_code' => '1', 'message' => 'Create by cannot be empty'));
        }

        if (empty($user_name)) {
            $user_name = $firstname . ' ' . $lastname;
        }
        $utility = new Utility();
        $check_user = $utility->is_user_exist($email, $user_type_id);
         if( $check_user['status_code'] != '0'){
            $this->response(array('status_code'=>$check_user['status_code'] ,  'message'=>$check_user['message']));
        }
       try {

         return  $this->response($utility->create_super_admin($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name,$create_by));

       } catch (Exception $e) {
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
   }   
    }

    public function admin_user_creation_post() {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phonenumber = $this->input->post('phonenumber');
        $password = $this->input->post('password');
        $user_name = $this->input->post('user_name');
        $user_type_id = $this->input->post('user_type_id');
        $department_id = $this->input->post('department_id');
        $create_by = $this->input->post('create_by');
        
        // Check if each input is set and not null before trimming
        if ($firstname !== null) {
            $firstname = ucfirst(trim($firstname));
        }
        if ($lastname !== null) {
            $lastname = ucfirst(trim($lastname));
        }
        if ($email !== null) {
            $email = trim($email);
        }
        if ($phonenumber !== null) {
            $phonenumber = trim($phonenumber);
        }
        if ($password !== null) {
            $password = md5(trim($password));
        }
        if ($user_name !== null) {
            $user_name = ucfirst(trim($user_name));
        }
        if ($user_type_id !== null) {
            $user_type_id = trim($user_type_id);
        }
        if ($department_id !== null) {
            $department_id = trim($department_id);
        }
        if ($create_by !== null) {
            $create_by = trim($create_by);
        }
        $randomNumber = sprintf('%04d', rand(1, 9999));
    
        if (empty($firstname) || empty($lastname)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide Firstname or Lastname'));
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid email address'));
        }
        
        if (empty($phonenumber)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid Phone Number'));
        }
        
        if (empty($password)) {
            $this->response(array('status_code' => '1', 'message' => 'Password cannot be empty'));
        }
        
        if (empty($user_type_id) ) {
            $this->response(array('status_code' => '1', 'message' => 'User type id  cannot be empty'));
        }
        if (empty($department_id) ) {
            $this->response(array('status_code' => '1', 'message' => 'Department id cannot be empty'));
        }
        if ($user_type_id == '1' ) {
            $this->response(array('status_code' => '1', 'message' => 'User type id  cannot be 1'));
        }
    
        if (empty($create_by)) {
            $this->response(array('status_code' => '1', 'message' => 'Create by cannot be empty'));
        }
    
        if (empty($user_name)) {
            $user_name = $firstname . ' ' . $lastname;
        }
        $utility = new Utility();
        $check_user = $utility->is_user_exist($email, $user_type_id);
         if( $check_user['status_code'] != '0'){
            $this->response(array('status_code'=>$check_user['status_code'] ,  'message'=>$check_user['message']));
        }
       try {

         return  $this->response($utility->create_admin_user($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name,$create_by,$department_id));

       } catch (Exception $e) {
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
   }   
    }

    public function user_creation_post() {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phonenumber = $this->input->post('phonenumber');
        $password = $this->input->post('password');
        $user_name = $this->input->post('user_name');
        $user_type_id = $this->input->post('user_type_id');
        $department_id = $this->input->post('department_id');
        $unit_id = $this->input->post('unit');
        $create_by = $this->input->post('create_by');
        
        // Check if each input is set and not null before trimming
        if ($firstname !== null) {
            $firstname = ucfirst(trim($firstname));
        }
        if ($lastname !== null) {
            $lastname = ucfirst(trim($lastname));
        }
        if ($email !== null) {
            $email = trim($email);
        }
        if ($phonenumber !== null) {
            $phonenumber = trim($phonenumber);
        }
        if ($password !== null) {
            $password = md5(trim($password));
        }
        if ($user_name !== null) {
            $user_name = ucfirst(trim($user_name));
        }
        if ($user_type_id !== null) {
            $user_type_id = trim($user_type_id);
        }
        if ($department_id !== null) {
            $department_id = trim($department_id);
        }
        if ($unit_id !== null) {
            $unit_id = trim($unit_id);
        }
        if ($create_by !== null) {
            $create_by = trim($create_by);
        }

        $randomNumber = sprintf('%04d', rand(1, 9999));
    
        if (empty($firstname) || empty($lastname)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide Firstname or Lastname'));
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid email address'));
        }
        
        if (empty($phonenumber)) {
            $this->response(array('status_code' => '1', 'message' => 'Provide a valid Phone Number'));
        }
        
        if (empty($password)) {
            $this->response(array('status_code' => '1', 'message' => 'Password cannot be empty'));
        }
        
        if (empty($user_type_id)) {
            $this->response(array('status_code' => '1', 'message' => 'User type id  cannot be empty'));
        }
        if (empty($department_id)) {
            $this->response(array('status_code' => '1', 'message' => 'Department id cannot be empty'));
        }
        if (empty($unit_id)) {
            $this->response(array('status_code' => '1', 'message' => 'Unit id cannot be empty'));
        }
        if ($user_type_id == '1' ) {
            $this->response(array('status_code' => '1', 'message' => 'User type id  cannot be 1 '));
        }
        if ($user_type_id == '2' ) {
            $this->response(array('status_code' => '1', 'message' => 'User type id  cannot be 2 '));
        }
        if (empty($create_by)) {
            $this->response(array('status_code' => '1', 'message' => 'User Create by cannot be empty'));
        }
    
        // if ($user_type_id == '3') {
        //     $create_by = $create_by;
        //     //$create_by = empty($create_by) ? $firstname.$lastname.$randomNumber :$create_by;
        // }
    
        if (empty($user_name)) {
            $user_name = $firstname . ' ' . $lastname;
        }
        $utility = new Utility();
        $check_user = $utility->is_user_exist($email, $user_type_id);
         if( $check_user['status_code'] != '0'){
            $this->response(array('status_code'=>$check_user['status_code'] ,  'message'=>$check_user['message']));
        }
       try {

         return  $this->response($utility->create_user($firstname,$lastname,$email,$phonenumber,$password,$user_type_id,$user_name,$create_by,$department_id,$unit_id));

       } catch (Exception $e) {
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
   }   
    }


    public function user_document_creation_post()
{
    $document_owner = $this->input->post('document_owner');
    $document_id = $this->input->post('document_id');
    $email = $this->input->post('email');
    $department_id = trim($this->input->post('department_id'));
    $phonenumber = trim($this->input->post('phonenumber'));
    $unit_id = trim($this->input->post('unit_id'));
    $create_by = $this->input->post('create_by');
    $purpose = ucfirst(trim($this->input->post('purpose')));

    if ($document_owner !== null) {
        $document_owner = ucfirst(trim($document_owner));
    }
    if ($document_id !== null) {
        $document_id = trim($document_id);
    }
    if ($department_id !== null) {
        $department_id = trim($department_id);
    }
    if ($phonenumber !== null) {
        $phonenumber = trim($phonenumber);
    }
    if ($email !== null) {
        $email = trim($email);
    }
    if ($create_by !== null) {
        $create_by = trim($create_by);
    }

    // Validate input fields
    if (empty($document_owner)) {
        $this->response(array('status_code' => '1', 'message' => 'Document Owner cannot be empty'));
    }
    if (empty($email)) {
        $this->response(array('status_code' => '1', 'message' => 'Email cannot be empty'));
    }
    if (empty($phonenumber)) {
        $this->response(array('status_code' => '1', 'message' => 'Phonenumber cannot be empty'));
    }
    if (empty($unit_id)) {
        $this->response(array('status_code' => '1', 'message' => 'Unit id cannot be empty'));
    }
    if (empty($purpose)) {
        $this->response(array('status_code' => '1', 'message' => 'Purpose cannot be empty'));
    }
    if (empty($create_by)) {
        $this->response(array('status_code' => '1', 'message' => 'Create by cannot be empty'));
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->response(array('status_code' => '1', 'message' => 'Provide a valid email address'));
    }

    // Handle image upload
    if (empty($_FILES['image']['name'])) {
        $this->response(array('status_code' => '1', 'message' => 'Image cannot be empty'));
    }

    $config['upload_path'] = 'assets/img/useraccount/';
    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|zip|csv';
    $config['file_name'] = $_FILES['image']['name'];
    $config['overwrite'] = TRUE;
    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
        $image = $this->upload->data('file_name');
    } else {
        $this->response(array('status_code' => '1', 'message' => $this->upload->display_errors()));
    }

    $utility = new Utility();
    $check_image = $utility->is_image_exist($image);
    if ($check_image['status_code'] !== '0') {
        $this->response(array('status_code' => $check_image['status_code'], 'message' => $check_image['message']));
    }

    try {
        $response = $utility->create_document($document_owner, $document_id, $email, $phonenumber, $department_id, $unit_id, $image, $purpose, $create_by);

        $this->response($response);
    } catch (Exception $e) {
        $this->response(array('status_code' => '1', 'message' => 'Registration error ' . $e->getMessage()));
    }
}

    
    public function document_counts_list_get(){
        $utility = new Utility();
        return $this->response( $utility->document_details_list());
    }
    

    public function get_user_type_by_super_admin_get(){
        $utility = new Utility();
        return $this->response( $utility->super_admin_types());

    }

    public function get_user_type_by_admin_get(){
        $utility = new Utility();
        return $this->response( $utility->admin_types());

    }

    public function department_get(){
        $utility = new Utility();
        return $this->response( $utility->department());
    }

    public function document_count_get(){
        $utility = new Utility();
        return $this->response( $utility->document_counts());
    }

    public function unit_get(){
        $utility = new Utility();
        return $this->response( $utility->unit());
    }

    public function document_get(){
        $utility = new Utility();
        return $this->response( $utility->document());
    }
    public function user_veiw_list_get(){
        $document_name = $this->input->get('document_name');
        $utility = new Utility();
        return $this->response( $utility->user_view_lists($document_name));
    }

    public function user_login_post(){
        $email = trim($this->input->post('email'));
        $password = md5($this->input->post('password'));
        if($email == ''){
            $this->response(array('status_code'=>'1',  'message'=>'Provide correct email address'));
        }
     

        $utility = new Utility();
        try { 
            $response = $utility->user_login($email,$password); 
           
            $this->response($response);
            
         } catch (Exception $e) {
              $this->response(array('status_code' => '1' ,'message' =>' Login Error '.$e->getMessage()));
       
          }
    }

    public function update_pass_post(){
        $email = $this->input->post('email');
        $user_type_id = $this->input->post('user_type_id'); 
        $old_password = md5($this->input->post('old_password')); 
        $new_password = $this->input->post('new_password');

        if ($email !== null) {
            $email = ucfirst(trim($email));
        }
        if ($user_type_id !== null) {
            $user_type_id = trim($user_type_id);
        }
        if ($old_password !== null) {
            $old_password= trim($old_password);
        }
        if ($new_password !== null) {
            $new_password = md5(trim($new_password));
        }
        if (empty($email)) {
            $this->response(array('status_code' => '1', 'message' => 'Email  cannot be empty'));
        }
        
        if (empty($user_type_id)) {
            $this->response(array('status_code' => '1', 'message' => 'User Type Id cannot be empty'));
        }
        
        if (empty($old_password)) {
            $this->response(array('status_code' => '1', 'message' => 'Old Password  cannot be empty'));
        }
        if (empty($new_password)) {
            $this->response(array('status_code' => '1', 'message' => 'New Password  cannot be empty'));
        }
        $utility = new Utility();
 
        $check_password = $utility->is_password_exist($email,$old_password,$user_type_id);
        if( $check_password['status_code'] != '1'){
           $this->response(array('status_code'=>$check_password['status_code'] , 'message'=>$check_password['message']));
         }
         try {

            return  $this->response($utility->get_pass($email,$user_type_id,$new_password));
   
          } catch (Exception $e) {
            //echo $e->getMessage();
            // die();
          $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
      } 
    }


    public function create_unit_post() {
        $department_id = $this->input->post('department_id');
        $unit = $this->input->post('unit');
        $description = $this->input->post('description');
        $unit_id = sprintf('%04d', rand(1, 9999));

        // Check if each input is set and not null before trimming
        if ($description !== null) {
            $description = ucfirst(trim($description));
        }
        if ($department_id !== null) {
            $department_id = trim($department_id);
        }
        if ($unit !== null) {
            $unit= trim($unit);
        }
        
        if (empty($description)) {
            $this->response(array('status_code' => '1', 'message' => 'Description  cannot be empty'));
        }
        
        if (empty($unit)) {
            $this->response(array('status_code' => '1', 'message' => 'Unit cannot be empty'));
        }
        
        if (empty($department_id)) {
            $this->response(array('status_code' => '1', 'message' => 'Department ID  cannot be empty'));
        }

        $utility = new Utility();
 
        $check_unit = $utility->is_unit_exist($unit);
        if( $check_unit['status_code'] != '0'){
           $this->response(array('status_code'=>$check_unit['status_code'] ,  'message'=>$check_unit['message']));
         }
       try {

         return  $this->response($utility->get_unit($department_id,$unit_id,$unit,$description));

       } catch (Exception $e) {
         //echo $e->getMessage();
         // die();
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
   }   
    }

    public function create_department_post() {
        $department = $this->input->post('department');
        $description = $this->input->post('description');
        $department_id = sprintf('%04d', rand(1, 9999));

        // Check if each input is set and not null before trimming
        if ($description !== null) {
            $description = ucfirst(trim($description));
        }
        if ($department !== null) {
            $department = trim($department);
        }
        
        if (empty($description)) {
            $this->response(array('status_code' => '1', 'message' => 'Description cannot be empty'));
        }
        
        if (empty($department)) {
            $this->response(array('status_code' => '1', 'message' => 'Department cannot be empty'));
        }
        

        $utility = new Utility();
 
        $check_dep = $utility->is_department_exist($department);
        if( $check_dep['status_code'] != '0'){
           $this->response(array('status_code'=>$check_dep['status_code'] ,  'message'=>$check_dep['message']));
         }
       try {

         return  $this->response($utility->get_department($department_id,$department,$description));

       } catch (Exception $e) {
         //echo $e->getMessage();
         // die();
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
      }   
    }

    public function create_user_views_post() {
        $email = $this->input->post('email');
        $ref_id = $this->input->post('ref_id');
        $document_name = $this->input->post('document_name');
        $url = $this->input->post('url');
        $action = $this->input->post('action');
        $inserted_dt = $this->input->post('inserted_dt');


        // Check if each input is set and not null before trimming
        if ($email !== null) {
            $email = ucfirst(trim($email));
        }
        if ($ref_id !== null) {
            $ref_id = trim($ref_id);
        }
        if ($document_name !== null) {
            $document_name = ucfirst(trim($document_name));
        }
        if ($url !== null) {
            $url = trim($url);
        }
        if ($action !== null) {
            $action = ucfirst(trim($action));
        }
        if ($inserted_dt !== null) {
            $inserted_dt = trim($inserted_dt);
        }
        
        if (empty($email)) {
            $this->response(array('status_code' => '1', 'message' => 'Email cannot be empty'));
        }
        
        if (empty($ref_id)) {
            $this->response(array('status_code' => '1', 'message' => 'reference Id  cannot be empty'));
        }
        if (empty($document_name)) {
            $this->response(array('status_code' => '1', 'message' => 'Document name cannot be empty'));
        }
        
        if (empty($url)) {
            $this->response(array('status_code' => '1', 'message' => 'URl cannot be empty'));
        }
        if (empty($action)) {
            $this->response(array('status_code' => '1', 'message' => 'Action cannot be empty'));
        }
        
        if (empty($inserted_dt)) {
            $this->response(array('status_code' => '1', 'message' => 'Inserted date cannot be empty'));
        }
        

        $utility = new Utility();

       try {

         return  $this->response($utility->create_user_view($email,$ref_id,$document_name,$url,$action,$inserted_dt));

       } catch (Exception $e) {
         //echo $e->getMessage();
         // die();
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
      }   
    }

    public function create_document_post() {
        $document_type = $this->input->post('document_type');
        $description = $this->input->post('description');
        $document_id = sprintf('%04d', rand(1, 9999));

        // Check if each input is set and not null before trimming
        if ($description !== null) {
            $description = ucfirst(trim($description));
        }
        if ($document_type !== null) {
            $document_type = trim($document_type);
        }
        
        if (empty($description)) {
            $this->response(array('status_code' => '1', 'message' => 'Description cannot be empty'));
        }
        if (empty($document_type)) {
            $this->response(array('status_code' => '1', 'message' => 'Description cannot be empty'));
        }

        $utility = new Utility();
 
        $check_dep = $utility->is_document_exist($document_type);
        if( $check_dep['status_code'] != '0'){
           $this->response(array('status_code'=>$check_dep['status_code'] ,  'message'=>$check_dep['message']));
         }
       try {

         return  $this->response($utility->get_document($document_id,$document_type,$description));

       } catch (Exception $e) {
         //echo $e->getMessage();
         // die();
       $this->response(array('status_code' => '1' ,'message' =>'Registration error '.$e->getMessage()));
   }   
    }


    public function update_department_post($department_id) {
       // var_dump($id); // Debugging line to check $id
    
        // Retrieve department and description from the request
        $department = $this->input->post('department');
        $description = $this->input->post('description');
    
        // Trim and capitalize department and description if they exist
        if ($department !== null) {
            $department = ucfirst(trim($department));
        }
    
        if ($description !== null) {
            $description = ucfirst(trim($description));
        }
    
        // Check if department and description are empty
        if (empty($department)) {
            return $this->response(array('status_code' => '1', 'message' => 'Provide a valid Department'));
        }
    
        if (empty($description)) {
            return $this->response(array('status_code' => '1', 'message' => 'Description cannot be empty'));
        }
            // Validate that department and description are non-numeric
       if (is_numeric($department) || is_numeric($description)) {
         return $this->response(array('status_code' => '1', 'message' => 'Department and description must not be numeric'));
       }
    
        // Instantiate your Utility class
        $utility = new Utility();
    
        // Check if the department name already exists
        $check_department_name = $utility->is_department_exist($department);
    
        if ($check_department_name['status_code'] == '1') {
            return $this->response(array('status_code' => $check_department_name['status_code'], 'message' => $check_department_name['message']));
        }
    
        try {
            // Update the department using the Utility class
            $result = $utility->update_department($department_id, $department, $description);
    
            // Return a response
            return $this->response($result);
        } catch (Exception $e) {
            return $this->response(array('status_code' => '1', 'message' => 'Department Update error' . $e->getMessage()));
        }
    }

    public function update_document_post($document_id) {
        // var_dump($id); // Debugging line to check $id
     
         // Retrieve document and description from the request
         $document_type = $this->input->post('document_type');
         $description = $this->input->post('description');
     
         // Trim and capitalize document and description if they exist
         if ($document_type !== null) {
             $document_type = ucfirst(trim($document_type));
         }
     
         if ($description !== null) {
             $description = ucfirst(trim($description));
         }
     
         // Check if document and description are empty
         if (empty($document_type)) {
             return $this->response(array('status_code' => '1', 'message' => 'Provide a valid Documnet Type'));
         }
     
         if (empty($description)) {
             return $this->response(array('status_code' => '1', 'message' => 'Description cannot be empty'));
         }
             // Validate that document and description are non-numeric
        if (is_numeric($document_type) || is_numeric($description)) {
          return $this->response(array('status_code' => '1', 'message' => 'Document Type and description must not be numeric'));
        }
     
         // Instantiate your Utility class
         $utility = new Utility();
     
         // Check if the document name already exists
         $check_document_name = $utility->is_document_exist($document_type);
     
         if ($check_document_name['status_code'] == '1') {
             return $this->response(array('status_code' => $check_document_name['status_code'], 'message' => $check_document_name['message']));
         }
     
         try {
             // Update the document using the Utility class
             $result = $utility->update_document($document_id, $document_type, $description);
     
             // Return a response
             return $this->response($result);
         } catch (Exception $e) {
             return $this->response(array('status_code' => '1', 'message' => 'Document Update error' . $e->getMessage()));
         }
   }

  public function update_unit_post($unit_id) {
    // var_dump($id); // Debugging line to check $id
 
     // Retrieve document and description from the request
     $department_id = $this->input->post('department_id');
     $unit = $this->input->post('unit');
     $description = $this->input->post('description');
 
     // Trim and capitalize document and description if they exist
     if ($department_id !== null) {
        $department_id = trim($department_id);
    }
     if ($unit !== null) {
         $unit = ucfirst(trim($unit));
     }
 
     if ($description !== null) {
         $description = ucfirst(trim($description));
     }
 
     // Check if document and description are empty
     if (empty($department_id)) {
        return $this->response(array('status_code' => '1', 'message' => 'Provide a valid Department ID'));
    }
     if (empty($unit)) {
         return $this->response(array('status_code' => '1', 'message' => 'Provide a Unit'));
     }
 
     if (empty($description)) {
         return $this->response(array('status_code' => '1', 'message' => 'Description cannot be empty'));
     }
         // Validate that document and description are non-numeric
    if (is_numeric($unit) || is_numeric($description)) {
      return $this->response(array('status_code' => '1', 'message' => 'Document Type and description must not be numeric'));
    }
 
     // Instantiate your Utility class
     $utility = new Utility();
 
     // Check if the document name already exists
     $check_document_name = $utility->is_unit_exist($unit);
 
     if ($check_document_name['status_code'] == '1') {
         return $this->response(array('status_code' => $check_document_name['status_code'], 'message' => $check_document_name['message']));
     }
 
     try {
         // Update the document using the Utility class
         $result = $utility->update_unit($unit_id, $department_id,$unit, $description);
 
         // Return a response
         return $this->response($result);
     } catch (Exception $e) {
         return $this->response(array('status_code' => '1', 'message' => 'Document Update error' . $e->getMessage()));
     }
 }

 public function docu_ment_details_get(){
    $create_by = $this->input->get('create_by');
    $email = $this->input->get('email');
    $utility = new Utility();
    return $this->response( $utility->document_details($create_by,$email));
 }
 public function get_document_details_by_id_get(){
    $document_id = $this->input->get('document_id');
    $utility = new Utility();
    return $this->response( $utility->get_document_details_by_id($document_id));
 }
 public function document_type_list_get(){
    $utility = new Utility();
    return $this->response( $utility->document_type_details());
}

public function unit_list_get(){
    $department_id = $this->input->get('department_id');
    $utility = new Utility();
    return $this->response( $utility->unit_details($department_id));
}

public function department_list_get(){
    $utility = new Utility();
    return $this->response( $utility->department_details());
}
     
public function generate_token_post(){
    $email  = $this->input->post('email'); 
    $user_type_id  =  trim($this->input->post('user_type_id'));  // SECURITY-ANSWER , PIN, UNLOCK, BVN-UPDATE  -->
    //$operation_type  =  'FORGET-PASSWORD'; 
    if ($email !== null) {
        $email = trim($email);
    }
    $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
      
    if ($email === '' || !preg_match($email_pattern, $email)) {
      $this->response(array('status_code' => '1', 'message' => 'Provide a valid email address'));
    }

  
    if ($user_type_id == '' )  {
        $this->response(array('status_code' => '1' , 'message' =>'Provide Request Parameters ( user_type_id )'));
    }

    $utility = new Utility();
    $check_email = $utility->is_emailanduser_type_exist($email,$user_type_id);
    if( $check_email['status_code'] != '1'){
       $this->response(array('status_code'=>$check_email['status_code'] ,  'message'=>$check_email['message']));
   }
    try { 
        $response = $utility->generate_token($email,$user_type_id);
       
        $this->response($response);
        
     } catch (Exception $e) {
          $this->response(array('status_code' => '1' ,'message' =>'Generate Token Error '.$e->getMessage()));
   
      }

}
     
public function forget_password_post(){
    $email  = $this->input->post('email'); 
    $password =  $this->input->post('password'); 
    $token =  trim($this->input->post('token')); 
    $user_type_id =  trim($this->input->post('user_type_id')); 

    if ($email !== null) {
        $email = trim($email);
    }
    
    if ($user_type_id !== null) {
        $user_type_id = trim($user_type_id);
    }
    if ($password !== null) {
        $password = trim($password);
    }
    if ($token !== null) {
        $token = trim($token);
    }
  

    $utility = new Utility();

    if ($email == '')  {
        $this->response(array('status_code' => '1' , 'message' =>'Provide Request Parameters ( Email )'));
    }
    if ($user_type_id == '')  {
        $this->response(array('status_code' => '1','message' =>'Provide the User type '));
    }
      
    if ($token == '')  {
        $this->response(array('status_code' => '1','message' =>'Provide the security_token'));
    }
  
    if ($password == '')  {
        $this->response(array('status_code' => '1' , 'message' =>'Provide Request Parameters ( password )'));
    }
    $val =  $utility->confirm_token($email, $token, $user_type_id);
    
    if (  $val['status_code']  !== '0')  {
        $this->response(array('status_code' => '1' , 'message' =>$val['message']));
    }

     $response = $utility->forget_password($email, $password, $user_type_id ); 
          
     if ($response){
              
               
         $this->response(array('status_code' => '0', 'message' => 'Account Updated Successfully'));
     }else{
              
       $this->response(array('status_code' => '1', 'message' => 'Account Update Failed'));
    
    }          
  }


  public function deleteImage_post() {
    // Check if the image file name is provided in the POST request
    $image = $this->input->post('image');


    $utility = new Utility();
    $check_document_name = $utility->is_image_exist($image);
    if ($check_document_name['status_code'] == '0') {
        return $this->response(array('status_code' => '202', 'message' => $check_document_name['message']));
    }
    
    if ($image) {
        $imagePath = 'assets/img/useraccount/' . $image;
        
        // Check if the image file exists
        if (file_exists($imagePath)) {
            // Try to delete the image file
            if (unlink($imagePath)) {
                // Image file deleted successfully, now delete from the database
                
                $response = $utility->deleteImageFromDatabase($image); 
                if ($response['status_code'] == '0'){
              
                    $this->response(array('status_code' => '0', 'message' => 'file deleted Successfully'));
                }else{
                         
                  $this->response(array('status_code' => '1', 'message' => ' Failed to be deleted'));
               
               }          
             }
        } 
    } 
}

   
    
public function email_message_post(){
    $user_email = trim($this->input->post("email"));
    $subject = trim(ucfirst($this->input->post("subject")));
    $message_content = trim($this->input->post("body"));

    if($user_email == ""){
        $this->response(array("status_code"=>"1", "message"=>"Email cannot be empty"));
    }

    if($subject == ""){
        $this->response(array("status_code"=>"1", "message"=>"Subject cannot be empty"));
    }

    if($message_content == ""){
        $this->response(array("status_code"=>"1", "message"=>"Body cannot be empty"));
    }

    $utility = new Utility();



   try {

     return  $this->response($utility->sendgrid($user_email,'',$subject,$message_content));
     // print_r($user_email,'',$subject,$message_content); die;
   } catch (Exception $e) {
    //  echo $e->getMessage();
    //   die();
   $this->response(array('status_code' => '1' ,'message' =>'Subscriber error '.$e->getMessage()));
}
}   
    
    
    
}


?>