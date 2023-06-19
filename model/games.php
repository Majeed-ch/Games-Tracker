<?php
	class Games{

		private $id;
		private $title;
		private $release_date;
		private $platforms;
        private $cover;


		function __construct($id, $title, $release_date, $platforms, $cover){
			$this->setId($id);
			$this->setTitle($title);
			$this->setReleasedate($release_date);
			$this->setPlatforms($platforms);
            $this->setCover($cover);
			}		
		
		public function getTitle(){
			return $this->title;
		}
		
		public function setTitle($title){
			$this->title = $title;
		}
		
		public function getReleasedate(){
			return $this->release_date;
		}
		
		public function setReleasedate($release_date){
			$this->release_date = $release_date;
		}

		public function getPlatforms(){
			return $this->platforms;
		}

		public function setPlatforms($platforms){
			$this->platforms = $platforms;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

        private function setCover($cover)
        {
            $this->cover = $cover;
        }
        public function getCover(){
            return $this->cover;
        }

    }
?>