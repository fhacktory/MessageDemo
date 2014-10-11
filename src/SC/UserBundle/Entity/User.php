<?php

namespace SC\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="SC\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="myContacts")
     */
    private $contactsWithMe;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="contactsWithMe")
     * @ORM\JoinTable(name="contacts",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="contact_user_id", referencedColumnName="id")}
     * )
     */
    private $myContacts;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SC\MessageBundle\Entity\Message", mappedBy="from")
     */
    private $sentMessages;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SC\MessageBundle\Entity\Message", mappedBy="to")
     */
    private $receivedMessages;

    /**
     * @var bool
     */
    private $online;

    public function __construct() {
        parent::__construct();

        $this->contactsWithMe       = new ArrayCollection();
        $this->myContacts           = new ArrayCollection();
        $this->sentMessages         = new ArrayCollection();
        $this->receivedMessages     = new ArrayCollection();
    }

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
     * Add contactsWithMe
     *
     * @param User $contactsWithMe
     * @return User
     */
    public function addContactsWithMe(User $contactsWithMe)
    {
        $this->contactsWithMe[] = $contactsWithMe;

        return $this;
    }

    /**
     * Remove contactsWithMe
     *
     * @param User $contactsWithMe
     */
    public function removeContactsWithMe(User $contactsWithMe)
    {
        $this->contactsWithMe->removeElement($contactsWithMe);
    }

    /**
     * Get contactsWithMe
     *
     * @return Collection
     */
    public function getContactsWithMe()
    {
        return $this->contactsWithMe;
    }

    /**
     * Add myContacts
     *
     * @param User $myContacts
     * @return User
     */
    public function addMyContact(User $myContacts)
    {
        $this->myContacts[] = $myContacts;

        return $this;
    }

    /**
     * Remove myContacts
     *
     * @param User $myContacts
     */
    public function removeMyContact(User $myContacts)
    {
        $this->myContacts->removeElement($myContacts);
    }

    /**
     * Get myContacts
     *
     * @return Collection
     */
    public function getMyContacts()
    {
        return $this->myContacts;
    }

    /**
     * @return mixed
     */
    public function getSentMessages()
    {
        return $this->sentMessages;
    }

    /**
     * @return array
     */
    public function getContacts()
    {
        $contacts = array();

        foreach(array('contactsWithMe', 'myContacts') as $relation) {
            /** @var User $contact */
            foreach ($this->$relation as $contact) {
                if (!isset($contacts[$contact->getId()])) {
                    $contacts[$contact->getId()] = $contact;
                }
            }
        }

        return $contacts;
    }

    /**
     * @param mixed $sentMessages
     */
    public function setSentMessages($sentMessages)
    {
        $this->sentMessages = $sentMessages;
    }

    /**
     * @return ArrayCollection
     */
    public function getReceivedMessages()
    {
        return $this->receivedMessages;
    }

    /**
     * @param ArrayCollection $receivedMessages
     */
    public function setReceivedMessages($receivedMessages)
    {
        $this->receivedMessages = $receivedMessages;
    }

    /**
     * @return boolean
     */
    public function isOnline()
    {
        return $this->online;
    }

    /**
     * @param boolean $online
     * @return $this
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }
}
