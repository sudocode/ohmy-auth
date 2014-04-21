<?php namespace ohmy;

use ohmy\Exceptions\AuthException;

/**
 * OAuth description.
 */
class Auth
{
    protected $protocolKeys;
    protected $clientCredentials;

    public static function init(array $clientCredentials)
    {
        $instance = new Auth();

        $instance->setClientCredentials($clientCredentials);

        return $instance->getAuth();
    }

    /**
     * [setClientCredentials description]
     *
     * @param [type] $clientCredentials [description]
     */
    public function setClientCredentials($clientCredentials)
    {
        $this->clientCredentials = array_change_key_case($clientCredentials, CASE_LOWER);
    }

    /**
     * [getAuthorization description]
     *
     * @return [type] [description]
     */
    public function getAuth()
    {
        extract($this->getProtocol());

        $class = 'ohmy\\Protocols\\'.$protocol;

        $auth = $class::legs($legs);

        return $auth->set($this->clientCredentials);

    }

    /**
     * [getProtocol description]
     *
     * @return [type] [description]
     */
    protected function getProtocol()
    {
        $protocolKeys      = $this->getDefaultProtocolKeys();
        $clientCredentials = array_keys($this->clientCredentials);

        foreach ($protocolKeys as $protocol => $legs) {

            $this->setCurrentProtocolKeys($clientCredentials, $protocol);

            foreach ($legs as $leg => $defaultKeys) {

                sort($defaultKeys);

                if ($this->protocolKeys === $defaultKeys)
                {
                    return array(
                        'protocol' => $protocol,
                        'legs'     => $leg
                    );
                }

            }

        }

        throw new AuthException('Doesn\'t exist protocol for this parameters: (' . implode(', ', $clientCredentials) . ')');
    }

    /**
     * [setProtocolKeys description]
     *
     * @param [type] $protocol     [description]
     * @param [type] $protocolKeys [description]
     */
    protected function setCurrentProtocolKeys($clientCredentials, $protocol)
    {
        $this->protocolKeys = array();

        foreach ($clientCredentials as $key) {
            $this->protocolKeys[] = call_user_func_array(array($this, 'get'.$protocol.'Key'), array($key));
        }

        sort($this->protocolKeys);

    }

    /**
     * [getAuth1Key description]
     *
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function getAuth1Key($value)
    {
        switch($value) {
            case 'oauth_consumer_key':
            case 'consumer_key':
            case 'key':
                return 'oauth_consumer_key';
                break;
            case 'oauth_consumer_secret':
            case 'consumer_secret':
            case 'secret':
                return 'oauth_consumer_secret';
                break;
            case 'oauth_callback':
            case 'callback':
                return 'oauth_callback';
                break;
            case 'oauth_token':
            case 'token':
                return 'oauth_token';
                break;
            case 'oauth_token_secret':
            case 'token_secret':
                return 'oauth_token_secret';
                break;
            default:
                return null;
        }
    }

    /**
     * [getAuth2Key description]
     *
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function getAuth2Key($value)
    {
        switch($value) {
            case 'client_id':
            case 'id':
                return 'client_id';
                break;
            case 'client_secret':
            case 'secret':
                return 'client_secret';
                break;
            case 'callback':
            case 'redirect':
            case 'redirect_uri':
                return 'redirect_uri';
                break;
            default:
                return null;
        }
    }

    /**
     * [getDefaultProtocolKeys description]
     *
     * @return [type] [description]
     */
    protected function getDefaultProtocolKeys()
    {
        return [
            'Auth1' => [
                2 => ['oauth_consumer_key', 'oauth_consumer_secret'],
                3 => ['oauth_consumer_key', 'oauth_consumer_secret', 'oauth_callback'],
            ],
            'Auth2' => [
                3 => ['client_id', 'client_secret', 'redirect_uri']
            ],
        ];
    }



}
