<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will guess the protocol, domain and
| path to your installation.
|
*/

// Set default timezone to India (Asia)
date_default_timezone_set('Asia/Calcutta');

//localhost
$config['base_url']                     = "http://localhost/thaipolltest"; //base_url index is default identified by CodeIgnitor, it cannot be change.
$config['base_path']			= "/var/www/htdocs/thaipolltest";
$config['fileUploadUrl']		= "/var/www/htdocs/thaipolltest/system/application/views/uploads";


////php demo
//$config['base_url']			= "http://phpdemo2.quagnitia.com/thaipolltest"; //base_url index is default identified by CodeIgnitor, it cannot be change.
//$config['base_path']			= "/opt/lampp/htdocs/thaipolltest";
//$config['fileUploadUrl']		= $config['base_path']."/system/application/views/uploads";



// ------- other
$config['homepageUrl'] 			= $config['base_url'];
$config['imageUrl']			= $config['base_url'] . "/images";
$config['actionFeUrl']  		= $config['base_url'] . "/index.php";
$config['actionBeUrl']   		= $config['base_url'] . "/index.php/backend";

//------- image paths
$config['editImage']			= $config['imageUrl'] . "/edit.png";
$config['uploadImage']			= $config['imageUrl'] . "/upload.jpg";


//############## FRONTEND urls will postfix with 'Action' - must be without '/'
// home page
$config['homeAction'] 			= $config['actionFeUrl'] . "/home";
$config['loginAction'] 			= $config['homeAction'] . "/login";
$config['registerAction'] 		= $config['homeAction'] . "/register";

$config['aboutUsAction'] = $config['homeAction'] . "/aboutUs";
$config['contactUsAction'] = $config['homeAction'] . "/contactUs";
$config['faqAction'] = $config['homeAction'] . "/faq";

//save contact us details
$config['contactUsFeAction'] = $config['homeAction'] . "/contactUsMail";

// User home page
$config['userHomeAction'] 		= $config['actionFeUrl'] . "/user_home";

//############## BACKEND URLs will postfix with 'BeAction' - must be without '/'

$config['loginBeAction'] 			= $config['actionBeUrl'] . "/login/loginCheck";
$config['logoutBeAction'] 			= $config['actionBeUrl'] . "/login/logout";
$config['dashboardBeAction'] 		= $config['actionBeUrl'] . "/dashboard";


//--------  Category
$config['categoryBeAction'] 			= $config['actionBeUrl'] . "/category";   //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['categoryListingBeAction'] 		= $config['categoryBeAction'] . "/listing";
$config['categoryAddBeAction'] 			= $config['categoryBeAction'] . "/addEditForm";
$config['categoryEditBeAction'] 		= $config['categoryBeAction'] . "/addEditForm";
$config['categorySaveBeAction'] 		= $config['categoryBeAction'] . "/save";
$config['categoryDeleteBeAction'] 		= $config['categoryBeAction'] . "/delete";
$config['categoryDeleteManyBeAction'] 	= $config['categoryBeAction'] . "/deleteMany";
$config['categorySearchBeAction'] 		= $config['categoryBeAction'] . "/search";
$config['categoryGetListBeAction'] 		= $config['categoryBeAction'] . "/getList";
$config['categorySearchFieldBeArr']			= array("name" => "Category Name", "status" => "Status");
$config['categoryDbFieldBeArr']				= array("name" => "Category Name", "status" => "Status");

