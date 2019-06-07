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
     * @param bool $checkMsv
     * @param int $msv
     * @param string $method
     * @throws Exception
     */
    public function __construct($checkMsv = false, $msv = 0, $method = 'GET')
    {
        parent::__construct($checkMsv, $msv, $method);
        $this->crawler = $this->setRequest(); // lay form ve
    }

	/**
	 * @return mixed
	 */
	protected function prepare() {
		// TODO: Implement prepare() method.
        set_time_limit(0);

        $this->crawler->filter('#tblDetail')->filter('tr:nth-of-type(n+1)')->each(function ($node) {
            /** @var \Symfony\Component\DomCrawler\Crawler $node */
            $this->list[] = $node->html();
        });
        dd($this->list);
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
