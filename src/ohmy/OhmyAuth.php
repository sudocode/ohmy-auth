<?php namespace ohmy;

use ohmy\Interfaces\AuthAdapter;
use ohmy\Support\Traits\OverloadMethod;

/**
 * Unifies all library in a class, OAuth clients load with DI pattern.
 *
 * Uses method overloading (by trait), to modify the 'init' method call.
 *
 * It has the functions 'session_start' and 'session_destroy' implicit.
 */
class OhmyAuth
{
    use OverloadMethod;

    /**
     * Object instance Auth1/Auth2.
     *
     * @var object
     */
    protected $auth = null;

    /**
     * OAuth flow type.
     *
     * @var integer
     */
    protected $flow;

    protected $session = false;

    /**
     * DI used to test better, and is implicit 'destroy_session' when needed.
     *
     * @param AuthAdapter  $auth
     * @param integer      $flow
     */
    public function __construct(AuthAdapter $auth = null, $flow = 3)
    {
        if ($auth instanceof ohmy\Auth1 && 3 == $flow)
        {
            session_start();

            $this->session = true;
        }

        $this->flow = $flow;
        $this->auth = $auth;

    }

    public function __destruct()
    {
        if ($this->session)
        {
            $this->auth->finally(session_destroy);
        }
    }

    /**
     * The same method, but now, you can use it as static way or... non-static way.
     *
     * (It is therefore as 'protected')
     *
     * @return Object
     */
    protected function init()
    {
        $instance = $this;

        if (!isset($instance->auth))
        {
            extract(func_get_args(), EXTR_PREFIX_ALL, 'var');

            $instance = new static($var_0, $var_1);
        }

        $auth = $instance->auth;

        $this->auth = $auth::init($instance->flow);

        return $this->auth;
    }

}
