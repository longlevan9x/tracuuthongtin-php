<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 10/20/2018
 * Time: 22:18
 */

namespace App\Crawler;


use App\Commons\CConstant;
use App\Models\Course;
use App\Models\Mark;
use App\Models\MoneyPay;
use App\Models\Schedule;
use App\Models\ScheduleExam;
use App\Models\Semester;
use App\Models\Student;
use App\Models\CrawlHistory;
use App\Models\StudentSchedule;
use App\Models\StudentScheduleExam;
use Log;

set_time_limit(0);

/**
 * Class Crawl
 * @package App\Crawler
 */
class Crawl
{
	private $link_api = '';

	public function __construct() {
		$this->setLinkApi(request()->url());
	}

	/**
	 * @param $course_code
	 * @param $total_student
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlStudentCourse($course_code, $total_student) {
		if ($total_student == 0) {
			$course        = Course::whereCode($course_code)->first();
			$total_student = $course->total_student;
			$course_code   = $course->code;
		}

		$students = [];
		set_time_limit(0);

		$time = -microtime(true);

		$infoStudent = new ThongTinSinhVien;
		$mark_student_list = [];
		for ($index = 1; $index <= $total_student; $index++) {
			$infoStudent->msv = Helper::getMsv($course_code, $index);
			$student_info     = $infoStudent->getThongTinSinhVien()->asArray();
			if (!empty($student_info)) {
                $mark_student = $infoStudent->getMarkStudent();
                $student_info['department_id'] = isset($course, $course->department) ? $course->department->id : 0;
                $student_info['course_id']     = isset($course) ? $course->id : 0;

				$students[] = $student_info;
                $mark_student_list = array_merge($mark_student_list, $mark_student);
			}
		}
		Log::info("log", $students);

		Student::insertOnDuplicateKey($students);
        Mark::insertOnDuplicateKey($mark_student_list);
		$time += microtime(true);

		Log::info("crawlScheduleCourse", [count($students), $time]);

		return responseJson(config("api_response.http_code.200"), [
			'student' => count($students),
			'marks' => count($mark_student_list),
			'time'    => $time
		]);
	}

	/**
	 * @param $msv
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlStudent($msv) {
		$infoStudent  = new ThongTinSinhVien(true, $msv);
		$student_info = $infoStudent->getThongTinSinhVien()->asArray();
		$code         = substr($msv, 0, 6);
		$course       = Course::whereCode($code)->first();

		$time         = -microtime(true);
		if (!empty($student_info)) {
            $mark_student = $infoStudent->getMarkStudent();
            $student_info['department_id'] = isset($course, $course->department) ? $course->department->id : 0;
            $student_info['course_id']     = isset($course) ? $course->id : 0;
			Student::insertOnDuplicateKey($student_info);
			if (!empty($mark_student)) {
			    Mark::insertOnDuplicateKey($mark_student);
            }
            $time += microtime(true);
			$this->saveCrawlHistory(count($student_info), $time, 1);

			return responseJson(config('api_response.http_code.200'), [
				'student' => count([$student_info]),
				'time'    => $time
			]);
		}
		else {
			return responseJson(config('api_response.message.fail'), null, config('api_response.status.error'));
		}


	}

	/**
	 * @throws \Exception
	 */
	public function crawlSemester() {
		$lichHoc = new LichHoc(false, 1);
		$dotList = $lichHoc->getDot()->getDotList();

		$data = [];
		$time = -microtime(true);
		foreach ($dotList as $index => $item) {
			$data[] = [
				'name'       => $item,
				'sort_order' => $index,
				'is_active'  => CConstant::STATE_ACTIVE,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
		}

		Semester::insertOnDuplicateKey($data);

		$time += microtime(true);

		$this->saveCrawlHistory(count($data), $time, 1);

		return responseJson(CConstant::STATUS_SUCCESS, [
			'semester' => count($data),
			'time'     => $time
		]);
	}

	/**
	 * @param $course_code
	 * @param $total_student
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleCourse($course_code, $total_student) {
		if ($total_student == 0) {
			$course        = Course::whereCode($course_code)->first();
			$total_student = $course->total_student;
			$course_code   = $course->code;
		}


		set_time_limit(0);
		$schedules = [];
		$time      = -microtime(true);

		$lichHoc = new LichHoc;
		//$total_student       = 3;
		$studentScheduleList = [];
		$msvList             = [];
		for ($index = 1; $index <= $total_student; $index++) {
			$lichHoc->msv = Helper::getMsv($course_code, $index);
			$msvList[]    = $lichHoc->msv;
			$schedule     = $lichHoc->getLichHoc()->asArray();
			$schedules    += $schedule;
			if (!empty($schedule)) {
				foreach ($schedule as $code => $item) {
					$studentScheduleList[] = [
						'student_code'  => $lichHoc->msv,
						'schedule_code' => $code,
						'created_at'    => date('Y-m-d H:i:s'),
						'updated_at'    => date('Y-m-d H:i:s')
					];
				}
			}
		}

		Schedule::insertOnDuplicateKey(array_values($schedules));
		StudentSchedule::insertOnDuplicateKey($studentScheduleList);

		$time += microtime(true);

		Log::info("crawlScheduleCourse", [count($schedules), $time]);

		return responseJson(config('api_response.http_code.200'), [
			'schedule'         => count($schedules),
			'student_schedule' => count($studentScheduleList),
			'time'             => $time
		]);
	}

	/**
	 * @param $msv
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlSchedule($msv) {
		$name = "schedule/$msv";
		set_time_limit(0);
		$schedules           = [];
		$studentScheduleList = [];
		$time                = -microtime(true);


		$lichHoc = new LichHoc;

		$lichHoc->msv = $msv;
		$schedule     = $lichHoc->getLichHoc()->asArray();
		$schedules    += $schedule;
		if (!empty($schedule)) {
			foreach ($schedule as $code => $item) {
				$studentScheduleList[] = [
					'student_code'  => $lichHoc->msv,
					'schedule_code' => $code,
					'created_at'    => date('Y-m-d H:i:s'),
					'updated_at'    => date('Y-m-d H:i:s')
				];
			}
		}

		Schedule::insertOnDuplicateKey(array_values($schedules));
		StudentSchedule::insertOnDuplicateKey($studentScheduleList);

		$time += microtime(true);

		$this->saveCrawlHistory(count($schedules), $time, 1);

		return responseJson(CConstant::STATUS_SUCCESS, [
			'schedule'         => count($schedules),
			'student_schedule' => count($studentScheduleList),
			'time'             => $time
		]);
	}

	/**
	 * @param $course_code
	 * @param $total_student
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleExamCourse($course_code, $total_student) {
		if ($total_student == 0) {
			$course        = Course::whereCode($course_code)->first();
			$total_student = $course->total_student;
			$course_code   = $course->code;
		}

		set_time_limit(0);
		$scheduleExams = [];
		$time          = -microtime(true);

		$lichThi = new LichThi;

		$studentScheduleExamList = [];
		for ($index = 1; $index <= $total_student; $index++) {
			$lichThi->msv  = Helper::getMsv($course_code, $index);
			$scheduleExam  = $lichThi->getLichThi('3 (2017 - 2018)')->asArray();
			$scheduleExams += $scheduleExam;

			if (!empty($scheduleExam)) {
				foreach ($scheduleExam as $code => $item) {
					$studentScheduleExamList[] = [
						'student_code'       => $lichThi->msv,
						'schedule_exam_code' => $code,
						'created_at'         => date('Y-m-d H:i:s'),
						'updated_at'         => date('Y-m-d H:i:s')
					];
				}
			}
		}

		ScheduleExam::insertOnDuplicateKey(array_values($scheduleExams));
		StudentScheduleExam::insertOnDuplicateKey($studentScheduleExamList);

		$time += microtime(true);

		Log::info("crawlScheduleExamCourse", [count($scheduleExams), $time]);

		return responseJson(config('api_response.http_code.200'), [
			'schedule'              => count($scheduleExams),
			'student_schedule_exam' => count($studentScheduleExamList),
			'time'                  => $time
		]);
	}

	/**
	 * @param $msv
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleExam($msv) {
		set_time_limit(0);
		$scheduleExams = [];

		$studentScheduleExamList = [];
		$time                    = -microtime(true);

		$lichThi = new LichThi;

		$lichThi->msv  = $msv;
		$scheduleExam  = $lichThi->getLichThi('3 (2017 - 2018)')->asArray();
		$scheduleExams += $scheduleExam;

		if (!empty($scheduleExam)) {
			foreach ($scheduleExam as $code => $item) {
				$studentScheduleExamList[] = [
					'student_code'       => $lichThi->msv,
					'schedule_exam_code' => $code,
					'created_at'         => date('Y-m-d H:i:s'),
					'updated_at'         => date('Y-m-d H:i:s')
				];
			}
		}
		$time += microtime(true);

		ScheduleExam::insertOnDuplicateKey(array_values($scheduleExams));
		StudentScheduleExam::insertOnDuplicateKey($studentScheduleExamList);
		$this->saveCrawlHistory(count($scheduleExams), $time, 1);

		return responseJson(CConstant::STATUS_SUCCESS, [
			'schedule'              => count($scheduleExams),
			'student_schedule_exam' => count($studentScheduleExamList),
			'time'                  => $time
		]);
	}

	/**
	 * @param $msv
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlMoneyPay($msv) {
		set_time_limit(0);
		$cong_no    = new CongNo(false, $msv);
		$time       = -microtime(true);
		$money_pays = $cong_no->asArray();
		$time       += microtime(true);
		if (!empty($money_pays)) {
			MoneyPay::insertOnDuplicateKey($money_pays);
			return responseJson(config('api_response.http_code.200'), [
				'total' => count($money_pays),
				'time'  => $time
			], config('api_response.status.success'));
		}

		return responseJson(config('api_response.message.error'), [
			'total' => 0
		], config('api_response.status.error'));
	}

	public function crawlMoneyPayCourse($course_code) {
		$course        = Course::whereCode($course_code)->first();
		$total_student = $course->total_student;

		set_time_limit(0);
		$cong_no    = new CongNo();
		$time       = -microtime(true);

		$time       += microtime(true);
		$moneyPayList = [];
		for ($index = 1; $index <= $total_student; $index++) {
			$cong_no->msv  = Helper::getMsv($course_code, $index);
			$money_pays = $cong_no->asArray();
			$moneyPayList += $money_pays;
		}

        if (!empty($moneyPayList)) {
            MoneyPay::insertOnDuplicateKey($moneyPayList);
            return responseJson(config('api_response.http_code.200'), [
                'total' => count($moneyPayList),
                'time'  => $time
            ], config('api_response.status.success'));
        }

        return responseJson(config('api_response.message.error'), [
            'total' => 0
        ], config('api_response.status.error'));
	}

	/**
	 * @param int       $total
	 * @param int|float $time
	 * @param int       $status
	 * @throws \Exception
	 */
	public function saveCrawlHistory($total = 0, $time = 0, $status = 0) {
		$crawlHistory               = new CrawlHistory;
		$crawlHistory->name         = $this->getLinkApi();
		$crawlHistory->type         = 'api';
		$crawlHistory->total_record = $total;
		$crawlHistory->time         = $time;
		$crawlHistory->status       = $status;
		$crawlHistory->save();
	}

	/**
	 * @return string
	 */
	public function getLinkApi(): string {
		return $this->link_api;
	}

	/**
	 * @param string $link_api
	 */
	public function setLinkApi(string $link_api): void {
		$this->link_api = $link_api;
	}
}
