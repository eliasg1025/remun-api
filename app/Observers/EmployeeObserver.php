<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\User;

class EmployeeObserver
{
    /**
     * Handle the employee "created" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "updated" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function updating(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "restored" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "force deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        //
    }
}
