<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 07/29/2018
 * Time: 23:09
 */

namespace App\Http\Controllers\Menu;


use App\Commons\Facade\CUser;
use App\Models\Admins;
use Bouncer;
use Illuminate\Support\Facades\View;

class AdminMenu
{
	/**
	 * render menus in file Middleware\RedirectIfNotAdmin
	 * @return void
	 */
	public static function render() {
		View::share('menusAdmin', (new self)->menu());
	}

	/**
	 * @return array
	 */
	public static function getMenu() {
		return (new  self)->menu();
	}

	/**
	 * @return array
	 */
	public function menu() {
		$controller = request()->segment(2);
		$action     = request()->segment(3);
//dd(\Auth::user(),  can_index('post'),  Bouncer::can('contact'));
		return [
			/*Dashboard*/
			[
				'name'     => __("admin/menu.dashboard"),
				'url'      => url_admin('/'),
				'visible'  => true,
				'icon'     => 'fa-home',
				'children' => []
			],
			/*Dashboard*/
			/*Profile*/
			[
				'name'     => __("admin/menu.your_profile"),
				'url'      => url_admin('profile'),
				'visible'  => true,
				'icon'     => 'fa-user-circle-o',
				'children' => []
			],
			/*Profile*/
			/*Student*/
			[
				'name'     => __("abilities.student.name"),
				'url'      => '#',
				'visible'  => can_index('student'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('student'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('student/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*Student*/
			/*Area*/
			[
				'name'     => __("abilities.area.name"),
				'url'      => '#',
				'visible'  => can_index('area'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('area'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('area/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*Area*/
			/*School*/
			[
				'name'     => __("abilities.school.name"),
				'url'      => '#',
				'visible'  => can_index('school'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('school'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('school/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*School*/
			/*Department*/
			[
				'name'     => __("abilities.department.name"),
				'url'      => '#',
				'visible'  => can_index('department'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('department'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('department/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*Department*/
			/*Course*/
			[
				'name'     => __("abilities.course.name"),
				'url'      => '#',
				'visible'  => can_index('course'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('course'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('course/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*Course*/
			/*Semester*/
			[
				'name'     => __("abilities.semester.name"),
				'url'      => '#',
				'visible'  => can_index('semester'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('semester'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('semester/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*Semester*/
			/*Admin*/
			[
				'name'     => __("abilities.admin.name"),
				'url'      => '#',
				'visible'  => can_index('admin'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('admin'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('admin/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*Admin*/
			/*User*/
			[
				'name'     => __("abilities.user.name"),
				'url'      => '#',
				'visible'  => can_index('user'),
				'icon'     => 'fa-users',
				'children' => [
					[
						'name'    => __("admin/menu.list"),
						'url'     => url_admin('user'),
						'visible' => true,
						'icon'    => 'fa-user-circle',
					],
					[
						'name'    => __("admin/menu.add"),
						'url'     => url_admin('user/create'),
						'visible' => true,
						'icon'    => 'fa-plus',
					],
				]
			],
			/*User*/
			/*Website*/
			[
				'name'     => __("admin/menu.website"),
				'url'      => '#',
				'visible'  => true,
				'icon'     => 'fa-rss-square',
				'children' => [
					[
						'name'    => __("admin/menu.config"),
						'url'     => url_admin('website/config'),
						'visible' => Bouncer::can('website-config'),
						'icon'    => 'fa-home',
					],
					[
						'name'    => __("admin/menu.slide"),
						'url'     => url_admin('slide'),
						'visible' => can_index('slide'),
						'icon'    => 'fa-rss-square',
					],
					[
						'name'    => __("admin/menu.content message website"),
						'url'     => url_admin('website/message'),
						'visible' => false,
						'icon'    => 'fa-columns',
					],
					[
						'name'    => __("admin/menu.menu"),
						'url'     => url_admin('menu'),
						'visible' => can_index('menu'),
						'icon'    => 'fa-bars',
					],
					/*Comment*/
					[
						'name'    => __("repositories.menu.comment.name"),
						'url'     => url_admin('comment'),
						'visible' => can_index('comment'),
						'icon'    => 'fa-bars',
					]
					/*Comment*/
				]
			],
			/*Website*/
			/*Config*/
			[
				'name'     => __("admin/menu.config"),
				'url'      => '#',
				'visible'  => true,
				'icon'     => 'fa-cog',
				'children' => [
					/*Setting*/
					[
						'name'     => __("admin/menu.setting"),
						'url'      => url_admin('setting'),
						'visible'  => Bouncer::can('admin-setting'),
						'icon'     => 'fa-cog',
						'children' => []
					],
					/*Setting*/
					/*Role*/
					[
						'name'     => __("abilities.role.name"),
						'url'      => url_admin('role'),
						'visible'  => can_index('role'),
						'icon'     => 'fa-cog',
						'children' => []
					],
					/*Role*/
					/*Translation*/
					[
						'name'     => __("abilities.translation-manager"),
						'url'      => url('translation-manager'),
						'visible'  => can_index('role'),
						'icon'     => 'fa-cog',
						'children' => []
					],
					/*Translation*/
				]
			],


			/*Config*/
			/*Cache*/
			[
				'name'     => __("Refresh Cache"),
				'url'      => url_admin('refresh-cache'),
				'visible'  => true,
				'icon'     => 'fa-refresh',
				'children' => []
			],
			/*Cache*/
		];
	}
}