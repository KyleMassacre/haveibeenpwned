<?php

namespace KyleMass\Hibp;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Hibp
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Collection
     */
    private $results;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://haveibeenpwned.com/api/v2/',
            'exceptions' => false,
            'headers' => [
                'User-Agent' => config('hibp.user_agent'),
            ],
        ]);
    }

    /**
     * Checks the password to see if it has been PWNED.
     *
     * @param string $password
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function hasPasswordBeenPwned(string $password)
    {
        $password = $this->_isShaOne($password) ? $password : sha1($password);
        $method = 'GET';
        $uri = 'pwnedpassword/'.$password;
        $options = [];
        $results = $this->_get($method, $uri, $options, true);

        return $results;
    }

    /**
     * Sends the request and returns the result(s).
     *
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @param bool   $lookingForHttp
     *
     * @return Collection | mixed
     */
    private function _get(string $method, string $uri, $options = [], $lookingForHttp = false)
    {
        $result = $this->client->request($method, $uri, $options);

        if ($lookingForHttp == true) {
            $return = $result->getStatusCode() == 200;
        } else {
            $return = new Collection(json_decode($result->getBody()));
        }

        return $return;
    }

    /**
     * Checks is the parameter is already a sha1 encoded string.
     *
     * @param string $string
     *
     * @return bool
     */
    private function _isShaOne(string $string)
    {
        return (bool)preg_match('/^[0-9a-f]{40}$/i', $string);
    }

    /**
     * Checks the account name to see if it has been PWNED.
     *
     * @param string $string
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function hasAccountBeenPwned(string $string)
    {
        $method = 'GET';
        $uri = 'breachedaccount/'.urlencode($string);
        $options = [];
        $results = $this->_get($method, $uri, $options);

        return $results->isNotEmpty();
    }

    /**
     * Gets a Collection of all of the accounts that has been
     * breached with the given username or email.
     *
     * @param string $string
     *
     * @return Collection
     */
    public function getPwnedAccounts(string $string)
    {
        $method = 'GET';
        $uri = 'breachedaccount/'.urlencode($string);
        $options = [
            'query' => [
                'truncateResponse' => config('hibp.truncate_results'),
                'includeUnverified' => config('hibp.include_unverified'),
            ],
        ];

        $return = $this->_get($method, $uri, $options);
        $this->results = $return;

        return $this->results;
    }

    /**
     * @param string $email
     *
     * @return Collection|mixed
     */
    public function getPwnedPastes(string $email)
    {
        $method = 'GET';
        $uri = 'pasteaccount/'.urlencode($email);
        $return = $this->_get($method, $uri, []);
        $this->results = $return;

        return $this->results;
    }
}
