<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Student;
use App\Teacher;

class CustomerController extends Controller
{
    public function all()
    {
        $students = Student::forBranch()->orderBy('name')->get();
        $teachers = Teacher::forBranch()->orderBy('name')->get();

        $students->map(function ($item) {
            $item->class = get_class($item);
        });

        $teachers->map(function ($item) {
            $item->class = get_class($item);
        });

        return response()->json([$students, $teachers]);
    }
}
