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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/',['as'=>'admin.chartrequest','uses'=>'ChartController@chartrequest']);
Route::get('/admin/home',['as'=>'admin.home','uses'=>'AdminController@index']);
Route::get('/admin/category',['as'=>'admin.category','uses'=>'AdminController@category']);
Route::get('/admin/category/delete/{id}',['as'=>'admin.category.delete','uses'=>'AdminController@categorydel']);
Route::post('/admin/category/store',['as'=>'admin.category.store','uses'=>'AdminController@categorystore']);
Route::get('/admin/subcategory',['as'=>'admin.subcategory','uses'=>'AdminController@subcategory']);
Route::get('/admin/subcategory/delete/{id}',['as'=>'admin.subcategory.delete','uses'=>'AdminController@subcategorydel']);
Route::post('/admin/subcategory/store',['as'=>'admin.subcategory.store','uses'=>'AdminController@subcategorystore']);
Route::get('/admin/spend',['as'=>'admin.spend','uses'=>'AdminController@spend']);
Route::post('/admin/spendstore',['as'=>'admin.spendstore','uses'=>'AdminController@spendstore']);

Route::get('/chartrequest',['as'=>'admin.chartrequest','uses'=>'ChartController@chartrequest']);
Route::post('/requestedchart',['as'=>'admin.requestedchart','uses'=>'ChartController@requested']);
Route::get('/chartjsmonth',['as'=>'admin.chartjsmonth','uses'=>'ChartController@chartjsmonth']);
Route::get('/chartjsmonthbycategory',['as'=>'admin.chartjsmonthbycategory','uses'=>'ChartController@chartjsmonthbycategory']);
Route::get('/chartjstwomonthbycategory',['as'=>'admin.chartjstwomonthbycategory','uses'=>'ChartController@chartjstwomonthbycategory']);
Route::get('/chartjstwomonthbysubcategory',['as'=>'admin.chartjstwomonthbysubcategory','uses'=>'ChartController@chartjstwomonthbysubcategory']);
Route::get('/chartjsyearbycategory',['as'=>'admin.chartjsyearbycategory','uses'=>'ChartController@chartjsyearbycategory']);
Route::get('/chartjsyearbysubcategory',['as'=>'admin.chartjsyearbysubcategory','uses'=>'ChartController@chartjsyearbysubcategory']);
Route::get('/chartjsyearbymonth',['as'=>'admin.chartjsyearbymonth','uses'=>'ChartController@chartjsyearbymonth']);
Route::get('/chartjstwoyearbycategory',['as'=>'admin.chartjstwoyearbycategory','uses'=>'ChartController@chartjstwoyearbycategory']);
Route::get('/chartjstwoyearbysubcategory',['as'=>'admin.chartjstwoyearbysubcategory','uses'=>'ChartController@chartjstwoyearbysubcategory']);
Route::get('/chartjstwoyearbymonth',['as'=>'admin.chartjstwoyearbymonth','uses'=>'ChartController@chartjstwoyearbymonth']);
Route::get('/chartjsbycurrentyearbymonth',['as'=>'admin.chartjsbycurrentyearbymonth','uses'=>'ChartController@chartjsbycurrentyearbymonth']);
Route::get('/chartjs',['as'=>'admin.spend','uses'=>'ChartController@chartjsbycurrentmonth']);
Route::get('/chartjscm',['as'=>'admin.spend','uses'=>'ChartController@chartjsbycurrentmonth']);
Route::get('/chartjscy',['as'=>'admin.spend','uses'=>'ChartController@chartjsbycurrentyear']);