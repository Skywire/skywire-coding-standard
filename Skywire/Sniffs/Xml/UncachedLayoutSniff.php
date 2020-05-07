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
        foreach ($tokens as $position => $token) {
            $noCache = strpos($token['content'], 'cacheable="false"') !== false;
            if($noCache) {
                $phpcsFile->addWarning('Using cacheable="false" in a layout renders the entire page uncacheable and should be avoided', $stackPtr, 'Skywire.Xml.UncachedLayout', [], 10);
            }
        }
    }

//    protected $supportedTokenizers = ['XML'];
//
//    /**
//     * Warning violation code.
//     *
//     * @var string
//     */
//    protected $warningCodeFoundHelper = 'UncachedLayoutFound';
//
//    /**
//     * String representation of warning.
//     *
//     * @var string
//     */
//    protected $warningMessageFoundHelper = 'cacheable="false" renders the entire page uncacheable and should be avoided';
//
//    /**
//     * @inheritdoc
//     */
//    public function register()
//    {
//        return [T_STRING];
//    }
//
//    /**
//     * @inheritdoc
//     */
//    public function process(File $phpcsFile, $stackPtr)
//    {
//        $tokens = $phpcsFile->getTokens();
//        if ($tokens[$stackPtr]['content'] === '$this') {
//            $position = $phpcsFile->findNext(T_STRING, $stackPtr, null, false, 'helper', true);
//            if ($position !== false) {
//                $phpcsFile->addWarning($this->warningMessageFoundHelper, $position, $this->warningCodeFoundHelper);
//            } else {
//                $phpcsFile->addWarning($this->warningMessageFoundThis, $stackPtr, $this->warningCodeFoundThis);
//            }
//        }
//    }
}
