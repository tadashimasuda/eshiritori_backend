<?php

namespace App\Policies;

use App\User;
use App\Table;
use Illuminate\Auth\Access\HandlesAuthorization;
use Symfony\Component\VarDumper\VarDumper;

class TablePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $user,Table $table){
        return $user->id == $table->owner_id;
    }
}
