<?php
declare(strict_types=1);

namespace Veiw\BotVAS\GTSInfoTel\Response;

use DV\MicroService\TraitContainer;
use DV\Service\UniqueGen;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Veiw\BotLogic\Core\ServiceProvider\ServiceProviderResponseInterface;
use Veiw\BotLogic\Presentation\Response\LogicResultResponse;
use Veiw\BotLogic\Presentation\Service\LogicResult;


class ShortcodeResponse implements ServiceProviderResponseInterface
{
    use TraitContainer ;

    /**
     * @var int
     * http://5.39.75.139:33115/message?user=julius&pass=jul@123&from=32811&to=(+234XXXXXXXXXX)&text=Testing&id=123456&dlrreq=1
     */

    const OK = 'ok' ;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container) ;
    }

    public function execute($responseEvent)
    {
        $response = $responseEvent->getResponse() ;
        ##
        $containerParams = $this->container->getParameterBag() ;

        /*
        * Only instance of LogicResult & LogicResultResponse can be mutated .
        */
        if(!$response instanceof LogicResultResponse && ! $response instanceof LogicResult)    {
            return ;
        }

        if($response instanceof LogicResultResponse)    {
            $logicResult = $response->getLogicResult() ;
        }else{
            $logicResult = $response ;
        }
        ##
        $triggerEvent = $logicResult->getEvent();
        /**
         * Fetch the triggerEvent Of LogicResult which will definitely have RequestParams

        $eventThatCallLogicResult['channel'] = $triggerEvent->getChannel()->getChannelName() ;
        $eventThatCallLogicResult['serviceProvider'] = $triggerEvent->getServiceProvider()->getName() ;*/

        $payload = [
            'headers' => [
                'Host' => $containerParams->get('GTSINFOTEL_HOST') ,
                "User-Agent" => 'Chrome/49.0.2587.3',
                'Accept' => 'text/html,application/xhtml+xml,application/xml'
            ] ,

            'on_headers' => function ($response) {
                ##
                if ($response->getStatusCode() != 200)  {
                    ##
                    return $response;
                }
            }
        ] ;

        /**
         *
         */
         $this->httpClient($triggerEvent->getServiceProvider()->getRequestType() , $this->prepareEndpoint($containerParams , $logicResult) , $payload) ;

         /**
          *
          */
         return new Response('ok') ;
    }

    public function getChannelName()
    {
        return CHANNEL_SMS_SHORTCODE ;
    }
    public function getServiceProviderName()
    {
        return SERVICE_PROVIDER_GTSINFOTEL ;
    }

    public function httpClient($method='GET' , $uri_endpoint , $payload)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request($method , $uri_endpoint , $payload) ;
    }

    protected function prepareEndpoint($params , LogicResult $logicResult)
    {
        /**
         * fetch GTSInfoTel URL ENpoing
         */
        $url_endpoint = $params->get('GTSINFOTEL_SMS_MT_ENDPOINT') ;
        ## http://%s:%d/message?user=%s&pass=%s&from=%d&to=%s&text=%s&id=%d&dlrreq=1
        ##
        $responseBody = ($logicResult->getFirstMessage());

        ##fetch the event that trigger the logicresult which we expect it to be BotKeywordEvent
        $triggerEvent = $logicResult->getEvent() ;

        ##
        $receiver = $triggerEvent->getReplyTo() ;

        ## id
        $responseId = UniqueGen::numberGen() ;

        /**
         *
         */
        $url_endpoint_string = sprintf($url_endpoint , $params->get('GTSINFOTEL_HOST') ,
                                                        $params->get('GTSINFOTEL_PORT') ,
                                                        $params->get('GTSINFOTEL_USERNAME') ,
                                                        $params->get('GTSINFOTEL_PASSWORD') ,
                                                        $params->get('GTSINFOTEL_SHORTCODE') ,
                                                        $receiver ,
                                                        $responseBody,
                                                        $responseId
        ) ;

        return $url_endpoint_string ;
    }
}