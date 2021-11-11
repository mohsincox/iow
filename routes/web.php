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

Route::get('/hh', function () {
    return 'hhhh';
});

// TEST ROUTE
// Route::post('/test', 'HomeController@test')->name('test');
// Route::get('/test', 'HomeController@test')->name('test');

Route::get('/404', function (){
    return "Nothing found";
})->name('404');


Route::get('/logout', 'UserController@logout')->name('logout');

# user controller
Route::match(['get','post'],'xadmin', 'UserController@admin_login')->name('admin.login');

Route::match(['get', 'post'], '/register', 'UserController@sign_up')->name('signup');
Route::match(['get', 'post'], '/login', 'UserController@customer_login')->name('signin');
//Route::match(['get', 'post'], '/xadmin/forgot-password', 'UserController@forgot_password')->name('forgot-password');
Route::match(['get', 'post'], '/forgot-password', 'UserController@forgot_password')->name('forgot-password');
Route::match(['get', 'post'],'/reset-password/{token}', 'UserController@reset_password')->name('reset-password');

Route::get('/google-login', 'UserController@redirectToGoogleProvider')->name('google-login');
Route::get('/google-callback', 'UserController@handleGoogleProviderCallback');

Route::get('/facebook-login', 'UserController@redirectToFacebookProvider')->name('facebook-login');
Route::get('/facebook-callback', 'UserController@handleFacebookProviderCallback');

