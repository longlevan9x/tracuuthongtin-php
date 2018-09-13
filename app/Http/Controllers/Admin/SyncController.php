<?php

namespace App\Http\Controllers\Admin;

use App\Models\Facade\StudentScheduleFacade;
use App\Models\Facade\StudentScheduleExamFacade;
use Illuminate\Http\Request;

/**
 * Class SyncController
 * @package App\Http\Controllers\Admin
 */
class SyncController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin.sync.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function syncStudentScheduleByDepartment(Request $request) {
        StudentScheduleFacade::syncStudentScheduleByDepartment($request->get('id_department'));
        return redirect('admin/sync');
    }


    public function syncStudentScheduleExamByDepartment(Request $request){
        StudentScheduleExamFacade::syncStudentScheduleExamByDepartment($request->get('id_department'));
        return redirect('admin/sync');
    }
}
