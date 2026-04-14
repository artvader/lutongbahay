<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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

/**
 * Serve built Vue frontend from Laravel public directory.
 */
$serveFrontend = function (): Response {
    $indexPath = public_path('frontend/index.html');
    if (file_exists($indexPath)) {
        return response()->file($indexPath);
    }

    return response('Frontend build not found. Run "npm run build" at repository root.', 404);
};

Route::get('/', $serveFrontend)->name('frontend.home');
Route::get('/browse', $serveFrontend)->name('frontend.browse');
Route::get('/saved', $serveFrontend)->name('frontend.saved');
Route::get('/more', $serveFrontend)->name('frontend.more');
Route::get('/recipe/{slug}', $serveFrontend)->name('frontend.recipe');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'totalRecipes' => Recipe::count(),
        'publishedRecipes' => Recipe::where('status', 'published')->count(),
        'draftRecipes' => Recipe::where('status', 'draft')->count(),
        'recentRecipes' => Recipe::latest()->take(5)->get(),
    ]);
})->middleware(['auth'])->name('dashboard');

Route::resource('recipes', RecipeController::class)->middleware(['auth']);
Route::resource('users', UserController::class)->except(['show'])->middleware(['auth', 'role:admin']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__.'/auth.php';
