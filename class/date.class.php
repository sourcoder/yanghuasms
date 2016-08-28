<?php
class date {
	private $today_sta;
	private $today_end;
	private $month_sta;
	private $month_end;
	const MY_DS = "return array(0,31,28,31,30,31,30,31,31,30,31,30,31);";
	static function getArray() {
		return eval(date::MY_DS);
	}
	function __construct($timestamp) {
		$year = date("Y", $timestamp);
		$month = date("m", $timestamp);
		$day = date("d", $timestamp);
		$this->today_sta = $year . "-" . $month . "-" . $day . " 00:00:00";
		$this->today_end = $year . "-" . $month . "-" . $day . " 23:59:59";
		$data = date::getArray();
		$dayend = $data[intval($month)];
		if (intval($month) == 2) {
			if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
				$dayend = 29;
			}
		}
		$this->month_sta = $year . "-" . $month . "-01 00:00:00";
		$this->month_end = $year . "-" . $month . "-" . $dayend . " 23:59:59";
	}
	public function getTodayStart() {
		return $this->today_sta;
	}
	public function getTodayEnd() {
		return $this->today_end;
	}
	public function getMonthStart() {
		return $this->month_sta;
	}
	public function getMonthEnd() {
		return $this->month_end;
	}
}
?>