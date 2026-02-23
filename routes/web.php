<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('cms/admin')->group(function(){
    Route::view('' , 'cms/temp');
    Route::resource('countries' , CountryController::class);

});
