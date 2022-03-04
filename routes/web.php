<?php

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

Route::get('/','Controller@root')->name('root');
// Route::get('/logout','Controller@logout');

Route::group(['prefix' => 'customer'], function () {
  Route::get('/login', 'CustomerAuth\LoginController@showLoginForm')->name('customerlogin');
  Route::post('/login', 'CustomerAuth\LoginController@login');
  Route::post('/logout', 'CustomerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'CustomerAuth\RegisterController@register');
  Route::get('/accepted', 'TransactionController@accepted')->name('customerBidAccepted');

  Route::post('/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'CustomerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');
});

Auth::routes();


/*custom route for user*/

Route::get('/home', 'UserController@index')->name('home');
Route::get('/history', 'TransactionController@history')->name('history');
// Route::get('/message', 'UserController@message')->name('message');
Route::get('/message', 'MessageController@showallmessageUser')->name('message');

Route::get('/profile', 'UserController@profile')->name('profile');
Route::get('/edit/profile', 'UserController@edit_profile')->name('edit_profile');
Route::post('/insert/post', 'PostController@store')->name('insertPost');
Route::post('/delete/post', 'PostController@destroy')->name('deletePost');
Route::get('/edit/post/{id}', 'PostController@edit')->name('editPost');
Route::post('/edit/post/update', 'PostController@update')->name('updatePost');
Route::post('/edit/profile/update', 'UserController@profileUpdate')->name('editProfile');



/*custom route for customer*/

Route::get('/customer/profile', 'CustomerController@customerProfile')->name('customerProfile');
Route::get('/cutomer/profile/edit', 'CustomerController@editCustomerProfile')->name('editCustomerProfile');
Route::post('/cutomer/profile/update', 'CustomerController@editCustomerProfileUpdate')->name('edit_customer_profile_update');
Route::get('/category/wise/post/{category_id}', 'CustomerController@categoryWisePost')->name('category_wise_post');
Route::post('/customer/post/comment', 'CustomerController@customerComment')->name('customerComment');



/*about post*/
Route::get('/customer/post/view/{post_id}', 'PostController@customerviewpost')->name('viewpost');
Route::get('/customer/post/comment/delete/{comment_id}', 'PostController@commentDelete')->name('commentDelete');
Route::get('/customer/post/comment/edit/{comment_id}', 'PostController@commentEdit')->name('commentEdit');
Route::post('/customer/post/comment/edit/update', 'PostController@commentEditUpdate')->name('commentEditUpdate');


/*bid route for customer*/

Route::post('/customer/post/bid', 'BidController@createBid')->name('createBid');
Route::get('/customer/post/bid/delete/{bid_id}', 'BidController@deleteBid')->name('deleteBid');
Route::get('/customer/post/bid/edit/{bid_id}', 'BidController@editBid')->name('editBid');
Route::post('/customer/post/bid/edit/update', 'BidController@editBidUpdate')->name('editBidUpdate');


/** route for user post view */

Route::get('/view/post/{post_id}', 'UserPostViewController@viewSingleUserPost')->name('viewSingleUserPost');
Route::post('/user/post/comment', 'UserPostViewController@userComment')->name('userComment');
Route::get('/user/post/comment/delete/{comment_id}', 'UserPostViewController@deleteUserComment')->name('deleteUserComment');
Route::get('/user/post/comment/edit/{comment_id}', 'UserPostViewController@editUserComment')->name('editUserComment');
Route::post('/user/post/comment/update', 'UserPostViewController@userCommentUpdate')->name('userCommentUpdate');



/*route for bid accept*/

Route::post('/user/post/bid/accept', 'TransactionController@bidAccept')->name('bidAccept');
Route::get('/customer/work/complete/{id}', 'TransactionController@workdone')->name('workdone');
Route::post('/history/delete', 'TransactionController@delete_history')->name('delete_history');
Route::post('/customer/accepted/delete', 'TransactionController@delete_customer_history')->name('delete_customer_history');


/* route for profile view*/

Route::get('/profile/view/{status}/{id}', 'ProfileController@viewProfile')->name('viewProfile');


/*Message*/

Route::post('/message/send', 'MessageController@store')->name('messageSend');
Route::get('/message/view/individual/{cutomer_id}', 'MessageController@view_individual_message')->name('view_individual_message');



/*Customer Messages*/

Route::get('/customer/messages', 'CustomermessageController@customer_message')->name('customer_message');

Route::get('customer/message/view/individual/{id}/{status}', 'CustomermessageController@view_individual_customer_message')->name('view_individual_customer_message');

// Route::get('customer/message/view/individual/{user_id}', 'CustomermessageController@view_individual_message')->name('view_individual_message');










