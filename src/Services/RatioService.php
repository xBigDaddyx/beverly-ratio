<?php

namespace Xbigdaddyx\BeverlyRatio\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Xbigdaddyx\Beverly\Models\CartonBoxAttribute;
use Xbigdaddyx\Beverly\Models\Polybag;
use Xbigdaddyx\Beverly\Models\Tag;
use Xbigdaddyx\BeverlyRatio\Interfaces\RatioInterface;
use Xbigdaddyx\BeverlyRatio\Model\RatioPolybag;
use Xbigdaddyx\BeverlyRatio\Model\RatioTag;
use Illuminate\Support\Str;
use Xbigdaddyx\Beverly\Models\CartonBox;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class RatioService implements RatioInterface
{
    public function createRatioPolybag(CartonBox $cartonBox, string $additional, User $user, ?string $polybag_code = null)
    {
        if ($polybag_code === '' || empty($polybag_code)) {
            return RatioPolybag::create(
                [
                    'polybag_code' => Str::ulid()->toBase32(),
                    'carton_box_id' => $cartonBox->id,
                    'status' => 'unvalidated',
                    'additional' => $additional,
                    'created_by' => $user->id,
                ]
            );
        }
        return RatioPolybag::create(
            [
                'polybag_code' => Str::ulid()->toBase32(),
                'carton_box_id' => $cartonBox->id,
                'status' => 'unvalidated',
                'additional' => $additional,
                'created_by' => $user->id,
            ]
        );
    }
    public function findRatioPolybag(string $polybag_code)
    {
        return RatioPolybag::where('polybag_code', $polybag_code)->first();
    }
    public function updateStatusRatioPolybag(RatioPolybag $polybag, string $status)
    {
        $polybag->update([
            'status' => $status
        ]);
        return $polybag->save();
    }
    public function ratioPrinciple(Model $cartonBox, ?RatioPolybag $polybag = null, string $tag_code, User $user) {}
}
