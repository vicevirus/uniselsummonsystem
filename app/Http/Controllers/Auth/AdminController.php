<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\IssueSummon;
use App\Models\SecurityGuard;
use App\Models\Student;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.adminLogin');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'admin_username' => 'required|string',
            'admin_password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt(['admin_username' => $request->admin_username, 'password' => $request->admin_password])) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->withInput($request->only('admin_username', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $students = Student::whereNull('QRCodeId')->get();
        return view('admin.adminDashboard', ['students' => $students]);
    }

    public function manageStudent()
    {
        $students = Student::all();
        return view('admin.adminManageStud', ['students' => $students]);
    }

    public function deleteStudent(Request $request, $matricNumber)
{
    // Find the student by their matricNumber
    $student = Student::where('matricNumber', $matricNumber)->first();

    // Check if the student exists
    if (!$student) {
        return redirect()->route('admin.manage_students')->with('error', 'Student not found.');
    }

    // Delete the student record
    $student->delete();

    // Redirect back to the "Manage Students" page with a success message
    return redirect()->route('admin.manage_students')->with('success', 'Student deleted successfully.');
}


    public function manageSummons()
    {
        $summons = IssueSummon::with('student')->get();

    

        return view('admin.adminManageSummon', ['summons' => $summons]);
    }

    public function manageGuards()
    {
        

      $guards = SecurityGuard::all();

        return view('admin.adminManageGuards', ['guards' => $guards]);
    }

    public function approveStudent(Request $request, $matricNumber)
    {
        $student = Student::findOrFail($matricNumber);
        $student->QRCodeId = (string) Str::uuid(); // Generate a random UUID
        $student->save();

        return redirect()->route('admin.dashboard');
    }
}
