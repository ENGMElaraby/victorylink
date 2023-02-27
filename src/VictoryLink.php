<?php /** @noinspection PhpPropertyNamingConventionInspection */

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
            $response = $this->ConvertXMLToArray($response);
            $this->response = $this->parseResponse($response);
            return $this;
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (UnknownProperties $e) {
            return $e->getMessage();
        }
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
     * @param array $response
     * @return string
     */
    private function parseResponse(array $response): string
    {
        return match ((int)$response[0]) {
            ResponseCodes::SUCCESS->value => ResponseCodes::SUCCESS->name,
            ResponseCodes::UserIsNotSubscribed->value => ResponseCodes::UserIsNotSubscribed->name,
            ResponseCodes::OutOfCredit->value => ResponseCodes::OutOfCredit->name,
            ResponseCodes::QueuedMessageNoNeedToSendItAgain->value => ResponseCodes::QueuedMessageNoNeedToSendItAgain->name,
            ResponseCodes::InvalidLanguage->value => ResponseCodes::InvalidLanguage->name,
            ResponseCodes::SMSIsEmpty->value => ResponseCodes::SMSIsEmpty->name,
            ResponseCodes::InvalidFakeSenderExceeded12CharsOrEmpty->value => ResponseCodes::InvalidFakeSenderExceeded12CharsOrEmpty->name,
            ResponseCodes::SendingRateGreaterThanReceivingRateOnlyForSendReceiveAccounts->value => ResponseCodes::SendingRateGreaterThanReceivingRateOnlyForSendReceiveAccounts->name,
            ResponseCodes::OtherError->value => ResponseCodes::OtherError->name,
            default => ResponseCodes::FAILED->name
        };
    }
}
