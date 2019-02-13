<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    private $params = [];

    /**
     * Показать форму ввода заказа
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $this->params['user'] = $request->user();
        return view('order', $this->params);
    }

    /**
     * Создать заказ
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $region = 'Ростовская область';
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:100',
                'order' => 'required|string|max:200',
                'city' => 'required|string|max:100',
                'adres' => 'required|string|max:200',
            ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        //Запросить координаты
        $url_send = implode('?geocode=', ['https://geocode-maps.yandex.ru/1.x/', $region . ',' . $request->city . ',' . $request->adres]);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_send);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $rezult = curl_exec($curl);
        curl_close($curl);

        $xml = simplexml_load_string($rezult);
        $arr = $this->xml2array(json_decode(json_encode((array)$xml, true)));

        //Проверить координаты
        if(1 != $arr['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found']){
            $validator->errors()->add('rezult', 'По данному адресу невозможно определить координаты - проверте правильность ввода "Города" и "Адреса"');
            return back()->withErrors($validator)->withInput();
        }
        //Проверить наличие координат
        if(!$arr['GeoObjectCollection']['featureMember']['GeoObject']['Point']['pos']) {
            $validator->errors()->add('rezult', 'Пустые координаты - проверте правильность ввода "Города" и "Адреса"');
            return back()->withErrors($validator)->withInput();
        }

        $arC = explode(' ', $arr['GeoObjectCollection']['featureMember']['GeoObject']['Point']['pos']);
        $cW = $arC[0];
        $cL = $arC[1];
        //Данные координаты всей ростовской области
        if(41.268128 == $cW && 47.728732 == $cL){
            $validator->errors()->add('rezult', 'Не верные координаты - проверте правильность ввода "Города" и "Адреса"');
            return back()->withErrors($validator)->withInput();
        }

        //сохранить заказ
        Order::create(
            [
                'user_id' => $request->user()->id,
                'fio' => $request->name,
                'city' => $request->city,
                'address' => $request->adres,
                'order' => $request->order,
                'coord_w' => $cW,
                'coord_l' => $cL
            ]
        );

        return redirect()->route('index');
    }

    /**
     * Преобразовать из simpleXml в массив
     * @param $xmlObject
     * @return array
     */
    private function xml2array($xmlObject)
    {
        $out = [];
        foreach((array)$xmlObject as $index=>$node)
            $out[$index] = (is_object($node)) ? $this->xml2array($node) : $node;
        return $out;
    }
}
