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

Route::group(['middleware'=>['Locale']],function(){


//login admin
Route::group(['namespace'=>'Auth','prefix'=>'admin/auth','middleware'=>'AdminGuest','as'=>'admin.auth.'],function(){
    Route::get('/login','AdminController@login')->name('login');
    Route::post('/login','AdminController@login_submit')->name('login_submit');
});
//logout admin
Route::post('admin/logout','Auth\AdminController@logout')->name('admin.logout')->middleware('Admin');

//reset admin users password
Route::group(['namespace'=>'Auth','prefix'=>'admin/reset','as'=>'admin.reset.'],function(){
    Route::get('/mail','AdminController@mail')->name('mail');
    Route::post('/mail_submit','AdminController@mail_submit')->name('mail_submit');
    Route::get('/reset_password_form/{token}','AdminController@reset_password_form')->name('reset_password_form');
    Route::post('/reset_password_submit','AdminController@reset_password_submit')->name('reset_password_submit');
});

//admin controls
Route::group(['prefix'=>'admin','as'=>'admin.','namespace'=>'Admin','middleware'=>'Admin'],function(){
    //dashboard
    Route::get('/','IndexController@index')->name('index');

    //dashboard
    Route::resource('tests','TestsController');

    //profile
    Route::group(['prefix'=>'profile','as'=>'profile.'],function(){
        Route::get('edit','ProfileController@edit')->name('edit');
        Route::post('update','ProfileController@update')->name('update');
    });

    //tests and its components
    Route::resource('tests','TestsController');
    Route::get('get_tests','TestsController@ajax')->name('get_tests');//datatable

    //antibiotics
    Route::resource('antibiotics','AntibioticsController');
    Route::get('get_antibiotics','AntibioticsController@ajax')->name('get_antibiotics');

    //patients
    Route::resource('patients','PatientsController');
    Route::get('get_patients','PatientsController@ajax')->name('get_patients');
    Route::get('patients_export','PatientsController@export')->name('patients.export');
    Route::get('patients_download_template','PatientsController@download_template')->name('patients.download_template');
    Route::post('patients_import','PatientsController@import')->name('patients.import');

    //cultures
    Route::resource('cultures','CulturesController');
    Route::get('get_cultures','CulturesController@ajax')->name('get_cultures');//datatable

    //culture options
    Route::resource('culture_options','CultureOptionsController');
    Route::get('get_culture_options','CultureOptionsController@ajax')->name('culture_options.ajax');

    //groups
    Route::resource('groups','GroupsController');
    Route::post('groups/send_receipt_mail/{id}','GroupsController@send_receipt_mail')->name('groups.send_receipt_mail');
    Route::post('groups/delete_analysis/{id}','GroupsController@delete_analysis');
    Route::get('get_groups','GroupsController@ajax')->name('get_groups');
    Route::post('groups/print_barcode/{group_id}','GroupsController@print_barcode')->name('groups.print_barcode');

    //doctors
    Route::resource('doctors','DoctorsController');
    Route::get('get_doctors','DoctorsController@ajax')->name('get_doctors');
    Route::get('doctors_export','DoctorsController@export')->name('doctors.export');
    Route::get('doctors_download_template','DoctorsController@download_template')->name('doctors.download_template');
    Route::post('doctors_import','DoctorsController@import')->name('doctors.import');

    //reports
    Route::resource('reports','ReportsController');
    Route::post('reports/pdf/{id}','ReportsController@pdf')->name('reports.pdf');
    Route::post('reports/update_culture/{id}','ReportsController@update_culture')->name('reports.update_culture');//update cultures
    Route::get('get_reports','ReportsController@ajax')->name('get_reports');
    Route::get('sign_report/{id}','ReportsController@sign')->name('reports.sign');
    Route::post('reports/send_report_mail/{id}','ReportsController@send_report_mail')->name('reports.send_report_mail');


    //roles
    Route::resource('roles','RolesController');
    Route::get('get_roles','RolesController@ajax')->name('get_roles');

    //users
    Route::resource('users','UsersController');
    Route::get('get_users','UsersController@ajax')->name('get_users');

    //tests price list
    Route::get('prices/tests','PricesController@tests')->name('prices.tests');
    Route::post('prices/tests','PricesController@tests_submit')->name('prices.tests_submit');
    Route::get('tests_prices_export','PricesController@tests_prices_export')->name('prices.tests_prices_export');
    Route::post('tests_prices_import','PricesController@tests_prices_import')->name('prices.tests_prices_import');

    //cultures price list
    Route::get('prices/cultures','PricesController@cultures')->name('prices.cultures');
    Route::post('prices/cultures','PricesController@cultures_submit')->name('prices.cultures_submit');
    Route::get('cultures_prices_export','PricesController@cultures_prices_export')->name('prices.cultures_prices_export');
    Route::post('cultures_prices_import','PricesController@cultures_prices_import')->name('prices.cultures_prices_import');

    //accounting reports
    Route::get('accounting','AccountingController@index')->name('accounting.index');
    Route::get('generate_report','AccountingController@generate_report')->name('accounting.generate_report');
    Route::get('doctor_report','AccountingController@doctor_report')->name('accounting.doctor_report');
    Route::get('generate_doctor_report','AccountingController@generate_doctor_report')->name('accounting.generate_doctor_report');

    //chat
    Route::get('chat','ChatController@index')->name('chat.index');

    //visits
    Route::resource('visits','VisitsController');
    Route::get('visits/create_tests/{id}','VisitsController@create_tests')->name('visits.create_tests');
    Route::get('get_visits','VisitsController@ajax')->name('get_visits');

    //branches
    Route::resource('branches','BranchesController');
    Route::get('get_branches','BranchesController@ajax')->name('get_branches');

    //contracts
    Route::resource('contracts','ContractsController');
    Route::get('get_contracts','ContractsController@ajax')->name('get_contracts');

    //expenses
    Route::resource('expenses','ExpensesController');
    Route::get('get_expenses','ExpensesController@ajax')->name('get_expenses');

    //expense categories
    Route::resource('expense_categories','ExpenseCategoriesController');
    Route::get('get_expense_categories','ExpenseCategoriesController@ajax')->name('get_expense_categories');

    //backups
    Route::resource('backups','BackupsController');

    //activity logs
    Route::resource('activity_logs','ActivityLogsController');
    Route::post('activity_logs_clear','ActivityLogsController@clear')->name('activity_logs.clear');
    Route::get('get_activity_logs','ActivityLogsController@ajax')->name('get_activity_logs');

    //settings
    Route::group(['prefix'=>'settings','as'=>'settings.'],function(){
        Route::get('/','SettingsController@index')->name('index');
        Route::post('info','SettingsController@info_submit')->name('info_submit');
        Route::post('emails','SettingsController@emails_submit')->name('emails_submit');
        Route::post('reports','SettingsController@reports_submit')->name('reports_submit');
        Route::post('sms','SettingsController@sms_submit')->name('sms_submit');
        Route::post('whatsapp','SettingsController@whatsapp_submit')->name('whatsapp_submit');
        Route::post('api_keys','SettingsController@api_keys_submit')->name('api_keys_submit');
    });

    //translations
    Route::resource('translations','TranslationsController');

    //updates
    Route::get('update/{version}','UpdatesController@update');
});




  Route::group(['prefix'=>'ajax','as'=>'ajax.'],function(){

    //get patients
    Route::get('get_patient_by_code','AjaxController@get_patient_by_code')->name('get_patient_by_code');
    Route::get('get_patient_by_name','AjaxController@get_patient_by_name')->name('get_patient_by_name');

    //get patient
    Route::get('get_patient','AjaxController@get_patient')->name('get_patient');

    //create patient
    Route::post('create_patient','AjaxController@create_patient')->name('create_patient');

    //get tests
    Route::get('get_tests','AjaxController@get_tests')->name('get_tests');

    //delete test
    Route::get('delete_test/{test_id}','AjaxController@delete_test')->name('delete_test');

    //delete option
    Route::get('delete_option/{option_id}','AjaxController@delete_option')->name('delete_option');


    //get cultures
    Route::get('get_cultures','AjaxController@get_cultures')->name('get_cultures');

    //get doctors
    Route::get('get_doctors','AjaxController@get_doctors')->name('get_doctors');

    //create doctor
    Route::post('create_doctor','AjaxController@create_doctor')->name('create_doctor');

    //add options
    Route::post('add_sample_type','AjaxController@add_sample_type')->name('add_sample_type');
    Route::post('add_organism','AjaxController@add_organism')->name('add_organism');
    Route::post('add_colony_count','AjaxController@add_colony_count')->name('add_colony_count');

    //get roles
    Route::get('get_roles','AjaxController@get_roles')->name('get_roles');

    //get online users
    Route::get('online','AjaxController@online')->name('online')->middleware('Admin');

    //get chat
    Route::get('get_chat/{id}','AjaxController@get_chat')->name('get_chat')->middleware('Admin');
    Route::get('chat_unread/{id}','AjaxController@chat_unread')->name('chat_unread')->middleware('Admin');
    Route::post('send_message/{id}','AjaxController@send_message')->name('send_message')->middleware('Admin');

    //change visit status
    Route::post('change_visit_status/{id}','AjaxController@change_visit_status')->name('change_visit_status')->middleware('Admin');

    //change lang status
    Route::post('change_lang_status/{id}','AjaxController@change_lang_status')->name('change_lang_status')->middleware('Admin');

    //add category
    Route::post('add_expense_category','AjaxController@add_expense_category')->name('add_expense_category')->middleware('Admin');

    //get unread messages
    Route::get('get_unread_messages','AjaxController@get_unread_messages')->name('get_unread_messages')->middleware('Admin');
    Route::get('get_unread_messages_count/{id}','AjaxController@get_unread_messages_count')->name('get_unread_messages_count')->middleware('Admin');

    //get my messages
    Route::get('get_my_messages/{id}','AjaxController@get_my_messages')->name('get_my_messages')->middleware('Admin');

    //get new visits
    Route::get('get_new_visits','AjaxController@get_new_visits')->name('get_new_visits')->middleware('Admin');

    //load more messages
    Route::get('load_more/{user_id}/{message_id}','AjaxController@load_more')->name('load_more')->middleware('Admin');

    //get current patient
    Route::get('get_current_patient','AjaxController@get_current_patient')->name('get_current_patient')->middleware('Patient');

});


//patient authentication
Route::group(['namespace'=>'Auth','prefix'=>'/','middleware'=>'PatientGuest','as'=>'patient.auth.'],function(){
  //register
  Route::get('register','PatientController@showRegistrationForm')->name('register');
  Route::post('register_submit','PatientController@register_submit')->name('register_submit');
  //login
  Route::get('/','PatientController@showLoginForm')->name('login');
  Route::post('/login_submit','PatientController@login_submit')->name('login_submit');
  //send mail patient code
  Route::get('/mail','PatientController@showMailForm')->name('mail');
  Route::post('/mail_submit','PatientController@mail_submit')->name('mail_submit');
  //quick login patient
  Route::get('patient/login/{code}','PatientController@login_patient')->name('login_by_code');
});
//logout patient
Route::post('/logout','Auth\PatientController@logout')->name('patient.logout');

//patient pages
Route::group(['namespace'=>'Patient','prefix'=>'patient','middleware'=>'Patient','as'=>'patient.'],function(){
  //dashboard
  Route::get('/','IndexController@index')->name('index');

  //get reports and receipts
  Route::group(['prefix'=>'groups','as'=>'groups.'],function(){
    Route::get('/','GroupsController@index')->name('index');
    Route::get('/reports/{id}','GroupsController@reports')->name('reports');
    Route::get('/receipt/{id}','GroupsController@receipt')->name('receipt');
    Route::post('/reports/pdf/{id}','GroupsController@pdf')->name('pdf');
  });
  //get patient groups
  Route::get('get_patient_groups','GroupsController@ajax')->name('get_patient_groups');

  //profile
  Route::group(['prefix'=>'profile','as'=>'profile.'],function(){
    Route::get('/','ProfileController@edit')->name('edit');
    Route::post('/','ProfileController@update')->name('update');
  });

  //visits
  Route::resource('visits','VisitsController');

  //branches
  Route::resource('branches','BranchesController');

  //tests library
  Route::resource('tests_library','TestsLibraryController');
  Route::get('get_analyses','TestsLibraryController@get_analyses');
  Route::get('get_cultures','TestsLibraryController@get_cultures');

});
});

Route::get('change_locale/{lang}','HomeController@change_locale')->name('change_locale');

Route::get('clear-cache',function(){
  \Artisan::call('cache:clear');
  \Artisan::call('config:clear');
  \Artisan::call('view:clear');
});

