<?php


namespace App\Traits;


use App\Constants\StatusConstant;
use Illuminate\Database\Query\Builder;

trait HasStatus
{
    public function scopePending($builder)
    {
        return $this->where('status', StatusConstant::PENDING);
    }

    public function scopeApproved($builder)
    {
        return $this->where('status', StatusConstant::APPROVED);
    }

    public function scopeSent($builder)
    {
        return $this->where('status', StatusConstant::SENT);
    }

    public function getStatusHtmlAttribute()
    {
        $class = "";
        switch ($this->status) {
            case StatusConstant::PENDING:
                $class = "badge badge-warning";
                break;
            case StatusConstant::APPROVED:
                $class = "badge badge-info";
                break;
            case StatusConstant::REJECTED:
                $class = "badge badge-danger";
                break;
            case StatusConstant::ACTIVE:
                $class = "badge badge-success";
                break;
            case StatusConstant::INACTIVE:
                $class = "badge badge-danger";
                break;
            case StatusConstant::UNPAID:
                $class = "badge badge-warning";
                break;
            case StatusConstant::PUBLISHED:
                $class = "badge badge-success";
                break;
        }

        return '<badge class="'.$class.'">'.$this->status.'</badge>';
    }

    public function scopeActive($builder)
    {
        return $builder->where('status', StatusConstant::ACTIVE);
    }

    /**
     * Inactive
     */
    public function inactive(){
        $this->status = StatusConstant::INACTIVE;
        $this->save();
        // TODO : Fire an Event
        return $this;
    }

    /**
     * Inactive
     */
    public function publish(){
        $this->status = StatusConstant::ACTIVE;
        $this->save();
        // TODO : Fire an Event
        return $this;
    }
}
