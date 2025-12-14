<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash; // ← brakowało
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ClassManagementController;
use App\Http\Controllers\Admin\SubjectManagementController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\ExportController; // ← NOWE

use App\Http\Controllers\Teacher\GradeController as TeacherGradeController;
use App\Http\Controllers\Teacher\StudentListController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\GradeHistoryController;

use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\GradesViewController;
use App\Http\Controllers\Student\AttendanceViewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', LogoutController::class)->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Authenticated
Route::middleware(['auth'])->group(function () {

    // Role-based redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();
        session()->forget('url.intended');

        if ($user->isAdmin())   return redirect()->route('admin.dashboard');
        if ($user->isTeacher()) return redirect()->route('teacher.dashboard');
        if ($user->isStudent()) return redirect()->route('student.dashboard');

        return redirect()->route('home');
    })->name('dashboard');

    /*
    |-------------------------
    | ADMIN
    |-------------------------
    */
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [SystemSettingsController::class, 'dashboard'])->name('dashboard');

            // 🔧 WAŻNE: /users/search musi być PRZED resource, inaczej koliduje z /users/{user}
            Route::get('/users/search', [UserManagementController::class, 'search'])->name('users.search');

            // Users
            Route::resource('users', UserManagementController::class);
            Route::post('/users/bulk-action', [UserManagementController::class, 'bulkAction'])
                ->name('users.bulk-action');

            // Classes
            Route::resource('classes', ClassManagementController::class);
            Route::get('/classes/{class}/manage', [ClassManagementController::class, 'manage'])->name('classes.manage');
            Route::post('/classes/{class}/assign-subject', [ClassManagementController::class, 'assignSubject'])->name('classes.assign-subject');
            Route::delete('/classes/{class}/subjects/{subject}/{teacher}', [ClassManagementController::class, 'removeSubject'])->name('classes.remove-subject');
            Route::post('/classes/{class}/add-student', [ClassManagementController::class, 'addStudent'])->name('classes.add-student');
            Route::delete('/classes/{class}/students/{student}', [ClassManagementController::class, 'removeStudent'])->name('classes.remove-student');

            // Subjects
            Route::resource('subjects', SubjectManagementController::class);

            // Reports
            Route::get('/reports', [SystemSettingsController::class, 'reports'])->name('reports');

            // Export PDF routes
            Route::get('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');
            Route::post('/export/pdf', [ExportController::class, 'generatePdf'])->name('export.generate');
        });

    /*
    |-------------------------
    | TEACHER
    |-------------------------
    */
    Route::middleware(['role:teacher'])
        ->prefix('teacher')
        ->name('teacher.')
        ->group(function () {

            Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');

            // Grades
            Route::get('/grades', [TeacherGradeController::class, 'index'])->name('grades.index');
            Route::get('/grades/create', [TeacherGradeController::class, 'create'])->name('grades.create');
            Route::get('/grades/quick', [TeacherGradeController::class, 'quickGrade'])->name('grades.quick');
            Route::post('/grades/quick', [TeacherGradeController::class, 'storeQuick'])->name('grades.quick.store');
            Route::post('/grades', [TeacherGradeController::class, 'store'])->name('grades.store');
            Route::get('/grades/{grade}/edit', [TeacherGradeController::class, 'edit'])->name('grades.edit');
            Route::put('/grades/{grade}', [TeacherGradeController::class, 'update'])->name('grades.update');
            Route::delete('/grades/{grade}', [TeacherGradeController::class, 'destroy'])->name('grades.destroy');
            Route::get('/grades/history', [GradeHistoryController::class, 'recent'])->name('grades.history');

            // Students
            Route::get('/students', [StudentListController::class, 'index'])->name('students.index');
            Route::get('/students/{class}', [StudentListController::class, 'index'])->name('students.list');

            // Attendance
            Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('attendance.index');
            Route::get('/attendance/reports', [TeacherAttendanceController::class, 'reports'])->name('attendance.reports');
            Route::get('/attendance/{class}/{subject}', [TeacherAttendanceController::class, 'showClass'])->name('attendance.show-class');
            Route::post('/attendance', [TeacherAttendanceController::class, 'store'])->name('attendance.store');
            Route::put('/attendance/{attendance}', [TeacherAttendanceController::class, 'update'])->name('attendance.update');

            // Subjects for teacher
            Route::get('/subjects', [TeacherGradeController::class, 'subjects'])->name('subjects.index');

            // Reports
            Route::get('/reports/grades', [TeacherGradeController::class, 'gradeReports'])->name('reports.grades');
            Route::get('/reports/class-performance', [TeacherGradeController::class, 'classPerformance'])->name('reports.class-performance');
        });

    /*
    |-------------------------
    | STUDENT
    |-------------------------
    */
    Route::middleware(['role:student'])
        ->prefix('student')
        ->name('student.')
        ->group(function () {

            Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

            // Grades
            Route::get('/grades', [GradesViewController::class, 'index'])->name('grades.index');
            Route::get('/grades/by-subject/{subjectId}', [GradesViewController::class, 'bySubject'])->name('grades.by-subject');
            Route::get('/grades/average', [GradesViewController::class, 'average'])->name('grades.average');
            Route::get('/grades/history', [GradesViewController::class, 'history'])->name('grades.history');
            Route::get('/grades/statistics', [GradesViewController::class, 'statistics'])->name('grades.statistics');

            // Attendance
            Route::get('/attendance', [AttendanceViewController::class, 'index'])->name('attendance.index');
            Route::get('/attendance/calendar', [AttendanceViewController::class, 'calendar'])->name('attendance.calendar');

            // Class info
            Route::get('/class/info', [AttendanceViewController::class, 'classInfo'])->name('class.info');
            Route::get('/class/ranking', [AttendanceViewController::class, 'ranking'])->name('class.ranking');

            // Subjects
            Route::get('/subjects', [GradesViewController::class, 'subjects'])->name('subjects.index');

            // Profile
            Route::get('/profile/edit', [StudentDashboardController::class, 'editProfile'])->name('profile.edit');
            Route::get('/profile/password', [StudentDashboardController::class, 'changePassword'])->name('profile.password');
        });

    /*
    |-------------------------
    | Wspólne
    |-------------------------
    */
    Route::get('/profile', function () {
        return view('profile.edit', ['user' => auth()->user()]);
    })->name('profile.edit');

    Route::put('/profile', function (Illuminate\Http\Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|regex:/^[0-9]{9}$/',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('success', 'Profil został zaktualizowany.');
    })->name('profile.update');

    Route::get('/help', function () {
        return view('help.index');
    })->name('help');
});

