<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 10/20/2018
 * Time: 21:54
 */

namespace App\Http\Controllers\Api\V1;

use App\Crawler\Crawl;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;

class CrawlController extends Controller
{
	protected $crawl;

	public function __construct(Crawl $crawl) {
		$this->crawl = $crawl;
	}

	/**
	 * get student with a msv
	 * return a student
	 * @param $student_code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlStudent($student_code) {
		return $this->crawl->crawlStudent($student_code);
	}


	/**
	 * get student with code of course
	 * return list student
	 * @param Request $request
	 * @param         $course_code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlStudentCourse(Request $request, $course_code) {
		return $this->crawl->crawlStudentCourse($course_code, $request->get('total_student', 0));
	}

	/**
	 * get schedule with msv
	 * return information schedule of a student
	 * @param $student_code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlSchedule($student_code) {
		return $this->crawl->crawlSchedule($student_code);
	}

	/**
	 * get schedule with code of course
	 * return list student & schedule of student
	 * @param Request $request
	 * @param         $course_code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleCourse(Request $request, $course_code) {
		return $this->crawl->crawlScheduleCourse($course_code, $request->get('total_student', 0));
	}

	/**
	 * get schedule exam with msv
	 * return information schedule exam of a student
	 * @param $student_code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleExam($student_code) {
		return $this->crawl->crawlScheduleExam($student_code);
	}

	/**
	 * get schedule exam with code of course
	 * return list student & schedule exam of student
	 * @param Request $request
	 * @param         $course_code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleExamCourse(Request $request, $course_code) {
		return $this->crawl->crawlScheduleExamCourse($course_code, $request->get('total_student', 0));
	}

    /**
     * get list semester
     * @throws \Exception
     */
	public function crawlSemester() {
		return $this->crawl->crawlSemester();
	}

	/**
	 * @param $student_code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlMoneyPay($student_code) {
		return $this->crawl->crawlMoneyPay($student_code);
	}

    /**
     * @param $course_code
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function crawlMoneyPayCourse($course_code) {
		return $this->crawl->crawlMoneyPayCourse($course_code);
	}

    /**
     * @param $student_code
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function crawlMark($student_code) {
		return $this->crawl->crawlMark($student_code);
	}

    /**
     * @param $course_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function crawlMarkCourse($course_code) {
		return $this->crawl->crawlMarkCourse($course_code);
	}
}
