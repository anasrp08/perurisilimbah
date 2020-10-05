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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['midlleware' => 'web'], function () {

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/dashboard/data', 'HomeController@dataDashboard')->name('dashboard.data');
Route::post('/dashboard/notifikasi', 'HomeController@dataNotifikasi')->name('notifikasi.data');

Route::get('/limbah/entri', 'LimbahController@viewEntri')->name('limbah.entri');
// Route::get('/limbah/update', 'LimbahController@Update')->name('limbah.update');
Route::get('/limbah/proses', 'LimbahController@viewProses')->name('limbah.proses');
Route::post('notifikasi/get', 'HomeController@getNotifikasi')->name('home.notifikasi');

Route::resource('limbah', 'LimbahController');
Route::post('limbah/list', 'LimbahController@index')->name('limbah.list');
Route::post('limbah/update', 'LimbahController@update') -> name('limbah.update');
Route::get('viewlist', 'LimbahController@viewIndex')->name('limbah.listview');

Route::get('/pemohon/viewlist', 'PemohonController@viewIndex')->name('pemohon.listview');
Route::get('pemohon/entri', 'PemohonController@viewEntri')->name('pemohon.entri');
Route::post('pemohon/list', 'PemohonController@index')->name('pemohon.list');
Route::post('pemohon/terima', 'PemohonController@updatevalid') -> name('pemohon.updatevalid');
Route::post('pemohon/validasi', 'PemohonController@updatedValidSatpam') -> name('satpam.valid');
Route::resource('pemohon', 'PemohonController');

Route::post('penyimpanan/list', 'PenyimpananLimbahController@index')->name('penyimpanan.list');
Route::post('penyimpanan/update', 'PenyimpananLimbahController@update') -> name('penyimpanan.update');
Route::get('viewlist', 'PenyimpananLimbahController@viewIndex')->name('penyimpanan.listview');
Route::post('penyimpanan/updatepack', 'PenyimpananLimbahController@updatepack') -> name('penyimpanan.updatepack');
Route::resource('penyimpanan', 'PenyimpananLimbahController');

Route::post('pemrosesan/list', 'PemrosesanLimbahController@index')->name('pemrosesan.list');
Route::post('pemrosesan/detaillist', 'PemrosesanLimbahController@detaillist')->name('pemrosesan.detaillist');
Route::post('pemrosesan/proses', 'PemrosesanLimbahController@proses') -> name('pemrosesan.proses');
Route::get('pemrosesan/viewlist', 'PemrosesanLimbahController@viewIndex')->name('pemrosesan.listview');
Route::resource('pemrosesan', 'PemrosesanLimbahController');



Route::post('report/list', 'ReportLimbahController@index')->name('limbah.list');
Route::post('report/update', 'ReportLimbahController@update') -> name('limbah.update');
Route::get('neraca/viewlist', 'ReportLimbahController@viewIndexNeraca')->name('neraca.listview');
Route::post('neraca/daftar', 'ReportLimbahController@indexNeraca')->name('neraca.daftar');
Route::get('/kadaluarsa/viewlist', 'ReportLimbahController@viewIndexKadaluarsa')->name('kadaluarsa.listview');
Route::get('/kapasitas/viewlist', 'ReportLimbahController@viewIndexKapasitas')->name('kapasitas.listview');
Route::post('kapasitas/daftar', 'ReportLimbahController@indexKapasitas')->name('kapasitas.daftar');
Route::get('penghasil/viewlist', 'ReportLimbahController@viewIndexPenghasil')->name('penghasil.listview');
Route::post('penghasil/daftar', 'ReportLimbahController@indexPenghasil')->name('penghasil.daftar');


Route::get('/kontrak/viewlist', 'ReportLimbahController@viewIndexKontrak')->name('kontrak.listview');
Route::post('/kontrak/data', 'ReportLimbahController@indexKontrak')->name('kontrak.data');
Route::get('/penghasil/viewlist', 'ReportLimbahController@viewIndexPenghasil')->name('penghasil.listview');
Route::get('/limbah/viewlist', 'ReportLimbahController@viewIndex')->name('limbah.listview');
Route::resource('report', 'ReportLimbahController');

Route::get('formulir/viewlist', 'FormLimbahController@viewIndex')->name('formulir.listview');
Route::post('formulir/daftar', 'FormLimbahController@index')->name('formulir.daftar');
Route::get('formulir/cetak/{id}', 'FormLimbahController@cetakFormulir')->name('formulir.cetak'); 
// Route::get('/footballerdetail/GeneratePDFBA/{id}','JadwalController@GeneratePDFBA');
Route::resource('formulir', 'FormLimbahController');

 
Route::post('limbah/getnamalimbah', 'LimbahController@getNama')->name('limbah.getnama');
Route::post('limbah/getsatuanlimbah', 'LimbahController@getSatuan')->name('limbah.getsatuan'); 

});