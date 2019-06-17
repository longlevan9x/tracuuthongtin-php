<?php

namespace App\Policies;

use App\Models\Admins;
use App\Models\Department;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy extends AbstractPolicy
{
	/**
	 * @param Admins     $user
	 * @param Department $ability
	 * @return bool
	 */
	public function index(Admins $user, Department $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins     $user
	 * @param Department $ability
	 * @return bool
	 */
	public function create(Admins $user, Department $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins     $user
	 * @param Department $ability
	 * @return bool
	 */
	public function edit(Admins $user, Department $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins     $user
	 * @param Department $ability
	 * @return bool
	 */
	public function destroy(Admins $user, Department $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}
}
