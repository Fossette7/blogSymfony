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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    /**
     * @var Blog_comment
     *
     * @ORM\OneToMany(targetEntity="Blog_comment", mappedBy="Blog_post")
     */
    private $blog_comments;

    public function __construct()
    {
        $this->blog_comments = new ArrayCollection();
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
     * @return Collection|Blog_comment[]
     */
    public function getBlogComments(): Collection
    {
        return $this->blog_comments;
    }


    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


    /**
     * @param Blog_comment $Blog_comments
     */
    public function setBlogComments($Blog_comments)
    {
        $this->blog_comments = $Blog_comments;
    }

    public function addBlogComment(Blog_comment $blog_comment): self
    {
        if(!$this->blog_comments->contains($blog_comment)) {
            $this->blog_comments[] = $blog_comment;
            $blog_comment->setBlogPost($this);
        }
        return $this;
    }

    public function removeBlogComment (Blog_comment $blog_comment): self
    {
        if($this->blog_comments->contains($blog_comment)){
            $this->blog_comments->removeElement($blog_comment);
            //become null
            if ($blog_comment->getBlogPost() === $this) {
                $blog_comment->setBlogPost(null);
            }
        }
        return $this;
    }
}
