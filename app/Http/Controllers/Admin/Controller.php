<?php

namespace App\Http\Controllers\Admin;

use App\Commons\Facade\CFile;
use App\Commons\Facade\CUser;
use App\Models\Admins;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Traits\ModelMethodTrait;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\ModelUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;


/**
 * Class Controller
 * @package App\Http\Controllers\Admin
 */
class Controller extends \App\Http\Controllers\Controller
{
	/**
	 * @var
	 */
	public $model;
	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	protected $user = null;
	/**
	 * @var \App\Commons\CUser|null
	 */
	protected $cUser = null;
	/**
	 * @var array
	 */
	protected $role       = [Admins::ROLE_ALL];
	protected $roleExcept = 0;

	/**
	 * Controller constructor.
	 */
	public function __construct() {
		$this->cUser = new \App\Commons\CUser;
		$this->middleware(function($request, $next) {
			$this->user = Auth::user();
			$this->cUser->setUser($this->user);
			$this->role($this->getRole(), $this->getRoleExcept());

			return $next($request);
		});

	}

	/**
	 * @param string|int|array $role
	 * @param string           $roleExcept
	 * @return void
	 */
	public function role($role = Admins::ROLE_ALL, $roleExcept = '') {
		if (!$this->cUser->checkRole($role, $roleExcept)) {
			throw new HttpException(401, "You do not have permission to access this url.");
		}
	}

	/**
	 * @return void
	 */
	protected function checkRole() {
		$this->role($this->getRole(), $this->getRoleExcept());
	}

	/**
	 * @return mixed
	 */
	public function getRole() {
		return $this->role;
	}

	public function setRole($role) {
		$this->role = $role;
	}

	/**
	 * @return string|array
	 */
	public function getRoleExcept() {
		return $this->roleExcept;
	}

	/**
	 * @param string|array $roleExcept
	 */
	public function setRoleExcept($roleExcept) {
		$this->roleExcept = $roleExcept;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function bulkDeleteAjax(Request $request) {
		$table = $request->table;
		$ids   = $request->ids;
		if (is_string($ids)) {
			$ids = explode(',', $ids);
		}

		if (empty($table)) {
			return responseJson('fail', 'table ' . __('admin/common.not found'));
		}

		if (empty($ids)) {
			return responseJson('fail', 'id ' . __('admin/common.not found'));
		}

		if (DB::table($table)->whereIn('id', $ids)->delete() > 0) {
			return responseJson('success');
		}

		return responseJson('fail');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function bulkDelete(Request $request) {
		$table = $request->table;
		$ids   = $request->ids;

		if (is_string($ids)) {
			$ids = explode(',', $ids);
		}

		if (empty($table)) {
			return redirect()->back()->with('fail', 'table ' . __('admin/common.not found'));
		}

		if (empty($ids)) {
			return redirect()->back()->with('fail', 'id ' . __('admin/common.not found'));
		}
		/** @var Model|ModelMethodTrait $model */
		$model = new $table;
		$model::whereIn('id', $ids)->get()->each(function($item, $index) {
			/** @var Model|ModelUploadTrait $item */
			if (key_exists('path', $item->getAttributes()) && !empty($item->path)) {
				$path = $item->path;
			}
			else {
				$path = $item->getTable();
			}
			$files = $item->getKeyImageUpload();
			foreach ($files as $k_f => $file) {
				CFile::removeFile($path, $item->{$file});
			}
		});

		if ($model::whereIn('id', $ids)->delete() > 0) {
			return redirect()->back()->with('success', __('message.delete success'));
		}

		return redirect()->back()->with('fail', __('message.delete fail'));
	}

	public function bulk(Request $request) {
		$table = $request->table;
		$key   = $request->key;
		$value = $request->value;
		$ids   = $request->ids;

		if (is_string($ids)) {
			$ids = explode(',', $ids);
		}

		if (empty($table)) {
			return redirect()->back()->with('fail', 'table ' . __('admin/common.not found'));
		}

		if (empty($ids)) {
			return redirect()->back()->with('fail', 'id ' . __('admin/common.not found'));
		}
		/** @var Model|ModelMethodTrait $model */
		$model = new $table;

		if ($model::whereIn('id', $ids)->update([$key => $value]) > 0) {
			return redirect()->back()->with('success', __('message.update success'));
		}

		return redirect()->back()->with('fail', __('message.update fail'));
	}

	/**
	 * phuong thuc dung de dieu huong va tra ve message
	 * $message co the truyen vao la 1 object Model hoac 1 mang message cua success va error
	 * neu message la mang success va error
	 * @param              $to
	 * @param bool         $check
	 * param message can is Model or messages
	 * @param array|object $message
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	protected function redirectWithMessage($to = null, $check = false, ...$message) {
		$current_method = $this->getCurrentMethod();
		$current_method = in_array($current_method, ['store', 'update', 'destroy']) ? __('admin.' . $current_method) : $current_method;
		if ($check) {
			$mess = ($message[0][0] ?? $current_method);
			$type = 'success';
		}
		else {
			$mess = ($message[0][1] ?? $current_method);
			$type = 'error';
		}

		return redirect($to, 302, [], null)->with($type, $mess);
	}

	protected function redirectWithModel($to = null, $check = false, $model = null) {
		$obj = $model;

		$text = '';
		if ($obj instanceof Model) {
			/** @var ModelTrait $obj */
			$text = $obj->{$obj->fieldSlugable()} ?? '';
		}

		$current_method = $this->getCurrentMethod();
		$current_method = in_array($current_method, ['store', 'update', 'destroy']) ? __('admin.' . $current_method) : $current_method;
		if ($check) {
			$mess = $current_method . " " . $text;
			$type = 'success';
		}
		else {
			$mess = $current_method . " " . $text;
			$type = 'error';
		}

		return redirect($to, 302, [], null)->with($type, $mess);
	}
}
