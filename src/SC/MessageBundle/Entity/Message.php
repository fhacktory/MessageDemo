<?php

namespace SC\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SC\UserBundle\Entity\User;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SC\MessageBundle\Entity\MessageRepository")
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="receivedAt", type="datetime")
     */
    private $receivedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="readAt", type="datetime")
     */
    private $readAt;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="SC\UserBundle\Entity\User", inversedBy="sentMessages")
     */
    private $from;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="SC\UserBundle\Entity\User", inversedBy="receivedMessages")
     */
    private $to;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set receivedAt
     *
     * @param \DateTime $receivedAt
     * @return Message
     */
    public function setReceivedAt($receivedAt)
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    /**
     * Get receivedAt
     *
     * @return \DateTime 
     */
    public function getReceivedAt()
    {
        return $this->receivedAt;
    }

    /**
     * Set readAt
     *
     * @param \DateTime $readAt
     * @return Message
     */
    public function setReadAt($readAt)
    {
        $this->readAt = $readAt;

        return $this;
    }

    /**
     * Get readAt
     *
     * @return \DateTime 
     */
    public function getReadAt()
    {
        return $this->readAt;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param User $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return User
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param User $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }
}
