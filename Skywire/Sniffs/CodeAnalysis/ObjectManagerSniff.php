<?php
/**
 * Copyright © Skywire Ltd. All rights reserved.
 *
 * See LICENSE.txt for license details.
 *
 */

namespace Skywire\Sniffs\CodeAnalysis;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Detects possible empty blocks.
 */
class ObjectManagerSniff implements Sniff
{
    protected $message = 'ObjectManager should never be used directly, except in tests and factories';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_VARIABLE,
            T_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(
        File $phpcsFile,
        $stackPtr
    ) {
        // Factories are allows so skip if this class is one
        $file = basename($phpcsFile->path);
        if (strpos($file, 'Factory') !== false || strpos($file, 'Test') !== false) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $token  = $tokens[$stackPtr];
        if ($token['type'] == 'T_VARIABLE' && strtolower($token['content']) == '$objectmanager') {
            $phpcsFile->addError($this->message, $stackPtr, 'Skywire.CodeAnalysis.ObjectManager');
        }

        if ($token['type'] == 'T_STRING' && strpos($token['content'], 'ObjectManager') !== false) {
            $phpcsFile->addError($this->message, $stackPtr, 'Skywire.CodeAnalysis.ObjectManager');
        }

        return null;
    }
}