//-------- Sub Category
$config['subCategoryBeAction'] 				= $config['actionBeUrl'] . "/sub_category";   //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['subCategoryListingBeAction'] 		= $config['subCategoryBeAction'] . "/listing";
$config['subCategoryAddBeAction'] 			= $config['subCategoryBeAction'] . "/addEditForm";
$config['subCategoryEditBeAction'] 			= $config['subCategoryBeAction'] . "/addEditForm";
$config['subCategorySaveBeAction'] 			= $config['subCategoryBeAction'] . "/save";
$config['subCategoryDeleteBeAction'] 		= $config['subCategoryBeAction'] . "/delete";
$config['subCategoryDeleteManyBeAction'] 	= $config['subCategoryBeAction'] . "/deleteMany";
$config['subCategorySearchBeAction'] 		= $config['subCategoryBeAction'] . "/search";
$config['subCategoryGetListBeAction'] 		= $config['subCategoryBeAction'] . "/getList";
$config['subCategorySearchFieldBeArr']		= array("name" => "Subcategory Name", "status" => "Status", "id" => "Id");
$config['subCategoryDbFieldBeArr']			= array("name" => "Subcategory Name", "status" => "Status");

//-------- Sub Category type
$config['subCategoryTypeBeAction'] 				= $config['actionBeUrl'] . "/sub_category_type";   //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['subCategoryTypeListingBeAction'] 		= $config['subCategoryTypeBeAction'] . "/listing";
$config['subCategoryTypeAddBeAction'] 			= $config['subCategoryTypeBeAction'] . "/addEditForm";
$config['subCategoryTypeEditBeAction'] 			= $config['subCategoryTypeBeAction'] . "/addEditForm";
$config['subCategoryTypeSaveBeAction'] 			= $config['subCategoryTypeBeAction'] . "/save";
$config['subCategoryTypeDeleteBeAction'] 		= $config['subCategoryTypeBeAction'] . "/delete";
$config['subCategoryTypeDeleteManyBeAction'] 	= $config['subCategoryTypeBeAction'] . "/deleteMany";
$config['subCategoryTypeSearchBeAction'] 		= $config['subCategoryTypeBeAction'] . "/search";
$config['subCategoryTypeGetListBeAction'] 		= $config['subCategoryTypeBeAction'] . "/getList";
$config['subCategoryTypeSearchFieldBeArr']		= array("name" => "Subcategory Name", "status" => "Status", "id" => "Id");
$config['subCategoryTypeDbFieldBeArr']			= array("name" => "Subcategory Name", "status" => "Status");

//--------  Country
$config['countryBeAction'] 				= $config['actionBeUrl'] . "/country";  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['countryListingBeAction'] 		= $config['countryBeAction'] . "/listing";
$config['countryAddBeAction'] 			= $config['countryBeAction'] . "/addEditForm";
$config['countryEditBeAction'] 			= $config['countryBeAction'] . "/addEditForm";
$config['countrySaveBeAction'] 			= $config['countryBeAction'] . "/save";
$config['countryDeleteBeAction'] 		= $config['countryBeAction'] . "/delete";
$config['countryDeleteManyBeAction'] 	= $config['countryBeAction'] . "/deleteMany";
$config['countrySearchBeAction'] 		= $config['countryBeAction'] . "/search";
$config['countryGetListBeAction'] 		= $config['countryBeAction'] . "/getList";
$config['countrySearchFieldBeArr']		= array("name" => "Country Name", "status" => "Status", "id" => "Id");
$config['countryDbFieldBeArr']			= array("name" => "Country Name", "status" => "Status");


//--------  State
$config['stateBeAction'] 			= $config['actionBeUrl'] . "/state";  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['stateListingBeAction'] 	= $config['stateBeAction'] . "/listing";
$config['stateAddBeAction'] 		= $config['stateBeAction'] . "/addEditForm";
$config['stateEditBeAction'] 		= $config['stateBeAction'] . "/addEditForm";
$config['stateSaveBeAction'] 		= $config['stateBeAction'] . "/save";
$config['stateDeleteBeAction'] 		= $config['stateBeAction'] . "/delete";
$config['stateDeleteManyBeAction'] 	= $config['stateBeAction'] . "/deleteMany";
$config['stateSearchBeAction'] 		= $config['stateBeAction'] . "/search";
$config['stateGetListBeAction'] 	= $config['stateBeAction'] . "/getList";
$config['stateSearchFieldBeArr']	= array("name" => "State Name", "status" => "Status", "id" => "Id");
$config['stateDbFieldBeArr']		= array("name" => "State Name", "status" => "Status");


