<?php


namespace App\Repositories;


use App\Student;
use Carbon\Carbon;
use App\StudentStudy;
use Illuminate\Support\Facades\DB;

class StudentRepository
{
    public function getStudentByTeacher($teacherId)
    {
        return Student::whereHas('branch.study', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->get();

    }

    public function getTotalByBranch($branchID)
    {
        return Student::where('branch_id', $branchID)->count();
    }

    public function getMutationReportDetailed($branchID, Carbon $startDate, Carbon $endDate)
    {
        $query = StudentStudy::with(['student', 'study', 'teacher', 'branch'])
                             ->whereBetween('stop_date', [$startDate, $endDate])
                             ->where('branch_id', $branchID)
                             ->get();

        return $query->keyBy('study.name')->groupBy('study.name');
    }

    public function getMutationReportRecap($branchID, Carbon $startDate, Carbon $endDate)
    {
        $newStartDate = $startDate->format("Y-m-d");
        $newEndDate = $endDate->format("Y-m-d");
        $query = DB::select(DB::raw("SELECT
	s.`unit`,
	s.`level`,
	(
	SELECT
		count(id)
	FROM
		student_studies ss2
	where
		ss2.study_id = ss.study_id
		and ss2.stop_date is NULL
		and ss2.branch_id = {$branchID}) as active_student,
	(
	SELECT
		count(id)
	FROM
		student_studies ss2
	where
		ss2.study_id = ss.study_id
		and ss2.start_date BETWEEN \"{$newStartDate}\" AND \"{$newEndDate}\"
		and ss2.branch_id =  {$branchID}) as new_student,
	(
	SELECT
		count(id)
	FROM
		student_studies ss2
	where
		ss2.study_id = ss.study_id
		and ss2.stop_date BETWEEN \"{$newStartDate}\" AND \"{$newEndDate}\"
		and ss2.branch_id =  {$branchID}) as stop_student
FROM
	student_studies ss
join studies as s on
	s.id = ss.study_id
where
	branch_id =  {$branchID}
group BY
	s.id"));


        return $query;
    }
}
