<?php

declare(strict_types=1);

namespace App\Domain\Dolibarr;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

/**
 * Guzzle request to Dolibarr REST API
 * Requête Guzzle vers l'API REST Dolibarr
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 */
abstract class Dolibarr
{
    private string $_apiUrl;
    private string $_apiKey;

    private string $_type;
    private string $_request;
    private array $_data;

    private $_response;
    private $_statusCode;
    private $_body;

    public function __construct()
    {
        $this->_apiUrl = $_ENV['DOLIBARR_API_URL'] . '/index.php/';
        $this->_apiKey = $_ENV['DOLIBARR_API_KEY'];
    }

    /**
     * Query on the Dolibarr API
     * Requête sur l'API Dolibarr
     * @return null
     */
    private function getDolibarrRequest()
    {
        try {
            $client = new Client([
                'base_uri' => $this->_apiUrl,
            ]);

            switch ($this->_type) {
                case 'GET':
                    $this->_response = $client->get($this->_request, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'DOLAPIKEY' => $this->_apiKey,
                        ],
                        'verify' => false, // ATTENTION true EN PRODUCTION !!! Vérification de certificat SSL
                    ]);
                    break;

                case 'POST':
                    $this->_response = $client->post($this->_request, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'DOLAPIKEY' => $this->_apiKey,
                        ],
                        'body' => $this->_data,
                    ]);
                    break;

                case 'PUT':
                    # TODO
                    $this->_response = false;
                    break;

                case 'DELETE':
                    # TODO
                    $this->_response = false;
                    break;

                default:
                    # TODO
                    $this->_response = false;
                    break;
            }
        } catch (ClientException $e) {
            throw new \Exception(Psr7\Message::toString($e->getResponse()));
        }

        $this->_statusCode = $this->_response->getStatusCode();
        if ($this->_statusCode != 200) {
            throw new \Exception("The response has an error, statusCode: " . $this->_statusCode);
        }

        $this->_body = json_decode((string) $this->_response->getBody(), true);

        return null;
    }

    /**
     * GET request on Dolibarr REST API
     * Requête GET sur l'API REST Dolibarr
     * @param string $request URi containing the request / URi contenant la requête
     * @return array $this->_body API Response / Réponse de l'API
     */
    protected function getDolibarr($request)
    {
        $this->_type = "GET";
        $this->_request = $request;
        $this->getDolibarrRequest();
        return $this->_body;
    }

    /**
     * POST request on Dolibarr REST API
     * Requête POST sur l'API REST Dolibarr
     * @param string $request URi containing the request / URi contenant la requête
     * @param array $data Paramètres du POST / POST parameters
     * @return array $this->_body API Response / Réponse de l'API
     */
    protected function postDolibarr($request, $data = [])
    {
        $this->_type = "POST";
        $this->_request = $request;
        $this->_data = $data;
        $this->getDolibarrRequest();
        return $this->_body;
    }

    /**
     * PUT request on Dolibarr REST API
     * Requête PUT sur l'API REST Dolibarr
     * @param string $request URi containing the request / URi contenant la requête
     * @return array $this->_body API Response / Réponse de l'API
     */
    protected function putDolibarr()
    {
        $this->_type = "PUT";
        $this->getDolibarrRequest();
        return $this->_body;
    }

    /**
     * DELETE request on Dolibarr REST API
     * Requête DELETE sur l'API REST Dolibarr
     * @param string $request URi containing the request / URi contenant la requête
     * @return array $this->_body API Response / Réponse de l'API
     */
    protected function deleteDolibarr()
    {
        $this->_type = "DELETE";
        $this->getDolibarrRequest();
        return $this->_body;
    }

    /**
     * Generates the URi of requests for Dolibarr API
     * Génère l'URi des requêtes pour Dolibarr API
     * @param string $uri URi to call on the API (after API/index.php/)
     * @param array $default = [] Default params on this request
     * @param array $params = [] Custom Settings
     * @return string Query formatted with params
     */
    protected function createRequestDolibarr($uri, $params = [], $default = [])
    {
        $request = $uri;
        $thereAreAlreadyParams = false;

        foreach (array_merge($default, $params) as $key => $value) {
            if ($thereAreAlreadyParams) {
                $request .= '&' . $key . '=' . $value;
            } else {
                $request .= '?' . $key . '=' . $value;
                $thereAreAlreadyParams = true;
            }
        }

        return $request;
    }
}
