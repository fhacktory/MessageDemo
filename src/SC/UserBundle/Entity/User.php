<?php

namespace SC\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="myContacts")
     */
    private $contactsWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="contactsWithMe")
     * @ORM\JoinTable(name="contacts",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="contact_user_id", referencedColumnName="id")}
     * )
     */
    private $myContacts;

    public function __construct() {
        parent::__construct();

        $this->contactsWithMe = new ArrayCollection();
        $this->myContacts = new ArrayCollection();
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
}
