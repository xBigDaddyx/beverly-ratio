<?php

namespace Xbigdaddyx\BeverlyRatio\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Xbigdaddyx\Beverly\Models\CartonBox;
use Xbigdaddyx\BeverlyRatio\Traits\HasRatioTag;
use Wildside\Userstamps\Userstamps;

class RatioPolybag extends Model
{

    use HasFactory, SoftDeletes, HasUuids, HasRatioTag, Userstamps;
    protected $primaryKey = 'uuid';
    protected $table = 'beverly_ratio_polybags';
    protected $with = ['ratioTags'];
    protected $fillable = [
        'polybag_code',
        'carton_box_id',
        'status',
        'additional',
    ];

    public function box()
    {
        return $this->belongsTo(CartonBox::class, 'carton_box_id', 'id');
    }
}
