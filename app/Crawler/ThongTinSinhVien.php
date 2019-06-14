<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 4/27/2018
 * Time: 9:15 PM
 */

namespace App\Crawler;


use function foo\func;

class ThongTinSinhVien extends Crawler
{
	public static $xem_dem_url = '';

	/**
	 * ThongTinSinhVien constructor.
	 * @param bool   $checkMsv
	 * @param int    $msv
	 * @param string $method
	 * @throws \Exception
	 */
	public function __construct($checkMsv = false, $msv = 0, $method = 'GET') {
		parent::__construct($checkMsv, $msv, $method);
		$this->crawler = $this->setRequest(); // lay form ve
	}

	protected function prepare() {
		if($this->crawler->count() == 0) {
			return $this->list = [];
		}
		if(!$this->checkTrangThai()) {
			return $this->list = [];
		}

        $name = trim($this->crawler->filter('.title-group')->text());
        $name = str_replace('BẢNG KẾT QUẢ HỌC TẬP', '', $name);
        $name = trim($name);
        $studentInfo = [];
		// TODO: Implement prepare() method.
        $this->crawler->filter('.body-group')->filter('table')->filter('tr')->each(function($node) use (&$studentInfo){

			/** @var \Symfony\Component\DomCrawler\Crawler $node */
            $arr_1 = explode(":", trim($node->filter('td')->text())); // chuyen chuoi ve mang theo dau ':'
            if($arr_1[0] == 'Khóa') {
                $arr_1[0] = 'khoa_hoc';
            }
            $key1 = vn2latin(trim($arr_1[0]), '_');
            $studentInfo[$key1] = isset($arr_1[1]) ? trim($arr_1[1]) : '';

            $arr_2 = explode(":", trim($node->filter('td:last-child')->text()));
            if (vn2latin(trim($arr_1[0]), '_') == "co_van_hoc_tap") {
                $key2 = "sdt_co_van_hoc_tap";
            }
            else {
                $key2 = vn2latin(trim($arr_2[0]), '_');
            }

            $studentInfo[$key2] = isset($arr_2[1]) ? trim($arr_2[1]) : '';
		});

		$tong_so_tc_tich_luy = $this->crawler->filter('#ctl00_ContentPlaceHolder_ucThongTinTotNghiepTinChi1_lblTongTinChi')->text();
		$diem_tb_tich_luy = $this->crawler->filter('#ctl00_ContentPlaceHolder_ucThongTinTotNghiepTinChi1_lblTBCTL')->text();

        $gpa    = $diem_tb_tich_luy;
        $gpa    = str_replace(' ', '', $gpa);
        $gpas   = explode('-', $gpa);
        $gpa_10 = $gpas[0] ?? 0;
        $gpa_4  = $gpas[1] ?? 0;

        if ($studentInfo['co_so'] == 'Hà Nội') {
            $coso = 10;
        }
        else {
            $coso = 20;
        }

        $this->list['code'] = $this->msv;
        $this->list['name'] = $name;
        $this->list['status'] = $studentInfo['trang_thai'];
        $this->list['gender'] = $studentInfo['gioi_tinh'];
        $this->list['day_admission'] = $studentInfo['ngay_vao_truong'];
        $this->list['area'] = $coso;
        $this->list['education_level'] = $studentInfo['bac_dao_tao'];
        $this->list['type_education'] = $studentInfo['loai_hinh_dao_tao'];
        $this->list['branch_group'] = $studentInfo['nganh'];
        $this->list['branch'] = $studentInfo['chuyen_nganh'];
        $this->list['class'] = $studentInfo['lop'];
        $this->list['teacher_lead'] = $studentInfo['gvcn'];
        $this->list['phone_teacher_lead'] = $studentInfo['so_dt'];
        $this->list['teacher_counselor'] = $studentInfo['co_van_hoc_tap'];
        $this->list['phone_teacher_counselor'] = $studentInfo['sdt_co_van_hoc_tap'];
        $this->list['education_time'] = $studentInfo['thoi_gian_dao_tao'];
        $this->list['gpa_10'] = $gpa_10;
        $this->list['gpa_4'] = $gpa_4;
        $this->list['school_year'] = $studentInfo['nien_khoa'];
        $this->list['total_term'] = $tong_so_tc_tich_luy;
        $this->list['is_active'] = 1;
        $this->list['created_at'] = date('Y-m-d H:i:s');
        $this->list['updated_at'] = date('Y-m-d H:i:s');
	}

	/**
	 * @return $this
	 */
	public function getThongTinSinhVien() {
		$this->setRequest();
		$this->crawler = $this->crawler->filter('.main-content');

		return $this;
	}

