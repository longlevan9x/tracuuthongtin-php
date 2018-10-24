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

class CrawlController extends Controller
{
	protected $crawl;

	public function __construct(Crawl $crawl) {
		$this->crawl = $crawl;
	}

	/**
	 * get student with a msv
	 * return a student
	 * @param $msv
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlStudent($msv) {
		return $this->crawl->crawlStudent($msv);
	}


	/**
	 * get student with code of course
	 * return list student
	 * @param $code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlStudentCourse($code) {
		return $this->crawl->crawlStudentCourse($code);
	}

	/**
	 * get schedule with msv
	 * return information schedule of a student
	 * @param $msv
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlSchedule($msv) {
		return $this->crawl->crawlSchedule($msv);
	}

	/**
	 * get schedule with code of course
	 * return list student & schedule of student
	 * @param $code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleCourse($code) {
		return $this->crawl->crawlScheduleCourse($code);
	}

	/**
	 * get schedule exam with msv
	 * return information schedule exam of a student
	 * @param $msv
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleExam($msv) {
		return $this->crawl->crawlScheduleExam($msv);
	}

	/**
	 * get schedule exam with code of course
	 * return list student & schedule exam of student
	 * @param $code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleExamCourse($code) {
		return $this->crawl->crawlScheduleExamCourse($code);
	}

	/**
	 * get list semester
	 */
	public function crawlSemester() {
		return $this->crawl->crawlSemester();
	}
}