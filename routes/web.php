<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['cas.auth'])->group(function() {
Route::get('/', function () {
	$authKey = Str::random(40);
        while (Cache::has($authKey)) {
		$authKey = Str::random(40);
        }
	Cache::forever($authKey, 0);
	$data['authKey'] = $authKey;
    	return view('weather',$data);
});
});
