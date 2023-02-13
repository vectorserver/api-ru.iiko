<?php
//author - https://vk.com/vectorserver
//IikoTransport
// methods https://api-ru.iiko.services/

namespace iikoCloud;

use Exception;

class iikoCloud
{

    private $apiurl = 'https://api-ru.iiko.services/';
    private $accessToken;

    /**
     * @param $apikey
     * @throws Exception
     */
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
        $this->accessToken = $this->getToken();
    }


    //Get customer info by specified criterion.
    public function getCustomerinfo($params){


        $orgJSON = $this->getResponse('api/1/loyalty/iiko/customer/info', $params, $this->accessToken);

        return json_decode($orgJSON, true);
    }


    //Discounts / surcharges.
    public function getDiscounts($organizationIds = [])
    {
        $params = [
            'organizationIds' => $organizationIds,
        ];
        $orgJSON = $this->getResponse('api/1/discounts', $params, $this->accessToken);

        return json_decode($orgJSON, true);
    }

    //Discounts / surcharges.
    public function getGetprograms($organizationId)
    {
        $params = [
            'WithoutMarketingCampaigns' => true,
            'organizationId' => $organizationId,
        ];

        $data = $this->getResponse('api/1/loyalty/iiko/program', $params, $this->accessToken);

        return json_decode($data, true);
    }

    //Out-of-stock items. - stop_list

    /**
     * @param $organizationId
     * @return array|mixed
     * @throws Exception
     */
    public function getStopLists($organizationId)
    {
        $params = [
            "organizationIds" => [$organizationId]
        ];

        $requestJSON = $this->getResponse('api/1/stop_lists', $params, $this->accessToken);
        $response_arr = json_decode($requestJSON, true);
        $items = [];
        if ($response_arr['terminalGroupStopLists'][0]["organizationId"] == $organizationId) {
            $items = $response_arr['terminalGroupStopLists'][0]["items"];
        }

        return $items;
    }

    /**
     * @param $organizationId
     * @param $orderId
     * @return mixed
     * @throws Exception
     */
    public function closeOrder($organizationId, $orderId)
    {
        $params = [
            //"deliveryDate"=>date(),
            "orderId" => $orderId,
            "organizationId" => $organizationId,
        ];

        $requestJSON = $this->getResponse('api/1/deliveries/close', $params, $this->accessToken);
        $response_arr = json_decode($requestJSON, true);

        return $response_arr;
    }


    //Organizations
    public function getOrganizations()
    {
        $params = [
            'organizationIds' => '',
            'returnAdditionalInfo' => true,
            'includeDisabled' => false,
        ];
        $orgJSON = $this->getResponse('api/1/organizations', $params, $this->accessToken);

        $response_arr = json_decode($orgJSON, true);

        return $response_arr["organizations"];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getToken()
    {

        $params = ['apiLogin' => $this->apikey];
        $tokenJson = $this->getResponse('api/1/access_token', $params);

        $response_arr = json_decode($tokenJson, true);

        if ($response_arr["errorDescription"]) {
            throw new Exception('getToken: ' . $response_arr["errorDescription"]);
        }

        return $response_arr["token"];
    }


    //others
    public function clear_phone($phone) {
        $bad_simbol = array("8 (", "+7(", "+7 (", "8(", "(", ")", "-", "_", " ", "+7", "*");
        $result = str_replace($bad_simbol, "", $phone);
        $result = preg_replace("/[^,.0-9]/", '', $result);
        return substr($result, -10);
    }

    /**
     * @param $action
     * @param $params
     * @param $token
     * @return bool|string
     * @throws Exception
     */
    private function getResponse($action, $params, $token = '')
    {
        $url = $this->apiurl . $action;
        if ($token) {
            $auth = 'Authorization: Bearer ' . $token;
        } else {
            $auth = '';
        }

        $curl = curl_init();
        $curl_arr = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($params)),
                $auth
            ],
        );
        if ($params != '') {
            $curl_arr[CURLOPT_POSTFIELDS] = json_encode($params);
        }
        curl_setopt_array($curl, $curl_arr);

        $response = curl_exec($curl);
        curl_close($curl);

        if (!$response) {
            throw new Exception($action . ': error connect!');
        }


        return $response;
    }
}
