<?php

use Illuminate\Support\Facades\Route;



//backend
Route::group(['as'=>'admin.','prefix'=>'admin/membership','middleware' => ['auth:admin','setlang']],function(){
    // membership type
    Route::group(['prefix'=>'type'],function(){
        Route::controller(\Modules\Membership\app\Http\Controllers\Backend\MembershipTypeController::class)->group(function () {
            Route::match(['get','post'],'all-type','all_type')->name('membership.type.all')->permission('membership-type-list');
            Route::post('edit-type','edit_type')->name('membership.type.edit')->permission('membership-type-edit');
            Route::post('delete/{id}','delete_type')->name('membership.type.delete')->permission('membership-type-delete');
            Route::post('bulk-action', 'bulk_action_type')->name('membership.type.delete.bulk.action')->permission('membership-type-bulk-delete');
            Route::get('paginate/data', 'pagination')->name('membership.type.paginate.data');
            Route::get('search-type', 'search_type')->name('membership.type.search');
        });
    });
    Route::controller(\Modules\Membership\app\Http\Controllers\Backend\MembershipController::class)->group(function () {
        Route::get('all-membership','all_membership')->name('membership.all')->permission('membership-list');
        Route::match(['get','post'],'add-membership','add_membership')->name('membership.add')->permission('membership-add');
        Route::match(['get','post'],'edit-membership/{id}','edit_membership')->name('membership.edit')->permission('membership-edit');
        Route::post('delete/{id}','delete_membership')->name('membership.delete')->permission('membership-delete');
        Route::post('status/{id}','status')->name('membership.status')->permission('membership-status-change');
        Route::post('bulk-action', 'bulk_action_membership')->name('membership.delete.bulk.action')->permission('membership-bulk-delete');
        Route::get('paginate/data', 'pagination')->name('membership.paginate.data');
        Route::get('search-type', 'search_membership')->name('membership.search');
    });

    Route::group(['prefix' => 'settings'],function(){
        Route::controller(\Modules\Membership\app\Http\Controllers\Backend\MembershipSettingsController::class)->group(function () {
            Route::match(['get','post'],'update','membership_settings')->name('membership.settings')->permission('membership-settings');
        });
    });

    Route::group(['prefix' => 'user'],function(){
        Route::controller(\Modules\Membership\app\Http\Controllers\Backend\UserMembershipController::class)->group(function () {
            Route::get('all','all_membership')->name('user.membership.all')->permission('user-membership-list');
            Route::get('paginate/data', 'pagination')->name('user.membership.paginate.data');
            Route::get('search-type', 'search_membership')->name('user.membership.search');
            Route::post('status/change/{id}', 'change_status')->name('user.membership.status')->permission('user-membership-status-change');
            Route::get('get/active/membership', 'active_membership')->name('user.membership.active')->permission('user-membership-active');
            Route::get('get/inactive/membership', 'inactive_membership')->name('user.membership.inactive')->permission('user-membership-inactive');
            Route::get('get/manual/membership', 'manual_membership')->name('user.membership.manual')->permission('user-membership-manual');
            Route::get('notification/read/unread/{id}', 'read_unread')->name('user.membership.read.unread');
            Route::post('update/manual/payment/status', 'update_manual_payment')->name('user.membership.update.manual.payment')->permission('user-membership-manual-payment-status-change');;
            Route::post('history/update/manual/payment/status', 'history_update_manual_payment')->name('user.membership.history.update.manual.payment');
            // sent email
            Route::get('/send-email/{id?}', 'send_email_to_user')->name('user.membership.email.sent');
        });
        Route::controller(\Modules\Membership\app\Http\Controllers\Backend\MembershipHistoryController::class)->group(function () {
            Route::get('history/membership/{id}','user_membership_history')->name('user.membership.history');
            Route::get('history/paginate/data', 'pagination')->name('user.membership.history.paginate.data');
            Route::get('history/search-type', 'search_membership')->name('user.membership.history.search');
        });
    });


    /*------------------ EMAIL SETTINGS MANAGE --------------*/
    Route::prefix('email-settings')->group(function (){
        Route::controller(\Modules\Membership\app\Http\Controllers\Backend\MembershipEmailTemplateController::class)->group(function () {
        Route::match(['get', 'post'], '/user/membership/free/template','userMembershipFreeTemplate')->name('email.user.membership.free.template');
        Route::match(['get', 'post'], '/user/membership/purchase/template','userMembershipPurchaseTemplate')->name('email.user.membership.purchase.template');
        Route::match(['get', 'post'], '/user/membership/renew/template','userMembershipRenewTemplate')->name('email.user.membership.renew.template');
        Route::match(['get', 'post'], '/user/membership/active/template','userMembershipActiveTemplate')->name('email.user.membership.active.template');
        Route::match(['get', 'post'], '/user/membership/inactive/template','userMembershipInactiveTemplate')->name('email.user.membership.inactive.template');
        Route::match(['get', 'post'], '/user/membership/manual-payment-complete/template','userMembershipManualPaymentCompleteTemplate')->name('email.user.membership.manual.payment.complete.template');
        Route::match(['get', 'post'], '/user/membership/manual-payment-complete/to-admin/template','userMembershipManualPaymentCompleteToAdminTemplate')->name('email.user.membership.manual.payment.complete.to.admin.template');
      });
    });

    //backend enquiry
    Route::group(['prefix'=>'enquiry'],function(){
        Route::controller(\Modules\Membership\app\Http\Controllers\Backend\EnquiryFormController::class)->group(function () {
            Route::match(['get','post'],'all','all_enquiry')->name('enquiry.form.all')->permission('enquiry-form-list');
            Route::post('delete/{id}','delete_enquiry')->name('enquiry.form.delete')->permission('enquiry-form-delete');
            Route::post('bulk-action', 'bulk_action_enquiry')->name('enquiry.form.delete.bulk.action')->permission('enquiry-form-bulk-delete');
            Route::get('paginate/data', 'pagination')->name('enquiry.form.paginate.data');
            Route::get('search-type', 'search_enquiry')->name('enquiry.form.search');
        });
    });

}); // admin end



