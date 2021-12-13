<?php

$this->device_types=array(
    'users'=>array(
        'CLASS'=>'Users',
        'DESCRIPTION'=>'Пользователи системы',
        'PROPERTIES'=>array(
            'coordinates'=>array('DESCRIPTION'=>'Координаты расположения пользователя','KEEP_HISTORY'=>10,),
            'address'=>array('DESCRIPTION'=>'Адрес расположения пользователя'),
        ),
        'METHODS'=>array(
            //'changeLocation'=>array('DESCRIPTION'=>'User change location'),
            //'onIdle'=>array('DESCRIPTION'=>'Rooms Idle'),
            //'updateActivityStatus'=>array('DESCRIPTION'=>'Update activity status')
        )
    ),
    'rooms'=>array(
        'CLASS'=>'Rooms',
        'DESCRIPTION'=>'Rooms/Locations',
        'PROPERTIES'=>array(
            'temperature'=>array('DESCRIPTION'=>'Температура','KEEP_HISTORY'=>30),
            'humidity'=>array('DESCRIPTION'=>'Влажность','KEEP_HISTORY'=>30),
            'pressure'=>array('DESCRIPTION'=>'Давление','KEEP_HISTORY'=>30),
            'volt'=>array('DESCRIPTION'=>'Напряжение','KEEP_HISTORY'=>30),
            'light'=>array('DESCRIPTION'=>'Освещенность','KEEP_HISTORY'=>30),
            'opened'=>array('DESCRIPTION'=>'Состояние открытости комнаты','KEEP_HISTORY'=>30),
            'EconomMode'=>array('DESCRIPTION'=>'Режим економии в помещении'),
            //'SomebodyHere'=>array('DESCRIPTION'=>'Somebody in the room'),
            //'IdleDelay'=>array('DESCRIPTION'=>'Nobody here idle delay'),
        ),
        'METHODS'=>array(
            'EconomModeswitch'=>'Активация економ режима в комнате',
            //'onActivity'=>array('DESCRIPTION'=>'Rooms Activity'),
            //'onIdle'=>array('DESCRIPTION'=>'Rooms Idle'),
            //'updateActivityStatus'=>array('DESCRIPTION'=>'Update activity status')
        )
    ),
    'general'=>array(
        'CLASS'=>'SDevices',
        'DESCRIPTION'=>'General Devices Class',
        'PROPERTIES'=>array(
            'alive'=>array('DESCRIPTION'=>'Состояние устройства'),
            'timeChek'=>array('DESCRIPTION'=>'Период обновления состояния устройства в минутах','_CONFIG_TYPE'=>'text'),
            'linkedRoom'=>array('DESCRIPTION'=>'Местоположение устройства'),
            'updated'=>array('DESCRIPTION'=>'Updated Timestamp'),// обязателен для проверки обратной связи цикл MAIN запускает методы
            //'status'=>array('DESCRIPTION'=>LANG_DEVICES_STATUS, 'KEEP_HISTORY'=>365, 'ONCHANGE'=>'statusUpdated', 'DATA_KEY'=>1),
            //'aliveTimeout'=>array('DESCRIPTION'=>LANG_DEVICES_ALIVE_TIMEOUT,'_CONFIG_TYPE'=>'num','_CONFIG_HELP'=>'SdAliveTimeout'),
            
        ),
        'METHODS'=>array(
            //'updateStatus'=>array('DESCRIPTION'=>'Обновление статуса устройтва','_CONFIG_SHOW'=>1),
            //'statusUpdated'=>array('DESCRIPTION'=>'Status updated event'),
            //'logicAction'=>array('DESCRIPTION'=>'Logic Action'),
            //'keepAlive'=>array('DESCRIPTION'=>'Alive update'),
        ),
        'INJECTS'=>array(
            'OperationalModes'=>array(
                //'EconomMode.activate'=>'econommode_activate',
                //'EconomMode.deactivate'=>'econommode_deactivate',
                //'NobodyHomeMode.activate'=>'nobodyhomemode_activate',
                //'NobodyHomeMode.deactivate'=>'nobodyhomemode_deactivate',
                //'NightMode.activate'=>'nightmode_activate',
                //'DarknessMode.activate'=>'darknessmode_activate',
                //'DarknessMode.deactivate'=>'darknessmode_deactivate',
                //'System.checkstate'=>'system_checkstate',
            ),
        )
    ),
    'controller'=>array(
        'CLASS'=>'SControllers',
        'PARENT_CLASS'=>'SDevices',
        'DESCRIPTION'=>'Управляемые устройства',
        'PROPERTIES'=>array(
            'groupEcoOn'=>array('DESCRIPTION'=>'Выключать устройство при входе в режим економии','_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupEcoOn'),
            'groupEcoOff'=>array('DESCRIPTION'=>'Включать устройство при выходе в режим економии','_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupEcoOff'),
            'groupSunriseOn'=>array('DESCRIPTION'=>'Включать устройство при закате','_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupSunriseOn'),
            'groupSunriseOff'=>array('DESCRIPTION'=>'Выключать устройство при закате','_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupSunriseOff'),
            'groupSunsetOn'=>array('DESCRIPTION'=>'Включать устройство при восходе','_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupSunsetOn'),
            'groupSunsetOff'=>array('DESCRIPTION'=>'Выключать устройство при восходе','_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupSunsetOff'),
            //'groupNight'=>array('DESCRIPTION'=>LANG_DEVICES_GROUP_NIGHT,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupNight'),
            //'isActivity'=>array('DESCRIPTION'=>LANG_DEVICES_IS_ACTIVITY,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdIsActivity'),
            'loadType'=>array('DESCRIPTION'=>LANG_DEVICES_LOADTYPE,
                '_CONFIG_TYPE'=>'select','_CONFIG_HELP'=>'SdLoadType',
                '_CONFIG_OPTIONS'=>'light='.LANG_DEVICES_LOADTYPE_LIGHT.
                    ',heating='.LANG_DEVICES_LOADTYPE_HEATING.
                    ',vent='.LANG_DEVICES_LOADTYPE_VENT.
                    ',curtains='.LANG_DEVICES_LOADTYPE_CURTAINS.
                    ',gates='.LANG_DEVICES_LOADTYPE_GATES.
                    ',power='.LANG_DEVICES_LOADTYPE_POWER),
            'icon'=>array('DESCRIPTION'=>LANG_IMAGE,'_CONFIG_TYPE'=>'style_image','_CONFIG_HELP'=>'SdIcon'),
        ),
        'METHODS'=>array(
            //'turnOn'=>array('DESCRIPTION'=>LANG_DEVICES_TURN_ON,'_CONFIG_SHOW'=>1),
            //'turnOff'=>array('DESCRIPTION'=>LANG_DEVICES_TURN_OFF,'_CONFIG_SHOW'=>1),
            //'switch'=>array('DESCRIPTION'=>'Switch'),
        )
    ),
    'Sockets'=>array(
        'CLASS'=>'SSockets',
        'PARENT_CLASS'=>'SControllers',
        'DESCRIPTION'=>'Класс управления розетками',
        'PROPERTIES'=>array(
            //'coordinates'=>array('DESCRIPTION'=>'Координаты расположения устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'updateAdress'),
            //'address'=>array('DESCRIPTION'=>'Адрес местонахождения устройства'),
            //'speed'=>array('DESCRIPTION'=>'Скорость'),
        ),
        'METHODS'=>array(
            //'updateAdress'=>array('DESCRIPTION'=>'Обновление адреса при изменении координат'),
            //'turnOff'=>array('DESCRIPTION'=>LANG_DEVICES_TURN_OFF,'_CONFIG_SHOW'=>1),
            //'switch'=>array('DESCRIPTION'=>'Switch'),
        )
    ),
    'Humidifiers'=>array(
        'CLASS'=>'SHumidifiers',
        'PARENT_CLASS'=>'SControllers',
        'DESCRIPTION'=>'Класс управления увлажнителями',
        'PROPERTIES'=>array(
            'mainSensor'=>array('DESCRIPTION'=>LANG_DEVICES_MAIN_SENSOR,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdMainSensor'),
            //'temperature'=>array('DESCRIPTION'=>'Температура полученная от устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'setRoomTemp'),
            //'humidity'=>array('DESCRIPTION'=>'Влажность полученная от устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'setRoomHum'),
            //'speed'=>array('DESCRIPTION'=>'Скорость'),
        ),
        'METHODS'=>array(
            //'setRoomTemp'=>array('DESCRIPTION'=>'Передача данных от устройства в комнату где оно находится'),
            //'setRoomHum'=>array('DESCRIPTION'=>'Передача данных от устройства в комнату где оно находится'),
            //'turnOff'=>array('DESCRIPTION'=>LANG_DEVICES_TURN_OFF,'_CONFIG_SHOW'=>1),
            //'switch'=>array('DESCRIPTION'=>'Switch'),
        )
    ),
    'GPSdevices'=>array(
        'CLASS'=>'SGPS',
        'PARENT_CLASS'=>'SDevices',
        'DESCRIPTION'=>'GPS device',
        'PROPERTIES'=>array(
            'coordinates'=>array('DESCRIPTION'=>'Координаты расположения устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'updateAdress'),
            'address'=>array('DESCRIPTION'=>'Адрес местонахождения устройства'),
            'speed'=>array('DESCRIPTION'=>'Скорость'),
        ),
        'METHODS'=>array(
            'updateAdress'=>array('DESCRIPTION'=>'Обновление адреса при изменении координат'),
            //'turnOff'=>array('DESCRIPTION'=>LANG_DEVICES_TURN_OFF,'_CONFIG_SHOW'=>1),
            //'switch'=>array('DESCRIPTION'=>'Switch'),
        )
    ),
    'SMartPhones'=>array(
        'CLASS'=>'SmartPhones',
        'PARENT_CLASS'=>'SDevices',
        'DESCRIPTION'=>'Seample smart phones',
        'PROPERTIES'=>array(
            'coordinates'=>array('DESCRIPTION'=>'Координаты расположения устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'updateAdress'),
            'address'=>array('DESCRIPTION'=>'Адрес местонахождения устройства'),
            'speed'=>array('DESCRIPTION'=>'Скорость'),
            'battery'=>array('DESCRIPTION'=>'Батарея'),
            'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства', 'ONCHANGE'=>'updatePropertys'),
        ),
        'METHODS'=>array(
            'updateAdress'=>array('DESCRIPTION'=>'Обновление адреса при изменении координат'),
            'updatePropertys'=>array('DESCRIPTION'=>'Обновляет свойства устройства из сырых значений полученных файлом gps.php'),
        )
    ),
    
    'SGateways'=>array(
        'CLASS'=>'SGateways',
        'PARENT_CLASS'=>'SDevices',
        'DESCRIPTION'=>'Seample Gateways class',
        'PROPERTIES'=>array(
            'loadType'=>array('DESCRIPTION'=>LANG_DEVICES_LOADTYPE,
                '_CONFIG_TYPE'=>'select','_CONFIG_HELP'=>'SdLoadType',
                '_CONFIG_OPTIONS'=>'light='.LANG_DEVICES_LOADTYPE_LIGHT.
                    ',heating='.LANG_DEVICES_LOADTYPE_HEATING.
                    ',vent='.LANG_DEVICES_LOADTYPE_VENT.
                    ',curtains='.LANG_DEVICES_LOADTYPE_CURTAINS.
                    ',gates='.LANG_DEVICES_LOADTYPE_GATES.
                    ',power='.LANG_DEVICES_LOADTYPE_POWER),
            'icon'=>array('DESCRIPTION'=>LANG_IMAGE,'_CONFIG_TYPE'=>'style_image','_CONFIG_HELP'=>'SdIcon'),
            //'coordinates'=>array('DESCRIPTION'=>'Координаты расположения устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'updateAdress'),
            //'address'=>array('DESCRIPTION'=>'Адрес местонахождения устройства'),
            //'speed'=>array('DESCRIPTION'=>'Скорость'),
            //'battery'=>array('DESCRIPTION'=>'Батарея'),
            //'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства', 'ONCHANGE'=>'updatePropertys'),
        ),
        'METHODS'=>array(
            //'updateAdress'=>array('DESCRIPTION'=>'Обновление адреса при изменении координат'),
            //'updatePropertys'=>array('DESCRIPTION'=>'Обновляет свойства устройства из сырых значений полученных файлом gps.php'),
            //'switch'=>array('DESCRIPTION'=>'Switch'),
        )
    ),
    'SSensors'=>array(
        'CLASS'=>'SSensors',
        'PARENT_CLASS'=>'SDevices',
        'DESCRIPTION'=>'Устройства-сенсоры',
        'PROPERTIES'=>array(
            'mainSensor'=>array('DESCRIPTION'=>LANG_DEVICES_MAIN_SENSOR,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdMainSensor'),
            'isActivity'=>array('DESCRIPTION'=>LANG_DEVICES_IS_ACTIVITY,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdIsActivity'),
            //'loadType'=>array('DESCRIPTION'=>LANG_DEVICES_LOADTYPE,
            //    '_CONFIG_TYPE'=>'select','_CONFIG_HELP'=>'SdLoadType',
            //    '_CONFIG_OPTIONS'=>'light='.LANG_DEVICES_LOADTYPE_LIGHT.
            //        ',heating='.LANG_DEVICES_LOADTYPE_HEATING.
            //        ',vent='.LANG_DEVICES_LOADTYPE_VENT.
            //        ',curtains='.LANG_DEVICES_LOADTYPE_CURTAINS.
            //        ',gates='.LANG_DEVICES_LOADTYPE_GATES.
            //        ',power='.LANG_DEVICES_LOADTYPE_POWER),
            //'icon'=>array('DESCRIPTION'=>LANG_IMAGE,'_CONFIG_TYPE'=>'style_image','_CONFIG_HELP'=>'SdIcon'),
            //'coordinates'=>array('DESCRIPTION'=>'Координаты расположения устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'updateAdress'),
            //'address'=>array('DESCRIPTION'=>'Адрес местонахождения устройства'),
            //'speed'=>array('DESCRIPTION'=>'Скорость'),
            //'battery'=>array('DESCRIPTION'=>'Батарея'),
            //'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства', 'ONCHANGE'=>'updatePropertys'),
        ),
        'METHODS'=>array(
            //'updateAdress'=>array('DESCRIPTION'=>'Обновление адреса при изменении координат'),
            //'updatePropertys'=>array('DESCRIPTION'=>'Обновляет свойства устройства из сырых значений полученных файлом gps.php'),
            //'switch'=>array('DESCRIPTION'=>'Switch'),
        )
    ),
);

$addons_dir=dirname(__FILE__).'/addons';
if (is_dir($addons_dir)) {
    $addon_files=scandir($addons_dir);
    foreach($addon_files as $file) {
        if (preg_match('/\_structure\.php$/',$file)) {
            require($addons_dir.'/'.$file);
        }
    }
}
