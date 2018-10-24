<?php

namespace App\Models;

use App\Commons\Facade\CFile;
use App\Commons\Facade\CUser;
use App\Models\Traits\ModelAuthTrait;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\ModelUploadTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class Admins
 *
 * @package App\Models
 * @property int                                                        $id
 * @property string                                                     $username
 * @property string                                                     $name
 * @property string                                                     $password
 * @property string                                                     $email
 * @property string                                                     $image
 * @property string                                                     $status
 * @property string                                                     $phone
 * @property string                                                     $address
 * @property string                                                     $overview
 * @property integer                                                    $role
 * @property integer                                                    $is_active
 * @property integer                                                    $is_online
 * @property integer                                                    $gender
 * @property mixed                                                      $last_login
 * @property mixed                                                      $last_logout
 * @property mixed                                                      $created_at
 * @property mixed                                                      $updated_at
 * @property int|null                                                   $author_id
 * @property string|null                                                $remember_token
 * @property-read Admins                                                $authorUpdated
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @method static Builder|Admins findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|Admins whereAddress($value)
 * @method static Builder|Admins whereAuthorId($value)
 * @method static Builder|Admins whereCreatedAt($value)
 * @method static Builder|Admins whereEmail($value)
 * @method static Builder|Admins whereGender($value)
 * @method static Builder|Admins whereId($value)
 * @method static Builder|Admins whereImage($value)
 * @method static Builder|Admins whereIsActive($value)
 * @method static Builder|Admins whereIsOnline($value)
 * @method static Builder|Admins whereLastLogin($value)
 * @method static Builder|Admins whereLastLogout($value)
 * @method static Builder|Admins whereName($value)
 * @method static Builder|Admins whereOverview($value)
 * @method static Builder|Admins wherePassword($value)
 * @method static Builder|Admins wherePhone($value)
 * @method static Builder|Admins whereRememberToken($value)
 * @method static Builder|Admins whereRole($value)
 * @method static Builder|Admins whereSlug($slug)
 * @method static Builder|Admins whereStatus($value)
 * @method static Builder|Admins whereUpdatedAt($value)
 * @method static Builder|Admins whereUsername($value)
 * @mixin \Eloquent
 * @method static Builder|Admins active($value = 1)
 * @method static Builder|Admins inActive()
 * @method static Builder|Admins orderBySortOrder()
 * @method static Builder|Admins orderBySortOrderDesc()
 * @method static Builder|Admins myPluck($column, $key = null, $title = '')
 */
class Admins extends Authenticatable
{
	use Notifiable;
	use ModelTrait;
	use ModelUploadTrait;
	use ModelAuthTrait;

	const ROLE_SUPER_ADMIN = 30;
	const ROLE_ADMIN       = 25;
	const ROLE_MANAGEMENT  = 20;
	const ROLE_AUTHOR      = 5;
	const ROLE_ALL         = "*";

	public static $roles = [
		25 => 'Administrator',
		20 => 'Management',
		/*10 => 'Staff',*/
		5  => 'Author'
	];

	public static function getCollectionRoles() {
		$roles = [0 => __('admin.select') . " " . __('admin/user.role')] + self::$roles;

		return new Collection($roles);
	}

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'author_id',
		'name',
		'email',
		'password',
		'username',
		'name',
		'password',
		'email',
		'image',
		'status',
		'phone',
		'address',
		'overview',
		'role',
		'is_active',
		'is_online',
		'gender',
		'last_login',
		'last_logout,'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	public function setAuthor_id() {
		return $this->author_id = CUser::userAdmin()->id;
	}

	public function getImagePath() {
		return CFile::getImageUrl($this->getTable(), $this->image, \App\Commons\CFile::DEFAULT_IMAGE_USER);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Model|null|object|static
	 */
	public function author() {
		return $this->hasOne(Admins::class, 'id', 'author_id')->first();
	}

	/**
	 * @return mixed|string
	 */
	public function getAuthorName() {
		if (!$this->getAuthor()) {
			return "";
		}

		return $this->getAuthor()->name;
	}

	public function getAuthorUsername() {
		if (!$this->getAuthor()) {
			return "";
		}

		return $this->getAuthor()->username;
	}

	/**
	 * @return Admins|bool|\Illuminate\Database\Eloquent\Model|null|object
	 */
	public function getAuthor() {
		$author = $this->author();
		if (isset($author) && !empty($author)) {
			return $author;
		}

		return false;
	}

	/**
	 * @return mixed
	 */
	public function getRoleText() {
		return self::$roles[$this->role];
	}

	public function getGenderLabel() {
		if ($this->gender == 1) {
			return view('admin.layouts.widget.labels.success', ['text' => __('admin.male')]);
		}

		return view('admin.layouts.widget.labels.info', ['text' => __('admin.female')]);
	}
}
