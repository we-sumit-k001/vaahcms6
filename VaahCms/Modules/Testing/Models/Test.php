<?php namespace VaahCms\Modules\Testing\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
/*use WebReinvent\VaahCms\Models\Taxonomy;*/

use VaahCms\Modules\Testing\Models\Taxonomy;
use VaahCms\Modules\Training\Models\Practice;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Libraries\VaahSeeder;
use VaahCms\Modules\Testing\Models\TaxonomyType;

class Test extends Model
{

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

     public array $matching_practice = [];

    //-------------------------------------------------
    protected $table = 'vh_test';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'email',
        'taxonomy_id',
        'parent_id',
        'hw_taxonomies_type_id',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    //-------------------------------------------------
    protected $fill_except = [

    ];

    //-------------------------------------------------
    protected $appends = [
    ];

    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');
        return $date->format($date_time_format);
    }

    //-------------------------------------------------
    public static function getUnFillableColumns()
    {
        return [
            'uuid',
            'created_by',
            'updated_by',
            'deleted_by',
        ];
    }
    //-------------------------------------------------
    public static function getFillableColumns()
    {
        $model = new self();
        $except = $model->fill_except;
        $fillable_columns = $model->getFillable();
        $fillable_columns = array_diff(
            $fillable_columns, $except
        );
        return $fillable_columns;
    }
    //-------------------------------------------------
    public static function getEmptyItem()
    {
        $model = new self();
        $fillable = $model->getFillable();
        $empty_item = [];
        foreach ($fillable as $column)
        {
            $empty_item[$column] = null;
        }

        $empty_item['practice_crud'] = [];

        return $empty_item;
    }

    //-------------------------------------------------

    public function createdByUser()
    {
        return $this->belongsTo(User::class,
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }



    //-------------------------------------------------
    public function updatedByUser()
    {
        return $this->belongsTo(User::class,
            'updated_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function deletedByUser()
    {
        return $this->belongsTo(User::class,
            'deleted_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }



    public function getPracticeCrudData()
    {
        return $this->belongsTo(Practice::class,'id','id');
    }

    /*public function practiceCrudList()
    {
        return $this->belongsToMany(
            Practice::all(), 'vh_training');
    }*/

    public function storePracticeCrudData()
    {
        return $this->belongsToMany(Practice::class,
            'test_practice_crud',
            'test_id',
            'practice_id')->withPivot('is_active',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at');
    }
    public function activePractice()
    {
        return $this->storePracticeCrudData()->wherePivot('is_active', 1);
    }

    public static function countUsers($id): int
    {
        $practices = self::withTrashed()->where('id', $id)->first();

        if (!$practices) {
            return 0;
        }

        return $practices->storePracticeCrudData()->wherePivot('is_active', 1)->count();
    }



    public static function syncPracticeWithTest()
    {
        $all_practices = Practice::select('id')->get()->pluck('id')->toArray();
        $all_tests = self::select('id')->get();

        if (!$all_tests) {
            return false;
        }

        foreach ($all_tests as $test) {
            $test->storePracticeCrudData()->syncWithoutDetaching($all_practices);
        }
        return true;

    }


    public function getTrainingDataByTaxonomy()
    {
        return $this->belongsTo(Taxonomy::class,
            'taxonomy_id', 'id'
        );
    }

    public function getStateData()
    {
        return $this->belongsTo(Taxonomy::class,
            'hw_taxonomies_type_id', 'id'
        );
    }

    public function getCountryData()
    {
        return $this->belongsTo(Taxonomy::class,
            'parent_id', 'id'
        );
    }

    /*public function practiceCrudData()
    {
        return $this->belongsToMany(Practice::class,
            'test_practice', 'practice_id','test_id'
        );
    }*/

    //-------------------------------------------------
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }

    //-------------------------------------------------
    public function scopeExclude($query, $columns)
    {
        return $query->select(array_diff($this->getTableColumns(), $columns));
    }

    //-------------------------------------------------
    public function scopeBetweenDates($query, $from, $to)
    {

        if ($from) {
            $from = \Carbon::parse($from)
                ->startOfDay()
                ->toDateTimeString();
        }

        if ($to) {
            $to = \Carbon::parse($to)
                ->endOfDay()
                ->toDateTimeString();
        }

        $query->whereBetween('updated_at', [$from, $to]);
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
            $response['messages'][] = "This name is already exist.";
            return $response;
        }

        // check if slug exist
        $item = self::where('slug', $inputs['slug'])->withTrashed()->first();

        if ($item) {
            $response['success'] = false;
            $response['messages'][] = "This slug is already exist.";
            return $response;
        }

        $item = new self();
        $item->fill($inputs);
        $item->slug = Str::slug($inputs['slug']);
        $item->save();

        self::syncPracticeWithTest();

       /* $practice_crud_id = array_column($inputs['practice_crud'], 'id');

        $item->storePracticeCrudData()->attach($practice_crud_id);*/

        $response = self::getItem($item->id);
        $response['messages'][] = 'Saved successfully.';
        return $response;

    }

    //-------------------------------------------------
    public function scopeGetSorted($query, $filter)
    {

        if(!isset($filter['sort']))
        {
            return $query->orderBy('id', 'desc');
        }

        $sort = $filter['sort'];


        $direction = Str::contains($sort, ':');

        if(!$direction)
        {
            return $query->orderBy($sort, 'asc');
        }

        $sort = explode(':', $sort);

        return $query->orderBy($sort[0], $sort[1]);
    }
    //-------------------------------------------------
    public function scopeIsActiveFilter($query, $filter)
    {

        if(!isset($filter['is_active'])
            || is_null($filter['is_active'])
            || $filter['is_active'] === 'null'
        )
        {
            return $query;
        }
        $is_active = $filter['is_active'];

        if($is_active === 'true' || $is_active === true)
        {
            return $query->where('is_active', 1);
        } else{
            return $query->where(function ($q){
                $q->whereNull('is_active')
                    ->orWhere('is_active', 0);
            });
        }

    }
    //-------------------------------------------------
    public function scopeTrashedFilter($query, $filter)
    {

        if(!isset($filter['trashed']))
        {
            return $query;
        }
        $trashed = $filter['trashed'];

        if($trashed === 'include')
        {
            return $query->withTrashed();
        } else if($trashed === 'only'){
            return $query->onlyTrashed();
        }

    }
    //-------------------------------------------------
    public function scopeSearchFilter($query, $filter)
    {

        if(!isset($filter['q']))
        {
            return $query;
        }
        $search = $filter['q'];
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('slug', 'LIKE', '%' . $search . '%');
        });

    }


    public function scopeCountryFilter($query, $filter)
    {

        if (isset($filter['country'])) {
            $country = $filter['country'];

            $query->whereHas('getCountryData', function ($query) use ($country) {
                $query->where('slug', $country);
            });
        }

        return $query;
    }

    public function scopeStateFilter($query, $filter)
    {

        if (isset($filter['state'])) {
            $state = $filter['state'];

            $query->whereHas('getStateData', function ($query) use ($state) {
                $query->where('slug', $state);
            });
        }


        return $query;
    }


    //-------------------------------------------------
    public static function getList($request)
    {

       /* if (!Auth::user()->hasPermission('can-manage-users')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }*/

        if (isset($request['recount']) && $request['recount'] == true) {
            self::syncPracticeWithTest();
        }


        $list = self::getSorted($request->filter);
        $list->isActiveFilter($request->filter);
        $list->trashedFilter($request->filter);
        $list->searchFilter($request->filter);
        $list->countryFilter($request->filter);
        $list->stateFilter($request->filter);
        $list->with('getTrainingDataByTaxonomy');
        $list->with('getCountryData');
        $list->with('getStateData');
        $list->with('getPracticeCrudData');


        $rows = config('vaahcms.per_page');

        if($request->has('rows'))
        {
            $rows = $request->rows;
        }

        $list->withCount(['activePractice']);
        $list = $list->paginate($rows);

        $taxonomy_training = $list->pluck('getTrainingDataByTaxonomy');

        $practice_crud_data= $list->pluck('getPracticeCrudData');

        $taxonomy_country = $list->pluck('getCountryData');

        $taxonomy_state = $list->pluck('getStateData');


        $response['getTaxonomyTraining'] = $taxonomy_training;

        $response['getTaxonomyCountry'] = $taxonomy_country;

        $response['getTaxonomyState'] = $taxonomy_state;

        $response['practiceCrudData'] =$practice_crud_data;

        $response['totalPractice'] = Practice::all()->count();



        $response['success'] = true;
        $response['data'] = $list;

        return $response;


    }

    //-------------------------------------------------
    public static function updateList($request)
    {

        $inputs = $request->all();

        $rules = array(
            'type' => 'required',
        );

        $messages = array(
            'type.required' => 'Action type is required',
        );


        $validator = \Validator::make($inputs, $rules, $messages);
        if ($validator->fails()) {

            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        if(isset($inputs['items']))
        {
            $items_id = collect($inputs['items'])
                ->pluck('id')
                ->toArray();
        }


        $items = self::whereIn('id', $items_id)
            ->withTrashed();

        switch ($inputs['type']) {
            case 'deactivate':
                $items->update(['is_active' => null]);
                break;
            case 'activate':
                $items->update(['is_active' => 1]);
                break;
            case 'trash':
                self::whereIn('id', $items_id)->delete();
                break;
            case 'restore':
                self::whereIn('id', $items_id)->restore();
                break;
        }

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }

    //-------------------------------------------------
    public static function deleteList($request): array
    {
        $inputs = $request->all();

        $rules = array(
            'type' => 'required',
            'items' => 'required',
        );

        $messages = array(
            'type.required' => 'Action type is required',
            'items.required' => 'Select items',
        );

        $validator = \Validator::make($inputs, $rules, $messages);
        if ($validator->fails()) {

            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $items_id = collect($inputs['items'])->pluck('id')->toArray();

        foreach ($items_id as $id) {
            $model = self::find($id);
            if ($model) {
                $model->storePracticeCrudData()->detach();
            }


        }
        self::whereIn('id', $items_id)->forceDelete();

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }
    //-------------------------------------------------
    public static function listAction($request, $type): array
    {
        $inputs = $request->all();

        if(isset($inputs['items']))
        {
            $items_id = collect($inputs['items'])
                ->pluck('id')
                ->toArray();

            $items = self::whereIn('id', $items_id)
                ->withTrashed();
        }

        $list = self::query();

        if($request->has('filter')){
            $list->getSorted($request->filter);
            $list->isActiveFilter($request->filter);
            $list->trashedFilter($request->filter);
            $list->searchFilter($request->filter);
        }

        switch ($type) {
            case 'deactivate':
                if($items->count() > 0) {
                    $items->update(['is_active' => null]);
                }
                break;
            case 'activate':
                if($items->count() > 0) {
                    $items->update(['is_active' => 1]);
                }
                break;
            case 'trash':
                if(isset($items_id) && count($items_id) > 0) {
                    self::whereIn('id', $items_id)->delete();
                }
                break;
            case 'restore':
                if(isset($items_id) && count($items_id) > 0) {
                    self::whereIn('id', $items_id)->restore();
                }
                break;
            case 'delete':
                if(isset($items_id) && count($items_id) > 0) {
                    self::whereIn('id', $items_id)->forceDelete();
                }
                break;
            case 'activate-all':
                $list->update(['is_active' => 1]);
                break;
            case 'deactivate-all':
                $list->update(['is_active' => null]);
                break;
            case 'trash-all':
                $list->delete();
                break;
            case 'restore-all':
                $list->restore();
                break;
            case 'delete-all':
                $list->forceDelete();
                break;
            case 'create-100-records':
            case 'create-1000-records':
            case 'create-5000-records':
            case 'create-10000-records':

            if(!config('testing.is_dev')){
                $response['success'] = false;
                $response['errors'][] = 'User is not in the development environment.';

                return $response;
            }

            preg_match('/-(.*?)-/', $type, $matches);

            if(count($matches) !== 2){
                break;
            }

            self::seedSampleItems($matches[1]);
            break;
        }

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }
    //-------------------------------------------------
    public static function getItem($id)
    {

        $item = self::where('id', $id)
            ->with(['createdByUser', 'updatedByUser', 'deletedByUser','getCountryData' => function ($query) {
                $query->select('id', 'name');
            },
                'deletedByUser',
                'getStateData' => function ($query) {
                    $query->select('id', 'name');

                },'storePracticeCrudData' => function ($query) {
                    $query->select('practice_id', 'name');

                }])
            ->withTrashed()
            ->first();

        if(!$item)
        {
            $response['success'] = false;
            $response['errors'][] = 'Record not found with ID: '.$id;
            return $response;
        }
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
        $item = self::where('id', '!=', $id)
            ->withTrashed()
            ->where('name', $inputs['name'])->first();

        if ($item) {
            $response['success'] = false;
            $response['errors'][] = "This name is already exist.";
            return $response;
        }

        // check if slug exist
        $item = self::where('id', '!=', $id)
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

        $practice_crud_id = array_column($inputs['practice_crud'], 'id');

        $item->storePracticeCrudData()->sync($practice_crud_id);

        $response = self::getItem($item->id);
        $response['messages'][] = 'Saved successfully.';
        return $response;

    }
    //-------------------------------------------------
    public static function deleteItem($request, $id): array
    {
        $item = self::where('id', $id)->withTrashed()->first();
        if (!$item) {
            $response['success'] = false;
            $response['errors'][] = 'Record does not exist.';
            return $response;
        }
        $item->forceDelete();

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = 'Record has been deleted';

        return $response;
    }
    //-------------------------------------------------
    public static function itemAction($request, $id, $type): array
    {
        switch($type)
        {
            case 'activate':
                self::where('id', $id)
                    ->withTrashed()
                    ->update(['is_active' => 1]);
                break;
            case 'deactivate':
                self::where('id', $id)
                    ->withTrashed()
                    ->update(['is_active' => null]);
                break;
            case 'trash':
                self::where('id', $id)
                ->withTrashed()
                ->delete();
                break;
            case 'restore':
                self::where('id', $id)
                    ->withTrashed()
                    ->restore();
                break;
        }

        return self::getItem($id);
    }
    //-------------------------------------------------

    public static function validation($inputs)
    {

        $rules = array(
            'name' => 'required|max:150',
            'slug' => 'required|max:150',
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

    //-------------------------------------------------
    public static function getActiveItems()
    {
        $item = self::where('is_active', 1)
            ->withTrashed()
            ->first();
        return $item;
    }

    //-------------------------------------------------
    //-------------------------------------------------
    public static function seedSampleItems($records=100)
    {

        $i = 0;

        while($i < $records)
        {
            $inputs = self::fillItem(false);

            $item =  new self();
            $item->fill($inputs);
            $item->save();

            $i++;

        }

    }


    //-------------------------------------------------
    public static function fillItem($is_response_return = true)
    {
        $request = new Request([
            'model_namespace' => self::class,
            'except' => self::getUnFillableColumns()
        ]);
        $fillable = VaahSeeder::fill($request);
        if(!$fillable['success']){
            return $fillable;
        }
        $inputs = $fillable['data']['fill'];

        $faker = Factory::create();

        /*
         * You can override the filled variables below this line.
         * You should also return relationship from here
         */

        if(!$is_response_return){
            return $inputs;
        }

        $response['success'] = true;
        $response['data']['fill'] = $inputs;
        return $response;
    }

    public static function getTaxonomyTraining($taxonomies_slug='training')
    {

        $taxonomies=Taxonomy::getTaxonomyByType($taxonomies_slug);



        return $taxonomies;



    }


    /*public static function getTaxonomyCountry()
    {

        $taxonomy = new Taxonomy();
        $taxonomies = $taxonomy->parentData();
        return $taxonomies;
    }*/

    public static function getTaxonomyCountry()
    {
        $taxonomy = new Taxonomy();
        $taxonomies = $taxonomy->parentData();

        $result = [];

        foreach ($taxonomies as $parent) {
            $children_array = [];

            // Access parent data
            $parentData = [
                'id' => $parent->id,
                'name' => $parent->name,
                'slug' => $parent->slug,
                'hw_taxonomies_type_id' => $parent->hw_taxonomies_type_id,
            ];

            // Access and extract child data
            if ($parent->children) {
                foreach ($parent->children as $child) {
                    $childData = [
                        'id' => $child->id,
                        'name' => $child->name,
                        // Add other child attributes as needed
                    ];
                    $children_array[] = $childData;
                }
            }

            $result[] = [
                'parent' => $parentData,
                'children' => $children_array,
            ];
        }

        return $result;
    }

    public static function State($id)
    {
        $taxonomy = new Taxonomy();


        $taxonomies = $taxonomy->parentData();

        $children_array = [];

        foreach ($taxonomies as $parent) {

            if ($parent->children) {
                foreach ($parent->children as $child) {
                    if ($child->parent_id == $id) {
                        $childData = [
                            'id' => $child->id,
                            'name' => $child->name,
                            'parent_id' => $child->parent_id,
                        ];
                        $children_array[] = $childData;
                    }
                }
            }
        }

        $response['success'] = true;
        $response['data'] = $children_array;

        return $response;


    }

    /*public static function stateFilter($slug)
    {
        $taxonomy = new Taxonomy();
        $taxonomies = $taxonomy->parentData();




    }*/

    public static function stateFilter($slug)
    {
        $taxonomy = new Taxonomy();
        $taxonomies = $taxonomy->parentData();

        $matchingRecord = null;

        // Find the matching record based on the slug
        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->slug === $slug) {
                $matchingRecord = $taxonomy;
                break;
            }
        }

        $children_array = [];

        if ($matchingRecord) {
            $id = $matchingRecord->id;

            foreach ($taxonomies as $parent) {
                if ($parent->children) {
                    foreach ($parent->children as $child) {
                        if ($child->parent_id == $id) {
                            $childData = [
                                'id' => $child->id,
                                'name' => $child->name,
                                'slug' => $child->slug,
                                'parent_id' => $child->parent_id,
                            ];
                            $children_array[] = $childData;
                        }
                    }
                }
            }

            $response['success'] = true;
            $response['data'] = $children_array;
        } else {
            $response['success'] = false;
            $response['message'] = 'Record not found with the given slug';
        }

        return $response;
    }


    public static function getPractice($request, $id): array
    {
        $item = self::withTrashed()->where('id', $id)->first();
        $response['data']['item'] = $item;

        if ($request->has("q")) {
            $matching_practice = $item->storePracticeCrudData()
                ->where(function ($q) use ($request) {
                    $q->where('vh_training.name', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('vh_training.slug', 'LIKE', '%' . $request->q . '%')
                        ->orWhere(DB::raw('concat(vh_training.name)'), 'like', '%' . $request->q . '%')
                        ->orWhere(DB::raw('concat(vh_training.name)'), 'like', '%' . $request->q . '%');

                })
                ->pluck('vh_training.id')
                ->toArray();

        } else {
            $matching_practice = $item->storePracticeCrudData()
                ->pluck('vh_training.id')
                ->toArray();


        }
        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }
        $list = $item->storePracticeCrudData()
            ->whereIn('vh_training.id', $matching_practice)
            ->orderBy('pivot_is_active', 'desc')
            ->paginate($rows);


        foreach ($list as $practice) {
            $data = self::getPivotData($practice->pivot);

            $practice['json'] = $data;
            $practice['json_length'] = count($data);
        }


        $response['data']['list'] = $list;


        $response['data']['matchingPracticeIds'] = $matching_practice;

        /*dd($matching_practice);*/
        $response['success'] = true;
        return $response;
    }
    public static function getPivotData($pivot): array
    {

        $data = array();

        if ($pivot->created_by && User::find($pivot->created_by)) {
            $data['created_by'] = User::find($pivot->created_by)->name;
        }

        if ($pivot->updated_by && User::find($pivot->updated_by)) {
            $data['updated_by'] = User::find($pivot->updated_by)->name;
        }

        if ($pivot->created_at) {
            $data['created_at'] = date('d-m-Y H:i:s', strtotime($pivot->created_at));
        }

        if ($pivot->updated_at) {
            $data['updated_at'] = date('d-m-Y H:i:s', strtotime($pivot->updated_at));
        }

        return $data;

    }

    public static function changePracticeStatus($request): array
    {

        $inputs = $request->all();


        $item = self::find($inputs['inputs']['id']);
        $data = [
            'is_active' => $inputs['data']['is_active'],
            'updated_by' => Auth::user()->id,
            'updated_at' => \Illuminate\Support\Carbon::now()
        ];




        if ($inputs['inputs']['practice_id']) {
            $pivot = $item->storePracticeCrudData->find($inputs['inputs']['practice_id'])->pivot;
            if ($pivot->is_active === null || !$pivot->created_by) {
                $data['created_at'] = Carbon::now();
            }

            $item->storePracticeCrudData()->updateExistingPivot(
                $inputs['inputs']['practice_id'],
                $data
            );

        } else {
            $item->storePracticeCrudData()
                ->newPivotStatement()
                ->where('test_id', '=', $item->id)
                ->update($data);
        }
        $response['success'] = true;
        $response['data'] = [];

        return $response;


    }

    //-------------------------------------------------
    public static function bulkChangePracticeStatus($request): array
    {

        $inputs = $request->get('inputs');
        $data = $request->get('data');


        $response = ['success' => true, 'data' => []];



        if (isset($inputs['id'])/* && isset($inputs['practice_id'])*/) {
            $item = self::find($inputs['id']);
            $practiceIds = $inputs['practice_id'];



            foreach ($practiceIds as $practiceId) {
                $pivot = $item->storePracticeCrudData->find($practiceId)->pivot;
                $updateData = [
                    'is_active' => $data['is_active'],
                    'updated_by' => Auth::user()->id,
                    'updated_at' => \Illuminate\Support\Carbon::now(),
                ];



                if ($pivot->is_active === null || !$pivot->created_by) {
                    $updateData['created_by'] = Auth::user()->id;
                    $updateData['created_at'] = Carbon::now();
                }

                $item->storePracticeCrudData()->updateExistingPivot($practiceId, $updateData);
            }
        }



        return $response;
    }








    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------


}
