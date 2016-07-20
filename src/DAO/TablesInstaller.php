<?php

namespace Mouf\Security\DAO;

use Mouf\Actions\InstallUtils;
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


        // These instances are expected to exist when the installer is run.
        $tdbmService = $moufManager->getInstanceDescriptor('tdbmService');

        // Let's create the instances.
        $Mouf_Security_Rights_RightsRegistry = InstallUtils::getOrCreateInstance('Mouf\\Security\\Rights\\RightsRegistry', 'Mouf\\Security\\Rights\\RightsRegistry', $moufManager);
        $Mouf_Security_DAO_SecurityRightDao = InstallUtils::getOrCreateInstance('Mouf\\Security\\DAO\\SecurityRightDao', 'Mouf\\Security\\DAO\\SecurityRightDao', $moufManager);
        $Mouf_Security_DAO_SecurityUserDao = InstallUtils::getOrCreateInstance('Mouf\\Security\\DAO\\SecurityUserDao', 'Mouf\\Security\\DAO\\SecurityUserDao', $moufManager);

        // Let's bind instances together.
        if (!$Mouf_Security_Rights_RightsRegistry->getConstructorArgumentProperty('rights')->isValueSet()) {
            $Mouf_Security_Rights_RightsRegistry->getConstructorArgumentProperty('rights')->setValue(array());
        }
        if (!$Mouf_Security_DAO_SecurityRightDao->getConstructorArgumentProperty('tdbmService')->isValueSet()) {
            $Mouf_Security_DAO_SecurityRightDao->getConstructorArgumentProperty('tdbmService')->setValue($tdbmService);
        }
        if (!$Mouf_Security_DAO_SecurityRightDao->getConstructorArgumentProperty('rightsRegistry')->isValueSet()) {
            $Mouf_Security_DAO_SecurityRightDao->getConstructorArgumentProperty('rightsRegistry')->setValue($Mouf_Security_Rights_RightsRegistry);
        }
        if (!$Mouf_Security_DAO_SecurityUserDao->getConstructorArgumentProperty('tdbmService')->isValueSet()) {
            $Mouf_Security_DAO_SecurityUserDao->getConstructorArgumentProperty('tdbmService')->setValue($tdbmService);
        }



        // Lets bind UserDao and RightsDao to userService and rightsService
        $rightsService = $moufManager->getInstanceDescriptor('rightsService');
        $rightsService->getPublicFieldProperty('rightsDao')->setValue($Mouf_Security_DAO_SecurityRightDao);

        $userService = $moufManager->getInstanceDescriptor('userService');
        $userService->getPublicFieldProperty('userDao')->setValue($Mouf_Security_DAO_SecurityUserDao);


        // TODO: apply patch
        // TODO: regenerate DAOs.

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}
