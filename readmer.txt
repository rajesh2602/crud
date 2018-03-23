Google Plus Login In CI
==
1. Goto https://console.developers.google.com
2. After Create a New Project and Save
3. After that select the Project which you have created 
   =) on left hand side select menu option credentials
   =) Now a popup options will display in that select Create Credentials =) OAuth Client ID =) Select the Application Type ( Web Application)
      (Before selecting the Application Type You need to configure consent screen)
	  After Selecting the Application Type You need to add the Redirection URL (in which you need the user data)
   =) Now you will get the Client_ID and Client_Secret_ID copy this both key and paste in your config file where you have  
      defined the google login.   

4. create the google_config.php file in config folder and add following Code
    defined('BASEPATH') OR exit('No direct script access allowed');

    $config['google_client_id']="YOUR CLIENT ID HERE";
    $config['google_client_secret']="YOUR SECRET KEY HERE";
    $config['google_redirect_url']=base_url().'users/oauth2callback'; // You need to change this url based on your controllers
	
5. get the Google Folder and google.php	and copy this two thinks in libraries

6. Now to goto your Controller and load the google Library
   eg:- $this->load->library('google');

7. Now get the google_login_url using the script below
   eg :- $this->google->get_login_url();   
   
8. Now create the callbackfunctions using following script  
    public function oauth2callback() {
        $google_data = $this->google->validate();
        $session_data = array(
            'name' => $google_data['name'],
            'email' => $google_data['email'],
            'source' => 'google',
            'profile_pic' => $google_data['profile_pic'],
            'link' => $google_data['link'],
            'sess_logged_in' => 1
        );
        $this->session->set_userdata($session_data);
        redirect(base_url());
    }  

9. Logout 
	public function logout() {
        session_destroy();
        unset($_SESSION['access_token']);
        $session_data = array(
            'sess_logged_in' => 0);
        $this->session->set_userdata($session_data);
        redirect(base_url());
    }