//--------  City
$config['cityBeAction'] 			= $config['actionBeUrl'] . "/city";  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['cityListingBeAction'] 		= $config['cityBeAction'] . "/listing";
$config['cityAddBeAction'] 			= $config['cityBeAction'] . "/addEditForm";
$config['cityEditBeAction'] 		= $config['cityBeAction'] . "/addEditForm";
$config['citySaveBeAction'] 		= $config['cityBeAction'] . "/save";
$config['cityDeleteBeAction'] 		= $config['cityBeAction'] . "/delete";
$config['cityDeleteManyBeAction'] 	= $config['cityBeAction'] . "/deleteMany";
$config['citySearchBeAction'] 		= $config['cityBeAction'] . "/search";
$config['cityGetListBeAction'] 		= $config['cityBeAction'] . "/getList";
$config['citySearchFieldBeArr']		= array("name" => "City Name", "status" => "Status", "id" => "Id");
$config['cityDbFieldBeArr']			= array("name" => "City Name", "status" => "Status");


//--------  Area
$config['areaBeAction'] 			= $config['actionBeUrl'] . "/area";  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['areaListingBeAction'] 		= $config['areaBeAction'] . "/listing";
$config['areaAddBeAction'] 			= $config['areaBeAction'] . "/addEditForm";
$config['areaEditBeAction'] 		= $config['areaBeAction'] . "/addEditForm";
$config['areaSaveBeAction'] 		= $config['areaBeAction'] . "/save";
$config['areaDeleteBeAction'] 		= $config['areaBeAction'] . "/delete";
$config['areaDeleteManyBeAction'] 	= $config['areaBeAction'] . "/deleteMany";
$config['areaSearchBeAction'] 		= $config['areaBeAction'] . "/search";
$config['areaGetListBeAction'] 		= $config['areaBeAction'] . "/getList";
$config['areaSearchFieldBeArr']		= array("name" => "Area Name", "status" => "Status", "id" => "Id");
$config['areaDbFieldBeArr']			= array("name" => "Area Name", "status" => "Status");

//--------  User
$config['userBeAction'] 		= $config['actionBeUrl'] . "/user";  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['userListingBeAction']		= $config['userBeAction'] . "/listing";
$config['userAddBeAction'] 		= $config['userBeAction'] . "/addEditForm";
$config['userEditBeAction'] 		= $config['userBeAction'] . "/addEditForm";
$config['userSaveBeAction'] 		= $config['userBeAction'] . "/save";
$config['userDeleteBeAction'] 		= $config['userBeAction'] . "/delete";
$config['userDeleteManyBeAction'] 	= $config['userBeAction'] . "/deleteMany";
$config['userSearchBeAction'] 		= $config['userBeAction'] . "/search";
$config['userSearchFieldBeArr']		= array("first_name" => "Name", "status" => "Status", "id" => "Id");
$config['userDbFieldBeArr']		= array("first_name" => "Name", "status" => "Status");


$config['userFeAction'] 		= $config['homeAction'];  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['userSaveFeAction'] 		= $config['userFeAction'] . "/save";
$config['userForgotPasswordFeAction']   = $config['userFeAction']."/forgotPassword";
//$config['userGetForgotPasswordFeAction']   = $config['userFeAction']."/getForgotPassword";

$config['userRegistrationQuestions']   = $config['userFeAction'] ."/showRegistrationQuestions";


//logout
$config['userLogoutFeAction']   = $config['actionFeUrl'];

