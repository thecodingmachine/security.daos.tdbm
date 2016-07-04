<?php

namespace Mouf\Security\DAO;

use Mouf\Database\Patcher\DatabasePatchInstaller;
use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;

/**
 *
 */
class TablesInstaller implements PackageInstallerInterface {
    /**
     * (non-PHPdoc)
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager) {
        DatabasePatchInstaller::registerPatch($moufManager,
            "createUserRoleRightTablesPatch",
            "This patch is added by the mouf/security.daos.tdbm package. It creates users, users_roles, roles, roles_rights tables.",
            "vendor/mouf/security.daos.tdbm/database/up/users-roles-rights.sql", // SQL patch file, relative to ROOT_PATH
            "vendor/mouf/security.daos.tdbm/database/down/users-roles-rights.sql"); // Optional SQL revert patch file, relative to ROOT_PATH

        // TODO: apply patch
        // TODO: regenerate DAOs.

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}
