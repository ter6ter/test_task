<?php

namespace app\models;

use GuzzleHttp;

class GithubApi
{
    public $apiUrl;
    public $token;

    private function query($query, $params = [])
    {
        $client = new GuzzleHttp\Client(['headers' =>
            ['Authorization' => 'token '.$this->token]]);
        if (count($params)) {
            $params = ['query' => $params];
        }
        try {
            $res = $client->get($this->apiUrl . $query, $params);
            if ($res->getStatusCode() == 200) {
                $response = json_decode($res->getBody());
                return $response;
            }
        } catch (GuzzleHttp\Exception\ClientException $e) {
            return false;
        }
    }

    public function getUser($username)
    {
        $response = $this->query('users/' . urlencode($username));
        if (isset($response->id)) {
            return $response->id;
        } else {
            return false;
        }
    }

    public function getRepos($username)
    {
        $response = $this->query('users/' . urlencode($username) . '/repos',
            ['sort' => 'updated_at',
             'direction' => 'desc',
             'per_page' => 10]);
        if (is_array($response)) {
            return $response;
        } else {
            return false;
        }
    }
}