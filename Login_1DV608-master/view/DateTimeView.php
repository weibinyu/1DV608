<?php

class DateTimeView {


	public function show() {
                date_default_timezone_set('America/Chicago'); // CDT
		$timeString = $this->currentTime();

		return '<p>' . $timeString . '</p>';
	}
        
        private function currentTime(){
            date_default_timezone_set('Europe/Stockholm'); // CDT
            $info = getdate();
            $date = date("jS",strtotime($info['mday']));
            $day = date("l",  strtotime($info['mday']));
            $month = date("F",strtotime($info['mon']));
            $year = $info['year'];
            $hour = $info['hours'];
            $min = $info['minutes'];
            $sec = $info['seconds'];

            return "$day,$date of $month $year, The time is $hour:$min:$sec";
        }
}