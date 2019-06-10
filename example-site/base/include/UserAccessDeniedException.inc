<?php

/**
 * custom class for user denied exception.
 *
 * @author sean
 */


class UserAccessDeniedException extends ErrorException
{

    /**
     *
     * @var bool
     */
    public $hasApplicationAccess;

    /**
     * Construct instance.
     *
     * @param bool $hasApplicationAccess
     */
    public function __construct(bool $hasApplicationAccess)
    {
        parent::__construct('Access denied.');
        $this->hasApplicationAccess = $hasApplicationAccess;
    }
}
