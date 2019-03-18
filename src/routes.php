<?php
Route::get('greeting', function () {
    return 'koosisher tavoni?';
});

Route::get('corax','arashrasoulzadeh\corax\Controllers\CoraxController@hello');
Route::get('corax/http/listen','arashrasoulzadeh\corax\Controllers\CoraxController@listen');