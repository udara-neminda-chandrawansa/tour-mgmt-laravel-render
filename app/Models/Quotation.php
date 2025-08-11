<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = ['uniqueId', 'itinerary_id', 'title', 'price_per_person', 'currency', 'notes', 'is_final'];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
