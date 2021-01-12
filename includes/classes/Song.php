<?php
    class Song {
        private $con;
        private $id;
        private $mysqliData;
        private $title;
        private $artistId;
        private $albumId;
        private $genre;
        private $duration;
        private $path;
        private $plays;
        private $image;
    
        public function __construct($con, $id) {
            $this->con = $con;
            $this->id = $id;
    
            $query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
            $this->mysqliData = mysqli_fetch_array($query);
            $this->title = $this->mysqliData['title'];
            $this->artistId = $this->mysqliData['artist'];
            $this->albumId = $this->mysqliData['album'];
            $this->genre = $this->mysqliData['genre'];
            $this->duration = $this->mysqliData['duration'];
            $this->path = $this->mysqliData['path'];
            $this->plays = $this->mysqliData['plays'];
            $this->image = $this->mysqliData['image'];
        }

        public function getId() {
            return $this->id;
        }

        public function getPlays() {
            return $this->plays;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getArtist() {
            return new Artist($this->con, $this->artistId);
        }

        public function getArtistId() {
            return $this->artistId;
        }

        public function getAlbumId() {
            return $this->albumId;
        }

        public function getAlbum() {
            return new Album($this->con, $this->albumId);
        }

        public function getPath() {
            return $this->path;
        }

        public function getImage() {
            return $this->image;
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getGenreName() {
            $query = mysqli_query($this->con, "SELECT * FROM genres WHERE id='$this->genre'");
            $row = mysqli_fetch_array($query);
            return $row['name'];
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getMysqliData() {
            return $this->mysqliData;
        }
    }
?>