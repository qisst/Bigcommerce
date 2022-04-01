<?php

namespace Qisst\Oneclick\Model\Api;
use Qisst\Oneclick\Api\BigInterface;
class Big implements BigInterface
{

    public function __construct(
        \Magento\Config\Model\ResourceModel\Config $config,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->config = $config;
    }


    public function bigOrder($params){



        $productId = $params['productid'];
        $productSku = $params['sku'];
        $storesec = $params['storesec'];
        $storeautho = $params['X-Auth-Token'];
        $billing =  $params['billing_address'];
        $products =  $params['products'];
        $billing = json_encode($billing);
        $products = json_encode($products);
        //return '{"billing_address": '.$billing.',"products":'.$products.'}';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bigcommerce.com/stores/'.$storesec.'/v3/catalog/products/'.$productId.'/variants',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-Auth-Token: '.$storeautho
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;


        //$data = $response;
        $data[0] = json_decode($response, true, JSON_UNESCAPED_SLASHES);
        //$data = json_decode( html_entity_decode( stripslashes ($response ) ) );
        //$res =  $response;
        //$data = substr($data, 1, -1);
        $key = "sku";
        //$skuval = $data['sku'];
        $prod = '';

//        foreach ($data  as $item) {
//            if ($item->sku == "rubish-GR-LA") {
//                $prod = $item->product_id;
//            }
//        }



        //$data = str_replace("\\", "",$response);
        $obj = json_decode($response);
        $i = 0;
        $danta = [];
        $nett = [];
        //return $danta;
        while($obj->data[$i]->sku) {
            if ($obj->data[$i]->sku == $productSku) {
                //$danta = $obj->data[$i]->sku;
                //$danta = $obj->data[$i]->sku;
                //$danta['sku'] = $obj->data[$i]->sku;
                //$danta[""] = "Kevin Amayi";
                //$danta['sku'] = $obj->data[$i]->sku;
                //array_push($danta, "sku", $obj->data[$i]->sku);
                $danta['id'] = $obj->data[$i]->id;
                $danta['sku'] = $obj->data[$i]->sku;
                $danta['productid'] = $obj->data[$i]->product_id;
                $danta['sku_id'] = $obj->data[$i]->sku_id;
                $danta['price'] = $obj->data[$i]->price;
                $danta['calculated_price'] = $obj->data[$i]->calculated_price;
                $danta['sale_price'] = $obj->data[$i]->sale_price;
                $danta['is_free_shipping'] = $obj->data[$i]->is_free_shipping;
                $danta['image_url'] = $obj->data[$i]->image_url;
                $danta['option_values'] = $obj->data[$i]->option_values;
                $j = 0;
                $opt = [];
                //$nett = $obj->data[$i]->option_values;
                // $nett = json_encode($nett);
                //$nett = json_decode($nett);
                //return $nett[0];
                //return $nett;
                if ($obj->data[$i]->option_values) {


                    while ($j < 2) {
                        //return $obj->data[$i]->option_values[$j]->id;
                        $opt[$j]['id'] = $obj->data[$i]->option_values[$j]->option_id;
                        $opt[$j]['value'] = $obj->data[$i]->option_values[$j]->id;
                        $j++;
                    }
                    $opt = json_encode($opt);
                    //return $opt;
                    //$val = '[{"id":68,"display_name": "Size","url": "https://api.bigcommerce.com/stores/c60ujnie4o/v2/products/77/options/108","resource": "/products/77/options/108"}]';
//return $danta['option_values'];
                    $val = $opt;
                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL => 'https://api.bigcommerce.com/stores/c60ujnie4o/v2/orders',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{"billing_address": ' . $billing . ',"products":[
            {
                "product_id": ' . $obj->data[$i]->product_id . ',
                "product_options": ' . $val . ',
                "name_customer": "Zaheer",
                "name_merchant": "Zaheer",
                "quantity": 1         
            }
        ]}',
                        CURLOPT_HTTPHEADER => [
                            'Accept: application/json',
                            'Content-Type: application/json',
                            'X-Auth-Token: 32nuh5grv0y5lhfpi4r6o7aczs7ik4n'
                        ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }
                }else{
                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL => 'https://api.bigcommerce.com/stores/c60ujnie4o/v2/orders',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{"billing_address": ' . $billing . ',"products":[
            {
                "product_id": ' . $obj->data[$i]->product_id . ',
                "name_customer": "Zaheer",
                "name_merchant": "Zaheer",
                "quantity": 1         
            }
        ]}',
                        CURLOPT_HTTPHEADER => [
                            'Accept: application/json',
                            'Content-Type: application/json',
                            'X-Auth-Token: 32nuh5grv0y5lhfpi4r6o7aczs7ik4n'
                        ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }
                }
                return json_encode($danta);
            }
            $i++;
        }
        return $i;
    }
}
