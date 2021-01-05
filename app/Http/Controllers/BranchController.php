<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Role;
use App\User;

class BranchController extends Controller
{
    public function __construct()
    {
        $isEdting = preg_match('/edit/', request()->url());

        request()->isEditing = false;

        if ($isEdting) {
           request()->isEditing = true;
        }
    }

    private function rules(array $request = [], array $except = [])
    {
        $rules = [
            'name' => 'required|unique:branches',
            'address' => 'required',
            'code' => 'required',
            'pic_name' => 'required',
            'pic_phone_number' => 'required',
            'admin_name' => 'required',
            'admin_email' => 'required|unique:users,email',
            'admin_password' => 'required|min:6|confirmed',
        ];

        $rules = array_merge($rules, $request);

        $rules = collect($rules)->except($except)->toArray();

        return $rules;
    }

    public function index()
    {
        $branches = Branch::where(function ($query) {
            $query->where('name', 'like', '%'.request()->search.'%')
                ->orWhere('code', 'like', '%'.request()->search.'%')
                ->orWhere('address', 'like', '%'.request()->search.'%')
                ->orWhere('pic_name', 'like', '%'.request()->search.'%')
                ->orWhere('pic_phone_number', 'like', '%'.request()->search.'%');
        })
        ->paginate(25);

        $branches->appends(['search' => request()->search]);

        return view('branch.index', compact('branches'));
    }

    public function create()
    {
        return view('branch.create_edit');
    }

    public function store()
    {
        $this->validate(request(), $this->rules());

        $branch = Branch::create(
            request()->only('name', 'address', 'pic_name', 'pic_phone_number', 'code')
        );

        User::create([
            'branch_id' => $branch->id,
            'role_id' => Role::where('name', 'Admin')->first()->id,
            'name' => request()->admin_name,
            'email' => request()->admin_email,
            'password' => bcrypt(request()->password),
        ]);

        session()->flash('success', 'Data cabang telah ditambah.');

        return redirect(route('branches.index'));
    }

    public function edit(Branch $branch)
    {
        if (is_null($branch)) {
            abort(404);
        }

        return view('branch.create_edit', compact('branch'));
    }

    public function update(Branch $branch)
    {
        if (is_null($branch)) {
            abort(404);
        }

        $this->validate(
            request(),
            $this->rules([
                'name' => 'required|unique:branches,id,'.$branch->id,
                'admin' => 'required|exists:users,id'
            ], ['admin_name', 'admin_email', 'admin_password'])
        );

        $branch->update(
            request()->only('name', 'address', 'pic_name', 'pic_phone_number', 'code')
        );

        $admin = User::find(request()->admin);

        if ($admin->branch_id != $branch->id) {
            $admin->update(['branch_id' => $branch->id]);
        }

        session()->flash('success', 'Data cabang telah diperbarui.');

        return redirect(route('branches.index'));
    }

    public function destroy(Branch $branch)
    {
        if (is_null($branch)) {
            abort(404);
        }

        $branch->delete();

        return redirect(route('branches.index'));
    }
}
