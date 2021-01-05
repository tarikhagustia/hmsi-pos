<?php

namespace App\Policies;

use App\Teacher;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any teachers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the teacher.
     *
     * @param  \App\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function view(User $user, Teacher $teacher)
    {
        //
    }

    /**
     * Determine whether the user can create teachers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can update the teacher.
     *
     * @param  \App\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function update(User $user, Teacher $teacher)
    {
        return ($user->branch_id === $teacher->branch_id || $user->hasRole('Super Admin'));
    }

    /**
     * Determine whether the user can delete the teacher.
     *
     * @param  \App\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function delete(User $user, Teacher $teacher)
    {
        return ($user->branch_id === $teacher->branch_id || $user->hasRole('Super Admin'));
    }

    /**
     * Determine whether the user can restore the teacher.
     *
     * @param  \App\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function restore(User $user, Teacher $teacher)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the teacher.
     *
     * @param  \App\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function forceDelete(User $user, Teacher $teacher)
    {
        //
    }
}
