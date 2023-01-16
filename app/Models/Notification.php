<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Notification extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	public function sender(): Relation
	{
		return $this->belongsTo(User::class, 'from');
	}

	public function receiver(): Relation
	{
		return $this->belongsTo(User::class, 'to');
	}
}
