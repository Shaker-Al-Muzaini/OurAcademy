<?php

use Illuminate\Support\Facades\Route;


Route::prefix('page-builder/')->as('page_builder.')->middleware(['auth'])->group(function () {
    Route::resource('pages', 'PageBuilderController')->except(['destroy','create']);
    Route::post('page/delete', 'PageBuilderController@destroy')->name('pages.destroy');
    Route::post('page/status', 'PageBuilderController@status')->name('pages.status');
    Route::get('page/design/{id}', 'PageBuilderController@design')->name('pages.design');
    Route::put('page/design/update/{id}', 'PageBuilderController@designUpdate')->name('pages.design.update');
    Route::get('page/affSnippet', 'PageBuilderController@affSnippet')->name('snippet');
});
