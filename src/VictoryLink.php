<?php

namespace MElaraby\VictoryLink;

use GuzzleHttp\{Client, Exception\GuzzleException};
use JsonException;
use MElaraby\VictoryLink\DTO\RequestParameters;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class VictoryLink
{
    public mixed $response;
    private string $APIURL;
    private string $APIUSERNAME;
    private string $APIPASSWORD;

    public function __construct()
    {
        $this->APIURL = env('VICTORY_LINK_URL') . '?';
        $this->APIUSERNAME = env('VICTORY_LINK_USERNAME');
        $this->APIPASSWORD = env('VICTORY_LINK_PASSWORD');
    }

    /**
     * @param string $mobileNumber
     * @param string $text
     * @return $this|string
     * @throws JsonException
     */
    public function send(string $mobileNumber, string $text): string|static
    {
        try {
            $response = (new Client)
                ->get($this->APIURL, [
                    'query' => (new RequestParameters([
                        'SMSSender' => $this->APIUSERNAME,
                        'Username' => $this->APIUSERNAME,
                        'Password' => $this->APIPASSWORD,
                        'SMSText' => $text,
                        'SMSLang' => 'E',
                        'SMSReceiver' => $mobileNumber,
                    ]))->toArray()
                ])
                ->getBody()
                ->getContents();
            $this->response = $this->handleResponse($response);
        } catch (GuzzleException $e) {
            $this->response = $e->getMessage();
        } catch (UnknownProperties $e) {
            $this->response = $e->getMessage();
        }
        return $this;
    }

    /**
     * @param string $response
     * @return string
     * @throws JsonException
     */
    private function handleResponse(string $response): string
    {
        $response = $this->ConvertXMLToArray($response);
        return ResponseCodes::parseResponse((int)$response[0]);
    }

    /**
     * @param string $data
     * @return mixed
     * @throws JsonException
     */
    private function ConvertXMLToArray(string $data): mixed
    {
        $xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml, JSON_THROW_ON_ERROR);
        return json_decode($json, TRUE, 512, JSON_THROW_ON_ERROR);
    }


    /**
     * @param int $response
     * @return bool
     */
    public function isSuccess(int $response): bool
    {
        return ResponseCodes::isSuccess($response);
    }

    /**
     * @param int $response
     * @return bool
     */
    public function isFailed(int $response): bool
    {
        return ResponseCodes::isFailed($response);
    }
}
