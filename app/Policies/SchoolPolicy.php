<?php

namespace App\Policies;

use App\Models\Admins;
use App\Models\School;

class SchoolPolicy extends AbstractPolicy
{
	/**
	 * @param Admins $user
	 * @param School $ability
	 * @return bool
	 */
	public function index(Admins $user, School $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param School $ability
	 * @return bool
	 */
	public function create(Admins $user, School $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param School $ability
	 * @return bool
	 */
	public function edit(Admins $user, School $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param School $ability
	 * @return bool
	 */
	public function destroy(Admins $user, School $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}
}
