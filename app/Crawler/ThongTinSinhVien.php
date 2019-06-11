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
            $arr = explode(":", trim($node->filter('td')->text())); // chuyen chuoi ve mang theo dau ':'
            if($arr[0] == 'Khóa') {
                $arr[0] = 'khoa_hoc';
            }
            $studentInfo[vn2latin(trim($arr[0]), '_')] = isset($arr[1]) ? trim($arr[1]) : '';
            $arr = explode(":", trim($node->filter('td:last-child')->text()));
            $studentInfo[vn2latin(trim($arr[0]), '_')] = isset($arr[1]) ? trim($arr[1]) : '';
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
