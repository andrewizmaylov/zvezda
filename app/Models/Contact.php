<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
	protected $fillable = [
		'user_id', 'first_name', 'second_name', 'last_name', 'tg', 'birthday'
	];

	protected $primaryKey = 'user_id';
	public $incrementing = false;
	protected $keyType = 'string';

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function getFullNameAttribute(): string
	{
		return $this->first_name . ' ' . $this->last_name;
	}
}
