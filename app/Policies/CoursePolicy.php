<?php

namespace App\Policies;

use App\Models\Admins;
use App\Models\Course;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy extends AbstractPolicy
{
	/**
	 * @param Admins $user
	 * @param Course $ability
	 * @return bool
	 */
	public function index(Admins $user, Course $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param Course $ability
	 * @return bool
	 */
	public function create(Admins $user, Course $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param Course $ability
	 * @return bool
	 */
	public function edit(Admins $user, Course $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param Course $ability
	 * @return bool
	 */
	public function destroy(Admins $user, Course $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}
}
