<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['enquiry_id', 'title', 'notes'];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function days()
    {
        return $this->hasMany(ItineraryDay::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
