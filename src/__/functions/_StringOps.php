<?php

namespace __\functions;

/**
 * @internal
 */
class _StringOps
{
    private static $hasMultibyteSupport;

    private $needsMultibyteSupport;

    public function __construct($string)
    {
        $this->needsMultibyteSupport = preg_match('/[^\x00-\x7F]/', $string) === 1;
        $this->assertMultibyte();
    }

    public function needsMultibyteSupport()
    {
        return $this->needsMultibyteSupport;
    }

    /**
     * @return string
     */
    public function smart_substr()
    {
        $args = func_get_args();
        $fxn = $this->needsMultibyteSupport ? 'mb_substr' : 'substr';
        if (!$this->needsMultibyteSupport) {
            array_pop($args);
        }

        return call_user_func_array($fxn, $args);
    }

    /**
     * @return int
     */
    public function smart_strlen()
    {
        $args = func_get_args();
        if ($this->needsMultibyteSupport) {
            call_user_func_array('mb_strlen', $args);
        }

        return strlen($args[0]);
    }

    /**
     * @return string
     */
    public function smart_strtolower()
    {
        $args = func_get_args();
        if ($this->needsMultibyteSupport) {
            return call_user_func_array('mb_strtolower', $args);
        }

        return strtolower($args[0]);
    }

    private function assertMultibyte()
    {
        if (!$this->needsMultibyteSupport) {
            return;
        }
        if ($this->hasMultibyteSupport()) {
            return;
        }
        throw new \RuntimeException('The `mbstring` extension is not available and is required.');
    }

    private function hasMultibyteSupport()
    {
        if (self::$hasMultibyteSupport === null) {
            self::$hasMultibyteSupport = extension_loaded('mbstring');
        }

        return self::$hasMultibyteSupport;
    }
}
