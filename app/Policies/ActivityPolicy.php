<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy extends AbstractMainPolicy
{

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->permission_name = 'MANAGE_ACTIVITIES';
        $this->can_manage_own = false;
    }

}
