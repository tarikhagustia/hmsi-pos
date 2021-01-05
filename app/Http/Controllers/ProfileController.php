<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\BranchRepository;

class ProfileController extends Controller
{
    /**
     * @var BranchRepository
     */
    private $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $branches = $this->branchRepository->getAll();
        // TODO: Implement __invoke() method.
        return view('user.profile', compact('user','branches'));
    }

    public function update(User $profile, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5|max:255',
            'email' => 'required',
            'password' => 'nullable|confirmed',
            'password_confirmation' => 'nullable',
        ]);
        $data = $request->only(['name']);

        if ($request->input('password')) {
            $request->merge([
                'password' => Hash::make($request->input('password'))
            ]);
            $data = $request->only(['name', 'password']);
        }
        $profile->update($data);
        return redirect()->back()->withSuccess('Berhasil merubah data profil');
    }
}
