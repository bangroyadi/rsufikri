<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminDoctorController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminPolyclinicController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminCareerController;
use App\Http\Controllers\Admin\AdminJobApplicationController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminKnowledgeBaseController;
use App\Http\Controllers\Admin\AdminTiktokPostController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\SitemapController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Event & Agenda Kegiatan Routes
Route::get('/informasi/event', [HomeController::class, 'eventPage'])->name('event.index');
Route::get('/informasi/event/{slug}', [HomeController::class, 'eventShow'])->name('event.show');
Route::get('/event', [HomeController::class, 'eventPage']);
Route::get('/event/{slug}', [HomeController::class, 'eventShow']);
Route::get('/agenda', [HomeController::class, 'eventPage']);

// Penawaran Khusus & Promo Routes
Route::get('/informasi/penawaran-khusus', [HomeController::class, 'promoPage'])->name('promo.index');
Route::get('/penawaran-khusus', [HomeController::class, 'promoPage']);
Route::get('/promo', [HomeController::class, 'promoPage']);
Route::get('/promo/{slug}', [HomeController::class, 'promoShow'])->name('promo.show');

// Layanan & Informasi Subpage Routes
Route::get('/layanan/{slug}', [HomeController::class, 'layananPage'])->name('layanan.show');
Route::get('/informasi/{slug}', [HomeController::class, 'informasiPage'])->name('informasi.show');

// Edukasi & Artikel Kesehatan Routes
Route::get('/artikel', [HomeController::class, 'artikelIndex'])->name('artikel.index');
Route::get('/artikel/{slug}', [HomeController::class, 'artikelShow'])->name('artikel.show');
Route::get('/edukasi-kesehatan', [HomeController::class, 'artikelIndex'])->name('edukasi.index');
Route::get('/edukasi-kesehatan/{slug}', [HomeController::class, 'artikelShow'])->name('edukasi.show');


// Dedicated Page Routes
Route::get('/profil', [HomeController::class, 'profilPage'])->name('profil');
Route::get('/jadwal-dokter', [HomeController::class, 'jadwalDokterPage'])->name('jadwal.dokter');
Route::get('/lokasi', [HomeController::class, 'lokasiPage'])->name('lokasi');
Route::get('/map', [HomeController::class, 'lokasiPage'])->name('map');
Route::get('/kontak', [HomeController::class, 'lokasiPage'])->name('kontak');
Route::get('/karir', [HomeController::class, 'karirPage'])->name('karir');
Route::get('/karir/{slug}', [HomeController::class, 'karirShow'])->name('karir.show');
Route::post('/karir/{slug}/apply', [HomeController::class, 'karirApply'])->name('karir.apply');
Route::get('/buat-janji', [HomeController::class, 'buatJanjiPage'])->name('buat.janji');

// Tanya Kakak Fikri - Intelligent AI Chatbot Routes
Route::post('/ai/chat', [AiChatController::class, 'chat'])->name('ai.chat');
Route::post('/ai/reset-session', [AiChatController::class, 'resetSession'])->name('ai.reset');

