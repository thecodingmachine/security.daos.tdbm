<?php
namespace Mouf\Security\Model;

use Mouf\Security\UserManagement\Api\RoleInterface;

class Role implements RoleInterface
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * Role constructor.
     * @param mixed $id
     * @param string $label
     */
    public function __construct($id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}