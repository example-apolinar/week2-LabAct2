<?php

class Book {
    public $title;
    protected $author;
    private $price;

    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    public function getDetails() {
        return "Title: {$this->title}, Author: {$this->author}, Price: \${$this->price}";
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function __call($name, $arguments) {
        if ($name == 'updateStock') {
            echo "Stock update for '{$this->title}' with argument: " . implode(', ', $arguments) . "<br>";
        } else {
            echo "Call to undefined method {$name}." . "<br>";
        }
    }
}

class Library {
    private $books = [];
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function removeBook($title) {
        foreach ($this->books as $index => $book) {
            if ($book->title === $title) {
                unset($this->books[$index]);
                echo "Book '{$title}' removed from the library." . "<br>";
                return;
            }
        }
        echo "Book '{$title}' not found in the library." . "<br>";
    }

    public function listBooks() {
        echo "Books in the Library:" . "<br>";
        foreach ($this->books as $book) {
            echo $book->getDetails() . "<br>";
        }
    }

    public function __destruct() {
        echo "The Library '{$this->name}' is now closed." . "<br>";
    }
}

// Books and library
$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 10.99);
$book2 = new Book("1984", "George Orwell", 15.99);

$library = new Library("City Library");

// Add multiple books
$library->addBook($book1);
$library->addBook($book2);

// Update price
$book1->setPrice(12.99);
$book2->setPrice(8.99);

// Call non-existent method, triggers __call
$book1->updateStock(50);

// List books
$library->listBooks();

// Remove book from library
$library->removeBook("1984");

// List books after removal
echo "Books in the library after removal:" . "<br>";
$library->listBooks();

// Destroy the library to trigger the destructor
unset($library);

?>


