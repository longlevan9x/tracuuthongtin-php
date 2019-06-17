<?php

namespace App\Policies;

use App\Models\Admins;
use App\Models\Area;

class AreaPolicy extends AbstractPolicy
{
	/**
	 * @param Admins $user
	 * @param Area   $ability
	 * @return bool
	 */
	public function index(Admins $user, Area $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param Area   $ability
	 * @return bool
	 */
	public function create(Admins $user, Area $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param Area   $ability
	 * @return bool
	 */
	public function edit(Admins $user, Area $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}

	/**
	 * @param Admins $user
	 * @param Area   $ability
	 * @return bool
	 */
	public function destroy(Admins $user, Area $ability) {
		if (!$this->checkAbility($user, __FUNCTION__, $ability)) {
			return false;
		}

		return true;
	}
}
