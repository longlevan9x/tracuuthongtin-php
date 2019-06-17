<?php

namespace App\Policies;

use App\Models\Admins;
use App\Models\Semester;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SemesterPolicy extends AbstractPolicy
{
	/**
	 * @param Admins   $user
	 * @param Semester $ability
	 * @return bool
	 */
	public function index(Admins $user, Semester $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins   $user
	 * @param Semester $ability
	 * @return bool
	 */
	public function create(Admins $user, Semester $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins   $user
	 * @param Semester $ability
	 * @return bool
	 */
	public function edit(Admins $user, Semester $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins   $user
	 * @param Semester $ability
	 * @return bool
	 */
	public function destroy(Admins $user, Semester $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}
}
