<?php

class DateTimeView {


	public function show() {
        date_default_timezone_set('Europe/Stockholm'); // CDT // CDT
        $timeString = $this->currentTime();
		return '<p>' . $timeString . '</p>';
	}
        //metod to create a string of current time
        private function currentTime(){
            $info = getdate();
            $date = date("jS");
            $day = $info['weekday'];
            $month = date("F");
            $year = date("o");
            $time = date("H:i:s");
            return "$day, the $date of $month $year, The time is $time";
        }
}