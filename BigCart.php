<?php

namespace Qisst\Oneclick\Model\Api;
use Qisst\Oneclick\Api\BigCartInterface;
class BigCart implements BigCartInterface
{

    public function __construct(
        \Magento\Config\Model\ResourceModel\Config $config,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->config = $config;
    }


    public function bigCartOrder($params){
        $cartId = $params['cartId'];
        $storeautho = $params['X-Auth-Token'];
        $storesec = $params['storesec'];
        $billing =  $params['billing_address'];
        $customerFirstname = $billing['first_name'];
        $customerLastname = $billing['last_name'];
        $billing = json_encode($billing);
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.bigcommerce.com/stores/c60ujnie4o/v3/carts/".$cartId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10000,
            CURLOPT_TIMEOUT => 300000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json",
                "X-Auth-Token: ".$storeautho
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo $response;
        }
        /* ************************* This is New Section for Cart API Start **************** */
        $obj = json_decode($response);
        //return $response;
        //return json_encode($obj->data->line_items->physical_items);

        $i = 0;
        $dantacart = [];
        $dantacartparent = [];
        $dantacartreturn = [];
        $dantacartcustomized = [];
        $datacompressor = 0;
        foreach ($obj->data->line_items->physical_items as $datacentera){
            //return $datacentera->product_id;
            $dantacart['sku'] = $datacentera->sku;
            $dantacart['productid'] = $datacentera->product_id;
            $dantacartcustomized['product_id'] = $datacentera->product_id;
            $dantacartcustomized['quantity'] = $datacentera->quantity;
            $dantacartcustomized['name_customer'] = $customerFirstname." ".$customerLastname;
            $dantacartcustomized['name_merchant'] = "BigCommerce";
            $dantacart['sku_id'] = $datacentera->variant_id;
            $dantacart['price'] = $datacentera->list_price;
            $dantacart['sale_price'] = $datacentera->sale_price;
            $dantacart['image_url'] = $datacentera->image_url;
            /* ################################################# Nested API for Product Variant ID */
            //if($datacentera->parent_id !== null ){
                //return $datacentera->parent_id;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.bigcommerce.com/stores/'.$storesec.'/v3/catalog/products/'.$dantacart['productid'].'/variants',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 1000,
                    CURLOPT_TIMEOUT => 100000,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-Auth-Token: '.$storeautho
                    ),
                ));
                $responsenested = curl_exec($curl);
                curl_close($curl);
                $objnested = json_decode($responsenested);
                $k = 0;
                $danta = [];
                foreach ($objnested->data as $datacenterb){
                    //return $datacenterb->option_values;
                    if ($datacenterb->sku == $dantacart['sku']) {
                        $danta['id'] = $datacenterb->id;
                        $danta['sku'] = $datacenterb->sku;
                        $danta['productid'] = $datacenterb->product_id;
                        $danta['sku_id'] = $datacenterb->sku_id;
                        $danta['price'] = $datacenterb->price;
                        $danta['calculated_price'] = $datacenterb->calculated_price;
                        $danta['sale_price'] = $datacenterb->sale_price;
                        $danta['is_free_shipping'] = $datacenterb->is_free_shipping;
                        $danta['image_url'] = $datacenterb->image_url;
                        $danta['option_values'] = $datacenterb->option_values;
                        $tempval = json_encode($danta['option_values']);
                       if($datacenterb->option_values){
                            //return $objnested->data[$k]->option_values;
                            echo "run 3" .$datacenterb->sku.":".$tempval;
                            //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                            //return json_encode($danta['option_values']);
                        }else{echo "run 2".$datacenterb->sku.":".json_encode($datacenterb->option_values);}
                        $j = 0;
                        $opt = [];
                        if ($datacenterb->option_values) {
                           foreach ($datacenterb->option_values as $decima) {
                               $opt[$j]['id'] = $decima->option_id;
                               $opt[$j]['value'] = $decima->id;
                               $j++;
                           }
                           //$opt = json_encode($opt);
                           $val = $opt;
                           $dantacartcustomized['product_options'] = $opt;
                           //return $opt;
                       }
                        //$dantacart['option_values'] = $val;
                       //return $datacenterb->option_values;
                      // if($datacenterb->option_values){$dantacartcustomized['product_options'] = $opt;}
                        //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                        //}
                    }
                }
               /* while($objnested->data[$k]->sku) {
                    if ($objnested->data[$k]->sku == $dantacart['sku']) {
                        $danta['id'] = $objnested->data[$k]->id;
                        $danta['sku'] = $objnested->data[$k]->sku;
                        $danta['productid'] = $objnested->data[$k]->product_id;
                        $danta['sku_id'] = $objnested->data[$k]->sku_id;
                        $danta['price'] = $objnested->data[$k]->price;
                        $danta['calculated_price'] = $objnested->data[$k]->calculated_price;
                        $danta['sale_price'] = $objnested->data[$k]->sale_price;
                        $danta['is_free_shipping'] = $objnested->data[$k]->is_free_shipping;
                        $danta['image_url'] = $objnested->data[$k]->image_url;
                        $danta['option_values'] = $objnested->data[$k]->option_values;
                        $tempval = json_encode($danta['option_values']);
                        if($tempval != '\[\]'){
                            //return $objnested->data[$k]->option_values;
                            echo "run 3" .$tempval;
                            //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                            //return json_encode($danta['option_values']);
                        }else{echo "run 2".$objnested->data[$k]->option_values;}

                        //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                        //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                        //}
                    }
                    echo "run ".$k;
                    $k++;
                    break;
                }//endwhile2*/
                echo "run outside";
            //}else{$dantacart['option_values'] = '[]';}
            /* ################################################# Nested API for Product Variant ID */
            $dantacartparent[$datacompressor] = $dantacart;
            $dantacartreturn[$datacompressor] = $dantacartcustomized;
            $datacompressor++;
        }
        /* Order API Hit here Start */
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.bigcommerce.com/stores/c60ujnie4o/v2/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"billing_address": ' . $billing . ',"products":'.json_encode($dantacartreturn).'}',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: 32nuh5grv0y5lhfpi4r6o7aczs7ik4n'
            ],
        ]);
        $responsesecure = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $responsesecure;
        }
        /* Order API Hit here Ends */




