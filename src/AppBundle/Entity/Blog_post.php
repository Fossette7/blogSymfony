<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blog_post
 *
 * @ORM\Table(name="blog_post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Blog_postRepository")
 */
class Blog_post
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var Blog_comment
     *
     * @ORM\OneToMany(targetEntity="Blog_comment", mappedBy="Blog_post")
     * @ORM\JoinColumn(name="Blog_comment_id", referencedColumnName="id")
     */
    private $Blog_comments;

    public function __construct()
    {
        $this->Blog_comments = new ArrayCollection();
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Blog_post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Blog_post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return Collection | Blog_comment[]
     */
    public function getBlogComments(): Collection
    {
        return $this->Blog_comments;
    }

    /**
     * @param Blog_comment $Blog_comments
     */
    public function setBlogComments($Blog_comments)
    {
        $this->Blog_comments = $Blog_comments;
    }
}