//--------  Poll
$config['pollBeAction'] 			= $config['actionBeUrl'] . "/poll";  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['pollListingBeAction']		= $config['pollBeAction'] . "/listing";
$config['pollAddBeAction'] 			= $config['pollBeAction'] . "/addEditForm";
$config['pollEditBeAction'] 		= $config['pollBeAction'] . "/addEditForm";
$config['pollSaveBeAction'] 		= $config['pollBeAction'] . "/save";
$config['pollDeleteBeAction'] 		= $config['pollBeAction'] . "/delete";
$config['pollDeleteManyBeAction'] 	= $config['pollBeAction'] . "/deleteMany";
$config['pollSearchBeAction'] 		= $config['pollBeAction'] . "/search";
/*
	$config['pollSearchFieldBeArr']		= array("first_name" => "Name", "status" => "Status", "id" => "Id");
*/	

$config['pollDbFieldBeArr']	= array("id" => "id", "title" => "Poll Title", "image"=>"Image","desc"=>"Description","pollCaegory_id"=>"Poll Category","pollpackage_id"=>"Poll Package","poll_type"=>"Poll Type","status"=>"Status","visibility"=>"visibility","agegroup_id"=>"Age Group","gender"=>"Gender","country_id"=>"Country","province_id"=>"Province","relationship"=>"Relationship Status","family_status"=>"Family Status","education_id"=>"Education Level","incomeGroup_id"=>"Income Group","jobFunction_id"=>"Job Function","job_status"=>"Job Status","interest_id"=>"Interest","create_date"=>"Create Date","expire_date"=>"Date Expired","expired"=>"Expired");


/** Define Giftcard Config **/

//--------  
$config['giftcardBeAction'] 			= $config['actionBeUrl'] . "/giftcard";  //Note: This is controller name - do not use camel case, use all small and underscore as separater
$config['giftcardListingBeAction']		= $config['giftcardBeAction'] . "/listing";
$config['giftcardAddBeAction'] 			= $config['giftcardBeAction'] . "/addEditForm";
$config['giftcardEditBeAction'] 		= $config['giftcardBeAction'] . "/addEditForm";
$config['giftcardSaveBeAction'] 		= $config['giftcardBeAction'] . "/save";
$config['giftcardDeleteBeAction'] 		= $config['giftcardBeAction'] . "/delete";
$config['giftcardDeleteManyBeAction'] 	= $config['giftcardBeAction'] . "/deleteMany";
$config['giftcardSearchBeAction'] 		= $config['giftcardBeAction'] . "/search";
$config['giftcardSearchFieldBeArr']		= array("title" => "Title", "points" => "Points", "id" => "Id");
$config['giftcardDbFieldBeArr']			= array("title" => "Title", "descp" => "Description","value"=>"Value","points"=>"Points","status"=>"Status");



/** Define config for filters whose values are picked by enum **/
$config['gender'] = array('MALE'=>'Male','FEMALE'=>'Female','BOTH'=>'Both');
$config['relationship'] = array('SINGLE'=>'Single','MARRIED'=>'Married','SEPARATED'=>'Separated','DIVORCED'=>'Divorced','WIDOWED'=>'Widowed','DECLINE'=>'Decline to tell');
$config['job_status'] = array('FULLTIME'=>'Full Time','PARTTIME'=>'Part Time','FREELANCE'=>'FreeLancer','BUSINESS'=>'Business','UNEMPLOYED'=>'UnEmployed','RETIRED'=>'Retired','STUDENT'=>'Student','OTHERS'=>'Others');
$config['family_status'] = array('PARENT'=>'Live with Parent','ALONE'=>'Live Alone','FAMILY'=>'Live with Family');

//question for first poll
$config["questions"] = array(
                        "1" => array("Which region do you belong to?","single-selection"),
                        "2" => array("Select your province","dropdown"),   
                        "3" => array("Your sex", "single-selection"),
                        "4" => array("Your date of birth", "single"),
                        "5" => array("Select your level of education", "single-selection"),
                        "6" => array("What is your monthly income?", "single-selection"),
                        "7" => array("Your job function", "dropdown"),     
                        "a" => array("Your job status", "single-selection"),    
                        "8" => array("Your Relationship status", "single-selection"),
                        "9" => array("Your family status", "single-selection"),
                        "10" => array("What Interests you?", "multiple-selection"),
                        );