return json_encode($dantacartreturn);



        /*while ($obj->data->line_items->physical_items[$i]->id){
            //return $obj->data->line_items->physical_items[$i]->id;
            //$dantacart['id'] = $obj->data->line_items->physical_items[$i]->id;
            $dantacart['sku'] = $obj->data->line_items->physical_items[$i]->sku;
            $dantacart['productid'] = $obj->data->line_items->physical_items[$i]->product_id;
            $dantacart['sku_id'] = $obj->data->line_items->physical_items[$i]->variant_id;
            $dantacart['price'] = $obj->data->line_items->physical_items[$i]->list_price;
            $dantacart['sale_price'] = $obj->data->line_items->physical_items[$i]->sale_price;
            $dantacart['image_url'] = $obj->data->line_items->physical_items[$i]->image_url;
            /* ################################################# Nested API for Product Variant ID */
            /*if($obj->data->line_items->physical_items[$i]->parent_id != null ){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.bigcommerce.com/stores/'.$storesec.'/v3/catalog/products/'.$dantacart['productid'].'/variants',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 1000,
                CURLOPT_TIMEOUT => 100000,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'X-Auth-Token: '.$storeautho
                ),
            ));
            $responsenested = curl_exec($curl);
            curl_close($curl);
            $objnested = json_decode($responsenested);

            $k = 0;
            $danta = [];
            while($objnested->data[$k]->sku) {
                if ($objnested->data[$k]->sku == $dantacart['sku']) {
                    $danta['id'] = $objnested->data[$k]->id;
                    $danta['sku'] = $objnested->data[$k]->sku;
                    $danta['productid'] = $objnested->data[$k]->product_id;
                    $danta['sku_id'] = $objnested->data[$k]->sku_id;
                    $danta['price'] = $objnested->data[$k]->price;
                    $danta['calculated_price'] = $objnested->data[$k]->calculated_price;
                    $danta['sale_price'] = $objnested->data[$k]->sale_price;
                    $danta['is_free_shipping'] = $objnested->data[$k]->is_free_shipping;
                    $danta['image_url'] = $objnested->data[$k]->image_url;
                    $danta['option_values'] = $objnested->data[$k]->option_values;
                    $tempval = json_encode($danta['option_values']);
                    if($tempval != '\[\]'){
                        //return $objnested->data[$k]->option_values;
                        echo "run 3" .$tempval;
                        //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                     //return json_encode($danta['option_values']);
                    }else{echo "run 2".$objnested->data[$k]->option_values;}

                    //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                    //$dantacart['option_values'] = $objnested->data[$k]->option_values;
                    //}
                }
                echo "run ".$k;
                $k++;
                break;
            }
            echo "run outside";
            }else{$dantacart['option_values'] = '[]';}
            /* ################################################# Nested API for Product Variant ID */
            //if($i>0){return json_encode($dantacart);}
            //$dantacart['option_values'] = $obj->data[$i]->option_values;
                $i++;
//                if(!$obj->data->line_items->physical_items[]){
//                    break;
//                    //return json_encode($dantacart);
//                }
        //}
        /* ************************* This is New Section for Cart API Ends **************** */


//        $productId = $params['productid'];
//        $productSku = $params['sku'];
//        //$storesec = $params['storesec'];
//        //$storeautho = $params['X-Auth-Token'];
//        $billing =  $params['billing_address'];
//        $products =  $params['products'];
//        $billing = json_encode($billing);
//        $products = json_encode($products);
//        //return '{"billing_address": '.$billing.',"products":'.$products.'}';
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://api.bigcommerce.com/stores/'.$storesec.'/v3/catalog/products/'.$productId.'/variants',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'GET',
//            CURLOPT_HTTPHEADER => array(
//                'X-Auth-Token: '.$storeautho
//            ),
//        ));
//
//        $response = curl_exec($curl);
//
//        curl_close($curl);
        //echo $response;


        //$data = $response;
        //$data[0] = json_decode($response, true, JSON_UNESCAPED_SLASHES);
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
                "name_customer": "Customer",
                "name_merchant": "Qisstpay",
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
