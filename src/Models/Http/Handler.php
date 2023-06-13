<?php

namespace Src\Models\Http;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use Src\Models\Api;
use Src\Models\Api\WB\Pager;
use Src\Models\Graber\WB;

class Handler
{
    protected ?Api $api = null;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function getData(): WB
    {
        $client = $this->api->getClient();

        try {
            $response = $client->request('POST', $this->api->getHost());
        } catch (RequestException $requestException) {
            return $requestException->getMessage();
        } catch (ConnectException $connectException) {
            throw new \Exception('check connection to internet');
        } catch (TooManyRedirectsException $manyRedirectsException) {
            throw new \Exception('Too many redirect!');
        } catch (BadResponseException $badResponseException) {
            throw new \Exception('not valid request');
        }

        $responseData = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (isset($responseData['value']['data']['model']['pagerModel']['pagingInfo'])) {
            $pages = $this->getPagesModel();

            $pages = $pages->calcPages($responseData['value']['data']['model']['pagerModel']['pagingInfo'], $this->api->getHost());

            $graber = new WB();

            foreach ($pages->pages as $page) {
                try {
                    $responseProducts = $client->request('POST', $page);
                } catch (RequestException $requestException) {
                    throw new \Exception('error remote server');
                } catch (ConnectException $connectException) {
                    throw new \Exception('check connection to internet');
                } catch (TooManyRedirectsException $manyRedirectsException) {
                    throw new \Exception('Too many redirect!');
                } catch (BadResponseException $badResponseException) {
                    throw new \Exception('not valid request');
                }

                $responseProductsData = json_decode($responseProducts->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

                if (isset($responseProductsData['value']['data']['model']['products']) &&
                    count($responseProductsData['value']['data']['model']['products']) > 0) {

                    foreach ($responseProductsData['value']['data']['model']['products'] as $productData) {
                        if (isset($productData['nmId'], $productData['name'])) {
                            $graber->addProduct($productData['nmId'], $productData['name']);
                        } else {
                            throw new \Exception('not found nmId or name');
                        }
                    }
                }
            }

            return $graber;

        } else {
            throw new \Exception('not found page data');
        }
    }


    protected function getPagesModel()
    {
        return new Pager();
    }
}