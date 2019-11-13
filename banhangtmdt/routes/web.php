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
});
Route::get('index',[
	'as'=>'trangchu',
	'uses'=>'PageController@getIndex'
]);


Route::get('loai-san-pham/{type}',[
	'as' => 'loaisanpham',
	'uses' => 'PageController@getLoaiSp'
]);

Route::get('chi-tiet-san-pham/{idsp}',[
	'as'=> 'chitietsanpham',
	'uses' => 'PageController@getChiTiet'
]);

Route::get('lien-he',[
	'as'=> 'lienhe',
	'uses'=>'PageController@getLienHe'
]);

Route::get('gioi-thieu',[
	'as'=>'gioithieu',
	'uses'=>'PageController@getGioiThieu'
]);

Route::post('add-to-cart/{id}',[
	'as' => 'themgiohang',
	'uses'=>'PageController@postAddtoCart'
]);

Route::get('del-cart/{id}',[
	'as'=>'xoagiohang',
	'uses' =>'PageController@getDelItemCart'
]);

Route::get('dat-hang',[
	'as' =>'dathang',
	'uses' =>'PageController@getDatHang' 
]);

Route::post('dat-hang',[
	'as' => 'dathang',
	'uses' => 'PageController@postDatHang'
]);

Route::get('dang-nhap',[
	'as' => 'dangnhap',
	'uses'=> 'PageController@getLogin'
]);

Route::post('dang-nhap',[
	'as' => 'dangnhap',
	'uses'=> 'PageController@postLogin'
]);

Route::get('dang-ky',[
	'as' => 'dangky',
	'uses'=> 'PageController@getRegister'
]);

Route::post('dang-ky',[
	'as' => 'dangky',
	'uses'=> 'PageController@postRegister'
]);

Route::get('dang-xuat',[
	'as'=> 'dangxuat',
	'uses'=>'PageController@postLogout'
]);

Route::get('tim-kiem',[
	'as' => 'timkiem',
	'uses' => 'PageController@getTimKiem'
]);

Route::post('sap-xep',[
	'as' => 'sapxep',
	'uses'=> 'PageController@postSapXep'
]);