# Admin Routes
Route::prefix('dashboard')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('admin','AdminController@admin_dashboard')->name('dashboard');

    //    user
    Route::match(['get','post'],'/add-user','AdminController@add_user_by_admin')->middleware('role_or_permission:Super_Admin|add_user')->name('add-user');
    Route::match(['get','post'],'/view-user','AdminController@view_user_by_admin')->middleware('role_or_permission:Super_Admin|view_user')->name('view-user');
    Route::match(['get','post'], '/edit-user/{user_id}','AdminController@edit_user_by_admin')->middleware('role_or_permission:Super_Admin|update_user')->name('edit-user');
    Route::post('/delete-user','AdminController@delete_user_by_admin')->middleware('role_or_permission:Super_Admin|delete_user')->name('delete-user');
    Route::post('/ajax-fetch-users','AdminController@ajax_fetch_users')->middleware('role_or_permission:Super_Admin|view_user')->name('ajax.fetch.user');

    // permission management
    Route::match(['get','post'], '/permission','AdminController@set_permission_by_admin')->middleware('role_or_permission:Super_Admin|update_permission')->name('permission');

    // category
    Route::match(['get','post'],'/add-category','ProductController@add_category_by_admin')->middleware('role_or_permission:Super_Admin|add_category')->name('add-category');
    Route::match(['get','post'],'/view-category','ProductController@view_category_by_admin')->middleware('role_or_permission:Super_Admin|view_category')->name('view-category');
    Route::match(['get','post'], '/edit-category/{category_id}','ProductController@edit_category_by_admin')->middleware('role_or_permission:Super_Admin|update_category')->name('edit-category');
    Route::post('/delete-category','ProductController@delete_category_by_admin')->middleware('role_or_permission:Super_Admin|delete_category')->name('delete-category');

    // sub_category
    Route::match(['get','post'],'/add-sub-category','ProductController@add_sub_category_by_admin')->middleware('role_or_permission:Super_Admin|add_sub_category')->name('add-sub-category');
    Route::match(['get','post'],'/view-sub-category','ProductController@view_sub_category_by_admin')->middleware('role_or_permission:Super_Admin|view_sub_category')->name('view-sub-category');
    Route::match(['get','post'], '/edit-sub-category/{sub_category_id}','ProductController@edit_sub_category_by_admin')->middleware('role_or_permission:Super_Admin|update_sub_category')->name('edit-sub-category');
    Route::post('/delete-sub-category','ProductController@delete_sub_category_by_admin')->middleware('role_or_permission:Super_Admin|delete_sub_category')->name('delete-sub-category');

    // product
    Route::match(['get','post'],'/add-product','ProductController@add_product_by_admin')->middleware('role_or_permission:Super_Admin|add_product')->name('add-product');
    Route::match(['get','post'],'/view-product','ProductController@view_product_by_admin')->middleware('role_or_permission:Super_Admin|view_product')->name('view-product');
    Route::match(['get','post'], '/edit-product/{product_id}','ProductController@edit_product_by_admin')->middleware('role_or_permission:Super_Admin|update_product')->name('edit-product');
    Route::post('/delete-product','ProductController@delete_product_by_admin')->middleware('role_or_permission:Super_Admin|delete_product')->name('delete-product');
    Route::post('/delete-product-image','ProductController@delete_product_image_by_admin')->middleware('role_or_permission:Super_Admin|update_product')->name('delete-product-image');

    // coupon
    Route::match(['get','post'],'/view-coupon','CouponController@view_coupon')->middleware('role_or_permission:Super_Admin|view_coupon')->name('view-coupon');
    Route::match(['get','post'],'/add-coupon','CouponController@add_coupon')->middleware('role_or_permission:Super_Admin|add_coupon')->name('add-coupon');
    Route::match(['get','post'],'/edit-coupon/{coupon_id}','CouponController@edit_coupon')->middleware('role_or_permission:Super_Admin|update_coupon')->name('edit-coupon');
    Route::post('/delete-coupon','CouponController@delete_coupon_by_admin')->middleware('role_or_permission:Super_Admin|delete_coupon')->name('delete-coupon');

    // view-purchase-discount routes
    Route::match(['get','post'],'/view-purchase-discount','CouponController@view_purchase_discount')->middleware('role_or_permission:Super_Admin|view_purchase_discount')->name('view-purchase-discount');
    Route::match(['get','post'],'/add-purchase-discount','CouponController@add_purchase_discount')->middleware('role_or_permission:Super_Admin|add_purchase_discount')->name('add-purchase-discount');
    Route::match(['get','post'],'/edit-purchase-discount/{discount_id}','CouponController@edit_purchase_discount')->middleware('role_or_permission:Super_Admin|update_purchase_discount')->name('edit-purchase-discount');
    Route::post('/delete-purchase-discount','CouponController@delete_purchase_discount')->middleware('role_or_permission:Super_Admin|delete_purchase_discount')->name('delete-purchase-discount');

    // slider
    Route::match(['get','post'],'/create-slider', 'CmsController@create_slider')->middleware('role_or_permission:Super_Admin|add_slider')->name('create-slider');
    Route::match(['get','post'],'/view-slider', 'CmsController@view_slider')->middleware('role_or_permission:Super_Admin|view_slider')->name('view-slider');
    Route::match(['get','post'],'/edit-slider/{id}', 'CmsController@edit_slider')->middleware('role_or_permission:Super_Admin|update_slider')->name('edit-slider');
    Route::match(['get','post'],'/delete-slider', 'CmsController@delete_slider')->middleware('role_or_permission:Super_Admin|delete_slider')->name('delete-slider');

    // recipe
    Route::match(['get','post'],'/create-recipe','RecipeController@create_recipe')->middleware('role_or_permission:Super_Admin|add_blog')->name('create-recipe');
    Route::match(['get','post'],'/view-recipe','RecipeController@view_recipe')->middleware('role_or_permission:Super_Admin|view_blog')->name('view-recipe');
    Route::match(['get','post'],'/edit-recipe/{slug}','RecipeController@edit_recipe')->middleware('role_or_permission:Super_Admin|update_blog')->name('edit-recipe');
    Route::post('/delete-recipe','RecipeController@delete_recipe')->middleware('role_or_permission:Super_Admin|delete_blog')->name('delete-recipe');

    // gallery
    Route::match(['get','post'],'/admin-add-gallery', 'GalleryController@add_gallery_by_admin')->middleware('role_or_permission:Super_Admin|add_gallery')->name('add-gallery');
    Route::get('/admin-view-gallery', 'GalleryController@view_gallery_by_admin')->middleware('role_or_permission:Super_Admin|view_gallery')->name('view-gallery');
    Route::match(['get','post'], '/admin-edit-gallery/{title_id}', 'GalleryController@edit_gallery_by_admin')->middleware('role_or_permission:Super_Admin|update_gallery')->name('edit-gallery');
    Route::post('/delete-gallery','GalleryController@delete_gallery_by_admin')->middleware('role_or_permission:Super_Admin|delete_gallery')->name('delete-gallery');
    Route::post('/delete-gallery-image','GalleryController@delete_gallery_image_by_admin')->middleware('role_or_permission:Super_Admin|update_gallery')->name('delete-gallery-image');

    // CMS
    Route::match(['get','post'],'/about-us','CmsController@about_us')->middleware('role_or_permission:Super_Admin|about_us')->name('about_us');
    Route::match(['get','post'],'/career','CmsController@career')->middleware('role_or_permission:Super_Admin|career')->name('career');
    Route::match(['get','post'],'/contact-us','CmsController@contact_us')->middleware('role_or_permission:Super_Admin|contact_us')->name('contact_us');
    Route::match(['get','post'],'/privacy-policy','CmsController@privacy_policy')->middleware('role_or_permission:Super_Admin|privacy_&_policy')->name('privacy_policy');
    Route::match(['get','post'],'/terms-condition','CmsController@terms_condition')->middleware('role_or_permission:Super_Admin|terms_&_condition')->name('terms-condition');

    // Order Route
    Route::get('/orders/history','OrderController@get_order_history')->middleware('role_or_permission:Super_Admin|view_order_history')->name('get-order-history');
    Route::post('/order-history-data','OrderController@get_orders_history_data')->middleware('role_or_permission:Super_Admin|view_order_history')->name('order-history-data');
    Route::get('/orders','OrderController@get_order')->middleware('role_or_permission:Super_Admin|view_order')->name('get-order');
    Route::post('/orderdata','OrderController@get_orders_data')->middleware('role_or_permission:Super_Admin|view_order')->name('order.data');
    Route::get('/order/change-status/{order_id}','OrderController@change_order_status')->middleware('role_or_permission:Super_Admin|update_order')->name('order.change-status');
    Route::post('/order/change-multi-status','OrderController@change_order_multi_status')->middleware('role_or_permission:Super_Admin|update_order')->name('order.change-multi-status');
    Route::get('/order-details/{order_id}','OrderController@order_details')->middleware('role_or_permission:Super_Admin|order_details')->name('order.details');
    Route::post('/order/mark-as-paid','OrderController@mark_as_paid')->middleware('role_or_permission:Super_Admin|order_payment')->name('order.mark-as-paid');

    // Admin Setting controler
    Route::match(['get','post'],'/admin-change-password', 'AdminSettingController@change_password')->middleware('role_or_permission:Super_Admin|Admin')->name('change-password');
});

 # Admin ajax routes
