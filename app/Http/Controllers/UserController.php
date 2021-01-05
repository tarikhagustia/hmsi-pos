<?php

namespace App\Http\Controllers;

use App\Repositories\BranchRepository;
use App\Teacher;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function request;

class UserController extends Controller
{

    /**
     * @var BranchRepository
     */
    private $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $pattern = '/edit/';

        request()->isEditing = false;

        if (preg_match($pattern, request()->url())) {
            request()->isEditing = true;
        }
        $this->authorizeResource(User::class);
        $this->branchRepository = $branchRepository;
    }

    public function index()
    {
        $users = User::with(['branch', 'role'])
            ->where(function ($query) {

                $query->where('name', 'like', '%' . request()->search . '%')
                    ->orWhere('email', 'like', '%' . request()->search . '%');
            })
            ->when(Auth::user()->hasRole('Admin'), function($q){
                $q->where('branch_id', Auth::user()->branch_id);
            })

            ->paginate(25);

        $users->appends(['search' => request()->search]);

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $branches = $this->branchRepository->getAll();

        return view('user.create_edit', compact( 'branches'));
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $fill = request()->except('_token');
        $fill['password'] = Hash::make($fill['password']);
        // Manually set branch if not Super Admin
        if (!Auth::user()->hasRole('Super Admin')) {
            $fill['branch_id'] = Auth::user()->branch->id;
        }

        DB::beginTransaction();
        try {
            $user = User::create($fill);
            $user->assignRole('Admin');
            session()->flash('success', 'Pengguna telah disimpan telah ditambah.');
            DB::commit();
        }catch (\Exception $exception) {
            Log::error($exception);
            DB::rollBack();
            session()->flash('success', 'Gagal Menambah user.');
        }

        return redirect(route('users.index'));
    }

    public function edit(User $user)
    {
        $branches = $this->branchRepository->getAll();

        return view('user.create_edit', compact('user',  'branches'));
    }

    public function update(User $user)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|unique:users,id,' . $user->id,
            'password' => 'confirmed',
        ]);

        $fill = request()->except(['_token', 'password']);


        // Manually set branch if not Super Admin
        if (!Auth::user()->hasRole('Super Admin')) {
            $fill['branch_id'] = Auth::user()->branch->id;
        }
        if (request()->has('password'))
        {
            $fill['password'] = Hash::make(request()->input('password'));
        }

        DB::beginTransaction();
        try {
            $user->update($fill);
            $user->assignRole('Admin');
            session()->flash('success', 'Pengguna telah diupdate.');
            DB::commit();
        }catch (\Exception $exception) {
            Log::error($exception);
            DB::rollBack();
            session()->flash('success', 'Gagal Merubah pengguna.');
        }

        return redirect(route('users.index'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', 'Sukses menghapus pengguna.');
        return redirect(route('users.index'));
    }
}
