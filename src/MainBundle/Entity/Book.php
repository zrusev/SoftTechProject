<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\BookRepository")
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="bookName", type="string", length=255, nullable=true)
     */
    private $bookName;

    /**
     * @var int
     *
     * @ORM\Column(name="authorId", type="integer")
     */
    private $authorId;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Chapter", mappedBy="book")
     */
    private $chapters;


    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * @param Chapter $chapter
     *
     * @return Book
     */
    public function addChapter(Chapter $chapter)
    {
        $this->chapters[] = $chapter;

        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(){
        return $this->authorId;
    }

    /**
     * @param $authorId
     * @return Book
     */
    function setAuthorId($authorId){
        $this->authorId = $authorId;
        return $this;
    }


    /**
     * @var User;
     *
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(name="authorId", referencedColumnName="id")
     */
    private $author;

    /**
     * @return User
     */
    public function getAuthor(){
        return $this->author;
    }

    /**
     * @param User $author
     * @return Book
     */
    public function setAuthor(User $author = null){
        $this->author = $author;

        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bookName
     *
     * @param string $bookName
     *
     * @return Book
     */
    public function setBookName($bookName)
    {
        $this->bookName = $bookName;

        return $this;
    }

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }


    /**
     * Get bookName
     *
     * @return string
     */
    public function getBookName()
    {
        return $this->bookName;
    }
}

