<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Facade\Student;
use App\Models\Facade\StudentSchedule;
use App\Models\Facade\StudentScheduleExam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyncController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function syncStudentScheduleByDepartment(Request $request) {
		StudentSchedule::syncStudentScheduleByDepartment($request->get('id_department'));
		return redirect('admin/sync');
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function syncStudentScheduleExamByDepartment(Request $request){
		StudentScheduleExam::syncStudentScheduleExamByDepartment($request->get('id_department'));
		return redirect('admin/sync');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public function syncInformationStudentByDepartment(Request $request) {
		Student::syncStudentByDepartment($request->get('id_department'));
		return redirect(url('admin/student'));
	}
}
