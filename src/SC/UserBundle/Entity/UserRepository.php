<?php

namespace SC\UserBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return array
     */
    public function getContacts($user)
    {
        $qb = $this
            ->createQueryBuilder('u')
            ->where('u.id IN (:contactsWithMe)')
            ->setParameter('contactsWithMe', self::getIdArray(
                $user->getContactsWithMe()
            ))
            ->orWhere('u.id IN (:myContacts)')
            ->setParameter('myContacts', self::getIdArray(
                $user->getMyContacts()
            ));

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param Collection $collection
     * @return array
     */
    private static function getIdArray($collection)
    {
        $result = array();

        /** @var User $user */
        foreach($collection as $user) {
            $result[] = $user->getId();
        }

        return $result;
    }
}
