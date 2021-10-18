<?php

$this->device_types=array(
    'users'=>array(
        'CLASS'=>'Users',
        'DESCRIPTION'=>'Пользователи системы',
        'PROPERTIES'=>array(
            'coordinates'=>array('DESCRIPTION'=>'Координаты расположения пользователя'),
        ),
        'METHODS'=>array(
            //'onActivity'=>array('DESCRIPTION'=>'Rooms Activity'),
            //'onIdle'=>array('DESCRIPTION'=>'Rooms Idle'),
            //'updateActivityStatus'=>array('DESCRIPTION'=>'Update activity status')
        )
    ),
    'rooms'=>array(
        'CLASS'=>'Rooms',
        'DESCRIPTION'=>'Rooms/Locations',
        'PROPERTIES'=>array(
            'temperature'=>array('DESCRIPTION'=>'Temperature'),
            'humidity'=>array('DESCRIPTION'=>'Humidity'),
            'pressure'=>array('DESCRIPTION'=>'Presse'),
            'volt'=>array('DESCRIPTION'=>'Volt'),
            //'SomebodyHere'=>array('DESCRIPTION'=>'Somebody in the room'),
            //'IdleDelay'=>array('DESCRIPTION'=>'Nobody here idle delay'),
        ),
        'METHODS'=>array(
            //'onActivity'=>array('DESCRIPTION'=>'Rooms Activity'),
            //'onIdle'=>array('DESCRIPTION'=>'Rooms Idle'),
            //'updateActivityStatus'=>array('DESCRIPTION'=>'Update activity status')
        )
    ),
    'general'=>array(
        'CLASS'=>'SDevices',
        'DESCRIPTION'=>'General Devices Class',
        'PROPERTIES'=>array(
            //'status'=>array('DESCRIPTION'=>LANG_DEVICES_STATUS, 'KEEP_HISTORY'=>365, 'ONCHANGE'=>'statusUpdated', 'DATA_KEY'=>1),
            //'alive'=>array('DESCRIPTION'=>'Alive'),
            //'aliveTimeout'=>array('DESCRIPTION'=>LANG_DEVICES_ALIVE_TIMEOUT,'_CONFIG_TYPE'=>'num','_CONFIG_HELP'=>'SdAliveTimeout'),
            //'linkedRoom'=>array('DESCRIPTION'=>'LinkedRoom'),
            //'updated'=>array('DESCRIPTION'=>'Updated Timestamp'),
        ),
        'METHODS'=>array(
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
        'DESCRIPTION'=>'Controllable device',
        'PROPERTIES'=>array(
            //'groupEco'=>array('DESCRIPTION'=>LANG_DEVICES_GROUP_ECO,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupEco'),
            //'groupEcoOn'=>array('DESCRIPTION'=>LANG_DEVICES_GROUP_ECO_ON,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupEcoOn'),
            //'groupSunrise'=>array('DESCRIPTION'=>LANG_DEVICES_GROUP_SUNRISE,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupSunrise'),
            //'groupSunset'=>array('DESCRIPTION'=>LANG_DEVICES_GROUP_SUNSET,'_CONFIG_TYPE'=>'yesno','_CONFIG_HELP'=>'SdGroupSunset'),
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
