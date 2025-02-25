<?php

/**
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com amentotech
 * @link    http://www.amentotech.com
 */

Route::fallback(
    function () {
        return View('errors.404 ');
    }
);
Route::get('emailtmp', function () {
    return View('emails.jobs ');
});
// Authentication route
Auth::routes();
// Cache clear route
Route::get(
    'cache-clear',
    function () {
        \Artisan::call('config:cache');
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        return redirect()->back();
    }
);
// Home
if (empty(Request::segment(1))) {
    if (Schema::hasTable('users') && Schema::hasTable('site_managements')) {
        //Route::get('/', 'HomeController@index')->name('home');
        Route::get('/', 'HomeController@theme5');
    } else {
        if (!empty(env('DB_DATABASE'))) {
            Route::get(
                '/',
                function () {
                    return Redirect::to('/install');
                }
            );
        } else {
            return trans('lang.configure_database');
        }
    }
}

Route::post('/clear-modal-session', function () {
    session()->forget('show_registration_modal');
    return response()->json(['status' => 'success']);
})->middleware('web');


Route::get('/clear-registration-modal', function () {
    session()->forget('show_registration_modal');
    return redirect()->back();
})->name('clear.registration.modal');

Route::get('/clear-registration-modal', 'UserController@clearRegistrationModal')->name('clear.registration.modal');


Route::get(
    '/home',
    function () {
        return Redirect::to('/');
    }
)->name('home');
$this->get('onboard', 'Auth\RegisterController@showOnboardForm')->name('onboard');
$this->post('onboard', 'Auth\RegisterController@register');
Route::get('/theme5', 'HomeController@theme5');
/** Linkedin OAuth routes */
Route::get('/auth/linkedin/redirect', 'Auth\LinkedinController@handleLinkedinRedirect');
Route::get('/auth/linkedin/callback', 'Auth\LinkedinController@handleLinkedinCallback');

//SiteMap
Route::get('/sitemap', 'SiteMapController@index');
// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
//         \UniSharp\LaravelFilemanager\Lfm::routes();
//     });
//whishlist
Route::get('get-skills-homepage', 'SkillController@getcatskills');
Route::get('get-skills-homepage-slug', 'SkillController@getcatskillsslug');
Route::post('/chatbot', 'UserController@chatbot');

Route::get('/generate-completion', 'PublicController@generateCompletion');
Route::post('get-wishlist-freelancers', 'PublicController@getWishlistFreelancers');
Route::get('wishlist', 'PublicController@GuestWishlist');
Route::get('get-skills-for-wishlist', 'SkillController@getWhishlistSkills');
Route::get('get-categories-for-whishlist', 'CategoryController@getWishlistCategories');
Route::get('/delete-video', 'UserController@deleteVideo')->name('delete.video');

//seo-blogs
Route::get('blogs/{slug}', 'BlogController@BlogList')->name('FilteredBlogs');
Route::get('blogs', 'BlogController@BlogsList')->name('blogs');

//seo-courses
Route::get('courses/{slug}', 'CourseController@courseList')->name('FilteredCourses');
Route::get('courses', 'CourseController@coursesListing')->name('courses');

//seo-services
Route::get('services/{slug}', 'ServiceController@ServiceList')->name('FilteredServices');
Route::get('services', 'ServiceController@servicesListing')->name('services');

//seo-freelancers
Route::get('hire/{slug}', 'FreelancerController@freelancerList')->name('FilteredFreelancers');
Route::get('hire', 'FreelancerController@freelancersListing')->name('freelancers');

//seo-jobs
Route::get('jobs', 'JobController@jobsListing')->name('jobs');
Route::get('jobs/{slug}', 'JobController@jobsList')->name('FilteredJobs');


//seo-remote-developers
Route::get('hire-remote-developers', 'PublicController@remoteDevPage');
Route::post('post-guest-message', 'PublicController@storeGuestMsg');
Route::get('/get-login-user-role', 'PublicController@loginUserRole');

/*Route::get('/sendemail', 'SendMailController@index');
Route::post('/sendemail/send', 'SendMailController@send'); */

// Route::get('/workdiary', 'WorkDiaryController@index');
//Route::post('workdiary/create', 'WorkDiaryController@create');
//Route::get('/workdiary', 'WorkDiaryController@showFreelancerWorkDiary');

// Route::get('bill/{slug}/{status}/workdiary', 'WorkDiaryController@showEmployerWorkDiary');

// Route::post('bill/workdiary/create', 'WorkDiaryController@create');

Route::get('linkedin', function () {
    return view('loginlinkedin');
});

Route::get('/redirect', 'SocialAuthLinkedinController@redirect');
Route::get('/callback', 'SocialAuthLinkedinController@callback');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/connect/{user}', 'ConnectionController@sendRequest')->name('connect.send');
Route::get('/accept-request/{id}', 'ConnectionController@acceptRequest')->name('connect.accept');
Route::get('/reject-request/{id}', 'ConnectionController@rejectRequest')->name('connect.reject');
Route::get('/freelancer/pending-connections', 'ConnectionController@pendingRequest')->name('pending.connections');
Route::get('/freelancer/my-connections', 'ConnectionController@myConnections')->name('my.connections');

Route::get('articles/{category?}', 'ArticleController@articlesList')->name('articlesList');
Route::get('article/{slug}', 'ArticleController@showArticle')->name('showArticle');
Route::get('profile/{slug}', 'PublicController@showUserProfile')->name('showUserProfile');
Route::get('agency/{slug}', 'PublicController@agencyView')->name('agencyView');
Route::get('categories', 'CategoryController@categoriesList')->name('categoriesList');
Route::get('page/{slug}', 'PageController@show')->name('showPage');

