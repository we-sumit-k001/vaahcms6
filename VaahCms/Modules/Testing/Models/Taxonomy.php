<?php namespace VaahCms\Modules\Testing\Models;

use Illuminate\Support\Str;
use VaahCms\Modules\Testing\Models\TaxonomyType;
use WebReinvent\VaahCms\Models\Taxonomy as TaxonomyBase;


class Taxonomy extends TaxonomyBase
{
  protected $table = 'hw_taxonomies';

  protected $fillable = [
    'uuid','parent_id','hw_taxonomies_type_id',
    'name','slug', 'excerpt','details',
    'notes','is_active','meta',
    'created_by','updated_by','deleted_by',
  ];

  //-------------------------------------------------
  public function type()
  {
      return $this->belongsTo(TaxonomyType::class,
          'hw_taxonomies_type_id', 'id'
      );
  }



  //-------------------------------------------------
  //-------------------------------------------------
  public function parent()
  {
      return $this->belongsTo(self::class,
          'parent_id', 'id'
      )->select('id', 'name', 'slug');
  }
    public function parentData()
    {
        return self::where('parent_id', null)
            ->with(['children' => function ($query) {
                $query->whereHas('type', function ($subQuery) {
                    $subQuery->where('slug', 'state');
                });
            }, 'children.parent'])
            ->select('id', 'name', 'slug', 'hw_taxonomies_type_id')
            ->get();
    }





    public function children()
    {
        return $this->hasMany(self::class,
            'parent_id', 'id'
        )->with(['children'])->select('id', 'name as label','name','slug','parent_id','hw_taxonomies_type_id');
    }

  //-------------------------------------------------
  public static function getList($request)
  {
      $list = self::with(['parent', 'type']);
      $list->getSorted($request->filter);
      $list->isActiveFilter($request->filter);
      $list->trashedFilter($request->filter);
      $list->searchFilter($request->filter);

      $rows = config('vaahcms.per_page');

      if ($request->has('rows')) {
          $rows = $request->rows;
      }

      $list = $list->paginate($rows);

      $response['success'] = true;
      $response['data'] = $list;

      return $response;
  }

  //-------------------------------------------------
  public static function createItem($request)
  {

      $inputs = $request->all();

      $validation = self::validation($inputs);
      if (!$validation['success']) {
          return $validation;
      }


      // check if name exist
      $item = self::where('name', $inputs['name'])->withTrashed()->first();

      if ($item) {
          $response['success'] = false;
          $response['errors'][] = "This name is already exist.";
          return $response;
      }

      // check if slug exist
      $item = self::where('slug', $inputs['slug'])->withTrashed()->first();

      if ($item) {
          $response['success'] = false;
          $response['errors'][] = "This slug is already exist.";
          return $response;
      }

      $item = new self();
      $item->fill($inputs);
      $item->slug = Str::slug($inputs['slug']);
      $item->save();

      $response = self::getItem($item->id);
      $response['messages'][] = 'Saved successfully.';
      return $response;

  }
  //-------------------------------------------------

  //-------------------------------------------------
  public static function getItem($id)
  {

      $item = self::where('id', $id)
          ->with(['createdByUser',
              'updatedByUser',
              'deletedByUser',
              'parent',
              'type'])
          ->withTrashed()
          ->first();


      $response['success'] = true;
      $response['data'] = $item;

      return $response;

  }

  //-------------------------------------------------
  public static function updateItem($request, $id)
  {
      $inputs = $request->all();

      $validation = self::validation($inputs);
      if (!$validation['success']) {
          return $validation;
      }

      // check if name exist
      $item = self::where('id', '!=', $inputs['id'])
          ->withTrashed()
          ->where('name', $inputs['name'])->first();

      if ($item) {
          $response['success'] = false;
          $response['errors'][] = "This name is already exist.";
          return $response;
      }

      // check if slug exist
      $item = self::where('id', '!=', $inputs['id'])
          ->withTrashed()
          ->where('slug', $inputs['slug'])->first();

      if ($item) {
          $response['success'] = false;
          $response['errors'][] = "This slug is already exist.";
          return $response;
      }

      $item = self::where('id', $id)->withTrashed()->first();
      $item->fill($inputs);
      $item->slug = Str::slug($inputs['slug']);
      $item->save();

      $response = self::getItem($item->id);
      $response['messages'][] = 'Saved successfully.';
      return $response;

  }

  //-------------------------------------------------

  public static function validation($inputs)
  {

      $rules = array(
          'hw_taxonomies_type_id' => 'required|exists:hw_taxonomies_types,id',
          'name' => 'required|max:150',
          'slug' => 'required|max:150'
      );

      $validator = \Validator::make($inputs, $rules);
      if ($validator->fails()) {
          $messages = $validator->errors();
          $response['success'] = false;
          $response['errors'] = $messages->all();
          return $response;
      }

      $response['success'] = true;
      return $response;

  }

    /*public static function getTaxonomyByType($type)
    {
        $item = self::whereNotNull('is_active')
            ->where('type',$type)
            ->get();
        return $item;
    }*/

    public static function getTaxonomyByType($type)
    {
        $tax_type = TaxonomyType::getFirstOrCreate($type);



        $item =array();

        if(!$tax_type){
            return $item;
        }


        $item = self::whereNotNull('is_active')
            ->where('hw_taxonomy_type_id',$tax_type->id)
            ->get();
        return $item;
    }








  //-------------------------------------------------

}
