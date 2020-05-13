<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Skywire\Sniffs\Xml;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Detects possible usage of $this variable files.
 */
class UncachedLayoutSniff implements Sniff
{
    public function register()
    {
        return [T_INLINE_HTML];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $noCache = strpos($token['content'], 'cacheable="false"') !== false;
        if ($noCache) {
            $phpcsFile->addWarning(
                'Using cacheable="false" in a layout renders the entire page uncacheable and should be avoided',
                $stackPtr,
                'Skywire.Xml.UncachedLayout',
                [],
                10
            );
        }
    }
}