	public function getMarkStudent() {
        $mark_list = [];
        $semester = '';
        $this->crawler->filter('.tblKetQuaHocTap')->first()->filter('tr:nth-of-type(n+3)')->each(function ($tr_node) use ($mark_list, &$semester) {
            /** @var \Symfony\Component\DomCrawler\Crawler $tr_node */
            /** @var \Symfony\Component\DomCrawler\Crawler $td_node */
            $td_node = $tr_node->filter('td');

            $total_td = $td_node->count();

            $tableThucHanh = $tr_node->filter('.tableThucHanh');

            if ($total_td == 25) {
                // truong hop lay duoc hoc ky
                $position_start = 1;
                $semester = trim($td_node->getNode(1)->textContent);
            }
            else {
                // truong hop ko kay duoc hoc ky
                $position_start = 0;
            }
            \Log::info($total_td);
            \Log::info($position_start);
//            dd($td_node->getNode(3)->textContent);
            $mark['student_code'] = $this->msv;
            $mark['semester'] = $semester;
            $mark['name_subject'] = trim($td_node->getNode($position_start + 1)->textContent);
            $mark['code_class'] = trim($td_node->getNode($position_start + 2)->textContent);
            $mark['credit'] = trim($td_node->getNode($position_start + 3)->textContent);
            $mark['mark_training'] = trim($td_node->getNode($position_start + 4)->textContent);

            if ($tableThucHanh->count() == 1) {
                $tr_node_tbth = $tableThucHanh->filter('tr')->last();
                if ($tr_node_tbth->count() > 0) {
                    $mark_practice_list = [];
                    $tr_node_tbth->filter('td')->each(function ($td_node) use (&$mark_practice_list) {
                        /** @var \Symfony\Component\DomCrawler\Crawler $td_node */
                        $mark_practice_list[] = trim($td_node->text());
                    });

                    $mark['mark_practice'] = json_encode($mark_practice_list, JSON_NUMERIC_CHECK);
                }
            }
            else {
                $coefficient1 = [
                    trim($td_node->getNode($position_start + 5)->textContent),
                    trim($td_node->getNode($position_start + 6)->textContent),
                    trim($td_node->getNode($position_start + 7)->textContent),
                    trim($td_node->getNode($position_start + 8)->textContent),
                    trim($td_node->getNode($position_start + 9)->textContent),
                    trim($td_node->getNode($position_start + 10)->textContent),
                ];
                $coefficient2 = [
                    trim($td_node->getNode($position_start + 11)->textContent),
                    trim($td_node->getNode($position_start + 12)->textContent),
                    trim($td_node->getNode($position_start + 13)->textContent),
                    trim($td_node->getNode($position_start + 14)->textContent),
                    trim($td_node->getNode($position_start + 15)->textContent),
                    trim($td_node->getNode($position_start + 16)->textContent),
                ];
                $mark['coefficient1'] = json_encode($coefficient1, JSON_NUMERIC_CHECK);
                $mark['coefficient2'] = json_encode($coefficient2, JSON_NUMERIC_CHECK);
            }

            $mark['mark_average_subject'] = trim($td_node->getNode($position_start + 17)->textContent);
            if ($total_td == 20) {
                $note = trim($td_node->getNode($position_start + 18)->textContent);
            }
            else {
                $mark['mark_exam'] = trim($td_node->getNode($position_start + 18)->textContent);
                $mark['mark_average'] = trim($td_node->getNode($position_start + 19)->textContent);
                $mark['mark_exam2'] = trim($td_node->getNode($position_start + 20)->textContent);
                $mark['exam_foul'] = trim($td_node->getNode($position_start + 21)->textContent);
                $mark['degree'] = trim($td_node->getNode($position_start + 22)->textContent);
                $note = trim($td_node->getNode($position_start + 23)->textContent);
            }
            $mark['note'] = $note;
            \Log::info($mark);
            $mark_list[] = $mark;
        });
        dd($mark_list);
        return $mark_list;
    }

	public function checkTrangThai() {
		$text = $this->crawler->filter('.main-content')->filter('.body-group')->filter('table')->text();
		if(strpos($text, 'Bảo lưu') > 0 || strpos($text, 'Đình chỉ') > 0 || strpos($text, 'Thôi học') > 0 || strpos($text, 'Đã tốt nghiệp') > 0) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return self::$base_url . 'XemDiem.aspx?MSSV=';
	}

	/**
	 * @param string $url
	 * @return Crawler
	 */
	public function setUrl($url) {
		$this->url = $url;

		return $this;
	}
}
