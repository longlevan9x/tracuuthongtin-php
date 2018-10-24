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
use App\Models\Schedule;
use App\Models\ScheduleExam;
use App\Models\Semester;
use App\Models\Student;
use App\Models\CrawlHistory;
use App\Models\StudentSchedule;
use App\Models\StudentScheduleExam;

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
	 * @param $code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlStudentCourse($code) {
		$course = Course::whereCode($code)->first();
		if (isset($course) && !empty($course)) {
			$students = [];
			set_time_limit(0);

			$time = -microtime(true);

			$infoStudent = new ThongTinSinhVien;

			$msv           = $course->code;
			$total_student = $course->total_student;
			//            $total_student = 5;

			for ($index = 1; $index <= $total_student; $index++) {
				$infoStudent->msv = Helper::getMsv($msv, $index);
				$student_info     = $infoStudent->getThongTinSinhVien()->asArray();
				if (!empty($student_info)) {
					if ($student_info['co_so'] == 'Hà Nội') {
						$coso = 10;
					}
					else {
						$coso = 20;
					}

					$students[] = [
						'code'               => $infoStudent->msv,
						'name'               => $student_info['name'],
						'status'             => $student_info['trang_thai'],
						'gender'             => $student_info['gioi_tinh'],
						'day_admission'      => $student_info['ngay_vao_truong'],
						'department_id'      => $course->department->id,
						'course_id'          => $course->id,
						'area'               => $coso,
						'education_level'    => $student_info['bac_dao_tao'],
						'type_education'     => $student_info['loai_hinh_dao_tao'],
						'branch_group'       => $student_info['nganh'],
						'branch'             => $student_info['chuyen_nganh'],
						'class'              => $student_info['lop'],
						'average_cumulative' => $student_info['diem_tb_tich_luy'],
						'school_year'        => $student_info['nien_khoa'],
						'total_term'         => $student_info['tong_so_tc_tich_luy'],
						//'course'             => $student_info['khoa_hoc'],
						'created_at'         => date('Y-m-d H:i:s'),
						'updated_at'         => date('Y-m-d H:i:s')
					];
				}

			}

			Student::insertOnDuplicateKey($students);

			$time += microtime(true);

			$this->saveCrawlHistory(count($students), $time, 1);

			return responseJson("Crawl Success", [
				'student' => count($students),
				'time'    => $time
			]);
		}
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
		$students     = [];
		$time         = -microtime(true);

		if (!empty($student_info)) {
			if ($student_info['co_so'] == 'Hà Nội') {
				$coso = 10;
			}
			else {
				$coso = 20;
			}

			$students[] = [
				'code'               => $infoStudent->msv,
				'name'               => $student_info['name'],
				'status'             => $student_info['trang_thai'],
				'gender'             => $student_info['gioi_tinh'],
				'day_admission'      => $student_info['ngay_vao_truong'],
				'department_id'      => $course->department->id,
				'course_id'          => $course->id,
				'area'               => $coso,
				'education_level'    => $student_info['bac_dao_tao'],
				'type_education'     => $student_info['loai_hinh_dao_tao'],
				'branch_group'       => $student_info['nganh'],
				'branch'             => $student_info['chuyen_nganh'],
				'class'              => $student_info['lop'],
				'average_cumulative' => $student_info['diem_tb_tich_luy'],
				'school_year'        => $student_info['nien_khoa'],
				'total_term'         => $student_info['tong_so_tc_tich_luy'],
				//'course'             => $student_info['khoa_hoc'],
				'created_at'         => date('Y-m-d H:i:s'),
				'updated_at'         => date('Y-m-d H:i:s')
			];
		}

		$time += microtime(true);

		Student::insertOnDuplicateKey($students);
		$this->saveCrawlHistory(count($students), $time, 1);

		return responseJson("Crawl Success", [
			'student' => count($students),
			'time'    => $time
		]);
	}

	/**
	 * @throws \Exception
	 */
	public function crawlSemester() {
		$lichHoc = new LichHoc(false, 1);
		$dotList = $lichHoc->getDot()->getDotList();
		$data    = [];
		$time    = -microtime(true);
		foreach ($dotList as $index => $item) {
			$data[] = [
				'name'       => $item,
				'is_active'  => CConstant::STATE_ACTIVE,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
		}

		Semester::insertOnDuplicateKey($data);

		$time += microtime(true);

		$this->saveCrawlHistory(count($data), $time, 1);

		return responseJson("Crawl Success", [
			'semester' => count($data),
			'time'     => $time
		]);
	}

	/**
	 * @param $code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleCourse($code) {
		$course = Course::whereCode($code)->first();
		$name   = "schedule-course/$code";
		if (isset($course) && !empty($course)) {
			set_time_limit(0);
			$schedules = [];
			$time      = -microtime(true);

			$lichHoc       = new LichHoc;
			$msv           = $course->code;
			$total_student = $course->total_student;
			//$total_student       = 3;
			$studentScheduleList = [];
			$msvList             = [];
			for ($index = 1; $index <= $total_student; $index++) {
				$lichHoc->msv = Helper::getMsv($msv, $index);
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

			$this->saveCrawlHistory(count($schedules), $time, 1);

			return responseJson("Crawl Success", [
				'schedule'         => count($schedules),
				'student_schedule' => count($studentScheduleList),
				'time'             => $time
			]);
		}
		$this->saveCrawlHistory();

		return responseJson("Crawl Fail", 'Code Not Found');
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

		return responseJson("Crawl Success", [
			'schedule'         => count($schedules),
			'student_schedule' => count($studentScheduleList),
			'time'             => $time
		]);
	}

	/**
	 * @param $code
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function crawlScheduleExamCourse($code) {
		$course = Course::whereCode($code)->first();
		if (isset($course) && !empty($course)) {
			set_time_limit(0);
			$scheduleExams = [];
			$time          = -microtime(true);

			$lichThi       = new LichThi;
			$msv           = $course->code;
			$total_student = $course->total_student;
			//            $total_student = 200;

			$studentScheduleExamList = [];
			for ($index = 1; $index <= $total_student; $index++) {
				$lichThi->msv  = Helper::getMsv($msv, $index);
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
			$time += microtime(true);

			ScheduleExam::insertOnDuplicateKey(array_values($scheduleExams));
			StudentScheduleExam::insertOnDuplicateKey($studentScheduleExamList);
			$this->saveCrawlHistory(count($scheduleExams), $time, 1);

			return responseJson("Crawl Success", [
				'schedule'              => count($scheduleExams),
				'student_schedule_exam' => count($studentScheduleExamList),
				'time'                  => $time
			]);
		}
		$this->saveCrawlHistory();

		return responseJson("Crawl Fail", 'Code Not Found');
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
		$this->saveCrawlHistory($scheduleExams, $time, 1);

		return responseJson("Crawl Success", [
			'schedule'              => count($scheduleExams),
			'student_schedule_exam' => count($studentScheduleExamList),
			'time'                  => $time
		]);
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