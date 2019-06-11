<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 5/28/2018
 * Time: 11:12 PM
 */

namespace App\Crawler;


use Exception;

class CongNo extends Crawler
{
	/**
	 * LichHoc constructor.
	 * @param bool   $checkMsv
	 * @param int    $msv
	 * @param string $method
	 * @throws Exception
	 */
	public function __construct($checkMsv = false, $msv = 0, $method = 'GET') {
		parent::__construct($checkMsv, $msv, $method);
		$this->crawler = $this->setRequest(); // lay form ve
	}

	/**
	 * @return mixed
	 */
	protected function prepare() {
		// TODO: Implement prepare() method.
        $this->setRequest();
		set_time_limit(0);
		$tr_node       = $this->crawler->filter('#tblDetail')->filter('tr:nth-of-type(n+2)');
		$total_tr_node = $tr_node->count();
		if ($total_tr_node > 0) {
			$tr_node->each(function($crawler, $index) use ($total_tr_node) {
				/** @var \Symfony\Component\DomCrawler\Crawler $crawler */
				/** @var \Symfony\Component\DomCrawler\Crawler $td_node */
				$td_node = $crawler->filter('td');

				if ($index < $total_tr_node - 1) {

					$this->list[] = [
						'student_code' => $this->msv,
						'number'       => $total_tr_node - $index - 1,
						'code_money'   => trim($td_node->getNode(1)->textContent),
						'content'      => trim($td_node->getNode(2)->textContent),
						'credit'       => trim($td_node->getNode(3)->textContent),
						'money'        => trim($td_node->getNode(4)->textContent),
						'money_paid'   => trim($td_node->getNode(5)->textContent),
						'money_deduct' => trim($td_node->getNode(6)->textContent),
						'money_pay'    => trim($td_node->getNode(7)->textContent),
						'status'       => trim($td_node->getNode(8)->textContent),
						'created_at'         => date('Y-m-d H:i:s'),
						'updated_at'         => date('Y-m-d H:i:s')
					];
				}
			});
		}
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return self::$base_url . 'CongNoSinhVien.aspx?MSSV=';
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
