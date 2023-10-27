<?php  namespace VaahCms\Themes\VaahTheme\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SetupController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Run when theme is activated
     */
    public static function activate($theme)
    {
        $response['status'] = 'success';
        $response['data'] = [];
        return $response;
    }

    /**
     * Run when theme is activated
     */
    public static function dependencies()
    {
        $response['status'] = 'success';
        //$response['data']['modules'] = ['cms'];
        $response['data']['themes'] = [];

        return $response;
    }

    /**
     * Run when theme is deactivate
     */
    public static function deactivate()
    {

        $response['status'] = 'success';
        $response['data'] = [];
        return $response;

    }

    /**
     * Run when theme's sample data link is clicked
     */
    public static function importSampleData()
    {

        $response['status'] = 'success';
        $response['data'] = [];
        return $response;

    }

    /**
     * Run when theme is deleted
     */
    public static function delete()
    {

        $response['status'] = 'success';
        $response['data'] = [];
        return $response;

    }

      /**
       * Run when theme is marked as default
       */
      public static function makeDefault()
      {

          $response['status'] = 'success';
          $response['data'] = [];
          return $response;

      }

}
