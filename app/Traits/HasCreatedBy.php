<?php
namespace App\Traits;

Trait HasCreatedBy
{
      /**
     * Scope For Customers Created By
     */
    public function scopeCreatedBy($query , $creator_id)
    {
        return $query->where('created_by' , $creator_id);
    }
}
