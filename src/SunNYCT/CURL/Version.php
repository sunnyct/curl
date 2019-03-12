<?php
/**
 * SunNY Creative Technologies
 *
 *   #####                                ##     ##    ##      ##
 * ##     ##                              ###    ##    ##      ##
 * ##                                     ####   ##     ##    ##
 * ##           ##     ##    ## #####     ## ##  ##      ##  ##
 *   #####      ##     ##    ###    ##    ##  ## ##       ####
 *        ##    ##     ##    ##     ##    ##   ####        ##
 *        ##    ##     ##    ##     ##    ##    ###        ##
 * ##     ##    ##     ##    ##     ##    ##     ##        ##
 *   #####        #######    ##     ##    ##     ##        ##
 *
 * C  R  E  A  T  I  V  E     T  E  C  H  N  O  L  O  G  I  E  S
 */

namespace SunNYCT\CURL;

/**
 * Version helper class
 */
class Version
{
    const MAJOR = 1;
    const MINOR = 0;
    const PATCH = 1;

    /**
     * Get full version string
     *
     * @return string
     */
    public static function getFullVersion()
    {
        return static::MAJOR . '.' . static::MINOR . '.' . static::PATCH;
    }
}