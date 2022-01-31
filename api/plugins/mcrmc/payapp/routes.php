<?php
//User Route
Route::get('/getAuthenticatedUser', 'Mcrmc\Payapp\Controllers\UserControl@getAuthenticatedUser');
//Archive Routes
Route::get('/getNotPaid', 'Mcrmc\Payapp\Controllers\ArchiveControl@getNotPaid');
Route::get('/getPaid', 'Mcrmc\Payapp\Controllers\ArchiveControl@getPaid');
//Payment Routes
Route::post('/newPayment', 'Mcrmc\Payapp\Controllers\PayControl@newPayment');
Route::post('/getPaymentInfo', 'Mcrmc\Payapp\Controllers\PayControl@getPaymentInfo');
Route::post('/paymentSuccess', 'Mcrmc\Payapp\Controllers\PayControl@paymentSuccess');
//Stripe Routes
Route::get('/getStripeInfo', 'Mcrmc\Payapp\Controllers\StripeControl@getStripeInfo');
Route::post('/updateStripe', 'Mcrmc\Payapp\Controllers\StripeControl@updateStripe');
//Contact Form Routes
Route::post('/newContact', 'Mcrmc\Payapp\Controllers\ContactControl@newContact');
