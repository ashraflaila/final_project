<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Models\Admin;
use App\Models\Category;
use App\Models\City;
use App\Models\Country as CountryModel;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
});

Route::middleware('auth:teacher')->group(function () {
    Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
    Route::get('/teacher/courses/{course}/students', [EnrollmentController::class, 'manage'])->name('teacher.courses.students');
    Route::delete('/teacher/courses/{course}/students/{student}', [EnrollmentController::class, 'removeStudent'])->name('teacher.courses.students.destroy');
});

Route::middleware('auth:student')->group(function () {
    Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');
    Route::post('/student/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('student.courses.enroll');
    Route::delete('/student/courses/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('student.courses.unenroll');
});

Route::middleware('auth:admin')->prefix('cms/admin')->group(function(){
    Route::get('settings/profile', [AdminSettingsController::class, 'editProfile'])->name('settings.profile.edit');
    Route::put('settings/profile', [AdminSettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('settings/password', [AdminSettingsController::class, 'editPassword'])->name('settings.password.edit');
    Route::put('settings/password', [AdminSettingsController::class, 'updatePassword'])->name('settings.password.update');

    Route::get('', function () {
        $stats = [
            'admins_count' => Admin::count(),
            'teachers_count' => Teacher::count(),
            'students_count' => Student::count(),
            'countries_count' => CountryModel::count(),
            'cities_count' => City::count(),
            'categories_count' => Category::count(),
            'courses_count' => Course::count(),
            'lessons_count' => Lesson::count(),
            'trashed_count' => Admin::onlyTrashed()->count()
                + Teacher::onlyTrashed()->count()
                + Student::onlyTrashed()->count()
                + CountryModel::onlyTrashed()->count()
                + City::onlyTrashed()->count()
                + Category::onlyTrashed()->count()
                + Course::onlyTrashed()->count()
                + Lesson::onlyTrashed()->count(),
        ];

        return view('cms.temp', compact('stats'));
    })->name('dashboard');
    Route::resource('countries' , CountryController::class)->except(['update']);
    Route::put('countries-update/{id}' , [CountryController::class , 'update'])->name('countries.update');
    Route::get('countries-trashed' , [CountryController::class , 'trashed'])->name('countries.trashed');
    Route::post('countries/{id}/delete' , [CountryController::class , 'destroy'])->name('countries.delete');
    Route::post('countries/delete-all' , [CountryController::class , 'destroyAll'])->name('countries.delete-all');
    Route::patch('countries/{id}/restore' , [CountryController::class , 'restore'])->name('countries.restore');
    Route::post('countries/{id}/restore' , [CountryController::class , 'restore'])->name('countries.restore.post');
    Route::post('countries/restore-all' , [CountryController::class , 'restoreAll'])->name('countries.restore-all');
    Route::post('countries/{id}/force-delete' , [CountryController::class , 'forceDelete'])->name('countries.force-delete');

    Route::resource('cities' , CityController::class)->except(['update']);
    Route::put('cities-update/{id}' , [CityController::class , 'update'])->name('cities.update');
    Route::post('cities/{id}/delete' , [CityController::class , 'destroy'])->name('cities.delete');
    Route::get('cities-trashed' , [CityController::class , 'trashed'])->name('cities.trashed');
    Route::post('cities/delete-all' , [CityController::class , 'destroyAll'])->name('cities.delete-all');
    Route::patch('cities/{id}/restore' , [CityController::class , 'restore'])->name('cities.restore');
    Route::post('cities/{id}/restore' , [CityController::class , 'restore'])->name('cities.restore.post');
    Route::post('cities/restore-all' , [CityController::class , 'restoreAll'])->name('cities.restore-all');
    Route::post('cities/{id}/force-delete' , [CityController::class , 'forceDelete'])->name('cities.force-delete');

    Route::resource('admins' , AdminController::class)->except(['update']);
    Route::put('admins-update/{id}' , [AdminController::class , 'update'])->name('admins.update');
    Route::post('admins/{id}/delete' , [AdminController::class , 'destroy'])->name('admins.delete');
    Route::get('admins-trashed' , [AdminController::class , 'trashed'])->name('admins.trashed');
    Route::post('admins/delete-all' , [AdminController::class , 'destroyAll'])->name('admins.delete-all');
    Route::patch('admins/{id}/restore' , [AdminController::class , 'restore'])->name('admins.restore');
    Route::post('admins/{id}/restore' , [AdminController::class , 'restore'])->name('admins.restore.post');
    Route::post('admins/restore-all' , [AdminController::class , 'restoreAll'])->name('admins.restore-all');
    Route::post('admins/{id}/force-delete' , [AdminController::class , 'forceDelete'])->name('admins.force-delete');

    // Teachers
    Route::resource('teachers' , TeacherController::class)->except(['update']);
    Route::put('teachers-update/{id}' , [TeacherController::class , 'update'])->name('teachers.update');
    Route::post('teachers/{id}/delete' , [TeacherController::class , 'destroy'])->name('teachers.delete');
    Route::get('teachers-trashed' , [TeacherController::class , 'trashed'])->name('teachers.trashed');
    Route::post('teachers/delete-all' , [TeacherController::class , 'destroyAll'])->name('teachers.delete-all');
    Route::patch('teachers/{id}/restore' , [TeacherController::class , 'restore'])->name('teachers.restore');
    Route::post('teachers/{id}/restore' , [TeacherController::class , 'restore'])->name('teachers.restore.post');
    Route::post('teachers/restore-all' , [TeacherController::class , 'restoreAll'])->name('teachers.restore-all');
    Route::post('teachers/{id}/force-delete' , [TeacherController::class , 'forceDelete'])->name('teachers.force-delete');

    // Students
    Route::resource('students' , StudentController::class)->except(['update']);
    Route::put('students-update/{id}' , [StudentController::class , 'update'])->name('students.update');
    Route::post('students/{id}/delete' , [StudentController::class , 'destroy'])->name('students.delete');
    Route::get('students-trashed' , [StudentController::class , 'trashed'])->name('students.trashed');
    Route::post('students/delete-all' , [StudentController::class , 'destroyAll'])->name('students.delete-all');
    Route::patch('students/{id}/restore' , [StudentController::class , 'restore'])->name('students.restore');
    Route::post('students/{id}/restore' , [StudentController::class , 'restore'])->name('students.restore.post');
    Route::post('students/restore-all' , [StudentController::class , 'restoreAll'])->name('students.restore-all');
    Route::post('students/{id}/force-delete' , [StudentController::class , 'forceDelete'])->name('students.force-delete');

    // Categories
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::get('categories-trashed' , [CategoryController::class , 'trashed'])->name('categories.trashed');
    Route::post('categories/{id}/delete' , [CategoryController::class , 'destroy'])->name('categories.delete');
    Route::post('categories/delete-all' , [CategoryController::class , 'destroyAll'])->name('categories.delete-all');
    Route::patch('categories/{id}/restore' , [CategoryController::class , 'restore'])->name('categories.restore');
    Route::post('categories/{id}/restore' , [CategoryController::class , 'restore'])->name('categories.restore.post');
    Route::post('categories/restore-all' , [CategoryController::class , 'restoreAll'])->name('categories.restore-all');
    Route::post('categories/{id}/force-delete' , [CategoryController::class , 'forceDelete'])->name('categories.force-delete');

    // Courses
    Route::resource('courses', \App\Http\Controllers\CourseController::class);
    Route::get('courses-trashed', [\App\Http\Controllers\CourseController::class, 'trashed'])->name('courses.trashed');
    Route::patch('courses/{id}/restore', [\App\Http\Controllers\CourseController::class, 'restore'])->name('courses.restore');
    Route::post('courses/{id}/restore', [\App\Http\Controllers\CourseController::class, 'restore'])->name('courses.restore.post');
    Route::post('courses/{id}/force-delete', [\App\Http\Controllers\CourseController::class, 'forceDelete'])->name('courses.force-delete');

    // Lessons
    Route::resource('lessons', \App\Http\Controllers\LessonController::class);
    Route::get('lessons-trashed', [\App\Http\Controllers\LessonController::class, 'trashed'])->name('lessons.trashed');
    Route::patch('lessons/{id}/restore', [\App\Http\Controllers\LessonController::class, 'restore'])->name('lessons.restore');
    Route::post('lessons/{id}/restore', [\App\Http\Controllers\LessonController::class, 'restore'])->name('lessons.restore.post');
    Route::post('lessons/{id}/force-delete', [\App\Http\Controllers\LessonController::class, 'forceDelete'])->name('lessons.force-delete');
    });
