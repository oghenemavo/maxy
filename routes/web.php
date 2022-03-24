<?php

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/test/modal', function () {
    return 'test modal content';
})->name('test-modal-view');


Route::get('/auth/login', function () {
    return view('welcome');
});

Route::post('/auth/check', function () {
    return ['status' =>false];
})->name('user-check');

Route::get('/session-check', 'UsersController@checkSession')->name('session-check');


Auth::routes(['verify' => true]);


Route::get('/loggedIn', function () {
    return 'user has logged In ';
})->name('loggedIn');

Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('/home', '/dashboard');
Route::get('/audits', 'AuditsController@index')->name('audits');
Route::post('/audits/data', 'AuditsController@tableData')->name('audit-data');
Route::get('/audits/export/data/{user}/{type?}/{date?}', 'AuditsController@export');
Route::get('/audit-details/{logId?}', 'AuditsController@details')->name('audit-details');

Route::post('/auth/login', 'Auth\LoginController@login')->name('login');
Route::get('/auth/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/auth/logout', 'UsersController@logout')->name('logout');
Route::post('/auth/register', 'Auth\LoginController@register')->name('register');

 
Route::match(['get', 'post'], 'all-files', [ 'uses' => 'FileController@index', 'as' => 'all-files']);
Route::post('/file-view/{id?}/{isModal?}', 'FileController@viewFile')->name('view-file');
Route::get('/file-view/{id?}/{isModal?}', 'FileController@viewFile')->name('view-file');
Route::get('/file/quick-search', 'FileController@quickSearch')->name('file-quick-search');
Route::get('/file/preview/{id}', 'FileController@preview')->name('file-preview');
Route::get('/version/preview/{id}', 'FileController@versionPreview')->name('version-preview');
Route::get('/other_files/preview/{id}', 'FileController@otherFilesPreview')->name('other_files-preview');
Route::get('/file/search', 'FileController@search')->name('file-search');

Route::get('/cat/fields/{catId?}/{fileName?}', 'FileController@categoryFields')->name('cat-fields');


Route::post('/file/permissions/data', 'FileController@filePermissions')->name('show-file-permisions');
Route::post('/file/permissions/update', 'FileController@updateFilePermissions')->name('update-permisions');
Route::post('/file/permissions/create', 'FileController@createPermission')->name('create-permission');
Route::post('/file/permissions/remove', 'FileController@removePermission')->name('remove-permission');


Route::post('/folder/permissions/data', 'FileController@folderPermissions')->name('show-folder-permisions');
Route::post('/folder/permissions/update', 'FileController@updateFolderPermissions')->name('update-folder-permisions');
Route::post('/folder/permissions/create', 'FileController@createFolderPermission')->name('create-folder-permission');
Route::get('/folder/permissions/{folderId}', 'FileController@newFolderPermission')->name('folder-permission');
Route::post('/folder/permissions/remove', 'FileController@removeFolderPermission')->name('remove-folder-permission');


Route::match(['get', 'post'], 'file/upload/{fileId?}', 'FileController@upload')->name('upload-file');
Route::get('/file/checkin/{file_id?}', 'FileController@checkIn')->name('checkin-file');
Route::post('/file/checkin/{file_id?}', 'FileController@checkIn')->name('checkin-file');
Route::get('/file/lock/{file_id}/{type}', 'FileController@lockFile')->name('lock-file');
Route::get('/file/delete/{file_id}', 'FileController@deleteFile')->name('delete-file');
Route::get('/file/follow/{file_id}', 'FileController@followFile')->name('follow-file');
Route::get('/file/unfollow/{file_id}', 'FileController@unfollowFile')->name('unfollow-file');
Route::get('/file/count/{folder_id?}', 'FileController@getFileCount')->name('file-count');
Route::get('/file/empty-trash', 'FileController@emptyTrash')->name('empty-trash');
Route::get('/file/restore/{file_id}', 'FileController@restoreFile')->name('restore-file');
Route::match(['get', 'post'], 'edit-file/{file_id}', [ 'uses' => 'FileController@editFile', 'as' => 'edit-file']);