//user subscription
Route::group(['prefix'=>'user/membership','as'=>'user.','middleware'=>['auth','userEmailVerify','globalVariable', 'maintains_mode','setlang']],function() {
    Route::controller(\Modules\Membership\app\Http\Controllers\User\UserMembershipController::class)->group(function () {
        Route::get('all', 'all_membership')->name('membership.all');
        Route::get('paginate/data', 'pagination')->name('membership.paginate.data');
        Route::get('search-history', 'search_history')->name('membership.search');
    });
    //user business hours
    Route::controller(\Modules\Membership\app\Http\Controllers\User\BusinessHoursController::class)->group(function () {
        Route::post('business-hours/add', 'business_hours_add')->name('business.hours.add');
    });
});


//user all enquiries
Route::group(['prefix'=>'user/enquiries','as'=>'user.','middleware'=>['auth','userEmailVerify','globalVariable', 'maintains_mode','setlang']],function() {
    Route::controller(\Modules\Membership\app\Http\Controllers\User\UserEnquiryFormController::class)->group(function () {
        Route::get('all', 'all_enquiries')->name('enquiries.all');
        Route::get('paginate/data', 'pagination')->name('enquiries.paginate.data');
        Route::get('search-history', 'search_history')->name('enquiries.search');
        Route::post('delete/{id}','delete_enquiry')->name('enquiry.form.delete');
    });
});


// submit enquiry form
Route::group(['prefix'=>'visitor/enquiry', 'middleware'=>['globalVariable', 'maintains_mode','setlang']],function() {
    Route::controller(\Modules\Membership\app\Http\Controllers\Frontend\EnquiryFormController::class)->group(function () {
        Route::post('submit', 'enquiry_form_submit')->name('visitor.enquiry.form.submit');
    });
});


// frontend membership buy
  Route::group(['middleware' => ['globalVariable', 'maintains_mode','setlang']], function () {
      // membership
      Route::controller(\Modules\Membership\app\Http\Controllers\Frontend\FrontendMembershipController::class)->group(function(){
          Route::post('membership/user/login', 'user_login')->name('membership.user.login');
      });
    // buy membership
    Route::controller(\Modules\Membership\app\Http\Controllers\Frontend\BuyMembershipController::class)->group(function(){
        Route::post('membership/buy', 'buy_membership')->name('user.membership.buy');
        Route::get('membership/buy/cancel-static','membership_payment_cancel_static')->name('membership.buy.payment.cancel.static');
    });

    // renew membership
    Route::controller(\Modules\Membership\app\Http\Controllers\frontend\RenewMembershipController::class)->group(function(){
        Route::post('membership/renew', 'renew_membership')->name('user.membership.renew');
        Route::get('membership/renew/cancel-static','renew_membership_payment_cancel_static')->name('membership.renew.payment.cancel.static');
    });
});

