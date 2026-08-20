<?php
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\Auth\DepartmentController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Artisan;
    use App\Http\Controllers\MajorController;
    use App\Http\Controllers\Admin\AdminController;
    use App\Http\Controllers\LocaleController;
    use Inertia\Inertia;

    Route::get('/', function () {
        $recentEvents = \App\Models\Event::where('is_published', true)->orderBy('id', 'desc')->take(3)->get();
        return Inertia::render('Welcome', [
            'recentEvents' => $recentEvents,
            'homeSettings' => [
                'home_hero_slides' => json_decode(\App\Models\Setting::getValue('home_hero_slides', '[]'), true),
                'home_scholarship' => json_decode(\App\Models\Setting::getValue('home_scholarship', '{}'), true),
                'home_four_years' => json_decode(\App\Models\Setting::getValue('home_four_years', '[]'), true),
                'home_video_url' => \App\Models\Setting::getValue('home_video_url', ''),
                'home_video_bg_image' => \App\Models\Setting::getValue('home_video_bg_image', ''),
                'home_video_bg_color' => \App\Models\Setting::getValue('home_video_bg_color', '#0f2154'),
                'home_activities_slides' => json_decode(\App\Models\Setting::getValue('home_activities_slides', '[]'), true),
                'home_graduate_attributes' => json_decode(\App\Models\Setting::getValue('home_graduate_attributes', '{}'), true),
                'home_stats' => json_decode(\App\Models\Setting::getValue('home_stats', '[]'), true),
            ]
        ]);
    });

    Route::get('/clear-cache', function() {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return '<h1 style="color:green; text-align:center; margin-top:50px; font-family:sans-serif;">✅ All Laravel Caches Cleared Successfully!</h1>';
    });

    Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

    Route::get('/contact', function () {
        return Inertia::render('Contact');
    })->name('/contact');

    Route::get('/events', function () {
        return Inertia::render('Events', [
            'events' => \App\Models\Event::where('is_published', true)->latest()->get()
        ]);
    })->name('events');

    Route::get('/events/{event}', function ($event) {
        $eventModel = \App\Models\Event::where('is_published', true)->findOrFail($event);
        return Inertia::render('EventDetail', [
            'event' => $eventModel,
        ]);
    })->name('events.show');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Admin CRUD & Restoration operations
        Route::post('/admin/home-settings', [AdminController::class, 'saveHomeSettings'])->name('admin.home.save');
        Route::post('/admin/home-settings/restore-defaults', [AdminController::class, 'restoreDefaultHomeSettings'])->name('admin.home.restoreDefaults');
        Route::post('/admin/navigation', [AdminController::class, 'saveNavigationItem'])->name('admin.navigation.save');
        Route::post('/admin/navigation/restore-defaults', [AdminController::class, 'restoreDefaultNavigation'])->name('admin.navigation.restoreDefaults');
        Route::delete('/admin/navigation/{item}', [AdminController::class, 'deleteNavigationItem'])->name('admin.navigation.delete');

        Route::post('/admin/pages', [AdminController::class, 'savePageContent'])->name('admin.pages.save');
        Route::post('/admin/pages/restore-defaults/{id}', [AdminController::class, 'restoreDefaultPageContent'])->name('admin.pages.restoreDefaults');
        Route::delete('/admin/pages/{page}', [AdminController::class, 'deletePageContent'])->name('admin.pages.delete');

        Route::post('/admin/events', [AdminController::class, 'saveEvent'])->name('admin.events.save');
        Route::post('/admin/events/restore-defaults', [AdminController::class, 'restoreDefaultEvents'])->name('admin.events.restoreDefaults');
        Route::delete('/admin/events/{event}', [AdminController::class, 'deleteEvent'])->name('admin.events.delete');

        Route::post('/admin/faculties', [AdminController::class, 'saveFaculty'])->name('admin.faculties.save');
        Route::post('/admin/faculties/restore-defaults', [AdminController::class, 'restoreDefaultFaculties'])->name('admin.faculties.restoreDefaults');
        Route::delete('/admin/faculties/{faculty}', [AdminController::class, 'deleteFaculty'])->name('admin.faculties.delete');

        Route::post('/admin/departments', [AdminController::class, 'saveDepartment'])->name('admin.departments.save');
        Route::delete('/admin/departments/{department}', [AdminController::class, 'deleteDepartment'])->name('admin.departments.delete');

        Route::post('/admin/settings', [AdminController::class, 'saveSettings'])->name('admin.settings.save');
        Route::post('/admin/settings/restore-defaults', [AdminController::class, 'restoreDefaultSettings'])->name('admin.settings.restoreDefaults');

        Route::post('/admin/contact-settings', [AdminController::class, 'saveContactSettings'])->name('admin.contact.save');

        Route::post('/admin/translations', [AdminController::class, 'saveTranslation'])->name('admin.translations.save');
        Route::post('/admin/translations/restore-defaults', [AdminController::class, 'restoreDefaultTranslations'])->name('admin.translations.restoreDefaults');
        Route::delete('/admin/translations/{translation}', [AdminController::class, 'deleteTranslation'])->name('admin.translations.delete');
    });

    Route::get('/faculties', function () {
        return Inertia::render('Faculties', [
            'faculties' => \App\Models\Faculty::all()
        ]);
    })->name('faculties');

// Dynamic pages are handled by the catch-all route at the bottom of the file

Route::get('/department/{department}/{major}', [MajorController::class, 'show'])->name('major.show');
 //end of office section

Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('department.show');

Route::get('/faculty/{faculty}/department/{department}', [MajorController::class, 'show'])
    ->name('department.view');

require __DIR__.'/auth.php';
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Run Storage Link (placed ABOVE the catch-all route)
    Route::get('/create-storage-link', function () {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Storage Link Created Successfully!';
    });

    // Catch-All Route for Dynamic CMS Pages
    // This MUST be the last route defined to prevent it from intercepting core routes (like /login)
    Route::get('/{slug}', function ($slug) {
        $page = \App\Models\PageContent::where('slug', $slug)->first();
        
        if (!$page) {
            abort(404);
        }

        if ($page->is_office) {
            $officeData = json_decode($page->content, true) ?? [];
            $officeData['title'] = $page->title;
            return Inertia::render('OfficePages/OfficeShow', [
                'office' => $slug,
                'officeData' => $officeData,
            ]);
        }

        // Use slug (stable across delete+restore) instead of id to pick the correct template
        $templateMap = [
            'rector'          => 'AboutPages/RectorMessage',
            'about'           => 'AboutPages/About',
            'exam-evaluation' => 'AboutPages/ExamEvaluation',
        ];

        if (isset($templateMap[$page->slug])) {
            return Inertia::render($templateMap[$page->slug], [
                'pageData' => json_decode($page->content, true),
                'faculties' => \App\Models\Faculty::all(),
            ]);
        }

        return Inertia::render('GenericPage', [
            'pageTitle' => $page->title,
            'pageData' => json_decode($page->content, true) ?: ['custom_sections' => []]
        ]);
    })->name('dynamic.page');

