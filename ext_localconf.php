<?php

defined('TYPO3_MODE') || die();

(static function () {
    $typo3VersionNumber = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(
        \TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()
    );

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1433416747]['provider'] =
        \MoveElevator\MeBackendSecurity\LoginProvider\UsernamePasswordLoginProvider::class;

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['postUserLookUp'][] =
        \MoveElevator\MeBackendSecurity\Hook\UserAuthHook::class . '->postUserLookUp';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals'][\MoveElevator\MeBackendSecurity\Evaluation\PasswordEvaluator::class] =
        'EXT:me_backend_security/Classes/Evaluation/PasswordEvaluator.php';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['me_backend_security'] =
        \MoveElevator\MeBackendSecurity\Hook\TableHook::class;

    if ($typo3VersionNumber > 10000000) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Authentication\PasswordReset::class] = [
            'className' => \MoveElevator\MeBackendSecurity\Authentication\PasswordReset::class
        ];

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Controller\LoginController::class] = [
            'className' => \MoveElevator\MeBackendSecurity\Controller\LoginController::class
        ];
    }
})();
