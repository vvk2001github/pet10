<?php

use App\Http\Controllers\TetrisController;
use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main as MainChatComponent;
use App\Http\Livewire\User\Main as MainUserComponent;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/test', function () {
        return view('test');
    })->name('test');

    Route::get('/tetris', [TetrisController::class, 'index'])->name('tetris.index');

    // Chat
    Route::get('/chatusers', CreateChat::class)->name('chat.users');
    Route::get('/chat{key?}', MainChatComponent::class)->name('chat.chat');

    Route::get('/confuser', MainUserComponent::class)->name('confuser')->middleware(['can:configure.user']);
});
