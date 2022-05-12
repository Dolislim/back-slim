<?php

declare(strict_types=1);

namespace App\Domain\Dolibarr;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Requête Guzzle vers l'API REST Dolibarr
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 */
abstract class Dolibarr
{
    private string $_apiUrl;
    private string $_apiKey;
    private Client $_client;

    private string $_type;
    private string $_request;
    private array $_data;
    private array $_response;

    public int $statut;
    public array $error;

    public function __construct()
    {
        $this->_apiUrl = $_ENV['DOLIBARR_API_URL'];
        $this->_apiKey = $_ENV['DOLIBARR_API_KEY'];
    }

    /**
     * On vérifie si le serveur API répond
     */
    private function getStatut(): bool
    {
        return @get_headers($this->_apiUrl);
    }

    /**
     * Requête sur l'API Dolibarr
     */
    private function getDolibarrRequest()
    {
        if (!$this->getStatut()) {

            $this->statut = 666; // TODO
            $this->error = [
                'request' => $this->_apiUrl,
                'response' => 'The server is not responding'
            ];
        }

        try {
            $this->_client = new Client([
                'base_uri' => $this->_apiUrl
            ]);

            switch ($this->_type) {
                case 'GET':
                    $this->_response = $this->_client->get($this->_request, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'DOLAPIKEY' => $this->_apiKey
                        ]
                    ]);
                    break;

                case 'POST':
                    $this->_response = $this->_client->post($this->_request, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'DOLAPIKEY' => $this->_apiKey
                        ],
                        'body' => $this->_data
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
        }
        // Todo: Voir le fonctionnement des erreurs dans Slim
        catch (ClientException $e) {
            $error = [
                'request' => Psr7\Message::toString($e->getRequest()),
                'response' => Psr7\Message::toString($e->getResponse())
            ];
        }
    }

    /**
     * Requête GET sur l'API REST Dolibarr
     * @param string $request URi de la requête
     * @return array $this->_response
     */
    protected function getDolibarr($request)
    {
        $this->_type = "GET";
        $this->_request = $request;
        $this->getDolibarrRequest();
        return $this->_response;
    }

    /**
     * Requête POST sur l'API REST Dolibarr
     */
    protected function postDolibarr($request, $data = false)
    {
        $this->_type = "POST";
        $this->_request = $request;
        $this->_data = $data;
        $this->getDolibarrRequest();
        return $this->_response;
    }

    /**
     * Requête PUT sur l'API REST Dolibarr
     */
    protected function putDolibarr()
    {
        $this->_type = "PUT";
        $this->getDolibarrRequest();
        return $this->_response;
    }

    /**
     * Requête DELETE sur l'API REST Dolibarr
     */
    protected function deleteDolibarr()
    {
        $this->_type = "DELETE";
        $this->getDolibarrRequest();
        return $this->_response;
    }

    /**
     * TODO
     * Retourne une collection après avoir supprimé les éléments vides (fonction récursive)
     */
    public function collectDolibarr($data)
    {
        $data = array_filter(
            $data,
            function ($v, $k) {
                if (in_array($v, array("", null))) return false; // On supprime les "" et les null
                else return true;
            },
            ARRAY_FILTER_USE_BOTH
        );

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->collectDolibarr($value);
            }
        }

        // return collect($data);
        return $data;
    }
}
