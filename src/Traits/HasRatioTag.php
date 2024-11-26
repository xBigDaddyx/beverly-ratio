<?php

namespace Xbigdaddyx\BeverlyRatio\Traits;

use Xbigdaddyx\BeverlyRatio\Model\RatioTag;

trait HasRatioTag
{
    public function ratioTags()
    {
        return $this->hasMany(RatioTag::class);
    }
}
