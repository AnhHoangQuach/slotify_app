<?php
    class Album {
        private $con;
        private $id;
        private $title;
        private $artistId;
        private $genre;
        private $artworkPath;

        public function __construct($con, $id) {
            $this->con = $con;
            $this->id = $id;

            $query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
            $album = mysqli_fetch_array($query);

            $this->title = $album['title'];
            $this->artistId = $album['artist'];
            $this->genre = $album['genre'];
            $this->artworkPath = $album['artworkPath'];
        }

        public function getId() {
            return $this->id;
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

        public function getGenre() {
            return $this->genre;
        }

        public function getGenreName() {
            $query = mysqli_query($this->con, "SELECT * FROM genres WHERE id='$this->genre'");
            $row = mysqli_fetch_array($query);
            return $row['name'];
        }

        public function getArtworkPath() {
            return $this->artworkPath;
        }

        public function getNumberOfSongs() {
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id'");
            return mysqli_num_rows($query);
        }

        public function getSongIds() {
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY plays DESC");
            $array = array();

            while($row = mysqli_fetch_array($query)) {
                array_push($array, $row['id']);
            }

            return $array;
        }
    }
?>