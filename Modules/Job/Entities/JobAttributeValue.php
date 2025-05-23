<?php

namespace Modules\Job\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Entities\AttributeValue;

class JobAttributeValue extends Model
{
    protected $fillable = ['attribute_value_id' , 'job_id'];

    public function value()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