//to map questions to field to save data in database
$config["questions_field_mapping"] = array(
                        "1" => "region_id",
                        "2" => "province_id",   
                        "3" => "gender",
                        "4" => "dob",
                        "5" => "education_id",
                        "6" => "income_group_id",
                        "7" => "job_function_id",     
                        "a" =>"job_status",    
                        "8" => "relationship_status",
                        "9" => "family_status",
                        "10" => "interest_id",
                        );

// sending email
$config['fromName'] = "Thaipoll";
$config['fromEmail'] = "mayoori.dessai@quagnitia.com";


//------------- Define common array

// Upload Image type, size and upload path
$config['imageTypes'] 		= 'gif|jpg|png';
$config['imageMaxSize']		= '1000'; //unit in KB, max size around 1MB
$config['imageMaxWidth']  	= '1024';
$config['imageMaxHeight']   = '768';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
//$config['index_page'] = 'index.php';
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'AUTO' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'AUTO'			Default - auto detects
| 'PATH_INFO'		Uses the PATH_INFO
| 'QUERY_STRING'	Uses the QUERY_STRING
| 'REQUEST_URI'		Uses the REQUEST_URI
| 'ORIG_PATH_INFO'	Uses the ORIG_PATH_INFO
|
*/
$config['uri_protocol']	= 'AUTO';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/urls.html
*/

$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;


/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';


/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify with a regular expression which characters are permitted
| within your URLs.  When someone tries to submit a URL with disallowed
| characters they will get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ folder. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/cache/ folder.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class or the Session class you
| MUST set an encryption key.  See the user guide for info.
|
*/
$config['encryption_key'] = 'asdgh23479dkjbwermbdv2-ff23zwg456hhe';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_cookie_name'		= the name you want for the cookie
| 'sess_expiration'			= the number of SECONDS you want the session to last.
|   by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
| 'sess_expire_on_close'	= Whether to cause the session to expire automatically
|   when the browser window is closed
| 'sess_encrypt_cookie'		= Whether to encrypt the cookie
| 'sess_use_database'		= Whether to save the session data to a database
| 'sess_table_name'			= The name of the session database table
| 'sess_match_ip'			= Whether to match the user's IP address when reading the session data
| 'sess_match_useragent'	= Whether to match the User Agent when reading the session data
| 'sess_time_to_update'		= how many seconds between CI refreshing Session Information
|
*/
$config['sess_cookie_name']		= 'ci_session';
$config['sess_expiration']		= 7200;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix' = Set a prefix if you need to avoid collisions
| 'cookie_domain' = Set to .your-domain.com for site-wide cookies
| 'cookie_path'   =  Typically will be a forward slash
| 'cookie_secure' =  Cookies will only be set if a secure HTTPS connection exists.
|
*/
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or 'gmt'.  This pref tells the system whether to use
| your server's local time as the master 'now' reference, or convert it to
| GMT.  See the 'date helper' page of the user guide for information
| regarding date handling.
|
*/
$config['time_reference'] = 'local';


/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy IP
| addresses from which CodeIgniter should trust the HTTP_X_FORWARDED_FOR
| header in order to properly identify the visitor's IP address.
| Comma-delimited, e.g. '10.0.1.200,10.0.1.201'
|
*/
$config['proxy_ips'] = '';
$config['api_username'] = "ravish_1360158715_biz_api1.quagnitia.com";
$config['api_password'] = "1360158738";
$config['api_signature'] = "AFcWxV21C7fd0v3bYYYRCpSSRl31AUywtj9WIAYuWsBQn.vFBGRt-BpP";
$config['test_mode'] = true;


/* End of file config.php */
/* Location: ./application/config/config.php */