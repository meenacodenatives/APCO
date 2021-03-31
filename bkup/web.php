<?php

use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'loginsession'], function () {
    Route::get('/', 'LoginController@showLogin');
    Route::get('/login', 'LoginController@showLogin');
    Route::post('/validate-login', 'LoginController@doLogin');
});
Route::group(['middleware' => 'usersession'], function () {
    Route::get('/logout', 'DashboardController@doLogout');
    Route::get('/dashboard', 'DashboardController@showDashboard');
     //Create Tracker
     Route::post('/saveLeadTracker', 'TrackerController@saveLeadTracker'); 
     //Create Lead
     Route::post('/createLead', 'LeadController@createLead'); 
     //View Lead
     Route::get('/leads', 'LeadController@showLead'); 
     //Create Lead
     //Route::post('/createLead', 'LeadController@createLead'); 
     
     //View Tracker List
     Route::get('/leadTracker/{id}', 'TrackerController@getLeadTrackerList'); 
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


    //Employee Module    
    Route::get('/employees', 'EmployeeController@showEmployees'); //Employee listing page
    Route::get('/add-employee', 'EmployeeController@addEmployee'); //Add employee
    Route::get('/edit-employee/{id}', 'EmployeeController@addEmployee'); //Edit employee
    Route::post('/get-country-location', 'EmployeeController@getCountryLocation'); //Get country location
    Route::post('/save-employee', 'EmployeeController@saveProfile'); // Save user details
    Route::post('/delete-employee', 'EmployeeController@deleteEmployee'); //Delete employee
    
    
    //Schedular Module
    Route::get('/schedular', 'SchedularController@showSchedular'); //List all user schedules
    Route::get('/popup', 'SchedularController@showPopup'); // Showing sample popup form elements
    
});
Route::get('/{page}', 'AdminController@index');
