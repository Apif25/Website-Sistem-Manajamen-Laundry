<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUniqueCodeAndUuid
{
    /**
     * Boot the trait.
     */
    public static function bootHasUniqueCodeAndUuid(): void
    {
        static::creating(function ($model) {
            // Generate UUID if the model uses it
            if ($model->usesUuid() && empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }

            // Generate unique code if the model uses it
            $codeFieldName = $model->getCodeFieldName();
            if ($codeFieldName && empty($model->{$codeFieldName})) {
                $model->{$codeFieldName} = static::generateUniqueCode(
                    $model->getCodePrefix(),
                    $codeFieldName
                );
            }
        });
    }

    /**
     * Check if this model uses UUID.
     */
    public function usesUuid(): bool
    {
        return property_exists($this, 'usesUuid') ? $this->usesUuid : false;
    }

    /**
     * Get the name of the unique code column.
     */
    public function getCodeFieldName(): ?string
    {
        return property_exists($this, 'codeFieldName') ? $this->codeFieldName : null;
    }

    /**
     * Get the prefix for the unique code.
     */
    public function getCodePrefix(): ?string
    {
        return property_exists($this, 'codePrefix') ? $this->codePrefix : null;
    }

    /**
     * Generate a unique sequential code.
     */
    public static function generateUniqueCode(?string $prefix, string $column): string
    {
        $datePart = now()->format('ym');

        if ($prefix) {
            $likePattern = "{$prefix}-{$datePart}-%";
            $latest = static::where($column, 'like', $likePattern)
                ->orderBy($column, 'desc')
                ->first();
        } else {
            $likePattern = "{$datePart}%";
            $latest = static::where($column, 'like', $likePattern)
                ->whereRaw("LENGTH({$column}) = 8")
                ->orderBy($column, 'desc')
                ->first();
        }

        $sequence = 1;
        if ($latest) {
            $latestCode = $latest->{$column};
            if ($prefix) {
                $parts = explode('-', $latestCode);
                $lastSeq = (int) end($parts);
                $sequence = $lastSeq + 1;
            } else {
                $lastSeq = (int) substr($latestCode, -4);
                $sequence = $lastSeq + 1;
            }
        }

        $paddedSeq = str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);

        if ($prefix) {
            return "{$prefix}-{$datePart}-{$paddedSeq}";
        }

        return "{$datePart}{$paddedSeq}";
    }
}
