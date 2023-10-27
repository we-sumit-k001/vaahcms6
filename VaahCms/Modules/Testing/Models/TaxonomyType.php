<?php namespace VaahCms\Modules\Testing\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\TaxonomyBase;
use WebReinvent\VaahCms\Models\TaxonomyType as TaxonomyTypeBase;

class TaxonomyType extends TaxonomyTypeBase {


  protected $table = 'hw_taxonomies_types';

  //-------------------------------------------------
  public function children(): HasMany
  {
      return $this->hasMany(self::class,
          'parent_id', 'id')
          ->with(['children'])
          ->select('id', 'id as key', 'name as label', 'slug as data', 'parent_id');
  }




  //-------------------------------------------------


}
