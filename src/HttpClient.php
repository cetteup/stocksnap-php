<?php
namespace Diza\Stocksnap;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class HttpClient
{
  private $client;
  private $api_url;

  public function __construct()
  {
    $this->client = new Client();
    $this->api_url = 'https://stocksnap.io/api';
  }

  public function all_photos($order_by = 'date', $sort_order = 'desc', $page = 1)
  {
    if (!is_string($order_by) || !is_string($sort_order) || !is_int($page)) return null;
    $photos = $this->send_request('GET','load-photos/'.$order_by.'/'.$sort_order.'/'.$page);

    return $photos;
  }

  public function author_photos($author_id,$page = 1)
  {
    if (!is_int($author_id) || !is_int($page)) return null;
    $photos = $this->send_request('GET','author-photos/'.$author_id.'/'.$page);
    return $photos;
  }

  private function send_request($method,$endpoint)
  {
    try {
      $request = new Request($method,$this->api_url.'/'.$endpoint);
      $response = $this->client->send($request);
    } catch (RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
        $status = $response->getStatusCode();
        if ($status == 404) {
          throw new Exception('404 not found');
        }
      }
    }
    return new ResponseArray(
      $response->getHeaders(),
      json_decode($response->getBody(),true)
    );
  }
}
?>