// Default Login Route Alias for Laravel Auth Middleware
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->middleware('prevent-back-history')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Protected Routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // CMS Section Routes
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::get('/doctors', [AdminDoctorController::class, 'index'])->name('doctors.index');
        Route::post('/doctors', [AdminDoctorController::class, 'store'])->name('doctors.store');
        Route::put('/doctors/{id}', [AdminDoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/doctors/{id}', [AdminDoctorController::class, 'destroy'])->name('doctors.destroy');

        Route::get('/schedules', [AdminScheduleController::class, 'index'])->name('schedules.index');
        Route::post('/schedules', [AdminScheduleController::class, 'store'])->name('schedules.store');
        Route::put('/schedules/{id}', [AdminScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/{id}', [AdminScheduleController::class, 'destroy'])->name('schedules.destroy');

        Route::get('/polyclinics', [AdminPolyclinicController::class, 'index'])->name('polyclinics.index');
        Route::post('/polyclinics', [AdminPolyclinicController::class, 'store'])->name('polyclinics.store');
        Route::put('/polyclinics/{id}', [AdminPolyclinicController::class, 'update'])->name('polyclinics.update');
        Route::delete('/polyclinics/{id}', [AdminPolyclinicController::class, 'destroy'])->name('polyclinics.destroy');
        Route::post('/polyclinics/{id}/gallery', [AdminPolyclinicController::class, 'uploadGallery'])->name('polyclinics.gallery.upload');
        Route::post('/polyclinics/{id}/gallery/delete', [AdminPolyclinicController::class, 'deleteGalleryPhoto'])->name('polyclinics.gallery.delete');

        Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{id}', [AdminServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{id}', [AdminServiceController::class, 'destroy'])->name('services.destroy');
        Route::post('/services/{id}/gallery', [AdminServiceController::class, 'uploadGallery'])->name('services.gallery.upload');
        Route::match(['get', 'post', 'delete'], '/services/{id}/gallery/delete', [AdminServiceController::class, 'deleteGalleryPhoto'])->name('services.gallery.delete');

        Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
        Route::post('/news', [AdminNewsController::class, 'store'])->name('news.store');
        Route::put('/news/{id}', [AdminNewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');

        Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
        Route::post('/articles', [AdminArticleController::class, 'store'])->name('articles.store');
        Route::put('/articles/{id}', [AdminArticleController::class, 'update'])->name('articles.update');
        Route::delete('/articles/{id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

        Route::get('/galleries', [AdminGalleryController::class, 'index'])->name('galleries.index');
        Route::post('/galleries', [AdminGalleryController::class, 'store'])->name('galleries.store');
        Route::put('/galleries/{id}', [AdminGalleryController::class, 'update'])->name('galleries.update');
        Route::delete('/galleries/{id}', [AdminGalleryController::class, 'destroy'])->name('galleries.destroy');

        Route::get('/banners', [AdminBannerController::class, 'index'])->name('banners.index');
        Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
        Route::put('/banners/{id}', [AdminBannerController::class, 'update'])->name('banners.update');
        Route::delete('/banners/{id}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');

        // Promos & Penawaran Khusus Routes
        Route::get('/promos', [AdminPromoController::class, 'index'])->name('promos.index');
        Route::post('/promos', [AdminPromoController::class, 'store'])->name('promos.store');
        Route::put('/promos/{id}', [AdminPromoController::class, 'update'])->name('promos.update');
        Route::delete('/promos/{id}', [AdminPromoController::class, 'destroy'])->name('promos.destroy');
        Route::post('/promos/{id}/toggle-active', [AdminPromoController::class, 'toggleActive'])->name('promos.toggle_active');

        // Hospital Events & Agenda Routes
        Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
        Route::post('/events', [AdminEventController::class, 'store'])->name('events.store');
        Route::put('/events/{id}', [AdminEventController::class, 'update'])->name('events.update');
        Route::delete('/events/{id}', [AdminEventController::class, 'destroy'])->name('events.destroy');
        Route::post('/events/{id}/toggle-active', [AdminEventController::class, 'toggleActive'])->name('events.toggleActive');
        Route::post('/events/{id}/gallery', [AdminEventController::class, 'uploadGallery'])->name('events.gallery.upload');
        Route::match(['get', 'post', 'delete'], '/events/{id}/gallery/delete', [AdminEventController::class, 'deleteGalleryPhoto'])->name('events.gallery.delete');

        // Careers & Rekrutmen HRD Routes
        Route::get('/careers', [AdminCareerController::class, 'index'])->name('careers.index');
        Route::post('/careers', [AdminCareerController::class, 'store'])->name('careers.store');
        Route::put('/careers/{id}', [AdminCareerController::class, 'update'])->name('careers.update');
        Route::delete('/careers/{id}', [AdminCareerController::class, 'destroy'])->name('careers.destroy');
        Route::post('/careers/{id}/toggle-active', [AdminCareerController::class, 'toggleActive'])->name('careers.toggleActive');
        Route::post('/careers/{id}/toggle-status', [AdminCareerController::class, 'toggleStatus'])->name('careers.toggleStatus');

        // Job Applications & Pelamar CV Routes
        Route::get('/applications', [AdminJobApplicationController::class, 'index'])->name('applications.index');
        Route::post('/applications/{id}/status', [AdminJobApplicationController::class, 'updateStatus'])->name('applications.update_status');
        Route::delete('/applications/{id}', [AdminJobApplicationController::class, 'destroy'])->name('applications.destroy');

        // TikTok Posts Routes
        Route::get('/tiktok', [AdminTiktokPostController::class, 'index'])->name('tiktok.index');
        Route::post('/tiktok', [AdminTiktokPostController::class, 'store'])->name('tiktok.store');
        Route::put('/tiktok/{id}', [AdminTiktokPostController::class, 'update'])->name('tiktok.update');
        Route::delete('/tiktok/{id}', [AdminTiktokPostController::class, 'destroy'])->name('tiktok.destroy');

        Route::get('/contact', [AdminContactController::class, 'index'])->name('contact.index');
        Route::post('/contact', [AdminContactController::class, 'update'])->name('contact.update');

        // Tanya Kakak Fikri - Knowledge Base & Learning System Routes
        Route::get('/knowledge-base', [AdminKnowledgeBaseController::class, 'index'])->name('knowledge.index');
        Route::post('/knowledge-base', [AdminKnowledgeBaseController::class, 'store'])->name('knowledge.store');
        Route::put('/knowledge-base/{id}', [AdminKnowledgeBaseController::class, 'update'])->name('knowledge.update');
        Route::delete('/knowledge-base/{id}', [AdminKnowledgeBaseController::class, 'destroy'])->name('knowledge.destroy');
        Route::post('/knowledge-base/auto-process', [AdminKnowledgeBaseController::class, 'autoProcess'])->name('knowledge.auto_process');
        Route::post('/knowledge-base/unrecognized/{id}/resolve', [AdminKnowledgeBaseController::class, 'resolveUnrecognized'])->name('knowledge.unrecognized.resolve');
        Route::delete('/knowledge-base/unrecognized/{id}', [AdminKnowledgeBaseController::class, 'destroyUnrecognized'])->name('knowledge.unrecognized.destroy');
    });
});
