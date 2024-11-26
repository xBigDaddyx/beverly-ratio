<?php

namespace Xbigdaddyx\BeverlyRatio;

use Illuminate\Database\Eloquent\Model;
use Xbigdaddyx\Beverly\Models\CartonBox;
use Xbigdaddyx\BeverlyRatio\Model\RatioPolybag;
use Xbigdaddyx\BeverlyRatio\Services\RatioService;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class BeverlyRatio
{
    protected $ratioService;
    public ?RatioPolybag $polybag = null;
    public function __construct(RatioService $ratioService)
    {
        $this->ratioService = $ratioService;
    }
    public function createPolybag(string $polybag_code) {}
    public function verification(CartonBox $cartonBox, ?RatioPolybag $polybag = null, string $tag_code, User $user, ?string $additional = null, ?string $polybag_code = null)
    {
        if ($polybag) {
            return $this->ratioService->ratioPrinciple($cartonBox, $polybag, $tag_code, $user);
        } else {
            if (!$this->polybag) {
                $this->polybag = $this->ratioService->createRatioPolybag($cartonBox, $additional, $user, $polybag_code);
            }
            return $this->ratioService->ratioPrinciple($cartonBox, $polybag, $tag_code, $user);
        }
    }
}
