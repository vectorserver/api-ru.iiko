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
     * @var
     */
    public $organizationId;
    public $terminalId;
    private $apikey;


    /**
     * IikoCloud API (1.0.0)
     * @param $apikey
     * @throws Exception
     * @version 1.0.0
     */
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
        $this->accessToken = $this->getToken();

    }

    //organizations

    /**
     * Возвращает организации, доступные пользователю
     * @return mixed
     * @throws Exception
     */
    public function getOrganizations()
    {
        $params = [
            'organizationIds' => '',
            'returnAdditionalInfo' => true,
            'includeDisabled' => false,
        ];

        return $this->getResponse('api/1/organizations', $params);


    }

    /**
     * Получаем ID организации
     * extends getOrganizations
     * @return mixed
     * @see getOrganizations
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    /**
     * Запишем ID организации
     * extends getOrganizations
     * @param mixed $organizationId
     * @see getOrganizations
     */
    public function setOrganizationId($organizationId): void
    {
        $this->organizationId = $organizationId;
    }


    /**
     * Терминальные группы<br>
     * Метод, возвращающий информацию о группах терминалов доставки.
     * https://api-ru.iiko.services/#tag/Terminal-groups/paths/~1api~11~1terminal_groups/post
     * @param array $params
     * @return mixed
     * @throws Exception
     * @example
     */
    public function getTerminalGroups(array $params = [])
    {
        $paramsDef = [
            'organizationIds' => [$this->organizationId],
            'includeDisabled' => false,
        ];

        $params = array_merge($paramsDef, $params);

        return $this->getResponse('api/1/terminal_groups', $params);


    }

    /**
     * extends getTerminalGroups
     * @return mixed
     * @see getTerminalGroups
     */
    public function getTerminalId()
    {
        return $this->terminalId;
    }

    /**
     * extends getTerminalGroups
     * @param mixed $terminalId
     * @see getTerminalGroups
     */
    public function setTerminalId($terminalId): void
    {
        $this->terminalId = $terminalId;
    }


    /**
     * Возвращает информацию о наличии группы терминалов.
     * https://api-ru.iiko.services/#tag/Terminal-groups/paths/~1api~11~1terminal_groups~1is_alive/post
     * @param array $organizationIds
     * @param array $terminalGroupIds
     * @return mixed
     * @throws Exception
     */
    public function getTerminalGroupsIsAlive(array $organizationIds = [], array $terminalGroupIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
            'terminalGroupIds' => $terminalGroupIds,
        ];

        return $this->getResponse('api/1/terminal_groups/is_alive', $paramsDef);

    }

    /**
     * Группы терминалов пробуждения из спящего режима.
     * https://api-ru.iiko.services/#tag/Terminal-groups/paths/~1api~11~1terminal_groups~1awake/post
     * @param array $organizationIds
     * @param array $terminalGroupIds
     * @return mixed
     * @throws Exception
     */
    public function getTerminalGroupsAwake(array $organizationIds = [], array $terminalGroupIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
            'terminalGroupIds' => $terminalGroupIds,
        ];

        return $this->getResponse('api/1/terminal_groups/awake', $paramsDef);

    }

    /**
     * Причины отмены доставки
     * https://api-ru.iiko.services/api/1/cancel_causes
     * @param array $organizationIds
     * @return mixed
     * @throws Exception
     */
    public function cancelCauses(array $organizationIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
        ];

        return $this->getResponse('api/1/cancel_causes', $paramsDef);

    }

    /**
     * Типы ордеров.
     * https://api-ru.iiko.services/#tag/Dictionaries/paths/~1api~11~1deliveries~1order_types/post
     * @param array $organizationIds
     * @return mixed
     * @throws Exception
     */
    public function orderTypes(array $organizationIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
        ];

        return $this->getResponse('api/1/deliveries/order_types', $paramsDef);

    }

    /**
     * Скидки / доплаты.
     * https://api-ru.iiko.services/#tag/Dictionaries/paths/~1api~11~1discounts/post
     * @param array $organizationIds
     * @return mixed
     * @throws Exception
     */
    public function getDiscounts(array $organizationIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
        ];

        return $this->getResponse('api/1/discounts', $paramsDef);

    }


    /**
     * Получите все программы лояльности для организации.
     * https://api-ru.iiko.services/#tag/Discounts-and-promotions/paths/~1api~11~1loyalty~1iiko~1program/post
     * @param $organizationId
     * @return mixed
     * @throws Exception
     */
    public function getGetprograms($organizationId)
    {
        $params = [
            'WithoutMarketingCampaigns' => true,
            'organizationId' => $organizationId,
        ];


        return $this->getResponse('api/1/loyalty/iiko/program', $params);
    }

    /**
     * Виды платежей.
     * https://api-ru.iiko.services/#tag/Dictionaries/paths/~1api~11~1payment_types/post
     * @param array $organizationIds
     * @return mixed
     * @throws Exception
     */
    public function paymentTypes(array $organizationIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
        ];

        return $this->getResponse('api/1/payment_types', $paramsDef);

    }

    /**
     * Типы удаления (причины удаления).
     * https://api-ru.iiko.services/#tag/Dictionaries/paths/~1api~11~1removal_types/post
     * @param array $organizationIds
     * @return mixed
     * @throws Exception
     */
    public function removalTypes(array $organizationIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
        ];

        return $this->getResponse('api/1/removal_types', $paramsDef);

    }

    /**
     * Get customer info
     * https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1info/post
     *
     * format +79126967777
     * @param $organizationId
     * @param string $type
     * @param string $input
     * @return mixed
     * @throws Exception
     */
    public function getCustomerinfo($organizationId, $type = 'phone', $input)
    {
        $params = [
            $type => $input,
            'type' => $type,
            'organizationId' => $organizationId,
        ];

        return $this->getResponse('api/1/loyalty/iiko/customer/info', $params);
    }


    /**
     * Получите советы для группы rms api-login.
     * https://api-ru.iiko.services/#tag/Dictionaries/paths/~1api~11~1tips_types/post
     * @return mixed
     * @throws Exception
     */
    public function tipsTypes()
    {

        return $this->getResponse('api/1/tips_types', []);

    }


    /**
     * номенклатура
     * https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1nomenclature/post
     * @param  $organizationIds
     * @return mixed
     * @throws Exception
     */
    public function getNomenclature($organizationId)
    {
        $paramsDef = [
            'organizationId' => $organizationId,
            'startRevision' => 0,
        ];

        return $this->getResponse('api/1/nomenclature', $paramsDef);

    }


    /**
     * Меню
     * https://api-ru.iiko.services/#tag/Menu/paths/~1api~12~1menu/post
     * @return mixed
     * @throws Exception
     */
    public function getMenu()
    {
        $paramsDef = [];
        return $this->getResponse('api/2/menu', $paramsDef);

    }

    /**
     * Получение внешнего меню по идентификатору.
     * https://api-ru.iiko.services/#tag/Menu/paths/~1api~12~1menu~1by_id/post
     * @param array $organizationIds
     * @param string $externalMenuId
     * @param string $priceCategoryId
     * @return mixed
     * @throws Exception
     */
    public function getMenubyId(array $organizationIds = [], string $externalMenuId = '', string $priceCategoryId = '')
    {
        $paramsDef = [
            'externalMenuId' => $externalMenuId,
            'organizationIds' => $organizationIds,
            'priceCategoryId' => $priceCategoryId,
            'version' => 0,
        ];
        return $this->getResponse('api/2/menu/by_id', $paramsDef);

    }


    /**
     * Товары, которых нет в наличии.
     * https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1stop_lists/post
     * @param array $organizationIds
     * @return mixed
     * @throws Exception
     */
    public function getStoplists(array $organizationIds = [])
    {
        $paramsDef = [
            'organizationIds' => $organizationIds,
        ];

        return $this->getResponse('api/1/stop_lists', $paramsDef);

    }

    /**
     * Получить информацию о комбо
     * https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1combo/post
     * @param  $organizationId
     * @return mixed
     * @throws Exception
     */
    public function getCombo($organizationId)
    {
        $paramsDef = [
            'extraData' => true,
            'organizationId' => $organizationId,
        ];

        return $this->getResponse('api/1/combo', $paramsDef);

    }

    /**
     * Рассчитать комбинированную цену
     * https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1combo~1calculate/post
     * @param $organizationId
     * @param array $items
     * @return mixed
     * @throws Exception
     */
    public function getComboCalculate($organizationId, array $items = [])
    {
        $paramsDef = [
            'items' => $items,
            'organizationId' => $organizationId,
        ];

        return $this->getResponse('api/1/combo/calculate', $paramsDef);

    }

    /**
     * Закрыть заказ
     * https://api-ru.iiko.services/#tag/Deliveries:-Create-and-update/paths/~1api~11~1deliveries~1close/post
     * @param $organizationId
     * @param $orderId
     * @return mixed
     * @throws Exception
     */
    public function closeOrder($organizationId, $orderId)
    {
        $params = [
            "orderId" => $orderId,
            "organizationId" => $organizationId,
        ];


        return $this->getResponse('api/1/deliveries/close', $params);
    }


    /**
     *Deliveries: Create and update
     * https://api-ru.iiko.services/#tag/Deliveries:-Create-and-update
     * @param array $order
     * @return mixed
     * @throws Exception
     */
    public function sendOrder($organizationId, $terminalGroupId = '', array $order = [])
    {

        $testOrder = [
            "id" => "497f6eca-6276-4993-bfeb-53cbbbba6f08",
            "externalNumber" => "string",
            "completeBefore" => "2019-08-24 14:15:22.123",
            "phone" => "stringst",
            "orderTypeId" => "c21c7b56-cdb7-4141-bc14-77df36146699",
            "orderServiceType" => "DeliveryByCourier",
            "deliveryPoint" => [
                "coordinates" => [
                    "latitude" => 0,
                    "longitude" => 0
                ],
                "address" => [
                    "street" => [
                        "classifierId" => "string",
                        "id" => "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                        "name" => "test",
                        "city" => "tagil"
                    ],
                    "index" => "string",
                    "house" => "string",
                    "building" => "string",
                    "flat" => "string",
                    "entrance" => "string",
                    "floor" => "string",
                    "doorphone" => "string",
                    "regionId" => "a29f01e1-8a8d-451e-b685-f8b0b4ec4767"
                ],
                "externalCartographyId" => "string",
                "comment" => "string"
            ],
            "comment" => "string",
            "customer" => [
                "type" => "string"
            ],
            "guests" => [
                "count" => 0,
                "splitBetweenPersons" => true
            ],
            "marketingSourceId" => "1a99aa80-99e1-4c2a-a8ab-de5af5e04338",
            "operatorId" => "373c4133-3dda-4217-938b-a5730b9cc41a",
            "items" => [
                [
                    "type" => "string",
                    "amount" => 0,
                    "productSizeId" => "b4513563-032a-4dbc-8894-4b05c402f7de",
                    "comboInformation" => [
                        "comboId" => "1fa22bdf-8ea5-4d3f-a6cf-3abb16e9aa74",
                        "comboSourceId" => "dd3c663c-f4a0-4960-be17-31d91758b3a4",
                        "comboGroupId" => "2cb9710d-2ed9-4514-8333-275a9727b4dd"
                    ],
                    "comment" => "string"
                ]
            ],
            "payments" => [
                [
                    "paymentTypeKind" => "string",
                    "sum" => 0,
                    "paymentTypeId" => "a681b746-24d1-4f1c-aa71-6af3f1e19567",
                    "isProcessedExternally" => true,
                    "paymentAdditionalData" => [
                        "type" => "string"
                    ],
                    "isFiscalizedExternally" => true
                ]
            ],
            "tips" => [
                [
                    "paymentTypeKind" => "string",
                    "tipsTypeId" => "e8b7f419-5ea5-4f5b-b897-d30febf1d59c",
                    "sum" => 0,
                    "paymentTypeId" => "a681b746-24d1-4f1c-aa71-6af3f1e19567",
                    "isProcessedExternally" => true,
                    "paymentAdditionalData" => [
                        "type" => "string"
                    ],
                    "isFiscalizedExternally" => true
                ]
            ],
            "sourceKey" => "string",
            "discountsInfo" => [
                "card" => [
                    "track" => "string"
                ],
                "discounts" => [
                    [
                        "type" => "string"
                    ]
                ]
            ],
            "iikoCard5Info" => [
                "coupon" => "string",
                "applicableManualConditions" => [
                    "497f6eca-6276-4993-bfeb-53cbbbba6f08"
                ]
            ]
        ];


        $params = [
            'organizationId' => $organizationId,
            'terminalGroupId' => $terminalGroupId,
            'createOrderSettings' => [
                "transportToFrontTimeout" => 0
            ],
            'order' => empty($order) ? $testOrder : $order,
        ];


        return $this->getResponse('api/1/deliveries/create', $params);
    }


    /**
     * Вывести баланс.
     * https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1wallet~1topup/post
     * @param string $customerId
     * @param string $walletId
     * @param float $sum
     * @param string $comment
     * @param $organizationId
     * @return mixed
     * @throws Exception
     */
    public function withdrawBalance(string $customerId, string $walletId, float $sum, string $comment, $organizationId)
    {

        $params = [
            'customerId' => $customerId,
            'walletId' => $walletId,
            'sum' => $walletId,
            'comment' => $comment,
            'organizationId' => $organizationId,
        ];

        return $this->getResponse('api/1/loyalty/iiko/customer/wallet/chargeoff', $params);

    }

    public function holdBalance($params)
    {

        $data = $this->getResponse('api/1/loyalty/iiko/customer/wallet/hold', $params, $this->accessToken);

        return json_decode($data, true);
    }


    /**
     * Получите ключ (token) сеанса для пользователя API.
     * @return string
     * @throws Exception
     */
    public function getToken(): string
    {

        $params = ['apiLogin' => $this->apikey];
        $response_arr = $this->getResponse('api/1/access_token', $params);

        if ($response_arr["errorDescription"]) {
            throw new Exception('getToken: ' . $response_arr["errorDescription"]);
        }

        return $response_arr["token"];
    }


    /**
     * @param $action
     * @param $params
     * @param $token
     * @return mixed
     */
    private function getResponse($action, $params)
    {
        $url = $this->apiurl . $action;
        if ($this->accessToken) {
            $auth = 'Authorization: Bearer ' . $this->accessToken;
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


        if (!$response) {
            throw new Exception($action . ': error connect! - ' . curl_error($curl));
        } else {
            $response = json_decode($response, true);
        }
        curl_close($curl);

        return $response;
    }


    /**
     * clear_phone
     * @param $phone
     * @return false|string
     */
    public function clear_phone($phone)
    {
        $bad_simbol = array("8 (", "+7(", "+7 (", "8(", "(", ")", "-", "_", " ", "+7", "*");
        $result = str_replace($bad_simbol, "", $phone);
        $result = preg_replace("/[^,.0-9]/", '', $result);
        return substr($result, -10);
    }


}
