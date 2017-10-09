<?php
namespace Mouf\Security\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Mouf\Database\Patcher\AbstractSchemaMigrationPatch;
use TheCodingMachine\FluidSchema\FluidSchema;

/**
 * This class is a patch used to apply changes to the database.
 */
class CreateUserRoleRightPatch extends AbstractSchemaMigrationPatch
{
    public function up(Schema $schema) : void
    {
        $db = new FluidSchema($schema);

        /* data base theme manager*/

        $db->table('users')
            ->column('id')->guid()->primaryKey()->comment('@UUID')
            ->column('login')->string(255)->index()
            ->column('password')->string(255)
            ->column('email')->string(255)->index()
            ->column('token')->string(255)->null()->index()
            ->column('lastname')->string(255)->null()
            ->column('firstname')->string(255)->null();

        $db->table('roles')
            ->column('id')->guid()->primaryKey()->comment('@UUID')
            ->column('label')->string(255);

        $db->junctionTable('users', 'roles');

        $db->table('roles_rights')
            ->column('role_id')->references('roles')
            ->column('right_key')->string(255)->then()
            ->primaryKey(['role_id', 'right_key']);

    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('roles_rights');
        $schema->dropTable('users_roles');
        $schema->dropTable('roles');
        $schema->dropTable('users');
    }
    
    public function getDescription(): string
    {
        return 'This patch is added by the mouf/security.daos.tdbm package. It creates users, users_roles, roles, roles_rights tables.';
    }
}
