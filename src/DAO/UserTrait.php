<?php


namespace Mouf\Security\DAO;

/**
 * This trait changes the behaviour of the "setPassword" method on the user bean.
 * It is used to automatically encrypt the password.
 */
trait UserTrait
{
    /**
     * Sets the password.
     * Note: this will encode the password.
     *
     * @param string $password
     */
    public function setPassword(string $password)
    {
        parent::setPassword(password_hash($password, PASSWORD_DEFAULT));
    }
}
