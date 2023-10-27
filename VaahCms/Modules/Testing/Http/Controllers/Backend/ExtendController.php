<?php  namespace VaahCms\Modules\Testing\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ExtendController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public static function topLeftMenu()
    {
        $links = [];

        $response['success'] = true;
        $response['data'] = $links;

        return vh_response($response);

    }
    //----------------------------------------------------------
    public static function topRightUserMenu()
    {
        $links = [];

        $response['success'] = true;
        $response['data'] = $links;

        return vh_response($response);
    }
    //----------------------------------------------------------
    public static function sidebarMenu()
    {
        $links = [];


        $links[0] = [
            'icon' => 'table',
            'label'=> 'Testing',
            'link'=> route('vh.backend.testing')
        ];


        if(version_compare(config('vaahcms.version'), '2.0.0', '<' )){
            $links[0]['link'] = route('vh.backend.testing');
        } else{
            $links[0]['url'] = route('vh.backend.testing');
        }


        $response['success'] = true;
        $response['data'] = $links;

        return vh_response($response);
    }
    //----------------------------------------------------------

    public function getNotificationActions()
    {

        $list = [
            [
                'name'=>'#!PARAM:CUSTOM_URL!#'
            ],
            [
                'name'=>'#!ROUTE:VH.NOTIFY!#'
            ],
        ];

        $response['success'] = true;
        $response['data'] = $list;

        return $response;
    }

}
