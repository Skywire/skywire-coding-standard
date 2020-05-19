<?php
/**
 * Copyright © Skywire Ltd. All rights reserved.
 *
 * See LICENSE.txt for license details.
 *
 */

namespace Skywire\Sniffs\Xml;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Detects possible usage of $this variable files.
 */
class MalformedSniff implements Sniff
{
    public function register()
    {
        return [T_INLINE_HTML];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        libxml_use_internal_errors(true);
        $xmlString = file_get_contents($phpcsFile->path);
        $dom = simplexml_load_string($xmlString);

        $errors = libxml_get_errors();

        foreach ($errors as $error) {
            $phpcsFile->addWarning(
                $error->message,
                $error->line-1,
                'Skywire.Xml.Malformed',
                [$error],
                10
            );
        }

        libxml_clear_errors();

        // ignore the rest of the file as we've already parsed the whole thing
        return $phpcsFile->numTokens;
    }
}
