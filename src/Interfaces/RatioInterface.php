<?php

namespace Xbigdaddyx\BeverlyRatio\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Xbigdaddyx\Beverly\Models\CartonBox;
use Xbigdaddyx\BeverlyRatio\Model\RatioPolybag;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

interface RatioInterface
{
    public function createRatioPolybag(CartonBox $cartonBox, string $additional, User $user, ?string $polybag_code = null);
    public function updateStatusRatioPolybag(RatioPolybag $polybag, string $status);
    public function findRatioPolybag(string $polybag_code);
    public function ratioPrinciple(CartonBox $cartonBox, ?RatioPolybag $polybag = null, string $tag_code, User $user);
}