// Buy membership ipn routes
Route::group(['prefix' => 'buy-membership'],function(){
    Route::controller(\Modules\Membership\app\Http\Controllers\Frontend\BuyMembershipIPNController::class)->group(function () {
        Route::get('/paypal-ipn','paypal_ipn_for_membership')->name('user.paypal.ipn.membership');
        Route::post('/paytm-ipn','paytm_ipn_for_membership')->name('user.paytm.ipn.membership');
        Route::get('/paystack-ipn','paystack_ipn_for_membership')->name('user.paystack.ipn.membership');
        Route::get('/mollie/ipn','mollie_ipn_for_membership')->name('user.mollie.ipn.membership');
        Route::get('/stripe/ipn','stripe_ipn_for_membership')->name('user.stripe.ipn.membership');
        Route::post('/razorpay-ipn','razorpay_ipn_for_membership')->name('user.razorpay.ipn.membership');
        Route::get('/flutterwave/ipn','flutterwave_ipn_for_membership')->name('user.flutterwave.ipn.membership');
        Route::get('/midtrans-ipn','midtrans_ipn_for_membership')->name('user.midtrans.ipn.membership');
        Route::post('/payfast-ipn','payfast_ipn_for_membership')->name('user.payfast.ipn.membership');
        Route::get('/cashfree-ipn','cashfree_ipn_for_membership')->name('user.cashfree.ipn.membership');
        Route::get('/instamojo-ipn','instamojo_ipn_for_membership')->name('user.instamojo.ipn.membership');
        Route::get('/marcadopago-ipn','marcadopago_ipn_for_membership')->name('user.marcadopago.ipn.membership');
        Route::get('/squareup-ipn','squareup_ipn_for_membership' )->name('user.squareup.ipn.membership');
        Route::post('/cinetpay-ipn', 'cinetpay_ipn_for_membership' )->name('user.cinetpay.ipn.membership');
        Route::post('/paytabs-ipn','paytabs_ipn_for_membership' )->name('user.paytabs.ipn.membership');
        Route::post('/billplz-ipn','billplz_ipn_for_membership' )->name('user.billplz.ipn.membership');
        Route::post('/zitopay-ipn','zitopay_ipn_for_membership' )->name('user.zitopay.ipn.membership');
        Route::post('/toyyibpay-ipn','toyyibpay_ipn_for_membership' )->name('user.toyyibpay.ipn.membership');
    });
});

// Renew membership ipn routes
Route::group(['prefix' => 'renew-membership'],function(){
    Route::controller(\Modules\Membership\app\Http\Controllers\Frontend\RenewMembershipIPNController::class)->group(function () {
        Route::get('/paypal-ipn','paypal_ipn_for_membership')->name('user.paypal.ipn.membership.renew');
        Route::post('/paytm-ipn','paytm_ipn_for_membership')->name('user.paytm.ipn.membership.renew');
        Route::get('/paystack-ipn','paystack_ipn_for_membership')->name('user.paystack.ipn.membership.renew');
        Route::get('/mollie/ipn','mollie_ipn_for_membership')->name('user.mollie.ipn.membership.renew');
        Route::get('/stripe/ipn','stripe_ipn_for_membership')->name('user.stripe.ipn.membership.renew');
        Route::post('/razorpay-ipn','razorpay_ipn_for_membership')->name('user.razorpay.ipn.membership.renew');
        Route::get('/flutterwave/ipn','flutterwave_ipn_for_membership')->name('user.flutterwave.ipn.membership.renew');
        Route::get('/midtrans-ipn','midtrans_ipn_for_membership')->name('user.midtrans.ipn.membership.renew');
        Route::post('/payfast-ipn','payfast_ipn_for_membership')->name('user.payfast.ipn.membership.renew');
        Route::get('/cashfree-ipn','cashfree_ipn_for_membership')->name('user.cashfree.ipn.membership.renew');
        Route::get('/instamojo-ipn','instamojo_ipn_for_membership')->name('user.instamojo.ipn.membership.renew');
        Route::get('/marcadopago-ipn','marcadopago_ipn_for_membership')->name('user.marcadopago.ipn.membership.renew');
        Route::get('/squareup-ipn','squareup_ipn_for_membership' )->name('user.squareup.ipn.membership.renew');
        Route::post('/cinetpay-ipn', 'cinetpay_ipn_for_membership' )->name('user.cinetpay.ipn.membership.renew');
        Route::post('/paytabs-ipn','paytabs_ipn_for_membership' )->name('user.paytabs.ipn.membership.renew');
        Route::post('/billplz-ipn','billplz_ipn_for_membership' )->name('user.billplz.ipn.membership.renew');
        Route::post('/zitopay-ipn','zitopay_ipn_for_membership' )->name('user.zitopay.ipn.membership.renew');
        Route::post('/toyyibpay-ipn','toyyibpay_ipn_for_membership' )->name('user.toyyibpay.ipn.membership.renew');
    });
});
