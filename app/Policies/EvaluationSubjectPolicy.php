<?php

namespace App\Policies;

use App\EvaluationSubject;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluationSubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any evaluation subjects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['Teacher']);
    }

    /**
     * Determine whether the user can view the evaluation subject.
     *
     * @param  \App\User  $user
     * @param  \App\EvaluationSubject  $evaluationSubject
     * @return mixed
     */
    public function view(User $user, EvaluationSubject $evaluationSubject)
    {
        return $user->hasAnyRole(['Teacher']);
    }

    /**
     * Determine whether the user can create evaluation subjects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['Teacher']);
    }

    /**
     * Determine whether the user can update the evaluation subject.
     *
     * @param  \App\User  $user
     * @param  \App\EvaluationSubject  $evaluationSubject
     * @return mixed
     */
    public function update(User $user, EvaluationSubject $evaluationSubject)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the evaluation subject.
     *
     * @param  \App\User  $user
     * @param  \App\EvaluationSubject  $evaluationSubject
     * @return mixed
     */
    public function delete(User $user, EvaluationSubject $evaluationSubject)
    {
        //
    }

    /**
     * Determine whether the user can restore the evaluation subject.
     *
     * @param  \App\User  $user
     * @param  \App\EvaluationSubject  $evaluationSubject
     * @return mixed
     */
    public function restore(User $user, EvaluationSubject $evaluationSubject)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the evaluation subject.
     *
     * @param  \App\User  $user
     * @param  \App\EvaluationSubject  $evaluationSubject
     * @return mixed
     */
    public function forceDelete(User $user, EvaluationSubject $evaluationSubject)
    {
        //
    }
}
