<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Branch;
use App\Repositories\StudentRepository;
use App\Teacher;
use App\Study;
use App\StudentPayment;
use App\StudentStudy;
use Illuminate\Support\Facades\Auth;
use App\BranchStudy;

class BranchOverview extends Component
{
    // Injection
    protected $studentRepository;

    public $counter = 0;

    public $branches = [];

    public $selectedBranch = 1;

    public $selectedBranchName = "Pusat";

    // Data
    public $totalStudent = 0;

    public $totalTeacher = 0;

    public $totalStudy = 0;

    public $totalEarning = 0;

    public function mount(StudentRepository $studentRepository)
    {


        $this->totalStudent = 0;
    }

    public function selectBranch(StudentRepository $studentRepository, $branchID, $branchName)
    {
        $this->selectedBranch = $branchID;
        $this->selectedBranchName = $branchName;
        $this->totalStudent = $studentRepository->getTotalByBranch($this->selectedBranch);
    }

    public function render()
    {
        $this->branches = [];
        $this->totalTeacher = 1;
        $this->totalStudy = 1;
        $this->totalEarning = 1;

        return view('livewire.branch-overview');
    }

    private function getTeacher()
    {
        return Teacher::where('branch_id', $this->selectedBranch)->count();
    }

    private function getStudy()
    {
        return Study::whereIn('id', BranchStudy::where('branch_id', $this->selectedBranch)->pluck('study_id'))->count();
    }

    private function getEarning()
    {
        return StudentStudy::whereHas('study', function($q){
            $q->where('branch_id', $this->selectedBranch);
        })->sum('amount_paid');
    }
}
