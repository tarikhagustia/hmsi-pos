<?php

use App\BranchStudy;
use Illuminate\Support\Facades\Auth;

if (!function_exists('option_data_branches')) {
    function option_data_branches()
    {
        $query = \App\Branch::select('id', 'name as text');

        if (auth()->user()->role->name == 'Admin') {
            $query->where('id', auth()->user()->branch->id);
        }

        return $query->orderBy('name')->get();
    }
}

if (!function_exists('option_data_provinces')) {
    function option_data_provinces()
    {
        return \App\Province::select('province_id as id', 'province_name as text')
                            ->orderBy('province_name')
                            ->get();
    }
}

if (!function_exists('option_data_cities')) {
    function option_data_cities()
    {
        return \App\City::select('city_id as id', 'city_name_full as text', 'province_id')
                        ->whereRAW('province_id = (select min(province_id) from provinces)')
                        ->orderBy('city_name')
                        ->get();
    }
}

if (!function_exists('option_data_jobs')) {
    function option_data_jobs()
    {
        return \App\GuardianJob::select('id', 'name as text')
                               ->orderBy('name')
                               ->get();
    }
}

if (!function_exists('option_data_school_levels')) {
    function option_data_school_levels()
    {
        return ['TK', 'SD', 'SMP', 'SMA'];
    }
}

if (!function_exists('option_data_branch_admins')) {
    function option_data_branch_admins($current = null)
    {
        $users = \App\User::select('id', 'name as text')
                          ->where(function ($query) {
                              $query->whereNull('branch_id')->whereHas('role', function ($role) {
                                  $role->where('name', 'Admin');
                              });
                          });

        if (!is_null($current)) {
            $users->orWhere('id', $current);
        }

        return $users->orderBy('name')->get();
    }
}

if (!function_exists('option_data_study_categories')) {
    function option_data_study_categories()
    {
        return \App\StudyCategory::select('id', 'name as text')
                                 ->orderBy('name')
                                 ->get();
    }
}

if (!function_exists('option_data_studies')) {
    function option_data_studies($isEdit = false)
    {


        $query = \App\Study::select('id', \DB::raw("CONCAT(unit, ' (', level, ')') as text"))
                           ->active();


        if (!$isEdit) {
            // $branchStudies = BranchStudy::where('branch_id', Auth::user()->branch_id)->pluck('study_id');
            // $query->whereNotIn('id', $branchStudies);
        }

        return $query->latest()->get();
    }
}

if (!function_exists('option_data_studies_single')) {
    function option_data_studies_single()
    {
        $query = \App\Study::select('id', \DB::raw("CONCAT(name, ' (', level, ')') as text"))
                           ->whereNotNull('category_id');

        if (auth()->user()->role->name == 'Admin') {
            $query->where('branch_id', auth()->user()->branch->id);
        }

        return $query->orderBy('name')->get();
    }
}

if (!function_exists('option_data_teachers')) {
    function option_data_teachers()
    {
        $query = \App\Teacher::select('id', 'name as text')->active();

        if (auth()->user()->role->name == 'Admin') {
            $query->where('branch_id', auth()->user()->branch->id);
        }

        return $query->orderBy('name')->get();
    }
}

if (!function_exists('option_data_product_categories')) {
    function option_data_product_categories()
    {
        return \App\ProductCategory::select('id', 'name as text')
                                   ->orderBy('name')
                                   ->active()
                                   ->get();
    }
}

if (!function_exists('currency')) {
    function currency($value, $decimal = 2, $prefix = 'Rp. ')
    {
        return $prefix.number_format($value, $decimal, ',', '.');
    }
}

if (!function_exists('list_months')) {
    function list_months()
    {
        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );
        $monthArray = [];

        foreach ($months as $key => $row) {
            $monthArray[$key + 1] = $row;
        }

        return $monthArray;
    }
}

if (!function_exists('list_years')) {
    function list_years()
    {
        $currentYear = date('Y');
        $toYear = 1;

        return [$currentYear, $currentYear - 1];
    }
}
