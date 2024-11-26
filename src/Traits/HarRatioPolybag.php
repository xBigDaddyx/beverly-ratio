<?php

namespace Xbigdaddyx\BeverlyRatio\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Xbigdaddyx\BeverlyRatio\Model\RatioPolybag;

trait HasRatioPolybag
{
    public function ratioPolybags(): HasMany
    {
        return $this->hasMany(RatioPolybag::class);
    }
}
