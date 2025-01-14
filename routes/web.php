<?php

use App\Livewire\Tools\LoremIpsumGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});


Route::get('/tools/lorem-ipsum', LoremIpsumGenerator::class)->name('tools.lorem-ipsum');
