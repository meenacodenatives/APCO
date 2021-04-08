<?php
use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
/* Route::get('/', function () {
  return view('index');
  }); */
Route::group(['middleware' => 'loginsession'], function () {
    Route::get('/', 'LoginController@showLogin');
    Route::get('/login', 'LoginController@showLogin');
    Route::post('/validate-login', 'LoginController@doLogin');
    //post Forgot Password
Route::post('/forgot-password', 'PasswordResetController@getUserPwd');
Route::get('/change-password/{secretKey}', 'PasswordResetController@getSecretKey');
Route::post('/update-password', 'PasswordResetController@changePwd');

});

Route::group(['middleware' => 'usersession'], function () {
       Route::get('/logout', 'DashboardController@doLogout');
    Route::get('/dashboard', 'DashboardController@showDashboard');
    // Product -View
    Route::get('/searchProduct','ProductController@searchProduct');
 // Route::post('showProduct', ['as' => 'showProduct', 'uses' => 'ProductController@showProduct']);
  Route::post('/searchResults','ProductController@searchResults');

         // Product -Store
         Route::post('/chkProductPrice','ProductController@chkProductPrice');
           // Product -Store
           Route::post('/storeProduct','ProductController@storeProduct');
         // Product -View
         Route::get('/showProduct','ProductController@showProduct');
          //Add Product
    Route::get('/add-product', 'ProductController@addProduct');
         //Edit Product
    Route::get('/edit-product/{id}', 'ProductController@editProduct');
    //view Single Product
    Route::get('/viewSingleproduct/{id}', 'ProductController@viewSingleproduct');
     // RFQ -View
     Route::get('/showRFQ','RFQController@showRFQ');
     //Add RFQ
    Route::get('/add-RFQ', 'RFQController@addRFQ');
     // RFQ -Store
     Route::post('/storeRFQ','RFQController@storeRFQ');
     //Edit RFQ
    Route::get('/edit-RFQ/{id}', 'RFQController@editRFQ');
    //view Single Product
    Route::get('/viewSingleRFQ/{id}', 'RFQController@viewSingleRFQ');
    //delete RFQsearchResultsRFQ
    Route::post('/delete-RFQ', 'RFQController@destroyRFQ');
    Route::post('/RFQsearchResults','RFQController@searchResults');
    //Edit Lead RFQ
    Route::get('/edit-lead-RFQ/{id}', 'RFQController@editLeadRFQ');
  
         // Category -View
         Route::get('/showCategory','CategoryController@showCategory');
         //delete Category
    Route::post('/delete-product', 'ProductController@destroyProduct');
         // Category -Add
         Route::post('/storeCategory','CategoryController@storeCategory');
        //delete Category
    Route::post('/delete-category', 'CategoryController@destroyCategory');
    //edit Category
    Route::get('/edit-category/{id}', 'CategoryController@editCategory');
  
  //get users - popup
   Route::get('/get-users', 'TrackerController@getUsers');
    //View Tracker List
    Route::get('/leadTracker/{id}', 'TrackerController@getLeadTrackerList'); 
  //Create Tracker
    Route::post('/saveLeadTracker', 'TrackerController@saveLeadTracker'); 
      //View RFQ Tracker List
      Route::get('/RFQTracker/{id}', 'RFQTrackerController@getRFQTrackerList'); 
      //Create RFQ Tracker
        Route::post('/saveRFQTracker', 'RFQTrackerController@saveRFQTracker'); 
    //Create Lead
    Route::post('/createLead', 'LeadController@createLead'); 
    //View Lead
    Route::get('/leads', 'LeadController@showLead'); 
    Route::post('/leadSearchResults','LeadController@leadSearchResults');
  //Edit Lead
    Route::get('/viewSinglelead/{id}', 'LeadController@viewSinglelead');
      //Create Customer
      Route::post('/createCustomer', 'CustomerController@createCustomer'); 
     //View Customer
     Route::get('/customers', 'CustomerController@showCustomer'); 
     //Edit Customer
    Route::get('/edit-customer/{id}', 'CustomerController@viewSingleCustomer');
     // Add Customer
     Route::get('/add-customer','CustomerController@getCustomer');
     //Delete Customer
    Route::post('/delete-customer', 'CustomerController@deleteCustomer');
   
      // Country Drop down
    Route::get('/add-lead','CountryController@getCountries');
    //Edit Lead
    Route::get('/edit-lead/{id}', 'LeadController@editSingleLead');
    //delete Lead
    Route::post('/delete-lead', 'LeadController@deleteLead');
    //Location drop down
    Route::get('/getLoc/{regcode}','CountryController@getLocationFromRegion','getreg');
     //Region drop down
    Route::get('/getRegion/{ctrycode}','CountryController@getRegionFromCountries','getctry');
    //employee creation
    Route::get('/employees', 'EmployeeController@showEmployees');
    Route::get('/add-employee', 'EmployeeController@addEmployee');
    Route::get('/edit-employee/{id}', 'EmployeeController@addEmployee');
    Route::post('/get-country-location', 'EmployeeController@getCountryLocation');
    Route::post('/save-employee', 'EmployeeController@saveProfile');
    Route::post('/delete-employee', 'EmployeeController@deleteEmployee');
  
    //Schedular Module
    Route::get('/schedular', 'SchedularController@showSchedular'); //List all user schedules
    Route::get('/popup', 'SchedularController@showPopup'); // Showing sample popup form elements
    Route::post('/createScheduler', 'SchedularController@createScheduler');     //Create Scheduler
    Route::get('/edit-schedular/{id}', 'SchedularController@showSingleSchedular');     //edit Scheduler
    Route::post('/delete-schedular', 'SchedularController@deleteSchedular');//delete Scheduler

});
Route::get('/{page}', 'AdminController@index');

