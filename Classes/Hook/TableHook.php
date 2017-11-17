<?php

namespace MoveElevator\MeBackendSecurity\Hook;

use TYPO3\CMS\Core\DataHandling\DataHandler;

/**
 * @package MoveElevator\MeBackendSecurity\Hook
 */
class TableHook
{
    /**
     * @param array       $incomingFieldArray
     * @param string      $table
     * @param int         $id
     * @param DataHandler $pObj
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function processDatamap_preProcessFieldArray(&$incomingFieldArray, $table, $id, DataHandler &$pObj)
    {
        if ($table !== 'be_users') {
            return;
        }

        if (empty($incomingFieldArray['password'])) {
            return;
        }

        if ((int) $id !== (int) $GLOBALS['BE_USER']->user['uid']) {
            return;
        }

        if (empty($GLOBALS['BE_USER']->user['ses_backuserid']) === false) {
            return;
        }

        $incomingFieldArray['tx_mebackendsecurity_lastpasswordchange'] = time() + date('Z');
    }
}
