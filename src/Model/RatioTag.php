<?php

namespace Xbigdaddyx\BeverlyRatio\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RatioTag extends Model
{
    use SoftDeletes, HasUuids, Userstamps;
    protected $primaryKey = 'uuid';
    protected $table = 'beverly_ratio_tags';
    protected $fillable = [
        'carton_box_attribute_id',
        'tag',
        'polybag_id',
    ];

    public function polybag(): BelongsTo
    {
        return $this->belongsTo(RatioPolybag::class);
    }
}