Route::get('/file/checkout/{fileId?}', 'FileController@checkOut')->name('checkoutFile');
Route::get('/file/download/{fileId?}', 'FileController@download')->name('downloadFile');
Route::get('/file/export/{fileId?}', 'FileController@export')->name('exportFile');

Route::match(['get', 'post'], 'user-fields', [ 'uses' => 'FileController@userFields', 'as' => 'user-fields']);
Route::match(['get', 'post'], 'store-user-field', [ 'uses' => 'FileController@storeUserField', 'as' => 'store-user-field']);
Route::match(['get', 'post'], 'file-categories/{catId?}', [ 'uses' => 'FileController@fileCategories', 'as' => 'file-categories']);





Route::get('/get-folder-breakdown', 'FileController@folderBreakdown')->name('get-folder-breakdown');
Route::post('/trash-folder', 'FileController@trashFolder')->name('trash-folder');
Route::post('/duplicate-folder', 'FileController@duplicateFolder')->name('duplicate-folder');
Route::post('/trash-user-field', 'FileController@trashUserField')->name('trash-user-field');
Route::match(['get', 'post'], 'store-folder/{parent_id?}/{folder_id?}', [ 'uses' => 'FileController@storeFolder', 'as' => 'store-folder']);
Route::match(['get', 'post'], 'folder-perm', [ 'uses' => 'FileController@permFolder', 'as' => 'folder-perm']);
Route::match(['get', 'post'], 'new-file-upload', [ 'uses' => 'FileController@newFileUpload', 'as' => 'new-file-upload']);
Route::match(['get', 'post'], 'file-upload-page', [ 'uses' => 'FileController@UploadPage', 'as' => 'file-upload-page']);
Route::match(['get', 'post'], 'file-categorize', [ 'uses' => 'FileController@categorize', 'as' => 'file-categorize']);

Route::match(['get', 'post'], 'cancel-index/{fileId}', [ 'uses' => 'FileController@cancelIndexing', 'as' => 'cancel-index']);


Route::match(['get', 'post'], 'user/import', ['uses' => 'UsersController@importUser', 'as' => 'import-user']);
Route::match(['get', 'post'], 'user/create', ['uses' => 'UsersController@create', 'as' => 'create-user']);
Route::match(['get', 'post'], 'user/activate/{userid}/{status}', ['uses' => 'UsersController@activateUser', 'as' => 'activate-user']);
Route::match(['get', 'post'], 'user/edit/{id}', ['uses' => 'UsersController@edit', 'as' => 'edit-user']);
Route::match(['get', 'post'], 'user/password/reset/{id}', ['uses' => 'UsersController@resetPassword', 'as' => 'reset-user-password']);
Route::match(['get', 'post'], 'change-password', ['uses' => 'UsersController@changePassword', 'as' => 'change-password']);
Route::get('/users', 'UsersController@index')->name('user-index');
Route::get('/user/{id}', 'UsersController@view')->name('view-user');
Route::get('/dashboard', 'UsersController@dashboard')->name('dashboard');
Route::get('/ajax-stats', 'UsersController@ajaxStats')->name('ajax-stats');




Route::match(['get', 'post'], 'group/create', ['uses' => 'GroupsController@create', 'as' => 'create-group']);
Route::match(['get', 'post'], 'group/edit/{id}', ['uses' => 'GroupsController@edit', 'as' => 'edit-group']);

Route::get('/vlist/excel', 'ValueListsController@excel')->name('excel-vlist');
Route::post('/vlist/import', 'ValueListsController@import')->name('import-vlist');
Route::post('/vlist/display', 'ValueListsController@connect')->name('connect-database');
Route::get('/vlist/refresh/{id}', 'ValueListsController@refresh')->name('refresh-database');
Route::get('/value-lists', 'ValueListsController@index')->name('value-lists');
Route::match(['get', 'post'], 'vlist/add', ['uses' => 'ValueListsController@create', 'as' => 'create-vlist']);
Route::match(['get', 'post'], 'vlist/edit/{id}', ['uses' => 'ValueListsController@edit', 'as' => 'edit-vlist']);
Route::get('/vlist/{id}', 'ValueListsController@view')->name('view-vlist');
Route::get('/delete-list/{id}', 'ValueListsController@delList')->name('delete-vlist');