Route::post('store/project-offer', 'UserController@storeProjectOffers');
if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'jobs') {
    // Route::get('jobs', 'JobController@listjobs')->name('jobs');
    Route::get('job/{slug}', 'JobController@show')->name('jobDetail');
}
Route::get('blog/{slug}', 'BlogController@show')->name('BlogDetail');
if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services') {
    // Route::get('services', 'ServiceController@index')->name('services');
    Route::get('service/{slug}', 'ServiceController@show')->name('serviceDetail');
}
if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'instructor') {

    Route::get('course/{slug}', 'CourseController@show')->name('CourceDetail');
}
Route::get('user/password/reset/{verify_code}', 'PublicController@resetPasswordView')->name('getResetPassView');
Route::post('user/update/password', 'PublicController@resetUserPassword')->name('resetUserPassword');
// Authentication|Guest Routes
Route::post('register/onboard-user', 'Auth\RegisterController@onBoardDirectly');
Route::post('register/login-register-user', 'PublicController@loginUser')->name('loginUser');
Route::post('register/verify-user-code', 'PublicController@verifyUserCode');
Route::post('register/form-step1-custom-errors', 'PublicController@RegisterStep1Validation');
Route::post('register/form-step2-custom-errors', 'PublicController@RegisterStep2Validation');
Route::get('search-results', 'PublicController@getSearchResult')->name('searchResults');
Route::post('user/add-wishlist', 'UserController@addWishlist');
Route::post('user/remove-wishlist', 'UserController@RemoveWishlist');
Route::post('/apply-coupon', 'CouponController@applyCoupon');
// Admin Routes
Route::group(
    ['middleware' => ['role:admin']],
    function () {
        Route::get('user', ['uses' => 'UserController@records', 'as' => 'user.records']);
        Route::resource('admin/coupons', CouponController::class);


        // Article Category Routes
        Route::get('admin/article/categories', 'ArticleCategoryController@index')->name('articleCategories');
        Route::post('admin/get-freelancer-skills', 'SkillController@getAdminFreelancerSkills');
        Route::post('admin/get-admin-freelancer-skills', 'FreelancerController@getAdminFreelancerSkills');
        Route::get('admin/article/categories/edit-cats/{id}', 'ArticleCategoryController@edit')->name('editArticleCategories');
        Route::post('admin/article/store-category', 'ArticleCategoryController@store');
        Route::get('admin/article/categories/search', 'ArticleCategoryController@index');
        Route::post('admin/article/categories/delete-cats', 'ArticleCategoryController@destroy');
        Route::post('admin/article/categories/update-cats/{id}', 'ArticleCategoryController@update');
        Route::post('admin/articles/categories/upload-temp-image', 'ArticleCategoryController@uploadTempImage');
        Route::post('admin/article/delete-checked-cats', 'ArticleCategoryController@deleteSelected');
        // Articles Routes
        Route::get('admin/articles', 'ArticleController@index')->name('articles');
        Route::get('admin/articles/edit-article/{id}', 'ArticleController@edit')->name('editArticle');
        Route::post('admin/articles/store-article', 'ArticleController@store');
        Route::get('admin/articles/search', 'ArticleController@index');
        Route::post('admin/articles/delete-article', 'ArticleController@destroy');
        Route::post('admin/articles/update-article/{id}', 'ArticleController@update');
        Route::post('admin/articles/upload-temp-image', 'ArticleController@uploadTempImage');
        Route::post('admin/article/delete-checked-article', 'ArticleController@deleteSelected');

        Route::post('admin/clear-cache', 'SiteManagementController@clearCache');
        Route::get('admin/clear-allcache', 'SiteManagementController@clearAllCache');
        Route::get('admin/import-updates', 'SiteManagementController@importUpdate');
        Route::get('admin/import-demo', 'SiteManagementController@importDemo');
        Route::get('admin/remove-demo', 'SiteManagementController@removeDemoContent');
        Route::get('admin/payouts', 'UserController@getPayouts')->name('adminPayouts');
        Route::post('admin/update-payout-status', 'UserController@updatePayoutStatus');
        Route::get('admin/payouts/download/{year}/{month}/{ids?}', 'UserController@generatePDF');

        Route::get('users-datatable', 'UserController@datatable')->name('users.datatable');
        Route::get('users-data', 'UserController@usersList')->name('users.data');


        Route::get('admin/dashboard', 'StatsController@index')->name('adminDashboard');


        Route::post('admin/store-freelancer-profile-settings', 'UserController@storeFreelancerProfileSettings');
        Route::post('admin/store-employer-profile-settings', 'UserController@storeEmployerProfileSettings');

        Route::get('admin/home-page-settings', 'SiteManagementController@homePageSettings')->name('homePageSettings');
        Route::post('admin/get-page-option', 'SiteManagementController@getPageOption');
        // Skill Routes
        Route::get('admin/skills', 'SkillController@index')->name('skills');
        Route::get('admin/skills/edit-skills/{id}', 'SkillController@edit')->name('editSkill');
        Route::post('admin/store-skill', 'SkillController@store');
        Route::post('admin/skills/update-skills/{id}', 'SkillController@update');
        Route::get('admin/skills/search', 'SkillController@index');
        Route::post('admin/skills/delete-skills', 'SkillController@destroy');
        Route::post('admin/delete-checked-skills', 'SkillController@deleteSelected');
        // Department Routes
        Route::get('admin/departments', 'DepartmentController@index')->name('departments');
        Route::get('admin/departments/edit-dpts/{id}', 'DepartmentController@edit')->name('editDepartment');
        Route::post('admin/store-department', 'DepartmentController@store');
        Route::get('admin/departments/search', 'DepartmentController@index');
        Route::post('admin/departments/delete-dpts', 'DepartmentController@destroy');
        Route::post('admin/departments/update-dpts/{id}', 'DepartmentController@update');
        Route::post('admin/delete-checked-dpts', 'DepartmentController@deleteSelected');
        // Language Routes
        Route::get('admin/languages', 'LanguageController@index')->name('languages');
        Route::get('admin/languages/edit-langs/{id}', 'LanguageController@edit')->name('editLanguages');
        Route::post('admin/store-language', 'LanguageController@store');
        Route::get('admin/languages/search', 'LanguageController@index');
        Route::post('admin/languages/delete-langs', 'LanguageController@destroy');
        Route::post('admin/languages/update-langs/{id}', 'LanguageController@update');
        Route::post('admin/delete-checked-langs', 'LanguageController@deleteSelected');
        // Category Routes
        Route::get('admin/categories', 'CategoryController@index')->name('categories');
        Route::get('admin/categories/edit-cats/{id}', 'CategoryController@edit')->name('editCategories');
        Route::post('admin/store-category', 'CategoryController@store');
        Route::get('admin/categories/search', 'CategoryController@index');
        Route::post('admin/categories/delete-cats', 'CategoryController@destroy');
        Route::post('admin/categories/update-cats/{id}', 'CategoryController@update');
        Route::post('admin/categories/upload-temp-image', 'CategoryController@uploadTempImage');
        Route::post('admin/delete-checked-cats', 'CategoryController@deleteSelected');
        // Badges Routes
        Route::get('admin/badges', 'BadgeController@index')->name('badges');
        Route::get('admin/badges/edit-badges/{id}', 'BadgeController@edit')->name('editbadges');
        Route::post('admin/store-badge', 'BadgeController@store');
        Route::get('admin/badges/search', 'BadgeController@index');
        Route::post('admin/badges/delete-badges', 'BadgeController@destroy');
        Route::post('admin/badges/update-badges/{id}', 'BadgeController@update');
        Route::post('admin/badges/upload-temp-image', 'BadgeController@uploadTempImage');
        Route::post('admin/delete-checked-badges', 'BadgeController@deleteSelected');
        // Location Routes
        Route::get('admin/locations', 'LocationController@index')->name('locations');
        Route::get('admin/locations/edit-locations/{id}', 'LocationController@edit')->name('editLocations');
        Route::post('admin/store-location', 'LocationController@store');
        Route::post('admin/locations/delete-locations', 'LocationController@destroy');
        Route::post('/admin/locations/update-location/{id}', 'LocationController@update');
        Route::post('admin/get-location-flag', 'LocationController@getFlag');
        Route::post('admin/locations/upload-temp-image', 'LocationController@uploadTempImage');
        Route::post('admin/delete-checked-locs', 'LocationController@deleteSelected');
        // Review Options Routes
        Route::get('admin/review-options', 'ReviewController@index')->name('reviewOptions');
        Route::get('admin/review-options/edit-review-options/{id}', 'ReviewController@edit')->name('editReviewOptions');
        Route::post('admin/store-review-options', 'ReviewController@store');
        Route::post('admin/review-options/delete-review-options', 'ReviewController@destroy');
        Route::post('admin/review-options/update-review-options/{id}', 'ReviewController@update');
        Route::post('admin/delete-checked-rev-options', 'ReviewController@deleteSelected');
        // Delivery Time Routes
        Route::get('admin/delivery-time', 'DeliveryTimeController@index')->name('deliveryTime');
        Route::get('admin/delivery-time/edit-delivery-time/{id}', 'DeliveryTimeController@edit')->name('editDeliveryTime');
        Route::post('admin/store-delivery-time', 'DeliveryTimeController@store');
        Route::post('admin/delivery-time/delete-delivery-time', 'DeliveryTimeController@destroy');
        Route::post('admin/delivery-time/update-delivery-time/{id}', 'DeliveryTimeController@update');
        Route::post('admin/delete-checked-delivery-time', 'DeliveryTimeController@deleteSelected');
        // Response Time Routes
        Route::get('admin/response-time', 'ResponseTimeController@index')->name('ResponseTime');
        Route::get('admin/response-time/edit-response-time/{id}', 'ResponseTimeController@edit')->name('editResponseTime');
        Route::post('admin/store-response-time', 'ResponseTimeController@store');
        Route::post('admin/response-time/delete-response-time', 'ResponseTimeController@destroy');
        Route::post('admin/response-time/update-response-time/{id}', 'ResponseTimeController@update');
        Route::post('admin/delete-checked-response-time', 'ResponseTimeController@deleteSelected');
        // Site Management Routes
        Route::get('admin/settings', 'SiteManagementController@Settings')->name('settings');
        Route::post('admin/store/email-settings', 'SiteManagementController@storeEmailSettings');
        Route::post('admin/store/home-settings', 'SiteManagementController@storeHomeSettings');
        Route::get('admin/get-section-display-setting', 'SiteManagementController@getSectionDisplaySetting');
        Route::get('admin/get-chat-display-setting', 'SiteManagementController@getchatDisplaySetting');
        Route::post('admin/store/section-settings', 'SiteManagementController@storeSectionSettings');
        Route::post('admin/store/service-section-settings', 'SiteManagementController@storeServiceSectionSettings');
        Route::post('admin/store/settings', 'SiteManagementController@storeGeneralSettings');
        Route::post('admin/store/general-home-settings', 'SiteManagementController@storeGeneralHomeSettings');
        Route::post('admin/store/chat-settings', 'SiteManagementController@storeChatSettings');

        Route::get('admin/get/registration-settings', 'SiteManagementController@getRegistrationSettings');
        Route::get('admin/get/site-payment-option', 'SiteManagementController@getSitePaymentOption');
        // Route::get('admin/theme-style-settings', 'SiteManagementController@ThemeStyleSettings');
        Route::post('admin/store/theme-styling-settings', 'SiteManagementController@storeThemeStylingSettings');
        Route::get('admin/get-theme-color-display-setting', 'SiteManagementController@getThemeColorDisplaySetting');
        Route::post('admin/store/registration-settings', 'SiteManagementController@storeRegistrationSettings');
        Route::post('admin/upload-temp-image/{file_name}', 'SiteManagementController@uploadTempImage');
        Route::post('admin/pages/upload-temp-image/{file_name}', 'PageController@uploadTempImage');
        Route::post('admin/store/upload-icons', 'SiteManagementController@storeDashboardIcons');
        Route::post('admin/store/footer-settings', 'SiteManagementController@storeFooterSettings');
        Route::post('admin/store/access-type-settings', 'SiteManagementController@storeAccessTypeSettings');
        Route::post('admin/store/social-settings', 'SiteManagementController@storeSocialSettings');
        Route::post('admin/store/search-menu', 'SiteManagementController@storeSearchMenu');
        Route::post('admin/store/commision-settings', 'SiteManagementController@storeCommisionSettings');
        Route::post('admin/store/payment-settings', 'SiteManagementController@storePaymentSettings');
        Route::post('admin/store/stripe-payment-settings', 'SiteManagementController@storeStripeSettings');
        Route::post('admin/store/banktransfar-settings', 'SiteManagementController@storeBankTransfarSettings');
        Route::get('admin/email-templates', 'EmailTemplateController@index')->name('emailTemplates');
        Route::get('admin/email-templates/filter-templates', 'EmailTemplateController@index')->name('emailTemplates');
        Route::get('admin/manage-users/filter-users', 'UserController@userListing');
        Route::get('admin/email-templates/{id}', 'EmailTemplateController@edit')->name('editEmailTemplates');
        Route::post('admin/email-templates/update-content', 'EmailTemplateController@updateTemplateContent');
        Route::post('admin/email-templates/update-templates/{id}', 'EmailTemplateController@update');
        Route::get('admin/invitation', 'UserController@newInviteForm')->name('inviteUser');
        Route::post('admin/invitationsubmit', 'UserController@newInvite')->name('inviteUserSubmit');




        Route::post('admin/get/project-settings', 'SiteManagementController@getprojectSettings');
        Route::post('admin/store/project-settings', 'SiteManagementController@storeProjectSettings');
        Route::post('admin/store/bank-detail', 'SiteManagementController@storeBankDetail');
        Route::post('admin/store/order-settings', 'SiteManagementController@storeOrderSettings');
        // Pages Routes
        Route::get('admin/pages', 'PageController@index')->name('pages');
        Route::get('admin/create/pages', 'PageController@create')->name('createPage');
        Route::get('admin/pages/edit-page/{id}', 'PageController@edit')->name('editPage');
        Route::post('admin/store-page', 'PageController@store');
        Route::get('admin/pages/search', 'PageController@index');
        Route::post('admin/pages/delete-page', 'PageController@destroy');
        Route::post('admin/pages/update-page/{id}', 'PageController@update');
        Route::post('admin/delete-checked-pages', 'PageController@deleteSelected');
        //All Jobs
        Route::get('admin/jobs', 'JobController@jobsAdmin')->name('allJobs');
        Route::get('admin/jobs/search', 'JobController@jobsAdmin');
        //All Services
        Route::get('admin/services', 'ServiceController@adminServices')->name('allServices');
        Route::get('admin/service-orders', 'ServiceController@adminServiceOrders')->name('ServiceOrders');
        Route::get('admin/services/search', 'ServiceController@adminServices');
        Route::patch('/admin/services/{id}/status', 'ServiceController@updateStatus')->name('admin.updateServiceStatus');

        //All Courses
        Route::get('admin/courses', 'CourseController@adminCourses')->name('allCourses');
        Route::get('admin/course-orders', 'CourseController@adminCourseOrders')->name('adminCourseOrders');
        Route::get('admin/course/search', 'CourseController@adminCourses');
        Route::patch('/admin/courses/{id}/status', 'CourseController@updateStatus')->name('admin.updateCourseStatus');

        //All packages
        Route::get('admin/packages', 'PackageController@create')->name('createPackage');
        Route::get('admin/packages/search', 'PackageController@create');
        Route::get('admin/packages/edit/{slug}', 'PackageController@edit')->name('editPackage');
        Route::post('admin/packages/update/{slug}', 'PackageController@update');
        Route::post('admin/store/package', 'PackageController@store');
        Route::post('admin/packages/delete-package', 'PackageController@destroy');
        Route::post('package/get-package-options', 'PackageController@getPackageOptions');

        Route::get('admin/profile', 'UserController@adminProfileSettings')->name('adminProfile');
        Route::post('admin/store-profile-settings', 'UserController@storeProfileSettings');
        Route::post('admin/upload-temp-image', 'UserController@uploadTempImage');
        Route::post('admin/submit-user-refund', 'UserController@submitUserRefund');

        Route::get('admin/orders', 'UserController@showOrders')->name('orderList');
        Route::post('admin/order/change-status', 'UserController@changeOrderStatus');
        //rating to freelancer



        Route::get('/admin/login-notification', [
            'as' => 'UserData',
            'uses' => 'UserController@getLogNotificationData'
        ]);
        Route::get('/admin/send-notifications', 'UserController@viewNotificationData')->name('viewMobileNotification');
        Route::post('/admin/send-notifications-post', 'UserController@sendNotificationData')->name('sendMobileNotification');
        Route::post('/admin/login-notification-updated', 'UserController@updateNotificationData');

        //blogs
        Route::get('admin/manage-blogs', 'BlogController@manageAdminBlogs')->name('manageAdminBlogs');
    }
);
Route::group(
    ['middleware' => ['role:editor|admin']],
    function () {
        Route::post('admin/store-freelancer-profile-settings', 'UserController@storeFreelancerProfileSettings');
        Route::get('admin/export-users', 'UserController@export');
        Route::post('admin/get-freelancer-skills', 'SkillController@getAdminFreelancerSkills');
        Route::post('admin/get-admin-freelancer-skills', 'FreelancerController@getAdminFreelancerSkills');
        Route::get('admin/invite-people', 'InvitationController@index')->name('invitePeople');
        Route::post('admin/invite-people', 'InvitationController@sendInvitation');
        Route::get('editor/dashboard', 'StatsController@index')->name('editorDashboard');
        Route::get('users', 'UserController@userListing')->name('userListing');
        Route::get('users/profile-edit/{id}', 'UserController@userProfileUpdate');
        Route::post('/admin/update-user-is-featured-status', 'UserController@updateIsFeaturedStatus');
        Route::post('/admin/update-user-is-certified-status', 'UserController@updateIsCertifiedStatus');
        Route::post('/admin/update-user-is-disabled-status', 'UserController@updateIsDisabledStatus');
        Route::post('/admin/update-user-badge', 'UserController@updateUserBadge');
        Route::post('admin/submit-rating', 'FreelancerController@adminRating');
        Route::post('admin/submit-course-rating', 'FreelancerController@adminCourseRating');
        // Skill Routes
        Route::get('admin/skills', 'SkillController@index')->name('skills');
        Route::get('admin/skills/edit-skills/{id}', 'SkillController@edit')->name('editSkill');
        Route::post('admin/store-skill', 'SkillController@store');
        Route::post('admin/skills/update-skills/{id}', 'SkillController@update');
        Route::get('admin/skills/search', 'SkillController@index');
        Route::post('admin/skills/delete-skills', 'SkillController@destroy');
        Route::post('admin/delete-checked-skills', 'SkillController@deleteSelected');
        // Department Routes
        Route::get('admin/departments', 'DepartmentController@index')->name('departments');
        Route::get('admin/departments/edit-dpts/{id}', 'DepartmentController@edit')->name('editDepartment');
        Route::post('admin/store-department', 'DepartmentController@store');
        Route::get('admin/departments/search', 'DepartmentController@index');
        Route::post('admin/departments/delete-dpts', 'DepartmentController@destroy');
        Route::post('admin/departments/update-dpts/{id}', 'DepartmentController@update');
        Route::post('admin/delete-checked-dpts', 'DepartmentController@deleteSelected');
        // Language Routes
        Route::get('admin/languages', 'LanguageController@index')->name('languages');
        Route::get('admin/languages/edit-langs/{id}', 'LanguageController@edit')->name('editLanguages');
        Route::post('admin/store-language', 'LanguageController@store');
        Route::get('admin/languages/search', 'LanguageController@index');
        Route::post('admin/languages/delete-langs', 'LanguageController@destroy');
        Route::post('admin/languages/update-langs/{id}', 'LanguageController@update');
        Route::post('admin/delete-checked-langs', 'LanguageController@deleteSelected');
        // Category Routes
        Route::get('admin/categories', 'CategoryController@index')->name('categories');
        Route::get('admin/categories/edit-cats/{id}', 'CategoryController@edit')->name('editCategories');
        Route::post('admin/store-category', 'CategoryController@store');
        Route::get('admin/categories/search', 'CategoryController@index');
        Route::post('admin/categories/delete-cats', 'CategoryController@destroy');
        Route::post('admin/categories/update-cats/{id}', 'CategoryController@update');
        Route::post('admin/categories/upload-temp-image', 'CategoryController@uploadTempImage');
        Route::post('admin/delete-checked-cats', 'CategoryController@deleteSelected');
        // Badges Routes
        Route::get('admin/badges', 'BadgeController@index')->name('badges');
        Route::get('admin/badges/edit-badges/{id}', 'BadgeController@edit')->name('editbadges');
        Route::post('admin/store-badge', 'BadgeController@store');
        Route::get('admin/badges/search', 'BadgeController@index');
        Route::post('admin/badges/delete-badges', 'BadgeController@destroy');
        Route::post('admin/badges/update-badges/{id}', 'BadgeController@update');
        Route::post('admin/badges/upload-temp-image', 'BadgeController@uploadTempImage');
        Route::post('admin/delete-checked-badges', 'BadgeController@deleteSelected');
        // Location Routes
        Route::get('admin/locations', 'LocationController@index')->name('locations');
        Route::get('admin/locations/edit-locations/{id}', 'LocationController@edit')->name('editLocations');
        Route::post('admin/store-location', 'LocationController@store');
        Route::post('admin/locations/delete-locations', 'LocationController@destroy');
        Route::post('/admin/locations/update-location/{id}', 'LocationController@update');
        Route::post('admin/get-location-flag', 'LocationController@getFlag');
        Route::post('admin/locations/upload-temp-image', 'LocationController@uploadTempImage');
        Route::post('admin/delete-checked-locs', 'LocationController@deleteSelected');
        // Delivery Time Routes
        Route::get('admin/delivery-time', 'DeliveryTimeController@index')->name('deliveryTime');
        Route::get('admin/delivery-time/edit-delivery-time/{id}', 'DeliveryTimeController@edit')->name('editDeliveryTime');
        Route::post('admin/store-delivery-time', 'DeliveryTimeController@store');
        Route::post('admin/delivery-time/delete-delivery-time', 'DeliveryTimeController@destroy');
        Route::post('admin/delivery-time/update-delivery-time/{id}', 'DeliveryTimeController@update');
        Route::post('admin/delete-checked-delivery-time', 'DeliveryTimeController@deleteSelected');
        // Response Time Routes
        Route::get('admin/response-time', 'ResponseTimeController@index')->name('ResponseTime');
        Route::get('admin/response-time/edit-response-time/{id}', 'ResponseTimeController@edit')->name('editResponseTime');
        Route::post('admin/store-response-time', 'ResponseTimeController@store');
        Route::post('admin/response-time/delete-response-time', 'ResponseTimeController@destroy');
        Route::post('admin/response-time/update-response-time/{id}', 'ResponseTimeController@update');
        Route::post('admin/delete-checked-response-time', 'ResponseTimeController@deleteSelected');

        // Route::get('admin/profile', 'UserController@adminProfileSettings')->name('adminProfile');
        Route::get('editor/profile', 'UserController@editorProfileSettings')->name('editorProfile');
        Route::post('editor/store-profile-settings', 'UserController@storeProfileSettings');
        Route::post('editor/upload-temp-image', 'UserController@uploadTempImage');
        Route::post('admin/upload-temp-image', 'UserController@uploadTempImage');

        //blogs
        Route::get('editor/dashboard/post-blog', 'BlogController@create')->name('PostBlog');
        Route::post('blog/get-stored-blog-skills', 'BlogController@getBlogSkills');
        Route::post('skills/get-blog-skills', 'SkillController@getBlogSkills');
        Route::post('blogs/post-blog', 'BlogController@store');
        Route::post('blog/upload-temp-image', 'BlogController@uploadTempImage');
        Route::get('editor/manage-blogs', 'BlogController@manageBlogs')->name('manageBlogs');
        Route::get('editor/blogs', 'BlogController@editorBlogs')->name('editorBlogs');

        Route::post('{role}/dashboard/delete-blog', 'BlogController@destroy');
        Route::get('{role}/dashboard/edit-blog/{id}', 'BlogController@edit')->name('edit_blog');
        Route::get('get/{type}/{filename}/{id}', 'PublicController@getFile')->name('getfile');
        Route::post('blog/update-blog', 'BlogController@update');
        Route::post('blog/change-status', 'BlogController@changeStatus');

        //landing page guests
        Route::get('editor/pages', 'PageController@dynamicPages');
        Route::get('/guest-messages', 'PublicController@showGuestInfo')->name('guestMessages');

        //seo inner pages edit
        Route::get('editor/settings/inner-pages', 'SiteManagementController@editorInnerPageSettings');
        Route::post('admin/store/breadcrumbs-settings', 'SiteManagementController@storeBreadcrumbsSettings');
        Route::post('admin/get/breadcrumbs-settings', 'SiteManagementController@getBreadcrumbsSettings');
        Route::post('admin/store/innerpage-settings', 'SiteManagementController@storeInnerPageSettings');
        Route::post('admin/get/innerpage-settings', 'SiteManagementController@getInnerPageSettings');
    }
);
Route::group(
    ['middleware' => ['role:employer|admin']],
    function () {
        Route::get('job/edit-job/{job_slug}', 'JobController@edit')->name('editJob');
        Route::post('job/get-stored-job-skills', 'JobController@getJobSkills');
        Route::post('job/get-job-settings', 'JobController@getAttachmentSettings');
        Route::post('job/update-job', 'JobController@update');
        Route::post('skills/get-job-skills', 'SkillController@getJobSkills');
        Route::post('job/delete-job', 'JobController@destroy');
        Route::get('proposal/{slug}/{status}', 'ProposalController@show');
    }
);
Route::group(
    ['middleware' => ['role:freelancer|admin']],
    function () {
        if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services') {
            Route::get('freelancer/services/{status}', 'FreelancerController@showServices')->name('ServiceListing');
            Route::get('freelancer/service/{id}/{status}', 'FreelancerController@showServiceDetail')->name('ServiceDetail');
            Route::get('freelancer/courses/{status}', 'FreelancerController@showCourses')->name('CourseListing');
            Route::get('freelancer/course/{id}/{status}', 'FreelancerController@showCourseDetail');
        }
        Route::get('freelancer/course/orders', 'CourseController@courseOrders')->name('CourseOrders');
        Route::post('services/change-status', 'ServiceController@changeStatus');
        Route::post('courses/change-status', 'CourseController@changeStatus');
        Route::post('courses/change-course-status', 'CourseController@changeCourseStatus');
        Route::get('freelancer/dashboard/edit-service/{id}', 'ServiceController@edit')->name('edit_service');
        Route::get('freelancer/dashboard/edit-course/{id}', 'CourseController@edit')->name('edit_course');
        Route::post('course/get-stored-course-skills', 'CourseController@getCourseSkills');
        Route::post('service/get-stored-service-skills', 'ServiceController@getServiceSkills');
        Route::post('agency/get-stored-agency-skills', 'AgencyController@getAgencySkills');
        Route::post('skills/get-course-skills', 'SkillController@getCourseSkills');
        Route::post('skills/get-service-skills', 'SkillController@getServiceSkills');
        Route::post('skills/get-agency-skills', 'SkillController@getAgencySkills');
        Route::post('services/post-service', 'ServiceController@store');
        Route::post('courses/post-course', 'CourseController@store');
        Route::post('service/upload-temp-image', 'ServiceController@uploadTempImage');
        Route::post('cource/upload-temp-image', 'CourseController@uploadTempImage');
        Route::post('freelancer/dashboard/delete-service', 'ServiceController@destroy');
        Route::post('freelancer/dashboard/delete-course', 'CourseController@destroy');
        Route::post('service/get-service-settings', 'ServiceController@getServiceSettings');
        Route::post('course/get-course-settings', 'CourseController@getCourseSettings');
        Route::post('service/update-service', 'ServiceController@update');
        Route::post('service/update-course', 'CourseController@update');
        // Route::get('/send-notifications','UserController@viewNotificationData')->name('viewMobileNotification');
        // Route::post('/send-notifications-post','UserController@sendNotificationData')->name('sendMobileNotification');
    }
);
//Employer Routes
Route::group(
    ['middleware' => ['role:employer']],
    function () {
        Route::post('skills/get-job-skills', 'SkillController@getJobSkills');
        Route::get('employer/dashboard/post-job', 'JobController@postJob')->name('employerPostJob');
        Route::get('employer/dashboard/manage-jobs', 'JobController@index')->name('employerManageJobs');
        Route::get('employer/jobs/{status}', 'EmployerController@showEmployerJobs');
        Route::get('employer/dashboard/job/{slug}/proposals', 'ProposalController@getJobProposals')->name('getProposals');
        Route::get('employer/dashboard', 'EmployerController@employerDashboard')->name('employerDashboard');
        Route::get('employer/profile', 'EmployerController@index')->name('employerPersonalDetail');
        Route::post('employer/upload-temp-image', 'EmployerController@uploadTempImage');
        Route::post('employer/store-profile-settings', 'EmployerController@storeProfileSettings');
        Route::post('job/post-job', 'JobController@store');
        Route::post('job/upload-temp-image', 'JobController@uploadTempImage');
        Route::post('proposal/hire-freelancer', 'ProposalController@hiredFreelencer');
        // Route::get('employer/services/{status}', 'EmployerController@showEmployerServices');
        // Route::get('employer/service/{service_id}/{id}/{status}', 'EmployerController@showServiceDetail');
        Route::get('employer/payout-settings', 'EmployerController@payoutSettings')->name('employerPayoutsSettings');
        Route::get('employer/payouts', 'EmployerController@getPayouts')->name('getEmployerPayouts');

        Route::get('employer/bill/{slug}/{status}/workdiary/{id}', 'WorkDiaryController@showEmployerWorkDiary');
        Route::get('employer/bill/workdiary/{id}/{start_date}/{end_date}', 'WorkDiaryController@EmployerWorkDiaryPayNow');
    }
);
// Freelancer Routes
Route::group(
    ['middleware' => ['role:freelancer']],
    function () {
        Route::get('/get-freelancer-skills', 'SkillController@getFreelancerSkills');
        Route::get('course/bacs-checkout', 'CourseController@bacsPayment');
        Route::post('course/send-message', 'CourseController@sendMessage');
        Route::post('course/send-message-to-instructor', 'CourseController@sendMessagetoInstructor');
        // // Route::get('/get-freelancer-skills', 'SkillController@getCourseSkills');
        // routes/api.php or routes/web.php
        Route::get('get-skills/{categoryId}', 'SkillController@getSkillsByCategory');

        Route::get('course/{id}/enrolled-students', 'CourseController@StudentsListing');
        Route::get('course/{id}/waiting-students', 'CourseController@waitingStudents');
        Route::get('/get-skills', 'SkillController@getSkills');
        Route::get('freelancer/dispute/{slug}', 'UserController@raiseDispute');
        Route::post('freelancer/store-dispute', 'UserController@storeDispute');
        Route::get('freelancer/dashboard/experience-education', 'FreelancerController@experienceEducationSettings')->name('experienceEducation');
        Route::get('freelancer/dashboard/project-awards', 'FreelancerController@projectAwardsSettings')->name('projectAwards');
        Route::post('freelancer/store-profile-settings', 'FreelancerController@storeProfileSettings')->name('freelancerProfileSetting');
        Route::post('freelancer/store-experience-settings', 'FreelancerController@storeExperienceEducationSettings');
        Route::post('freelancer/store-project-award-settings', 'FreelancerController@storeProjectAwardSettings');
        Route::get('freelancer/get-freelancer-skills', 'FreelancerController@getFreelancerSkills');
        Route::get('freelancer/get-freelancer-experiences', 'FreelancerController@getFreelancerExperiences');
        Route::get('freelancer/get-freelancer-projects', 'FreelancerController@getFreelancerProjects');
        Route::get('freelancer/get-freelancer-educations', 'FreelancerController@getFreelancerEducations');
        Route::get('freelancer/get-freelancer-awards', 'FreelancerController@getFreelancerAwards');
        Route::get('freelancer/jobs/{status}', 'FreelancerController@showFreelancerJobs');
        Route::get('freelancer/job/{slug}', 'FreelancerController@showOnGoingJobDetail')->name('showOnGoingJobDetail');
        Route::get('freelancer/proposals', 'FreelancerController@showFreelancerProposals')->name('showFreelancerProposals');
        Route::get('freelancer/proposal-edit/{job_slug}/{id}', 'ProposalController@ProposalUpdate');
        Route::post('proposal/update-proposal', 'ProposalController@update');
        Route::get('freelancer/dashboard', 'FreelancerController@freelancerDashboard')->name('freelancerDashboard');
        Route::get('freelancer/profile', 'FreelancerController@index')->name('personalDetail');

        Route::post('freelancer/upload-temp-image', 'FreelancerController@uploadTempImage');
        Route::get('freelancer/dashboard/post-service', 'ServiceController@create')->name('freelancerPostService');
        Route::get('freelancer/dashboard/post-course', 'CourseController@create')->name('freelancerPostCourse');
        Route::get('/category/{id}/skills', 'SkillController@getSkillsByCategory');
        Route::get('freelancer/payout-settings', 'FreelancerController@payoutSettings')->name('FreelancerPayoutsSettings');
        Route::get('freelancer/payouts', 'FreelancerController@getPayouts')->name('getFreelancerPayouts');
        Route::get('freelancer/jobs/workdiary', 'WorkDiaryController@index');

        Route::get('bill/workdiary/{id}/{date}', 'WorkDiaryController@index');
        Route::post('bill/workdiary/create', 'WorkDiaryController@create');

        Route::get('freelancer/bill/{slug}/{status}/workdiary/{id}', 'WorkDiaryController@showFreelancerWorkDiary');

        Route::get('freelancer/bill/workdiary/{id}', 'WorkDiaryController@submitFreelancerBill');

        Route::get('agency/create/new', 'AgencyController@createNew')->name('agencyNew');
        Route::get('agency-members', 'AgencyController@viewMembers')->name('Members');
        Route::get('agency/invitations/list', 'AgencyController@viewInvites');
        Route::get('agency/acceptInvitation/{agencyid}', 'AgencyController@acceptInvitation');
        Route::get('agency/declineInvitation/{agencyid}', 'AgencyController@DeclineInvitation');
        Route::post('agency/upload-temp-image', 'AgencyController@uploadTempImage');
        Route::get('agency/users', 'AgencyController@index')->name('agency-user-list');
        Route::get('agency-user-status-change/{id}', 'AgencyController@updateStatus');
        Route::get('get-agency-list', 'AgencyController@getAgencyList');
        Route::post('freelancer/dashboard/delete-agency', 'AgencyController@destroy');
        Route::post('agency/remove-member', 'AgencyController@removeMembers');
        Route::get('freelancer/dashboard/edit-agency/{id}', 'AgencyController@edit')->name('edit_agency');

        //connections
        Route::get('get-related-freelancers', 'PublicController@getUserRelatedFreelancers');
    }
);
// Employer|Freelancer Routes
Route::group(
    ['middleware' => ['role:employer|freelancer|admin|editor']],
    function () {
        Route::post('proposal/upload-temp-image', 'ProposalController@uploadTempImage');
        Route::get('job/proposal/{job_slug}', 'ProposalController@createProposal')->name('createProposal');
        Route::get('profile/settings/manage-account', 'UserController@accountSettings')->name('manageAccount');
        Route::get('profile/settings/reset-password', 'UserController@resetPassword')->name('resetPassword');
        Route::get('profile/settings/agency-settings', 'UserController@agencySettings')->name('agencySettings');
        Route::post('profile/settings/request-password', 'UserController@requestPassword');
        Route::get('profile/settings/email-notification-settings', 'UserController@emailNotificationSettings')->name('emailNotificationSettings');
        Route::post('profile/settings/save-email-settings', 'UserController@saveEmailNotificationSettings');
        Route::post('profile/settings/save-account-settings', 'UserController@saveAccountSettings');
        Route::post('profile/settings/save-agency', 'UserController@saveAgencyData')->name('agencyDataPost');
        Route::post('profile/settings/edit-agency', 'UserController@EditAgencyData')->name('agencyDataEdit');
        Route::post('agency/invite-user', 'UserController@inviteToAgency')->name('inviteToAgency');
        Route::post('agency/suggest', 'UserController@autoSuggestFetch')->name('autocomplete.fetch');
        Route::get('profile/settings/delete-account', 'UserController@deleteAccount')->name('deleteAccount');
        Route::post('profile/settings/delete-user', 'UserController@destroy');
        Route::post('admin/delete-user', 'UserController@deleteUser');
        Route::get('profile/settings/get-manage-account', 'UserController@getManageAccountData');
        Route::get('profile/settings/get-user-notification-settings', 'UserController@getUserEmailNotificationSettings');
        Route::get('profile/settings/get-user-searchable-settings', 'UserController@getUserSearchableSettings');
        Route::get('{role}/saved-items', 'UserController@getSavedItems')->name('getSavedItems');
        Route::post('profile/get-wishlist', 'UserController@getUserWishlist');
        Route::post('job/add-wishlist', 'JobController@addWishlist');

        Route::post('proposal/download-attachments', 'UserController@downloadAttachments');
        Route::post('proposal/send-message', 'UserController@sendPrivateMessage');
        Route::post('proposal/get-private-messages', 'UserController@getPrivateMessage');
        Route::get('proposal/download/message-attachments/{id}', 'UserController@downloadMessageAttachments');
        Route::get('user/package/checkout/{id}', 'UserController@checkout');
        Route::get('user/package/checkout/stripe/stripe-order', 'PackageController@stripePage');
        Route::get('user/order/bacs/{id}/{order}/{type}/{project_type?}', 'UserController@bankCheckout');
        Route::get('bacs-checkout', 'CourseController@bacsPayment');
        Route::post('user/generate-order/bacs/{id}/{type}', 'UserController@generateOrder');
        Route::get('course/{id}/generate-order', 'CourseController@generateOrder');
        Route::get('course/{id}/stripe-order', 'CourseController@stripePage');
        Route::get('employer/{type}/invoice', 'UserController@getEmployerInvoices')->name('employerInvoice');
        Route::get('freelancer/{type}/invoice', 'UserController@getFreelancerInvoices')->name('freelancerInvoice');
        Route::get('show/invoice/{id}', 'UserController@showInvoice');
        Route::post('service/upload-temp-message_attachments', 'ServiceController@uploadTempMessageAttachments');
        // Route::post('user/verify/emailcode', 'UserController@verifyUserEmailCode');
        Route::post('user/update-payout-detail', 'UserController@updatePayoutDetail');
        Route::get('user/get-payout-detail', 'UserController@getPayoutDetail');
        Route::post('user/upload-temp-image/{type?}', 'UserController@uploadTempImage');
        Route::post('user/submit/transection', 'UserController@submitTransection');
    }
);
Route::group(
    ['middleware' => ['role:employer|freelancer|admin']],
    function () {
        Route::post('user/submit-review', 'UserController@submitReview');
    }
);
Route::get('page/get-page-data/{id}', 'PageController@getPage');
Route::get('get-categories', 'CategoryController@getCategories');
Route::get('get-articles', 'PublicController@getArticles');
Route::get('get-home-slider/{id}', 'PageController@getSlider');
// Route::get('section/get-iframe/{video}', 'PublicController@getVideo');
Route::get('get-top-freelancers', 'FreelancerController@getTopFreelancers');
Route::get('get-services', 'ServiceController@getServices');
Route::post('job/get-wishlist', 'JobController@getWishlist');
Route::get('dashboard/packages/{role}', 'PackageController@index');
Route::get('package/get-purchase-package', 'PackageController@getPurchasePackage');
Route::get('paypal/redirect-url', 'PaypalController@getIndex');
Route::get('paypal/ec-checkout', 'PaypalController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'PaypalController@getExpressCheckoutSuccess');
Route::get('user/products/thankyou', 'UserController@thankyou');
Route::get('payment-process/{id}', 'EmployerController@employerPaymentProcess');

Route::get('hourly/payment-process/{id}', 'EmployerController@employerHourlyPaymentProcess');

Route::get('search/get-search-filters', 'PublicController@getFilterlist');
Route::post('search/get-searchable-data', 'PublicController@getSearchableData');
Route::post('postskill', 'PublicController@saveSkillData');

Route::get('channels/{channel}/messages', 'MessageController@index')->name('message');
Route::post('channels/{channel}/messages', 'MessageController@store');
Route::post('message/send-private-message', 'MessageController@store');
Route::get('message-center', 'MessageController@index')->name('message');
Route::get('message-center/get-users', 'MessageController@getUsers');
Route::post('message-center/get-messages', 'MessageController@getUserMessages');
Route::post('message', 'MessageController@store')->name('message.store');
Route::get('get/{type}/{filename}/{id}', 'PublicController@getFile')->name('getfile');
Route::post('submit-report', 'UserController@storeReport');
Route::post('badge/get-color', 'BadgeController@getBadgeColor');
Route::get('check-proposal-auth-user', 'PublicController@checkProposalAuth');
Route::get('check-service-auth-user', 'PublicController@checkServiceAuth');
Route::post('proposal/submit-proposal', 'ProposalController@store');
Route::post('get-freelancer-experiences', 'PublicController@getFreelancerExperience');
Route::post('get-freelancer-education', 'PublicController@getFreelancerEducation');

// Route::get('addmoney/stripe', array('as' => 'addmoney.paywithstripe', 'uses' => 'StripeController@payWithStripe',));
Route::match(['get', 'post'], 'addmoney/stripe', array('as' => 'addmoney.stripe', 'uses' => 'StripeController@postPaymentWithStripe',));


Route::get('service/payment-process/{id}', 'ServiceController@employerPaymentProcess');
Route::get('course/payment-process/{id}', 'CourseController@employerPaymentProcess');
Route::get('paypal/ec-hourly-checkout', 'PaypalController@getHourlyExpressCheckout');
Route::get('paypal/ec-hourly-checkout-success', 'PaypalController@getHourlyExpressCheckoutSuccess');
