<?php



return array(



    /** set your paypal credential **/

    'client_id' =>'AYT6PMcPAhyNjyswDTkA6UCKe1AzYSFI7gA259I-rtGccuyylzKQYftOJ2IontvchZHk98IHJ20UoySj',

    'secret' =>'EJNtrz0PXWRPiOc3dy39lD-_vu_e8B1P0X0DXd88-lzerfnfrXVRETLeV85dpOKa3e91xlnNKFtlyv2f',



    'settings' => array(



        'mode' => 'sandbox',

        'http.ConnectionTimeOut' => 1000,

        /** Whether want to log to a file*/



        'log.LogEnabled' => true,

        /** Specify the file that want to write on*/



        'log.FileName' => storage_path() . '/logs/paypal.log',



        /** Available option 'FINE', 'INFO', 'WARN' or 'ERROR'*



         * Logging is most verbose in the 'FINE' level and decreases as you



         * proceed towards ERROR*/



        'log.LogLevel' => 'FINE'

    ),

);