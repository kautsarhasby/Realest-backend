<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\DisableCsrfForTesting;
use App\Http\Middleware\handleCors as MiddlewareHandleCors;
use App\Models\Reminder;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/register',[UserController::class,'user']);
Route::post('/login',[UserController::class,'login']);
Route::get('/user/{username}',[UserController::class,'singleUser'])->name('user');;

Route::post('/message/{id}',[MessageController::class,'sendMessage'])->name('send');
Route::get('/message/{id}', [MessageController::class, 'index']);;
Route::patch('/editmessage/{id}',[MessageController::class,'updateMessage']);
Route::delete("/message/{id}",[MessageController::class,'deleteMessage']);

Route::post('/room',[RoomController::class,'store'])->name('room');
Route::get('/room',[RoomController::class,'index']);
Route::get('/room/{id}',[RoomController::class,'show']);

Route::post('/event',[EventController::class,'sendEvent']);
Route::get('/event/{id}',[EventController::class,'index']);
ROute::patch('/editevent/{id}',[EventController::class,'updateEvent']);
Route::delete('/event/{id}',[EventController::class,'deleteEvent']);

Route::post('/reminder',[ReminderController::class,'sendReminder']);
Route::get('/reminder/{id}',[ReminderController::class,'index']);  
Route::patch('/editreminder/{id}',[ReminderController::class,'updateReminder']); 
Route::delete('/reminder/{id}',[ReminderController::class,'deleteReminder']); 


Route::get('/information/{id}',[InformationController::class,'index']);
Route::post('/information',[InformationController::class,'sendInformation']);
Route::patch('/editinformation/{id}',[InformationController::class,'updateInformation']);
Route::delete('/information/{id}',[InformationController::class,'deleteInformation']);