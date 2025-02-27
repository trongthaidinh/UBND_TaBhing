<?php
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminExternalLinkController;
use App\Http\Controllers\AdminHomepageBlockController;
use App\Http\Controllers\AdminPhotoLibraryController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminVideoController;
use App\Http\Controllers\BusinessSupportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PhotoGalleryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileLookupController;
use App\Http\Controllers\RssFeedController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\VideoController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Post Routes
Route::middleware('web')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/category/{category}', [PostController::class, 'byCategory'])->name('posts.category');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
});

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Category Routes
Route::middleware('web')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
});

// Video routes
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');

// Photo Gallery routes
Route::get('/photo-library', [PhotoGalleryController::class, 'index'])->name('photo-library.index');
Route::get('/photo-library/{photo}', [PhotoGalleryController::class, 'show'])->name('photo-library.show');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public RSS feed
Route::get('/rss', [RssFeedController::class, 'generateRssFeed'])
    ->name('rss.feed');

// Admin Routes
Route::middleware(['auth', 'role:admin,editor'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    // Admin Post Routes
    Route::prefix('posts')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('admin.posts.index');
        Route::get('/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
        Route::post('/', [AdminPostController::class, 'store'])->name('admin.posts.store');
        Route::get('/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
        Route::put('/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
        Route::put('/{post}/approve', [AdminPostController::class, 'approve'])
            ->name('admin.posts.approve')
            ->middleware('role:admin');
        Route::delete('/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
    });

    // Admin Category Routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
        Route::post('/{category}/toggle-home-visibility',
                [AdminCategoryController::class, 'toggleHomeVisibility'])
            ->name('admin.categories.toggle-home-visibility');
    });

    Route::prefix('homepage-blocks')->group(function () {
        Route::get('/', [AdminHomepageBlockController::class, 'index'])->name('admin.homepage-blocks.index');
        Route::get('/create', [AdminHomepageBlockController::class, 'create'])->name('admin.homepage-blocks.create');
        Route::post('/', [AdminHomepageBlockController::class, 'store'])->name('admin.homepage-blocks.store');
        Route::get('/{homepageBlock}/edit', [AdminHomepageBlockController::class, 'edit'])->name('admin.homepage-blocks.edit');
        Route::put('/{homepageBlock}', [AdminHomepageBlockController::class, 'update'])->name('admin.homepage-blocks.update');
        Route::delete('/{homepageBlock}', [AdminHomepageBlockController::class, 'destroy'])->name('admin.homepage-blocks.destroy');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('photo-library')->group(function () {
        Route::get('/', [AdminPhotoLibraryController::class, 'index'])->name('admin.photo-library.index');
        Route::get('/create', [AdminPhotoLibraryController::class, 'create'])->name('admin.photo-library.create');
        Route::post('/', [AdminPhotoLibraryController::class, 'store'])->name('admin.photo-library.store');
        Route::put('/{photoLibrary}', [AdminPhotoLibraryController::class, 'update'])->name('admin.photo-library.update');
        Route::delete('/{photoLibrary}', [AdminPhotoLibraryController::class, 'destroy'])->name('admin.photo-library.destroy');
    });

    Route::prefix('videos')->group(function () {
        Route::get('/', [AdminVideoController::class, 'index'])->name('admin.videos.index');
        Route::get('/create', [AdminVideoController::class, 'create'])->name('admin.videos.create');
        Route::post('/', [AdminVideoController::class, 'store'])->name('admin.videos.store');
        Route::get('/{video}/edit', [AdminVideoController::class, 'edit'])->name('admin.videos.edit');
        Route::put('/{video}', [AdminVideoController::class, 'update'])->name('admin.videos.update');
        Route::delete('/{video}', [AdminVideoController::class, 'destroy'])->name('admin.videos.destroy');
    });

    Route::prefix('external-links')->group(function () {
        Route::get('/', [AdminExternalLinkController::class, 'index'])->name('admin.external-links.index');
        Route::get('/create', [AdminExternalLinkController::class, 'create'])->name('admin.external-links.create');
        Route::post('/', [AdminExternalLinkController::class, 'store'])->name('admin.external-links.store');
        Route::get('/{externalLink}/edit', [AdminExternalLinkController::class, 'edit'])->name('admin.external-links.edit');
        Route::put('/{externalLink}', [AdminExternalLinkController::class, 'update'])->name('admin.external-links.update');
        Route::delete('/{externalLink}', [AdminExternalLinkController::class, 'destroy'])->name('admin.external-links.destroy');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('banner')->group(function () {
        Route::get('/', [AdminBannerController::class, 'index'])->name('admin.banner.index');
        Route::get('/create', [AdminBannerController::class, 'create'])->name('admin.banner.create');
        Route::post('/', [AdminBannerController::class, 'store'])->name('admin.banner.store');
        Route::get('/{banner}/edit', [AdminBannerController::class, 'edit'])->name('admin.banner.edit');
        Route::put('/{banner}', [AdminBannerController::class, 'update'])->name('admin.banner.update');
        Route::delete('/{banner}', [AdminBannerController::class, 'destroy'])->name('admin.banner.destroy');
    });
});

Route::get('/sitemap', function () {
    return view('sitemap');
})->name('sitemap');

// Add Search Route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Include authentication routes
require __DIR__ . '/auth.php';
