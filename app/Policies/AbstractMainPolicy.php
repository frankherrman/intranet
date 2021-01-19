<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * AbstractMainPolicy
 * @abstract Checks for a permission name to make sure a user can
 * 			 access or manage the data. This abstract class is extended
 * 			 by other Policy classes to have the basic functionality.
 * @author Frank Herrman <frank@typify.com>
 */
abstract class AbstractMainPolicy
{
	 use HandlesAuthorization;
	 
	 protected $permission_name;
	 protected $can_manage_own = false;

	 /**
	  * Admins can do anything
	  *	
	  * @param User $user
	  * @param string $ability
	  * @return boolean|null
	  */
	 public function before(User $user, $ability) {
		 if( $user->hasPermission('ADMIN') ) {
			 return true;
		 }
	 }

	 /**
	  * Check create access
	  *
	  * @param User $user
	  * @return boolean
	  */
    public function create(User $user) {
        return $user->hasPermission($this->permission_name);
	 }
	 
	 /**
	  * Check update access
	  *
	  * @param User $user
	  * @param Model $model
	  * @return boolean
	  */
	 public function update(User $user, Model $model) {
		if($this->can_manage_own) {
			return !empty($user) && $model->user_id == $user->id;
		}
		return $user->hasPermission($this->permission_name);
	 }

	 /**
	  * Check delete access
	  *
	  * @param User $user
	  * @param Model $model
	  * @return boolean
	  */
	 public function delete(User $user, Model $model) {
		if($this->can_manage_own) {
			return !empty($user) && $model->user_id == $user->id;
		}
		return $user->hasPermission($this->permission_name);
	 }

	 /**
	  * Check view access
	  *
	  * @param User $user
	  * @param Model $model
	  * @return boolean
	  */
	 public function view(User $user, Model $model) {
		if($this->can_manage_own) {
			return !empty($user) && $model->user_id == $user->id;
		}
		return $user->hasPermission($this->permission_name);
	 }


}
