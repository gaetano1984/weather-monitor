<?php 

	namespace App\Services;

	use App\Model\Weather;
	use App\Repositories\WeatherRepository;

	class WeatherService{
		public $weatherRepository;
		public function __construct(WeatherRepository $weatherRepository){
			$this->weatherRepository = $weatherRepository;
		}
		public function saveStats($temp_f, $temp_c, $humidity){
			$weather = new Weather();
			$weather->temp_f = $temp_f;
			$weather->temp_c = $temp_c;
			$weather->humidity = $humidity;
			$weather->save();
		}
		public function hourly(){
			$stats = $this->weatherRepository->hourly();
			return $stats;
		}
		public function daily(){
			$stats = $this->weatherRepository->daily();
			return $stats;
		}
		public function monthly(){
			$stats = $this->weatherRepository->monthly();
			return $stats;
		}
		public function weekly(){
			$stats = $this->weatherRepository->weekly();
			return $stats;
		}

	}

 ?>