Route::name('ajax.')->group(function (){
    Route::post('/get-permission-by-role', 'AdminController@get_permission_by_role')->name('get_permission_by_role');
    Route::post('/get-attributes-value', 'ProductController@get_attributes_value')->name('get_attributes_value');
});


#Site Controller
//index Route

Route::match(['get','post'],'/', 'SiteController@index')->name('index');

//CMS Route
Route::get('/about-us', 'SiteController@get_about_us')->middleware('check_phone')->name('about-us');
Route::get('/terms-condition', 'SiteController@get_terms_condition')->middleware('check_phone')->name('terms-condition');
Route::get('/privacy-policy', 'SiteController@get_privacy_policy')->middleware('check_phone')->name('privacy-policy');
Route::match(['get','post'],'/contact-us', 'SiteController@get_contact_us')->middleware('check_phone')->name('contact-us');
Route::match(['get','post'],'/career', 'SiteController@career')->middleware('check_phone')->name('career');
Route::get('/faq', 'SiteController@get_faq')->middleware('check_phone')->name('faq');

//products Route

Route::match(['get','post'],'/products','SiteController@products')->middleware('check_phone')->name('products');
Route::match(['get','post'],'/product-details/{product_id}','SiteController@product_details')->middleware('check_phone')->name('product-details');

//offers route
Route::match(['get','post'],'/my-offer','SiteController@my_offers')->middleware('check_phone')->name('my-offer');
//cart route
Route::match(['get','post'],'/my-cart','SiteController@my_cart')->middleware('check_phone')->name('cart');

//checkout route
Route::match(['get','post'],'/checkout','SiteController@checkout')->middleware('check_phone')->name('checkout');
Route::post('/checkout-login','SiteController@checkout_login')->name('checkout-login');


// Recipe route
Route::match(['get','post'],'/igloo-recipe','SiteController@igloo_recipe')->middleware('check_phone')->name('igloo-recipe');
Route::match(['get','post'],'/igloo-article','SiteController@igloo_article')->middleware('check_phone')->name('igloo-article');
Route::get('/blog-details/{slug}','SiteController@get_recipe_details')->middleware('check_phone')->name('get-recipe-details');

// Gallery Route
Route::get('/igloo-gallery','GalleryController@igloo_gallery')->middleware('check_phone')->name('igloo-gallery');
Route::get('/igloo-gallery/{gallery_id}','GalleryController@single_igloo_gallery')->middleware('check_phone')->name('igloo-single-gallery');

// Order Process
Route::match(['get','post'],'/igloo-order-process','SiteController@igloo_order_process')->middleware('check_phone')->name('igloo-order-process');

// Customer route
Route::match(['get','post'],'/my-account', 'SiteController@customer_account')->middleware(['auth', 'role_or_permission:Customer'])->name('customer-account');
Route::post('/change-password', 'UserController@customer_change_password')->middleware(['auth', 'role_or_permission:Customer'])->name('customer-change-password');
Route::post('/upload-user-photo', 'UserController@upload_user_photo')->middleware(['auth', 'role_or_permission:Customer'])->name('upload-user-photo');
Route::post('/customer-edit-info', 'UserController@customer_edit_info')->middleware(['auth', 'role_or_permission:Customer'])->name('customer-edit-info');
Route::get('/customer/order-details/{order_id}','OrderController@customer_order_details')->middleware('role_or_permission:Customer')->name('customer.order.details');
Route::post('/submit-career', 'SiteController@submit_career')->name('submit-career');


# Cart routes
Route::get('/add-to-cart/{product_id}', 'CartController@add_to_cart')->middleware('check_phone');
Route::get('/remove-cart-item/{rowId}','CartController@remove_cart_item')->middleware('check_phone')->name('remove.item');
Route::post('/update-cart-item/','CartController@update_cart')->middleware('check_phone')->name('update.cart');
Route::post('/apply-discount/','CartController@apply_discount')->middleware('check_phone')->name('apply.discount');

#order route
Route::post('/place-order','OrderController@place_order')->middleware('check_phone')->name('place.order');
Route::match(['get','post'], '/thankyou','SiteController@thankyou')->name('thankyou');
Route::match(['get','post'], '/cancel-payment','SiteController@cancel_payment')->name('cancel-payment');



Route::post('/update/phone', 'UserController@customer_update_phone')->name('update-phone');


// Route::match(['get','post'],'/test', 'RecipeController@test')->name('test');