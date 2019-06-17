<?php

namespace App\Policies;

use App\Models\Admins;
use App\Models\Student;

class StudentPolicy extends AbstractPolicy
{
	/**
	 * @param Admins  $user
	 * @param Student $ability
	 * @return bool
	 */
	public function index(Admins $user, Student $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins  $user
	 * @param Student $ability
	 * @return bool
	 */
	public function create(Admins $user, Student $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins  $user
	 * @param Student $ability
	 * @return bool
	 */
	public function edit(Admins $user, Student $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins  $user
	 * @param Student $ability
	 * @return bool
	 */
	public function destroy(Admins $user, Student $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}
}
