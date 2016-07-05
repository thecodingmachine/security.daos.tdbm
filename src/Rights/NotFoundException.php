<?php


namespace Mouf\Security\Rights;


class NotFoundException extends \RuntimeException
{
    public static function create(string $name) : NotFoundException
    {
        return new self(sprintf('Tried to fetch non-existing right %s from RightsRegistry.', $name));
    }
}