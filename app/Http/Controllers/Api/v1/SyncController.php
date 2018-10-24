<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Facade\StudentFacade;
use App\Models\Facade\StudentScheduleFacade;
use App\Models\Facade\StudentScheduleExamFacade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyncController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function syncStudentScheduleByDepartment(Request $request) {
		StudentScheduleFacade::syncStudentScheduleByDepartment($request->get('id_department'));
		return redirect('admin/sync');
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function syncStudentScheduleExamByDepartment(Request $request) {
		StudentScheduleExamFacade::syncStudentScheduleExamByDepartment($request->get('id_department'));
		return redirect('admin/sync');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public function syncInformationStudentByDepartment(Request $request) {
		StudentFacade::syncStudentByDepartment($request->get('id_department'));
		return redirect(url('admin/student'));
	}
}
