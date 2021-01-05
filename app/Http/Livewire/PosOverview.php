<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Branch;
use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StudentRepository;

class PosOverview extends Component
{
    // Injection
    protected $studentRepository;

    public $counter = 0;

    public $branches = [];

    public $selectedBranch = 1;

    public $selectedBranchName = "Pusat";

    // Data
    public $totalEarning = 0;

    public $period;

    public $total;

    public function mount()
    {
        if (Auth::user()->hasRole('Admin')) {
            $this->selectedBranch = Auth::user()->branch_id;
        }
    }

    public function selectBranch($branchID, $branchName)
    {
        $this->selectedBranch = $branchID;
        $this->selectedBranchName = $branchName;
        list($this->period, $this->total) = $this->mapping($this->getPosSales());

        $this->emit('labelsUpdated', json_encode([$this->period]));
        $this->emit('datasetsUpdated', json_encode([$this->total]));
        // $this->emit('optionsUpdated', json_encode([]));
    }

    public function render()
    {
        $this->branches = Auth::user()->hasRole('Super Admin') ? Branch::all() : Branch::where('id', Auth::user()->branch_id)->get();
        list($this->period, $this->total) = $this->mapping($this->getPosSales());

        $this->totalEarning = $this->getEarning();

        return view('livewire.pos-overview');
    }

    private function mapping(Collection $collection)
    {
        $dateTo = Carbon::now();
        $cDate = [];
        $cTotal = [];
        for ($i = 1; $i <= 7; $i++) {
            $cDate[] = $dateTo->addDays(-1)->format('Y-m-d');
            $cTotal[] = 0;
        }

        foreach ($collection as $c) {
            if (in_array($c->date, $cDate)) {
                $found = array_search($c->date, $cDate);
                $cDate[array_search($c->date, $cDate)] = $c->total;
                $cTotal[$found] = $c->total;
            }
        }

        return [array_reverse($cDate, true), array_reverse($cTotal)];

    }

    protected function getPosSales()
    {
        $query = Order::select([DB::raw('SUM(total_amount) as total'), DB::raw('DATE(created_at) as date')])
                      ->whereHas('cashier', function ($q) {
                          $q->where('branch_id', $this->selectedBranch);
                      })->whereBetween('created_at', [Carbon::now()->addDays(-7), Carbon::now()])
                      ->groupBy(DB::raw('DATE(created_at)'))->get();
        return $query;
    }

    protected function getEarning()
    {
        return Order::whereHas('cashier', function ($q) {
            $q->where('branch_id', $this->selectedBranch);
        })->sum('total_amount');
    }

}
