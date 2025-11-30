<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\Seller\SellerMainController;
use App\Http\Controllers\Seller\SellerStoreController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Admin\ProductDiscountController;
use App\Http\Controllers\Customer\CustomerMainController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ReviewController;;
use App\Http\Controllers\Seller\SellerReviewController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\StoreController as ControllersStoreController;

Route::controller(HomePageController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/category/{category_name}', 'showCategoryProducts')->name('productby.category');
});

Route::get('/store', [ControllersStoreController::class, 'index'])->name('store');

// admin routes
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::controller(AdminMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('admin');
            Route::get('/settings', 'setting')->name('admin.setting');
            Route::put('/settings/homepagesetting/update', 'updatehomepagesetting')->name('admin.homepagesetting.update');
            Route::get('/manage/users', 'manage_user')->name('admin.manage.users');
            Route::get('/manage/stores', 'manage_stores')->name('admin.manage.stores');
            Route::get('/cart/history', 'cart_history')->name('admin.cart.history');
            Route::get('/order/history', 'order_history')->name('admin.order.history');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/category/create', 'index')->name('category.create');
            Route::get('/category/manage', 'manage')->name('category.manage');
        });

        Route::controller(SubCategoryController::class)->group(function () {
            Route::get('/subcategory/create', 'index')->name('subcategory.create');
            Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('/product/manage', 'index')->name('product.create');
            Route::get('/product/review/manage', 'review_manage')->name('product.review.manage');
        });

        Route::controller(ProductAttributeController::class)->group(function () {
            Route::get('/productattribute/create', 'index')->name('productattribute.create');
            Route::get('/productattribute/manage', 'manage')->name('productattribute.manage');
            Route::post('/defaultattribute/create', 'createattribute')->name('attribute.create');
            Route::get('/defaultattribute/{id}', 'showattribute')->name('show.attribute');
            Route::put('/defaultattribute/update/{id}', 'updateattribute')->name('update.attribute');
            Route::delete('/defaultattribute/delete/{id}', 'deleteattribute')->name('delete.attribute');
        });

        Route::controller(ProductDiscountController::class)->group(function () {
            Route::get('/discount/create', 'index')->name('discount.create');
            Route::get('/discount/manage', 'manage')->name('discount.manage');
        });

        Route::controller(MasterCategoryController::class)->group(function () {
            Route::post('/store/category', 'storecat')->name('store.cat');
            Route::get('/category/{id}', 'showcat')->name('show.cat');
            Route::put('/category/update/{id}', 'updatecat')->name('update.cat');
            Route::delete('/category/delete/{id}', 'deletecat')->name('delete.cat');
        });

        Route::controller(MasterSubCategoryController::class)->group(function () {
            Route::post('/store/subcategory', 'storesubcat')->name('store.subcat');
            Route::get('/subcategory/{id}', 'showsubcat')->name('show.subcat');
            Route::put('/subcategory/update/{id}', 'updatesubcat')->name('update.subcat');
            Route::delete('/subcategory/delete/{id}', 'deletesubcat')->name('delete.subcat');
        });

        Route::controller(HomePageController::class)->group(function () {
            Route::get('/homepage-setting/create', [HomePageController::class, 'create'])->name('homepage_setting.create');
            Route::post('/homepage-setting/store', [HomePageController::class, 'store'])->name('homepage_setting.store');
        });

        Route::controller(AdminReviewController::class)->group(function () {
            Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
            Route::get('/reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
            Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
            Route::patch('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
            Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
            Route::post('/reviews/bulk-action', [AdminReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
        });
    }); // END ADMIN PREFIX

}); // END ADMIN MIDDLEWARE



// vendor routes
Route::middleware(['auth', 'verified', 'rolemanager:vendor'])->group(function () {

    Route::prefix('vendor')->group(function () {

        Route::controller(SellerMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('vendor');
            Route::get('/order/history', 'orderhistory')->name('vendor.order.history');
        });

        Route::controller(SellerProductController::class)->group(function () {
            Route::get('/product/create', 'index')->name('vendor.product');
            Route::post('/product/store', 'storeproduct')->name('vendor.product.store');
            Route::get('/product/manage', 'manage')->name('vendor.product.manage');
            Route::delete('/product/{id}/delete', 'destroy')->name('vendor.product.destroy');
        });

        Route::controller(SellerStoreController::class)->group(function () {
            Route::get('/store/create', 'index')->name('vendor.store');
            Route::get('/store/manage', 'manage')->name('vendor.store.manage');
            Route::post('/store/publish', 'store')->name('create.store');
            Route::delete('/product/delete/{id}', 'destroy')->name('vendor.product.destroy');
        });

        Route::controller(SellerReviewController::class)->group(function () {
            Route::get('/reviews', [SellerReviewController::class, 'index'])->name('reviews.index');
            Route::post('/reviews/{review}/reply', [SellerReviewController::class, 'reply'])->name('reviews.reply');
            Route::delete('/reviews/{review}/reply', [SellerReviewController::class, 'deleteReply'])->name('reviews.delete-reply');
        });
    }); // END VENDOR PREFIX

}); // END VENDOR MIDDLEWARE



// customer routes
Route::middleware(['auth', 'verified', 'rolemanager:customer'])->group(function () {

    Route::prefix('user')->group(function () {

        Route::controller(CustomerMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/order/history', 'history')->name('customer.history');
            Route::get('/setting/payment', 'payment')->name('customer.payment');
            Route::get('/affiliate', 'affiliate')->name('customer.affiliate');
        });

        Route::post('/checkout', [CustomerMainController::class, 'checkout'])->name('customer.checkout');
        Route::get('/order/{order}', [CustomerMainController::class, 'showOrder'])->name('customer.order.show');
    }); // END USER PREFIX
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/products/{product}/review/create', 'create')->name('reviews.create');
        Route::post('/products/{product}/review', 'store')->name('reviews.store');
        Route::get('/my-reviews', 'myReviews')->name('reviews.my-reviews');
        Route::get('/reviews/{review}/edit', 'edit')->name('reviews.edit');
        Route::put('/reviews/{review}', 'update')->name('reviews.update');
        Route::delete('/reviews/{review}', 'destroy')->name('reviews.destroy');
    });
}); // END CUSTOMER MIDDLEWARE



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
