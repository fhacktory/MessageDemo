<?php

namespace SC\UserBundle\Entity;

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
     **/
    private $contactsWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="contactsWithMe")
     * @ORM\JoinTable(name="contacts",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contact_user_id", referencedColumnName="id")}
     *      )
     **/
    private $myContacts;

    public function __construct() {
        parent::__construct();

        $this->$contactsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->$myContacts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \SC\UserBundle\Entity\User $contactsWithMe
     * @return User
     */
    public function addContactsWithMe(\SC\UserBundle\Entity\User $contactsWithMe)
    {
        $this->contactsWithMe[] = $contactsWithMe;

        return $this;
    }

    /**
     * Remove contactsWithMe
     *
     * @param \SC\UserBundle\Entity\User $contactsWithMe
     */
    public function removeContactsWithMe(\SC\UserBundle\Entity\User $contactsWithMe)
    {
        $this->contactsWithMe->removeElement($contactsWithMe);
    }

    /**
     * Get contactsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContactsWithMe()
    {
        return $this->contactsWithMe;
    }

    /**
     * Add myContacts
     *
     * @param \SC\UserBundle\Entity\User $myContacts
     * @return User
     */
    public function addMyContact(\SC\UserBundle\Entity\User $myContacts)
    {
        $this->myContacts[] = $myContacts;

        return $this;
    }

    /**
     * Remove myContacts
     *
     * @param \SC\UserBundle\Entity\User $myContacts
     */
    public function removeMyContact(\SC\UserBundle\Entity\User $myContacts)
    {
        $this->myContacts->removeElement($myContacts);
    }

    /**
     * Get myContacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyContacts()
    {
        return $this->myContacts;
    }
}
