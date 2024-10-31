<?php
// Menggunakan Namespace
namespace LibrarySystem;

// Trait untuk fitur tambahan
trait CanBorrow {
    public function borrow() {
        return "The book has been borrowed.";
    }
}

// Abstract Class yang mendefinisikan struktur umum untuk semua buku
abstract class Book {
    protected $title;
    protected $author;

    public function __construct($title, $author) {
        $this->title = $title;
        $this->author = $author;
    }

    abstract public function getDescription();
}

// Class Fiction yang mewarisi dari Book dan menggunakan trait CanBorrow
class Fiction extends Book {
    use CanBorrow;

    private $genre;

    public function __construct($title, $author, $genre) {
        parent::__construct($title, $author);
        $this->genre = $genre;
    }

    public function getDescription() {
        return "Fiction Book: {$this->title} by {$this->author}<br>Genre: {$this->genre} " . $this->borrow() . "<br>";
    }

    // Contoh Magic Method __toString
    public function __toString() {
        return $this->getDescription();
    }
}

// Class NonFiction yang mewarisi dari Book
class NonFiction extends Book {
    private $subject;

    public function __construct($title, $author, $subject) {
        parent::__construct($title, $author);
        $this->subject = $subject;
    }

    public function getDescription() {
        return "Non-Fiction Book: {$this->title} by {$this->author},<br>Subject: {$this->subject}<br>";
    }
}

// Penggunaan program
$fictionBook = new Fiction("To Kill a Mockingbird", "Harper Lee", "Classic");
echo $fictionBook; // Memanfaatkan Magic Method __toString

$nonFictionBook = new NonFiction("Sapiens", "Yuval Noah Harari", "History");
echo $nonFictionBook->getDescription();
?>
