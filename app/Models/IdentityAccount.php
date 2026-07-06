<?php

namespace App\Models;

use Domain\Identity\QueryBuilders\IdentityAccountQueryBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['uuid', 'email', 'phone', 'password', 'status', 'reset_token', 'reset_token_expires_at'])]
#[Hidden(['password', 'reset_token'])]
class IdentityAccount extends Model
{
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'reset_token_expires_at' => 'datetime',
        ];
    }

    public function newEloquentBuilder($query): IdentityAccountQueryBuilder
    {
        return new IdentityAccountQueryBuilder($query);
    }
}
