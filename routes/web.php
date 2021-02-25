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
Route::post('/dashboard/data_kuota', 'HomeController@dataKuota')->name('dashboard.kuota');
Route::post('/dashboard/data_neraca', 'HomeController@dataNeraca')->name('dashboard.neraca');
Route::post('/dashboard/data_penghasil', 'HomeController@dataPenghasil')->name('dashboard.penghasil');
Route::post('/dashboard/data_kadaluarsa', 'HomeController@dashboardToBeKadaluarsa1')->name('dashboard.kadaluarsa');

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
Route::post('histori/update', 'PemohonController@updateRevisi')->name('history.update');
Route::resource('pemohon', 'PemohonController');

Route::post('penyimpanan/list', 'PenyimpananLimbahController@index')->name('penyimpanan.list');
Route::post('penyimpanan/update', 'PenyimpananLimbahController@update') -> name('penyimpanan.update');
Route::get('viewlist', 'PenyimpananLimbahController@viewIndex')->name('penyimpanan.listview');
Route::post('penyimpanan/updatepack', 'PenyimpananLimbahController@updatepack') -> name('penyimpanan.updatepack');
Route::resource('penyimpanan', 'PenyimpananLimbahController');


Route::post('pemrosesan/list', 'PemrosesanLimbahController@index')->name('pemrosesan.list');
Route::get('pemrosesan/viewlist', 'PemrosesanLimbahController@viewIndex')->name('pemrosesan.listview');
Route::post('pemrosesan/detaillist', 'PemrosesanLimbahController@detaillist')->name('pemrosesan.detaillist');
Route::post('pemrosesan/proses', 'PemrosesanLimbahController@proses') -> name('pemrosesan.proses');

Route::post('lain/list', 'PemrosesanLimbahController@indexLain')->name('lain.list');
Route::get('lain/viewlist', 'PemrosesanLimbahController@viewIndexLain')->name('lain.listview');
Route::post('lain/proses', 'PemrosesanLimbahController@prosesLain') -> name('lain.proses');
Route::post('lain/update', 'PemrosesanLimbahController@update') -> name('lain.update');
Route::get('lain/destroy/{id}', 'PemrosesanLimbahController@destroy');
Route::resource('pemrosesan', 'PemrosesanLimbahController');



Route::post('report/list', 'ReportLimbahController@index')->name('limbah.list');
Route::post('report/update', 'ReportLimbahController@update') -> name('limbah.update');
Route::get('neraca/viewlist', 'ReportLimbahController@viewIndexNeraca')->name('neraca.listview');
Route::post('neraca/daftar', 'ReportLimbahController@indexNeraca')->name('neraca.daftar');
Route::post('neraca/detail', 'ReportLimbahController@detailNeraca')->name('neraca.detail');
Route::get('/kadaluarsa/viewlist', 'ReportLimbahController@viewIndexKadaluarsa')->name('kadaluarsa.listview');
Route::get('/kapasitas/viewlist', 'ReportLimbahController@viewIndexKapasitas')->name('kapasitas.listview');
Route::post('kapasitas/daftar', 'ReportLimbahController@indexKapasitas')->name('kapasitas.daftar');
Route::get('penghasil/viewlist', 'ReportLimbahController@viewIndexPenghasil')->name('penghasil.listview');
Route::post('penghasil/daftar', 'ReportLimbahController@indexPenghasil')->name('penghasil.daftar');
Route::get('histori/viewlist', 'ReportLimbahController@viewHistory')->name('history.listview');
Route::post('histori/data', 'ReportLimbahController@indexHistory')->name('history.data');




Route::get('/penghasil/viewlist', 'ReportLimbahController@viewIndexPenghasil')->name('penghasil.listview');
// Route::get('/limbah/viewlist', 'ReportLimbahController@viewIndex')->name('limbah.listview');

// Route::get('/limbah/kuota_anggaran', 'ReportLimbahController@viewIndexKontrak')->name('kuota.listview');
Route::get('/kontrak/viewlist', 'ReportLimbahController@viewIndexKontrak')->name('kontrak.listview');
Route::post('/kontrak/data', 'ReportLimbahController@indexKontrak')->name('kontrak.data'); 
Route::post('/kontrak/editdata', 'ReportLimbahController@editData')->name('kontrak.editdata'); 
Route::post('/kontrak/kuota_anggaran/save', 'ReportLimbahController@storeAnggaran')->name('kontrak.save_anggaran');
Route::post('/kontrak/kuota_anggaran/update', 'ReportLimbahController@updateAnggaran')->name('kontrak.update_anggaran');
Route::post('/kontrak/kuota_anggaran/konsumsi', 'ReportLimbahController@updateKonsumsi')->name('kontrak.konsumsi_anggaran');
Route::resource('report', 'ReportLimbahController');

Route::get('formulir/viewlist', 'FormLimbahController@viewIndex')->name('formulir.listview');
Route::post('formulir/daftar', 'FormLimbahController@index')->name('formulir.daftar');
Route::get('formulir/cetak/{id}', 'FormLimbahController@cetakFormulir')->name('formulir.cetak'); 
// Route::get('/footballerdetail/GeneratePDFBA/{id}','JadwalController@GeneratePDFBA');
Route::resource('formulir', 'FormLimbahController');

 
Route::post('limbah/getnamalimbah', 'LimbahController@getNama')->name('limbah.getnama');
Route::post('limbah/getsatuanlimbah', 'LimbahController@getSatuan')->name('limbah.getsatuan'); 



Route::resource('user', 'MDUserController');
Route::get('user/destroy/{id}', 'MDUserController@destroy');
Route::post('user/userlist', 'MDUserController@index') -> name('user.list');
Route::post('user/update', 'MDUserController@update') -> name('user.update');

Route::resource('nama_limbah', 'MDNamaLimbahController');
Route::get('nama_limbah/destroy/{id}', 'MDNamaLimbahController@destroy');
Route::post('nama_limbah/nama_limbahlist', 'MDNamaLimbahController@index') -> name('nama_limbah.list');
Route::post('nama_limbah/update', 'MDNamaLimbahController@update') -> name('nama_limbah.update');

Route::resource('vendor', 'MDVendorController');
Route::get('vendor/destroy/{id}', 'MDVendorController@destroy');
Route::post('vendor/vendorlist', 'MDVendorController@index') -> name('vendor.list');
Route::post('vendor/update', 'MDVendorController@update') -> name('vendor.update');

//export
Route::get('/neraca/export/{month}/{year}', 'ExportDataController@downloadNeraca')-> name('export.neraca');



});