// API (AJAX)
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/classes/{class}/students', function (App\Models\SchoolClass $class) {
        return response()->json($class->students);
    });

    Route::get('/classes/{classId}/subjects', function ($classId) {
        $assignments = \DB::table('class_subject_teacher')
            ->where('class_subject_teacher.class_id', $classId)
            ->join('subjects', 'class_subject_teacher.subject_id', '=', 'subjects.id')
            ->join('users', 'class_subject_teacher.teacher_id', '=', 'users.id')
            ->select(
                'subjects.id as subject_id',
                'subjects.name as subject_name',
                'users.id as teacher_id',
                'users.name as teacher_name'
            )
            ->orderBy('subjects.name')
            ->get();

        return response()->json($assignments);
    });

    Route::get('/teacher/subjects', function () {
        $teacher = auth()->user();
        if (! $teacher->isTeacher()) {
            return response()->json([], 403);
        }
        return response()->json($teacher->teachingSubjects);
    });

    Route::get('/grades/stats/{student}', function (App\Models\User $student) {
        if (!auth()->user()->isTeacher() && auth()->id() !== $student->id) {
            return response()->json([], 403);
        }

        return response()->json([
            'total_grades' => $student->grades->count(),
            'average' => $student->getWeightedAverage(),
            'by_subject' => $student->grades->groupBy('subject_id')->map(function ($grades) use ($student) {
                return [
                    'subject' => $grades->first()->subject->name,
                    'average' => $student->getSubjectAverage($grades->first()->subject_id),
                    'count'   => $grades->count(),
                ];
            }),
        ]);
    });
});

// 404
Route::fallback(function () {
    return view('errors.404');
});
