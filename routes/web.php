<?php

use App\Models\User;
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
    // return view('welcome');
    $title = "Notification Title";
    $message = "Notification Message";
    $icon = "https://s3-ap-southeast-1.amazonaws.com/loket-production-sg/images/organization/20210312095654_604ad8766d6ba.jpg";
    $url = "https://yourwebsite.com/";
    $subscribers = array(
        "pmwOuwfxJyk6d3O9muqM0wA==",
    );

    $apiKey = "1ca4884911ca6288aea423b70653edbc";

    $curlUrl = "https://api.pushalert.co/rest/v1/send";

    //POST variables
    $post_vars = array(
        "icon" => $icon,
        "title" => $title,
        "message" => $message,
        "url" => $url,
        "subscriber" => "puWC5SFuLrqF91DJ/JSQtDA=="
    );

    $headers = array();
    $headers[] = "Authorization: api_key=" . $apiKey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curlUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_vars));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    $output = json_decode($result, true);
    if ($output["success"]) {
        echo $output["id"]; //Sent Notification ID
    } else {
        //Others like bad request
    }
    // return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('save-token');
Route::post('/send-notification', [App\Http\Controllers\HomeController::class, 'sendNotification'])->name('send.notification');
Route::get('/debug', function () {
    $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
    dd($firebaseToken);
});