Route::get('/groups', 'GroupsController@index')->name('group-index');
Route::get('/group/{id}', 'GroupsController@view')->name('view-group');
Route::any('/settings/company', 'SettingsController@view')->name('view-settings');
Route::any('/settings/email', 'SettingsController@email')->name('email-settings');
Route::get('/settings/company-details', 'SettingsController@companyDetails')->name('company-details');

Route::match(['get', 'post'], 'backup', [ 'uses' => 'FileController@backups', 'as' => 'backup']);
Route::match(['get', 'post'], 'create-backup', [ 'uses' => 'FileController@createBackup', 'as' => 'create-backup']);
Route::match(['get', 'post'], 'cancel-backup', [ 'uses' => 'FileController@cancelBackup', 'as' => 'cancel-backup']);
Route::match(['get', 'post'], 'restore-backup', [ 'uses' => 'FileController@restoreBackup', 'as' => 'restore-backup']);

Route::match(['get', 'post'], 'workflows', ['uses' => 'WorkflowController@index', 'as' => 'workflows']);
Route::match(['get', 'post'], 'workflows/create', ['uses' => 'WorkflowController@create', 'as' => 'create-workflow']);
Route::match(['get', 'post'], 'workflows/edit/{id}', ['uses' => 'WorkflowController@edit', 'as' => 'edit-workflow']);
Route::get('/workflow/{id}', 'WorkflowController@view')->name('view-workflow');
Route::match(['get', 'post'], 'workflows/edit-metadata/{id}', ['uses' => 'WorkflowController@editMetadata', 'as' => 'edit-workflow-metadata']);
Route::match(['get', 'post'], 'workflows/update-workflow-step/{workflow_id}/{id?}', ['uses' => 'WorkflowController@updateStep', 'as' => 'update-workflow-step']);

Route::match(['get', 'post'], 'workflows/update-step-notification/{step_id}/{id?}', ['uses' => 'WorkflowController@updateNotification', 'as' => 'update-step-notification']);

Route::match(['get', 'post'], 'workflows/update-step-assignee/{step_id}/{id?}', ['uses' => 'WorkflowController@updateAssignee', 'as' => 'update-step-assignee']);

Route::match(['get', 'post'], 'workflows/update-step-condition/{step_id}/{mode}/{id?}', ['uses' => 'WorkflowController@updateCondition', 'as' => 'update-step-condition']);

Route::match(['get', 'post'], 'workflows/update-step-trigger/{step_id}/{id?}', ['uses' => 'WorkflowController@updateTrigger', 'as' => 'update-step-trigger']);
Route::match(['get', 'post'], 'workflows/update-step-combined-trigger/{step_id}/{id?}', ['uses' => 'WorkflowController@updateCombinedTrigger', 'as' => 'update-step-combined-trigger']);
Route::match(['get', 'post'], 'workflows/combined-trigger-action/{step_id}/{id?}', ['uses' => 'WorkflowController@combinedTriggerAction', 'as' => 'combined-trigger-action']);

Route::match(['get', 'post'], 'workflows/update-step-metadata/{step_id}/{id?}', ['uses' => 'WorkflowController@updateMetadata', 'as' => 'update-step-metadata']);

Route::get('/delete-step/{stepId}', 'WorkflowController@delStep')->name('delete-step');
Route::get('/delete-assignee/{assId}', 'WorkflowController@delAssignee')->name('delete-assignee');
Route::get('/delete-notification/{notifId}', 'WorkflowController@delNotification')->name('delete-notif');
Route::get('/delete-condition/{condId}', 'WorkflowController@delCondition')->name('delete-condition');
Route::get('/delete-trigger/{triggerId}', 'WorkflowController@delTrigger')->name('delete-trigger');
Route::get('/delete-combined-trigger/{triggerId}', 'WorkflowController@delCombinedTrigger')->name('delete-combined-trigger');

Route::get('clear-notification', 'UsersController@clearNotification')->name('clear-notification');


