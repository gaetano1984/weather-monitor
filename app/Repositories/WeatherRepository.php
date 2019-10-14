<?php 
	
	namespace App\Repositories;

	use App\Model\Weather;

	class WeatherRepository{
		public $model;

		public $weather;

		public function __construct(Weather $weather){
			$this->weather = $weather;
		}

		public function getQueryBase($s){
			$date_format = $this->formatData($s);
			$q = Weather::select([
				$date_format
				,\DB::RAW('min(temp_c)')
				,\DB::RAW('cast(avg(temp_c) as decimal(6,2))')
				,\DB::RAW('max(temp_c)')
				,\DB::RAW('min(humidity)')
				,\DB::RAW('cast(avg(humidity) as decimal(6,2))')
				,\DB::RAW('max(humidity)')
			]);
			return $q;
		}

		public function formatData($s){
			$date_format;
			switch($s){
				case 'h':
					$date_format = 'date_format(created_at, "%Y-%m-%d %H:00")';
				break;
				case 'd':
					$date_format = 'date_format(created_at, "%Y-%m-%d")';
				break;
				case 'w':
					$date_format = 'weekofyear(created_at)';
				break;
				case 'm':
					$date_format = 'date_format(created_at, "%Y-%m")';
				break;
			}
			$date_format = \DB::RAW($date_format);
			return $date_format;
		}

		public function buildQuery($s){
			$q = $this->getQueryBase($s)->groupBy($this->formatData($s))->get()->toArray();
			return $q;
		}

		public function hourly(){
			$stats = $this->buildQuery('h');
			return $stats;			
		}

		public function daily(){
			$stats = $this->buildQuery('d');
			return $stats;			
		}

		public function monthly(){
			$stats = $this->buildQuery('m');
			return $stats;			
		}

		public function weekly(){
			$stats = $this->buildQuery('w');
			return $stats;
		}
	}

 ?>