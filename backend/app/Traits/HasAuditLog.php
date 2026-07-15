<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait HasAuditLog
{
    protected static function bootHasAuditLog()
    {
        static::created(function ($model) {
            $model->logActivity('created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $model->logActivity('updated', $model->getOriginal(), $model->getAttributes());
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->getOriginal(), null);
        });

        // Event restored hanya untuk model yang pakai SoftDeletes
        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                $model->logActivity('restored', null, $model->getAttributes());
            });
        }
    }

    protected function logActivity($event, $oldValues = null, $newValues = null)
    {
        $exclude = ['password', 'remember_token'];
        
        if ($oldValues) {
            $oldValues = array_diff_key($oldValues, array_flip($exclude));
        }
        if ($newValues) {
            $newValues = array_diff_key($newValues, array_flip($exclude));
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'branch_id' => app()->has('current_branch') ? app('current_branch')->id : null,
            'model_type' => get_class($this),
            'model_id' => $this->getKey(),
            'event' => $event,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}