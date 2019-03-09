<?php

use Illuminate\Http\Request;

//use App\Http\Controllers\ContactOwnerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api', 'content-type'])->group(
    function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::resource('contacts', 'ContactOwnerController', ['except' => 'store']);
        Route::post('contacts/{id}', [
            'uses' => ContactOwnerController::class . '@store',
            'as' => 'contacts.store',
        ]);
        Route::get('contacts/{contact}/relationships/home_address', [
            'uses' => ContactOwnerController::class . '@home_address',
            'as' => 'contacts.relationships.home_address',
        ]);
        Route::get('contacts/{contact}/relationships/mail_address', [
            'uses' => ContactOwnerController::class . '@mail_address',
            'as' => 'contacts.relationships.mail_address',
        ]);
        Route::get('contacts/{contact}/relationships/phone_number', [
            'uses' => ContactOwnerController::class . '@phone_number',
            'as' => 'contacts.relationships.phone_number',
        ]);
    }
);
