<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Instance extends Model
{
    use HasFactory;
	
	protected $guarded = [];
	
	/**
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'users_instances', 'instance_id', 'user_id');
	}
}
