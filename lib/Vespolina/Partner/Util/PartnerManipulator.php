<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\PartnerBundle\Util;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\UserManipulator;
use Vespolina\PartnerBundle\Model\Partner;
use Vespolina\PartnerBundle\Model\PartnerInterface;


/**
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class PartnerManipulator
{
    protected $userManager;

    public function __construct(UserManagerInterface $userManager, UserManipulator $userManipulator) {

        $this->userManager = $userManager;
        $this->userManipulator = $userManipulator;
    }

    /**
     * Create or updates the (FOS) User linkage
     *
     * @param PartnerInterface $partner
     */
    public function createUser(PartnerInterface $partner, $username, $password)
    {
        $email = $partner->getPrimaryContact()->getEmail();
        $user = $this->userManipulator->create($username, $password, $email, true, false);

        $user->setPartner($partner);
        //Setup user roles
        $userRoles = $this->mapPartnerToUserRoles($partner->getRoles());

        foreach ($userRoles as $userRole) {
            $user->addRole($userRole);
        }

        return $user;
    }

    /**
     * Map provided partner business roles to FOS user roles
     *
     * For instance, a sales clerk might get multiple roles
     */
    public function mapPartnerToUserRoles(array $partnerRoles)
    {
        $userRoles = array();
        foreach ($partnerRoles as $partnerRole) {

            $userRoles[] = $partnerRole;

            if ($partnerRole == Partner::ROLE_EMPLOYEE) {

                $userRoles[] = 'ROLE_ADMIN';
            }

        }
        return $userRoles;
    }
}