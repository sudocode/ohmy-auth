<?php namespace ohmy;

use ohmy\Exceptions\AuthException;

/**
 * A factory class to use OAuth and OAuth2 protocols implicity and intelligently.
 * The keys from client credentials are used to know what protocol is necessary, and return it.
 */
class Auth
{
    /**
     * Current keys with its protocol standard names.
     *
     * @var array
     */
    protected $protocolKeys;

    /**
     * Client Credentials from a consumer.
     *
     * @var array
     */
    protected $clientCredentials;

    public static function init(array $clientCredentials)
    {
        $instance = new Auth();

        $instance->setClientCredentials($clientCredentials);

        return $instance->getAuth();

    }

    /**
     * Sets input credentials.
     *
     * @param array $clientCredentials
     */
    public function setClientCredentials($clientCredentials)
    {
        $this->clientCredentials = array_change_key_case($clientCredentials, CASE_LOWER);

    }

    /**
     * Gets protocol object of Oauth or Oauth2
     *
     * @return mixed
     */
    public function getAuth()
    {
        extract($this->getProtocol());

        $class = 'ohmy\\Protocols\\'.$protocol;

        $auth = $class::legs($legs);

        return $auth->set($this->clientCredentials);

    }

    /**
     * Determines which protocol is needed and returns it.
     *
     * @throws AuthException
     * @return array
     */
    protected function getProtocol()
    {
        $clientCredentials = array_keys($this->clientCredentials);
        $protocolKeys      = $this->getDefaultProtocolKeys();

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
     * Sets current OAuth parameters used.
     *
     * @param array   $clientCredentials
     * @param integer $protocol
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
     * Normalizes to parameter name of OAuth.
     *
     * @param  string $value
     * @return mixed
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
     * Normalizes to parameter name of OAuth2.
     *
     * @param  string $value
     * @return mixed
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
     * Gets the default names OAuth/OAuth2 parameters.
     *
     * @return array
     */
    protected function getDefaultProtocolKeys()
    {
        return array(
            'Auth1' => array(
                2 => array('oauth_consumer_key', 'oauth_consumer_secret'),
                3 => array('oauth_consumer_key', 'oauth_consumer_secret', 'oauth_callback'),
            ),
            'Auth2' => array(
                3 => array('client_id', 'client_secret', 'redirect_uri'),
            ),
        );

    }

}
